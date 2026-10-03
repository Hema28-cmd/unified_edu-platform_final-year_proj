<?php
session_start();
require_once '../../config/db.php';

// 🔐 Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 🔹 Validate quiz_id
if (!isset($_GET['quiz_id'])) {
    die("Invalid quiz.");
}

$quiz_id = intval($_GET['quiz_id']);

/* =============================
   Fetch quiz details
============================= */
$stmt = $conn->prepare("SELECT * FROM quizzes WHERE id=?");
if (!$stmt) {
    die("Quiz Fetch Error: " . $conn->error);
}
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();

if (!$quiz) {
    die("Quiz not found.");
}

/* =============================
   Prevent Multiple Passed Attempts
============================= */
$checkAttempt = $conn->prepare("
    SELECT id FROM quiz_attempts 
    WHERE user_id=? AND quiz_id=? AND status='passed'
");

if ($checkAttempt) {
    $checkAttempt->bind_param("ii", $user_id, $quiz_id);
    $checkAttempt->execute();
    $checkAttempt->store_result();

    if ($checkAttempt->num_rows > 0) {
        echo "<h3>✅ You already passed this quiz.</h3>";
        echo "<a href='primary_quizzes.php'>Back to Quizzes</a>";
        exit;
    }
}

/* =============================
   Fetch quiz questions
============================= */
$qstmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
if (!$qstmt) {
    die("Question Fetch Error: " . $conn->error);
}
$qstmt->bind_param("i", $quiz_id);
$qstmt->execute();
$questions = $qstmt->get_result();

if ($questions->num_rows == 0) {
    die("No questions available for this quiz.");
}

/* =============================
   Handle form submission
============================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $total = 0;
    $score = 0;

    $questions->data_seek(0); // reset pointer
    while ($row = $questions->fetch_assoc()) {
        $total++;
        $qid = $row['id'];

        if (isset($_POST['answer'][$qid])) {
            if ($_POST['answer'][$qid] == $row['correct_option']) {
                $score++;
            }
        }
    }

    /* PASS MARK 50% */
    $pass_mark = ceil($total * 0.5);
    $status = ($score >= $pass_mark) ? 'passed' : 'failed';

    /* =============================
       Insert or update attempt
    ============================= */
    $stmt = $conn->prepare("
        INSERT INTO quiz_attempts (user_id, quiz_id, score, status, attempted_at)
        VALUES (?, ?, ?, ?, NOW())
        ON DUPLICATE KEY UPDATE score=?, status=?, attempted_at=NOW()
    ");

    if (!$stmt) {
        die("Insert/Update Error: " . $conn->error);
    }

    $stmt->bind_param("iissis", $user_id, $quiz_id, $score, $status, $score, $status);
    $stmt->execute();

/* =============================
   Update user_progress table
============================= */
if ($status == 'passed') {

    $level = 'primary';

    // Check if record exists
    $check = $conn->prepare("SELECT id FROM user_progress WHERE user_id=? AND level=?");
    $check->bind_param("is", $user_id, $level);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Update completed count
        $update = $conn->prepare("
            UPDATE user_progress 
            SET quizzes_completed = quizzes_completed + 1
            WHERE user_id=? AND level=?
        ");
        $update->bind_param("is", $user_id, $level);
        $update->execute();
    } else {
        // Insert new row
        $insert = $conn->prepare("
            INSERT INTO user_progress 
            (user_id, level, quizzes_completed, certificate_unlocked)
            VALUES (?, ?, 1, 0)
        ");
        $insert->bind_param("is", $user_id, $level);
        $insert->execute();
    }

    // Unlock certificate if all quizzes passed
    $unlock = $conn->prepare("
        UPDATE user_progress 
        SET certificate_unlocked = 1
        WHERE user_id=? 
        AND level=?
        AND quizzes_completed >= (
            SELECT COUNT(*) FROM quizzes WHERE level='primary'
        )
    ");
    $unlock->bind_param("is", $user_id, $level);
    $unlock->execute();
}

    /* =============================
       Show result to user
    ============================= */
    echo "<h2>Quiz Result</h2>";
    echo "<h3>Score: $score / $total</h3>";
    echo "<h3>Status: " . strtoupper($status) . "</h3>";
    echo "<br><a href='primary_quizzes.php'>Back to Quizzes</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlspecialchars($quiz['title']); ?></title>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #333;
        }

        .header {
            padding: 25px;
            color: white;
            text-align: center;
            position: relative;
        }

        .back-btn {
            position: absolute;
            left: 25px;
            top: 25px;
            background: white;
            color: #1e3c72;
            padding: 8px 15px;
            border-radius: 20px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #f0f4ff;
            transform: translateX(-3px);
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }

        .quiz-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            margin-bottom: 25px;
            transition: 0.3s;
        }

        .quiz-card:hover {
            transform: translateY(-4px);
        }

        .question-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1e3c72;
        }

        .option {
            display: block;
            background: #f1f5ff;
            padding: 10px 15px;
            border-radius: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .option:hover {
            background: #dbeafe;
        }

        input[type="radio"] {
            margin-right: 8px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        .submit-btn:hover {
            transform: scale(1.03);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .progress-bar-bg {
            width: 100%;
            height: 8px;
            background: #cbd5e1;
            border-radius: 10px;
            margin: 20px 0;
        }

        .progress-bar-fill {
            height: 8px;
            background: linear-gradient(90deg, #22c55e, #16a34a);
            border-radius: 10px;
            width: 100%;
        }

    </style>
</head>

<body>

<div class="header">
    <a href="primary_quizzes.php" class="back-btn">⬅ Back</a>
    <h2><?php echo htmlspecialchars($quiz['title']); ?></h2>
    <p>Answer all questions carefully</p>
</div>

<div class="container">

<form method="POST">

<div class="progress-bar-bg">
    <div class="progress-bar-fill"></div>
</div>

<?php
$questions->data_seek(0);
$qno = 1;
while ($row = $questions->fetch_assoc()):
?>

    <div class="quiz-card">

        <div class="question-title">
            Q<?php echo $qno++; ?>.
            <?php echo htmlspecialchars($row['question']); ?>
        </div>

        <label class="option">
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="1" required>
            <?php echo htmlspecialchars($row['option1']); ?>
        </label>

        <label class="option">
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="2">
            <?php echo htmlspecialchars($row['option2']); ?>
        </label>

        <label class="option">
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="3">
            <?php echo htmlspecialchars($row['option3']); ?>
        </label>

        <label class="option">
            <input type="radio" name="answer[<?php echo $row['id']; ?>]" value="4">
            <?php echo htmlspecialchars($row['option4']); ?>
        </label>

    </div>

<?php endwhile; ?>

    <button type="submit" class="submit-btn">🚀 Submit Quiz</button>

</form>

</div>

</body>
</html>