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
        1 => 'a',
        2 => 'c',
        3 => 'b'
    ];

    $score = 0;
    foreach ($correct as $q => $ans) {
        if (isset($answers[$q]) && $answers[$q] === $ans) $score++;
    }

    header("Location: ../primary_quizzes.php?score=$score&quiz=quiz3");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Science Quiz</title>
<style>
body { font-family: Arial; background: #f0fdf4; padding: 20px; }
.container { max-width: 700px; margin:auto; background:#fff; padding:30px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.1);}
h2 { color:#16a34a; text-align:center; }
.question { margin-bottom:20px; }
label { display:block; margin-bottom:8px; cursor:pointer; }
button { background:#16a34a; color:#fff; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; font-size:16px; }
button:hover { background:#15803d; }
</style>
</head>
<body>

<div class="container">
<h2>📝 Science Quiz - Class 1</h2>

<form method="post">
    <div class="question">
        <p>1. Which one is a living thing?</p>
        <label><input type="radio" name="answer[1]" value="a"> Tree</label>
        <label><input type="radio" name="answer[1]" value="b"> Rock</label>
        <label><input type="radio" name="answer[1]" value="c"> Water</label>
    </div>

    <div class="question">
        <p>2. What do plants need to make food?</p>
        <label><input type="radio" name="answer[2]" value="a"> Soil only</label>
        <label><input type="radio" name="answer[2]" value="b"> Air only</label>
        <label><input type="radio" name="answer[2]" value="c"> Sunlight, water, and air</label>
    </div>

    <div class="question">
        <p>3. Which sense do we use to smell?</p>
        <label><input type="radio" name="answer[3]" value="a"> Eyes</label>
        <label><input type="radio" name="answer[3]" value="b"> Nose</label>
        <label><input type="radio" name="answer[3]" value="c"> Ears</label>
    </div>

    <button type="submit">Submit Quiz</button>
</form>
</div>

</body>
</html>
