<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') exit;

// Biology quiz with 4 options each
$quiz = [
 ['question'=>'The basic unit of life is?','options'=>['Cell','Atom','Molecule','Organ'],'answer'=>'Cell'],
 ['question'=>'The human heart has how many chambers?','options'=>['2','3','4','5'],'answer'=>'4'],
 ['question'=>'Which system is responsible for breathing?','options'=>['Respiratory','Circulatory','Digestive','Nervous'],'answer'=>'Respiratory'],
 ['question'=>'Photosynthesis occurs in which organelle?','options'=>['Chloroplast','Mitochondria','Nucleus','Ribosome'],'answer'=>'Chloroplast'],
 ['question'=>'Blood is pumped by which organ?','options'=>['Heart','Lungs','Kidney','Liver'],'answer'=>'Heart']
];

$score = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $i => $q) {
        if (($_POST['q'.$i] ?? '') === $q['answer']) $score++;
    }
    $_SESSION['highschool_quizzes']['biology'] = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Biology Quiz</title>
<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f0f9ff;
}

.wrapper {
    max-width: 800px;
    margin: 40px auto;
    background: #ffffff;
    padding: 35px;
    border-radius: 18px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.08);
}

h1 {
    text-align: center;
    color: #0c4a6e;
    margin-bottom: 30px;
}

.question-box {
    background: #e0f2fe;
    border-left: 6px solid #0284c7;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 22px;
}

.question-box p {
    margin: 0 0 12px;
    font-weight: 600;
    color: #0c4a6e;
}

.option {
    display: block;
    padding: 10px 14px;
    background: #ffffff;
    border: 1px solid #7dd3fc;
    border-radius: 8px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.2s;
}

.option:hover {
    background: #bae6fd;
}

.submit-btn {
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 10px;
    background: #0284c7;
    color: white;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.submit-btn:hover {
    background: #0369a1;
}

.result {
    text-align: center;
}

.result h2 {
    color: #16a34a;
}

.back-link {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 25px;
    background: #38bdf8;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
}

.back-link:hover {
    background: #0ea5e9;
}
</style>
</head>
<body>

<div class="wrapper">

<?php if($score === null): ?>
<h1>🧬 Biology Quiz</h1>
<form method="post">
<?php foreach($quiz as $i=>$q): ?>
    <div class="question-box">
        <p><?= ($i+1) . ". " . $q['question'] ?></p>
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
    <h1>🎉 Quiz Completed</h1>
    <h2>Your Score: <?= $score ?>/5</h2>
    <p>Congratulations! Biology quiz has been completed.</p>
    <a class="back-link" href="highschool_quizzes.php">⬅ Back to Quizzes</a>
</div>
<?php endif; ?>

</div>

</body>
</html>
