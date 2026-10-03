<?php
session_start();

// Ensure user is highschool
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

// Check which quiz was submitted
$quiz = $_POST['quiz'] ?? '';
if (!$quiz) {
    header("Location: highschool_quizzes.php");
    exit;
}

// Correct answers
$answers = [
    'math' => [1=>'12',2=>'12',3=>'25',4=>'5',5=>'8x'],
    'physics' => [1=>'Newton',2=>'distance/time',3=>'9.8 m/s²',4=>'V = IR',5=>'mgh'],
    'chemistry' => [1=>'Water',2=>'6',3=>'Salt',4=>'<7',5=>'>7'],
    'biology' => [1=>'Cell',2=>'Sunlight',3=>'Heart',4=>'Body',5=>'Respiration']
];

// Calculate score
$score = 0;
if (isset($answers[$quiz])) {
    foreach ($answers[$quiz] as $qNum=>$correct) {
        if (isset($_POST['q'.$qNum]) && $_POST['q'.$qNum] === $correct) {
            $score++;
        }
    }
}

// Update session
if (!isset($_SESSION['highschool_quizzes'])) {
    $_SESSION['highschool_quizzes'] = ['math'=>false,'physics'=>false,'chemistry'=>false,'biology'=>false];
}
$_SESSION['highschool_quizzes'][$quiz] = true;

// Check if all quizzes completed
if ($_SESSION['highschool_quizzes']['math'] &&
    $_SESSION['highschool_quizzes']['physics'] &&
    $_SESSION['highschool_quizzes']['chemistry'] &&
    $_SESSION['highschool_quizzes']['biology']) {
    $_SESSION['quiz_completed'] = true;
}

// Redirect back to dashboard with quiz info
header("Location: highschool_quizzes.php?quiz=$quiz&score=$score");
exit;
