<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') exit;

$quiz = [
 [
    'question'=>'Unit of force?',
    'options'=>['Newton','Joule','Watt','Pascal'],
    'answer'=>'Newton'
 ],
 [
    'question'=>'F = ma belongs to which law?',
    'options'=>['1st law','2nd law','3rd law','Law of gravitation'],
    'answer'=>'2nd law'
 ],
 [
    'question'=>'Speed of light in vacuum is?',
    'options'=>['3×10⁸ m/s','3×10⁶ m/s','3×10⁵ km/s','3×10⁷ m/s'],
    'answer'=>'3×10⁸ m/s'
 ],
 [
    'question'=>'Value of acceleration due to gravity (g)?',
    'options'=>['9.8 m/s²','8.9 m/s²','10 m/s²','9.2 m/s²'],
    'answer'=>'9.8 m/s²'
 ],
 [
    'question'=>'Work done is zero when force is?',
    'options'=>['Perpendicular to displacement','Parallel to displacement','Same direction','Opposite direction'],
    'answer'=>'Perpendicular to displacement'
 ]
];

$score = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $i => $q) {
        if (($_POST['q'.$i] ?? '') === $q['answer']) {
            $score++;
        }
    }
    $_SESSION['highschool_quizzes']['physics'] = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Physics Quiz</title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#f0fdf4;
}

.wrapper{
    max-width:780px;
    margin:40px auto;
    background:#ffffff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
}

h1{
    text-align:center;
    color:#065f46;
    margin-bottom:30px;
}

.question-box{
    background:#ecfeff;
    border-left:6px solid #14b8a6;
    padding:18px;
    border-radius:12px;
    margin-bottom:22px;
}

.question-box p{
    margin:0 0 12px;
    font-weight:600;
    color:#0f172a;
}

.option{
    display:block;
    padding:10px 14px;
    background:#ffffff;
    border:1px solid #99f6e4;
    border-radius:8px;
    margin-bottom:10px;
    cursor:pointer;
    transition:0.2s;
}

.option:hover{
    background:#ccfbf1;
}

.submit-btn{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#14b8a6;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
}

.submit-btn:hover{
    background:#0d9488;
}

.result{
    text-align:center;
}

.result h2{
    color:#15803d;
}

.back-link{
    display:inline-block;
    margin-top:20px;
    padding:12px 22px;
    background:#22c55e;
    color:#ffffff;
    text-decoration:none;
    border-radius:10px;
    font-weight:600;
}

.back-link:hover{
    background:#16a34a;
}
</style>
</head>

<body>

<div class="wrapper">

<?php if($score === null): ?>

<h1>🧲 Physics Quiz</h1>

<form method="post">
<?php foreach($quiz as $i=>$q): ?>
    <div class="question-box">
        <p><?= ($i+1).". ".$q['question'] ?></p>
        <?php foreach($q['options'] as $o): ?>
            <label class="option">
                <input type="radio" name="q<?= $i ?>" value="<?= $o ?>" required>
                <?= $o ?>
            </label>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<button type="submit" class="submit-btn">Submit Quiz</button>
</form>

<?php else: ?>

<div class="result">
    <h1>🎉 Quiz Finished</h1>
    <h2>Your Score: <?= $score ?>/5</h2>
    <p>Well done! Physics quiz has been completed.</p>
    <a class="back-link" href="highschool_quizzes.php">⬅ Back to Quizzes</a>
</div>

<?php endif; ?>

</div>

</body>
</html>
