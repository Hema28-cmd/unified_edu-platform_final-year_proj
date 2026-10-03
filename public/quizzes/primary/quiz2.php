<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary') {
    header("Location: ../../primary.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $answers = $_POST['answer'] ?? [];
    $correct = [
        1 => 'b',
        2 => 'a',
        3 => 'c'
    ];

    $score = 0;
    foreach ($correct as $q => $ans) {
        if (isset($answers[$q]) && $answers[$q] === $ans) $score++;
    }

    header("Location: ../primary_quizzes.php?score=$score&quiz=quiz2");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>English Quiz</title>
<style>
body { font-family: Arial; background: #fff7ed; padding: 20px; }
.container { max-width: 700px; margin:auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.1);}
h2 { color:#f97316; text-align:center; }
.question { margin-bottom:20px; }
label { display:block; margin-bottom:8px; cursor:pointer; }
button { background:#f97316; color:#fff; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; font-size:16px; }
button:hover { background:#ea580c; }
</style>
</head>
<body>

<div class="container">
<h2>📝 English Quiz - Class 1</h2>

<form method="post">
    <div class="question">
        <p>1. Which word is a noun?</p>
        <label><input type="radio" name="answer[1]" value="a"> Run</label>
        <label><input type="radio" name="answer[1]" value="b"> Apple</label>
        <label><input type="radio" name="answer[1]" value="c"> Quickly</label>
    </div>

    <div class="question">
        <p>2. Select the correct plural form of "cat".</p>
        <label><input type="radio" name="answer[2]" value="a"> Cats</label>
        <label><input type="radio" name="answer[2]" value="b"> Cates</label>
        <label><input type="radio" name="answer[2]" value="c"> Catss</label>
    </div>

    <div class="question">
        <p>3. Choose the correct spelling:</p>
        <label><input type="radio" name="answer[3]" value="a"> Appl</label>
        <label><input type="radio" name="answer[3]" value="b"> Aple</label>
        <label><input type="radio" name="answer[3]" value="c"> Apple</label>
    </div>

    <button type="submit">Submit Quiz</button>
</form>
</div>

</body>
</html>
