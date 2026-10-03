<?php
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten'){
    header("Location: ../../dashboard.php");
    exit;
}

$score = 0;
$submitted = false;

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $submitted = true;

    if($_POST['q1'] === 'A') $score++;
    if($_POST['q2'] === 'B') $score++;

    // Mark quiz as completed
    $_SESSION['quiz_completed'] = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kindergarten Quiz</title>
</head>
<body>

<h2>Alphabet Quiz</h2>

<?php if(!$submitted): ?>

<form method="POST">
    <p>1. First alphabet?</p>
    <input type="radio" name="q1" value="A" required> A<br>
    <input type="radio" name="q1" value="B"> B<br>

    <p>2. Second alphabet?</p>
    <input type="radio" name="q2" value="A"> A<br>
    <input type="radio" name="q2" value="B" required> B<br>

    <br>
    <button type="submit">Submit Quiz</button>
</form>

<?php else: ?>

<h3>Your Score: <?php echo $score; ?>/2</h3>

<h2>🎉 Excellent Work!</h2>
<p>You are doing great. Keep learning 🌟</p>

<a href="../../kindergarten.php?page=certificate">
    Go to Certificate
</a>

<?php endif; ?>

</body>
</html>
