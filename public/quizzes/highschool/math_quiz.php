<?php
session_start();

// Only allow highschool users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

// Quiz questions and answers for Math
$quiz = [
    [
        'question' => 'What is the value of π (pi) rounded to 2 decimal places?',
        'options' => ['3.12', '3.14', '3.16', '3.18'],
        'answer' => '3.14'
    ],
    [
        'question' => 'The area of a circle is given by?',
        'options' => ['πr^2', '2πr', 'πd', 'r^2'],
        'answer' => 'πr^2'
    ],
    [
        'question' => 'What is 7 × 8?',
        'options' => ['54', '56', '58', '60'],
        'answer' => '56'
    ],
    [
        'question' => 'Solve for x: 2x + 6 = 14',
        'options' => ['3', '4', '5', '6'],
        'answer' => '4'
    ],
    [
        'question' => 'The square root of 144 is?',
        'options' => ['10', '11', '12', '13'],
        'answer' => '12'
    ]
];

$score = null;

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = 0;
    foreach ($quiz as $index => $q) {
        $userAnswer = $_POST['q' . $index] ?? '';
        if ($userAnswer === $q['answer']) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Math Quiz - Highschool</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    margin: 0;
    padding: 0;
}
.container {
    max-width: 700px;
    margin: 50px auto;
    background: rgba(0,0,0,0.7);
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px #000;
}
h1 { text-align: center; margin-bottom: 30px; }
.question { margin-bottom: 20px; }
.options label {
    display: block;
    padding: 8px;
    margin-bottom: 5px;
    background: rgba(255,255,255,0.1);
    border-radius: 5px;
    cursor: pointer;
}
.options input { margin-right: 10px; }
button {
    display: block;
    width: 100%;
    padding: 10px;
    background: #ff6f61;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
}
button:hover { background: #ff3b2f; }
.result {
    text-align: center;
    font-size: 24px;
    margin-top: 20px;
    padding: 15px;
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
}
.back-btn a {
    color: #fff;
    text-decoration: none;
    display: inline-block;
    margin-top: 15px;
}
.back-btn a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="container">
    <h1>Math Quiz - Highschool</h1>

    <?php if ($score === null): ?>
    <form method="post">
        <?php foreach ($quiz as $index => $q): ?>
        <div class="question">
            <p><strong><?= ($index + 1) . ". " . $q['question'] ?></strong></p>
            <div class="options">
                <?php foreach ($q['options'] as $option): ?>
                    <label>
                        <input type="radio" name="q<?= $index ?>" value="<?= $option ?>" required> <?= $option ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <button type="submit">Submit Quiz</button>
    </form>
    <?php else: ?>
    <div class="result">
        You scored <?= $score ?> out of <?= count($quiz) ?>!
    </div>
    <div class="back-btn">
        <a href="highschool_quizzes.php"><i class="fa fa-arrow-left"></i> Back to Quizzes</a>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
