<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary') {
    header("Location: ../../primary.php");
    exit;
}

// Handle quiz submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Define correct answers
    $correct = [
        1 => 'b',
        2 => 'a',
        3 => 'c'
    ];

    $score = 0;
    $answers = $_POST['answer'] ?? [];
    foreach ($correct as $q => $ans) {
        if (isset($answers[$q]) && $answers[$q] === $ans) {
            $score++;
        }
    }

    // Redirect to primary_quizzes.php
    header("Location: ../primary_quizzes.php?score=$score&quiz=quiz1");
    exit; // Make sure nothing else is sent
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Math Quiz</title>
<style>
body { font-family: Arial; background: #f0f9ff; padding: 20px; }
.container { max-width: 700px; margin:auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.1);}
h2 { color:#0284c7; text-align:center; }
.question { margin-bottom:20px; }
label { display:block; margin-bottom:8px; cursor:pointer; }
button { background:#0284c7; color:#fff; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; font-size:16px; }
button:hover { background:#0369a1; }
</style>
</head>
<body>

<div class="container">
<h2>📝 Math Quiz - Class 1</h2>

<form method="post">
    <div class="question">
        <p>1. What is 2 + 3?</p>
        <label><input type="radio" name="answer[1]" value="a"> 4</label>
        <label><input type="radio" name="answer[1]" value="b"> 5</label>
        <label><input type="radio" name="answer[1]" value="c"> 6</label>
    </div>

    <div class="question">
        <p>2. Which number comes after 7?</p>
        <label><input type="radio" name="answer[2]" value="a"> 8</label>
        <label><input type="radio" name="answer[2]" value="b"> 9</label>
        <label><input type="radio" name="answer[2]" value="c"> 7</label>
    </div>

    <div class="question">
        <p>3. What is 5 - 2?</p>
        <label><input type="radio" name="answer[3]" value="a"> 1</label>
        <label><input type="radio" name="answer[3]" value="b"> 2</label>
        <label><input type="radio" name="answer[3]" value="c"> 3</label>
    </div>

    <button type="submit">Submit Quiz</button>
</form>
</div>

</body>
</html>
