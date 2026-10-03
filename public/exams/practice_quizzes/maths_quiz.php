<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Mathematics Important Questions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#eef2ff;}
.header{background:#4338ca;color:#fff;padding:40px;text-align:center;}
.quiz{max-width:850px;margin:40px auto;background:#fff;padding:30px;border-radius:24px;box-shadow:0 12px 30px rgba(0,0,0,0.1);}
.question{margin-bottom:25px;}
.question h3{color:#1e3a8a;}
label{display:block;margin:6px 0;color:#475569;}
.back{padding:12px 30px;background:#4338ca;color:#fff;border:none;border-radius:30px;text-decoration:none;}
</style>
</head>
<body>

<div class="header">
<h1>Mathematics Important Questions</h1>
<p>Review only important questions</p>
</div>

<div class="quiz">
<div class="question">
<h3>1. What is the derivative of x²?</h3>
<label>Answer: 2x</label>
</div>

<div class="question">
<h3>2. Value of sin(90°)?</h3>
<label>Answer: 1</label>
</div>

<div class="question">
<h3>3. Integrate x dx</h3>
<label>Answer: (1/2)x² + C</label>
</div>

<a href="../practice_subjects.php" class="back">Back</a>
</div>

</body>
</html>
