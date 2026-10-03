<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Subject-wise Practice</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#fff7ed;}
.header{background:#ea580c;color:#fff;padding:40px;text-align:center;}
.grid{max-width:1000px;margin:40px auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:25px;padding:20px;}
.card{background:#fff;padding:25px;border-radius:20px;box-shadow:0 10px 25px rgba(0,0,0,0.1);}
.card h3{color:#9a3412;}
.card p{color:#475569;font-size:14px;}
.card a{display:inline-block;margin-top:15px;padding:10px 24px;background:#ea580c;color:#fff;text-decoration:none;border-radius:20px;}
.back{display:inline-block;margin:40px auto 20px;padding:12px 28px;background:#ea580c;color:#fff;text-decoration:none;border-radius:30px;text-align:center;transition:0.2s;}
.back:hover{background:#c2410c;}
.back-container{text-align:center;}
</style>
</head>
<body>

<div class="header">
<h1>Subject-wise Practice</h1>
<p>Select a subject to begin focused practice</p>
</div>

<div class="grid">
<div class="card"><h3>Mathematics</h3><p>Practice problem-solving and formulas.</p><a href="practice_quizzes/maths_quiz.php">Mathematics</a></div>
<div class="card"><h3>Physics</h3><p>Conceptual and numerical practice.</p><a href="practice_quizzes/physics_quiz.php">Physics</a></div>
<div class="card"><h3>Chemistry</h3><p>Equations, reactions & logic.</p><a href="practice_quizzes/chemistry_quiz.php">Chemistry</a></div>
<div class="card"><h3>Computer Science</h3><p>Programming and theory questions.</p><a href="practice_quizzes/cs_quiz.php">Computer Science</a></div>
</div>

<div class="back-container">
<a href="practice_exams.php" class="back">Back</a>
</div>

</body>
</html>
