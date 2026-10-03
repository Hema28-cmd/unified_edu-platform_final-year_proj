<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

$quiz = [
 ['question'=>'Value of π?','options'=>['3.12','3.14','3.16','3.18'],'answer'=>'3.14'],
 ['question'=>'7 × 8 = ?','options'=>['54','56','58','60'],'answer'=>'56'],
 ['question'=>'√144 = ?','options'=>['10','11','12','13'],'answer'=>'12'],
 ['question'=>'2x+6=14, x=?','options'=>['3','4','5','6'],'answer'=>'4'],
 ['question'=>'Area of circle?','options'=>['πr²','2πr','πd','r²'],'answer'=>'πr²']
];

$score = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $i => $q) {
        if (($_POST['q'.$i] ?? '') === $q['answer']) {
            $score++;
        }
    }

    $_SESSION['highschool_quizzes']['math'] = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Math Quiz</title>

<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background:#f4f9ff;
}

.container{
    max-width:800px;
    margin:40px auto;
    background:#ffffff;
    padding:30px;
    border-radius:14px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

h1{
    text-align:center;
    color:#1e3a8a;
    margin-bottom:25px;
}

.question{
    background:#eef6ff;
    padding:18px;
    border-radius:10px;
    margin-bottom:20px;
}

.question p{
    font-weight:600;
    margin-bottom:12px;
    color:#0f172a;
}

.options label{
    display:block;
    padding:8px 12px;
    background:#ffffff;
    border:1px solid #dbeafe;
    border-radius:8px;
    margin-bottom:8px;
    cursor:pointer;
    transition:0.2s;
}

.options label:hover{
    background:#e0f2fe;
}

button{
    display:block;
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#3b82f6;
    color:#fff;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    margin-top:20px;
}

button:hover{
    background:#2563eb;
}

.result{
    text-align:center;
}

.result h2{
    color:#15803d;
}

.back-btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:#22c55e;
    color:#fff;
    text-decoration:none;
    border-radius:8px;
    font-weight:600;
}

.back-btn:hover{
    background:#16a34a;
}
</style>
</head>

<body>

<div class="container">

<?php if($score === null): ?>

<h1>📐 Math Quiz</h1>

<form method="post">
<?php foreach($quiz as $i=>$q): ?>
    <div class="question">
        <p><?= ($i+1).". ".$q['question'] ?></p>
        <div class="options">
        <?php foreach($q['options'] as $o): ?>
            <label>
                <input type="radio" name="q<?= $i ?>" value="<?= $o ?>" required>
                <?= $o ?>
            </label>
        <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<button type="submit">Submit Quiz</button>
</form>

<?php else: ?>

<div class="result">
    <h1>🎉 Quiz Completed</h1>
    <h2>Your Score: <?= $score ?>/5</h2>
    <p>Great job! Your progress has been saved.</p>
    <a class="back-btn" href="highschool_quizzes.php">⬅ Back to Quizzes</a>
</div>

<?php endif; ?>

</div>

</body>
</html>
