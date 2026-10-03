<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

// English quiz questions
$quiz = [
    ['question'=>'Choose the correct spelling:','options'=>['Accomodate','Acommodate','Accommodate','Acomodate'],'answer'=>'Accommodate'],
    ['question'=>'Synonym of "Happy" is?','options'=>['Sad','Joyful','Angry','Tired'],'answer'=>'Joyful'],
    ['question'=>'Antonym of "Difficult" is?','options'=>['Hard','Easy','Complex','Tough'],'answer'=>'Easy'],
    ['question'=>'Which is a noun?','options'=>['Run','Beauty','Quickly','Blue'],'answer'=>'Beauty'],
    ['question'=>'Correct sentence:','options'=>['He don\'t like apples.','He doesn\'t likes apples.','He doesn\'t like apples.','He not like apples.'],'answer'=>'He doesn\'t like apples.']
];

$score = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $index => $q) {
        $userAnswer = $_POST['q' . $index] ?? '';
        if ($userAnswer === $q['answer']) $score++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>English Quiz - Highschool</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body { font-family: Arial, sans-serif; background: linear-gradient(135deg,#f7971e,#ffd200); color: #fff; margin:0; padding:0; }
.container { max-width:700px; margin:50px auto; background:rgba(0,0,0,0.7); padding:30px; border-radius:10px; box-shadow:0 0 20px #000; }
h1 { text-align:center; margin-bottom:30px; }
.question { margin-bottom:20px; }
.options label { display:block; padding:8px; margin-bottom:5px; background:rgba(255,255,255,0.1); border-radius:5px; cursor:pointer; }
.options input { margin-right:10px; }
button { display:block; width:100%; padding:10px; background:#ff6f61; color:#fff; border:none; border-radius:5px; font-size:16px; cursor:pointer; }
button:hover { background:#ff3b2f; }
.result { text-align:center; font-size:24px; margin-top:20px; padding:15px; background:rgba(255,255,255,0.2); border-radius:10px; }
.back-btn a { color:#fff; text-decoration:none; display:inline-block; margin-top:15px; }
.back-btn a:hover { text-decoration:underline; }
</style>
</head>
<body>
<div class="container">
<h1>English Quiz - Highschool</h1>

<?php if ($score === null): ?>
<form method="post">
<?php foreach ($quiz as $index => $q): ?>
<div class="question">
<p><strong><?= ($index + 1) . ". " . $q['question'] ?></strong></p>
<div class="options">
<?php foreach ($q['options'] as $option): ?>
<label><input type="radio" name="q<?= $index ?>" value="<?= $option ?>" required> <?= $option ?></label>
<?php endforeach; ?>
</div>
</div>
<?php endforeach; ?>
<button type="submit">Submit Quiz</button>
</form>
<?php else: ?>
<div class="result">You scored <?= $score ?> out of <?= count($quiz) ?>!</div>
<div class="back-btn"><a href="highschool_quizzes.php"><i class="fa fa-arrow-left"></i> Back to Quizzes</a></div>
<?php endif; ?>
</div>
</body>
</html>
