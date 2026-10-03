<?php
session_start();
require_once "../config/db.php";

/* 🔐 Only Kindergarten users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_GET['quiz_id'])) {
    header("Location: kindergarten_quizzes.php");
    exit;
}

$quiz_id = intval($_GET['quiz_id']);

/* Fetch Quiz Info */
$stmt = $conn->prepare("SELECT title FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz_result = $stmt->get_result();

if ($quiz_result->num_rows == 0) {
    echo "Quiz not found.";
    exit;
}

$quiz = $quiz_result->fetch_assoc();

/* Fetch Questions */
$q_stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id = ?");
$q_stmt->bind_param("i", $quiz_id);
$q_stmt->execute();
$q_result = $q_stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Attend Quiz</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#fdfbfb,#d1fae5);
    padding:30px 15px;
}

/* QUIZ CONTAINER */
.quiz-box{
    max-width:850px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:25px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
    position:relative;
}

/* HEADER */
.quiz-box h2{
    text-align:center;
    margin-bottom:30px;
    color:#059669;
    font-size:28px;
}

/* QUESTION CARD */
.question{
    background:linear-gradient(135deg,#e0f2fe,#fef9c3);
    padding:20px;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 8px 18px rgba(0,0,0,0.08);
    transition:0.3s;
}

.question:hover{
    transform:translateY(-5px);
}

/* QUESTION TITLE */
.question strong{
    font-size:18px;
    color:#7c3aed;
}

/* OPTIONS */
.question label{
    display:block;
    padding:10px 15px;
    margin:8px 0;
    background:white;
    border-radius:12px;
    cursor:pointer;
    transition:0.3s;
    border:2px solid transparent;
}

.question label:hover{
    background:#f0f9ff;
    border-color:#38bdf8;
    transform:scale(1.02);
}

/* RADIO BUTTON STYLE */
.question input[type="radio"]{
    margin-right:10px;
    accent-color:#10b981;
}

/* SUBMIT BUTTON */
.submit-btn{
    display:block;
    width:100%;
    padding:14px;
    margin-top:20px;
    background:linear-gradient(90deg,#34d399,#3b82f6);
    color:white;
    border:none;
    border-radius:30px;
    font-size:18px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.submit-btn:hover{
    transform:scale(1.05);
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    background:#f97316;
    color:white;
    padding:8px 18px;
    border-radius:20px;
    font-weight:600;
}

.back-btn:hover{
    background:#ea580c;
}

/* RESPONSIVE */
@media(max-width:600px){
    .quiz-box{
        padding:20px;
    }
}
</style>
</head>

<body>

<div class="quiz-box">

    <a href="kindergarten_quizzes.php" class="back-btn">⬅ Back to Quizzes</a>

    <h2>📝 <?= htmlspecialchars($quiz['title']) ?></h2>

    <?php if ($q_result->num_rows > 0): ?>
        <form method="post" action="submit_quiz.php">
            <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">

            <?php 
            $qno = 1;
            while ($question = $q_result->fetch_assoc()): 
            ?>
                <div class="question">
                    <strong>Q<?= $qno++ ?>:</strong>
                    <?= htmlspecialchars($question['question']) ?><br><br>

                    <label>
                        <input type="radio" name="answer[<?= $question['id'] ?>]" value="1">
                        <?= htmlspecialchars($question['option1']) ?>
                    </label>

                    <label>
                        <input type="radio" name="answer[<?= $question['id'] ?>]" value="2">
                        <?= htmlspecialchars($question['option2']) ?>
                    </label>

                    <label>
                        <input type="radio" name="answer[<?= $question['id'] ?>]" value="3">
                        <?= htmlspecialchars($question['option3']) ?>
                    </label>

                    <label>
                        <input type="radio" name="answer[<?= $question['id'] ?>]" value="4">
                        <?= htmlspecialchars($question['option4']) ?>
                    </label>
                </div>
            <?php endwhile; ?>

            <button type="submit" class="submit-btn">
                🎉 Submit Quiz
            </button>
        </form>
    <?php else: ?>
        <p style="text-align:center;color:#dc2626;">
            No questions available for this quiz.
        </p>
    <?php endif; ?>

</div>

</body>
</html>