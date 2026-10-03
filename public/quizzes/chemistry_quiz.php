<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') exit;

// Chemistry Quiz with 4 options each
$quiz = [
 ['question'=>'What is the chemical formula for water?','options'=>['H2O','CO2','NaCl','O2'],'answer'=>'H2O'],
 ['question'=>'The pH value of pure water is?','options'=>['7','14','1','0'],'answer'=>'7'],
 ['question'=>'Which gas is released during photosynthesis?','options'=>['Oxygen','Nitrogen','Carbon dioxide','Hydrogen'],'answer'=>'Oxygen'],
 ['question'=>'Table salt is chemically known as?','options'=>['NaCl','KCl','Na2SO4','CaCO3'],'answer'=>'NaCl'],
 ['question'=>'Atomic number represents?','options'=>['Number of protons','Number of neutrons','Number of electrons','Mass number'],'answer'=>'Number of protons']
];

$score = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $i => $q) {
        if (($_POST['q'.$i] ?? '') === $q['answer']) $score++;
    }
    $_SESSION['highschool_quizzes']['chemistry'] = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Chemistry Quiz</title>
<style>
body {
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background: #fff7ed;
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
    text-align:center;
    color:#b45309;
    margin-bottom: 30px;
}

.question-box {
    background:#fef3c7;
    border-left:6px solid #f59e0b;
    padding:20px;
    border-radius:12px;
    margin-bottom:22px;
}

.question-box p {
    margin:0 0 12px;
    font-weight:600;
    color:#78350f;
}

.option {
    display:block;
    padding:10px 14px;
    background:#ffffff;
    border:1px solid #fde68a;
    border-radius:8px;
    margin-bottom:10px;
    cursor:pointer;
    transition:0.2s;
}

.option:hover {
    background:#fef9c3;
}

.submit-btn {
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#f59e0b;
    color:white;
    font-size:16px;
    font-weight:600;
    cursor:pointer;
    transition:0.2s;
}

.submit-btn:hover {
    background:#b45309;
}

.result {
    text-align:center;
}

.result h2 {
    color:#15803d;
}

.back-link {
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:#fbbf24;
    color:#fff;
    text-decoration:none;
    border-radius:10px;
    font-weight:600;
}

.back-link:hover {
    background:#d97706;
}
</style>
</head>
<body>

<div class="wrapper">

<?php if($score === null): ?>
<h1>⚗️ Chemistry Quiz</h1>
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
    <h1>🎉 Quiz Finished</h1>
    <h2>Your Score: <?= $score ?>/5</h2>
    <p>Well done! Chemistry quiz has been completed.</p>
    <a class="back-link" href="highschool_quizzes.php">⬅ Back to Quizzes</a>
</div>
<?php endif; ?>

</div>

</body>
</html>
