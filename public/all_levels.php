<?php
session_start();
if ($_SESSION['user_level'] !== 'ALL_LEVELS') {
    header("Location: dashboard.php");
    exit;
}
?>

<h1>🎓 Congratulations!</h1>
<p>You have completed all levels.</p>

<ul>
<li><a href="kindergarten.php">Kindergarten</a></li>
<li><a href="primary.php">Primary</a></li>
<li><a href="secondary.php">Secondary</a></li>
<li><a href="highschool.php">High School</a></li>
<li><a href="undergraduate.php">Undergraduate</a></li>
<li><a href="postgraduate.php">Postgraduate</a></li>
</ul>
