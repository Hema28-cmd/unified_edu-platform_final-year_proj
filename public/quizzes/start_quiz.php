<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$quiz_id = $_GET['id'] ?? 0;

/* Fetch Quiz Details */
$stmt = $conn->prepare("SELECT title FROM quizzes WHERE id=?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz_result = $stmt->get_result();
$quiz = $quiz_result->fetch_assoc();

if (!$quiz) {
    die("Invalid Quiz");
}

/* Check if already attempted */
$attempt_stmt = $conn->prepare("
    SELECT score FROM quiz_attempts 
    WHERE user_id=? AND quiz_id=?
");
$attempt_stmt->bind_param("ii", $user_id, $quiz_id);
$attempt_stmt->execute();
$attempt_result = $attempt_stmt->get_result();
$attempt = $attempt_result->fetch_assoc();
$alreadyAttempted = $attempt ? true : false;

/* Fetch Questions */
$qstmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
$qstmt->bind_param("i", $quiz_id);
$qstmt->execute();
$questions = $qstmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $quiz['title']; ?></title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #e0f2fe, #fef9c3);
    padding: 30px;
}

.container {
    max-width: 900px;
    margin: auto;
}

.quiz-box {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

h2 {
    text-align:center;
    color:#1e3a8a;
    margin-bottom:25px;
}

.question {
    margin-bottom: 20px;
    padding:15px;
    border-radius:10px;
    background:#f8fafc;
}

.options label {
    display:block;
    padding:8px;
    margin-bottom:5px;
    border-radius:8px;
    cursor:pointer;
}

.options input {
    margin-right:8px;
}

.correct {
    background:#dcfce7;
    border:1px solid #16a34a;
}

.submit-btn {
    padding:12px 25px;
    border:none;
    border-radius:25px;
    background:#2563eb;
    color:white;
    cursor:pointer;
    font-size:16px;
}

.submit-btn:hover {
    background:#1d4ed8;
}

.score-box {
    background:#16a34a;
    color:white;
    padding:15px;
    border-radius:10px;
    text-align:center;
    margin-bottom:20px;
}
</style>
</head>

<body>

<div class="container">
<div class="quiz-box">

<h2><?php echo $quiz['title']; ?></h2>

<?php if ($alreadyAttempted): ?>
    <div class="score-box">
        ✅ You already completed this quiz.  
        Your Score: <strong><?php echo $attempt['score']; ?></strong>
    </div>
<?php endif; ?>

<form method="POST" action="submit_quiz.php">
<input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

<?php 
$i = 1;
while ($row = $questions->fetch_assoc()):
?>
    <div class="question">
        <p><strong>Q<?php echo $i++; ?>:</strong> <?php echo $row['question']; ?></p>

        <div class="options">
        <?php for ($opt=1; $opt<=4; $opt++): 
            $isCorrect = ($opt == $row['correct_option']);
        ?>
            <label class="<?php echo ($alreadyAttempted && $isCorrect) ? 'correct' : ''; ?>">
                <?php if (!$alreadyAttempted): ?>
                    <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="<?php echo $opt; ?>">
                <?php endif; ?>

                <?php echo $row['option'.$opt]; ?>
            </label>
        <?php endfor; ?>
        </div>
    </div>
<?php endwhile; ?>

<?php if (!$alreadyAttempted): ?>
    <div style="text-align:center;">
        <button type="submit" class="submit-btn">Submit Quiz</button>
    </div>
<?php endif; ?>

</form>

</div>
</div>

</body>
</html>