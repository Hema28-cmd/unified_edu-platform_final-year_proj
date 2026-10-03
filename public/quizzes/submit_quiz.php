<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$quiz_id = $_POST['quiz_id'];
$answers = $_POST['answer'] ?? [];

$score = 0;
$results = [];

/* ===============================
   CHECK ANSWERS + STORE DETAILS
================================ */
foreach ($answers as $question_id => $selected_option) {

    $stmt = $conn->prepare("SELECT question, option1, option2, option3, option4, correct_option 
                            FROM quiz_questions WHERE id=?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $isCorrect = ($row['correct_option'] == $selected_option);

        if ($isCorrect) {
            $score++;
        }

        $results[] = [
            "question" => $row['question'],
            "options" => [
                1 => $row['option1'],
                2 => $row['option2'],
                3 => $row['option3'],
                4 => $row['option4']
            ],
            "selected" => $selected_option,
            "correct" => $row['correct_option'],
            "isCorrect" => $isCorrect
        ];
    }
}

/* ===============================
   SAVE ATTEMPT
================================ */
$stmt = $conn->prepare("INSERT INTO quiz_attempts (user_id, quiz_id, score) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $user_id, $quiz_id, $score);
$stmt->execute();

/* ===============================
   UPDATE USER PROGRESS
================================ */
$total_stmt = $conn->prepare("SELECT COUNT(*) as total FROM quizzes WHERE level='primary'");
$total_stmt->execute();
$total_row = $total_stmt->get_result()->fetch_assoc();
$total_quizzes = $total_row['total'];

$completed_stmt = $conn->prepare("
    SELECT COUNT(DISTINCT quiz_id) as completed 
    FROM quiz_attempts 
    WHERE user_id=? 
    AND quiz_id IN (SELECT id FROM quizzes WHERE level='primary')
");
$completed_stmt->bind_param("i", $user_id);
$completed_stmt->execute();
$completed_row = $completed_stmt->get_result()->fetch_assoc();
$completed_quizzes = $completed_row['completed'];

$certificate = ($completed_quizzes >= $total_quizzes) ? 1 : 0;

$stmt = $conn->prepare("
INSERT INTO user_progress (user_id, level, quizzes_completed, certificate_unlocked)
VALUES (?, 'primary', ?, ?)
ON DUPLICATE KEY UPDATE
quizzes_completed=?,
certificate_unlocked=?
");

$stmt->bind_param("iiiii",
    $user_id,
    $completed_quizzes,
    $certificate,
    $completed_quizzes,
    $certificate
);
$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
<title>Quiz Result</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #dbeafe, #fef3c7);
    padding: 30px;
}

.container {
    max-width: 950px;
    margin: auto;
}

.result-box {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

h2 {
    text-align:center;
    color:#1e3a8a;
}

.score {
    text-align:center;
    font-size:20px;
    margin-bottom:25px;
    padding:12px;
    border-radius:10px;
    background:#2563eb;
    color:white;
}

.question {
    margin-bottom:20px;
    padding:15px;
    border-radius:10px;
    background:#f8fafc;
}

.option {
    padding:6px 10px;
    border-radius:6px;
    margin-bottom:5px;
}

.correct {
    background:#dcfce7;
    border:1px solid #16a34a;
}

.wrong {
    background:#fee2e2;
    border:1px solid #dc2626;
}

.buttons {
    text-align:center;
    margin-top:30px;
}

button {
    padding:10px 20px;
    border:none;
    border-radius:25px;
    background:#1e40af;
    color:white;
    cursor:pointer;
    margin:5px;
}
button:hover {
    background:#1d4ed8;
}
</style>
</head>

<body>

<div class="container">
<div class="result-box">

<h2>📊 Quiz Result</h2>

<div class="score">
    Your Score: <strong><?php echo $score; ?> / <?php echo count($results); ?></strong>
</div>

<?php 
$qNo = 1;
foreach ($results as $r): 
?>
    <div class="question">
        <strong>Q<?php echo $qNo++; ?>:</strong> <?php echo $r['question']; ?><br><br>

        <?php foreach ($r['options'] as $key => $value): 
            $class = "";
            if ($key == $r['correct']) $class = "correct";
            if ($key == $r['selected'] && !$r['isCorrect']) $class = "wrong";
        ?>
            <div class="option <?php echo $class; ?>">
                <?php echo $value; ?>
                <?php
                if ($key == $r['selected']) echo " (Your Answer)";
                if ($key == $r['correct']) echo " ✅";
                ?>
            </div>
        <?php endforeach; ?>

    </div>
<?php endforeach; ?>

<div class="buttons">
    <button onclick="window.location.href='primary_quizzes.php'">
        Back to Quizzes
    </button>
</div>

</div>
</div>

</body>
</html>