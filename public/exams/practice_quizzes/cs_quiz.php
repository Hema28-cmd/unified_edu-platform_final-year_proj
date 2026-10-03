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
<title>Computer Science Important Questions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#eef2ff;}
.header{background:#5b21b6;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:950px;margin:40px auto;}
.card{background:#f5f3ff;padding:30px;border-radius:20px;margin-bottom:25px;box-shadow:0 12px 28px rgba(0,0,0,0.08);transition:0.3s;}
.card:hover{transform:translateY(-5px);box-shadow:0 18px 35px rgba(0,0,0,0.12);}
.card h3{color:#4c1d95;margin-bottom:12px;}
.card p{color:#1e293b;line-height:1.6;}
.back{display:inline-block;margin-top:20px;padding:12px 28px;background:#5b21b6;color:#fff;border-radius:30px;text-decoration:none;transition:0.2s;}
.back:hover{background:#4c1d95;}
</style>
</head>
<body>

<div class="header">
<h1>Computer Science Important Questions</h1>
<p>Key programming and theory concepts for review</p>
</div>

<div class="container">

<div class="card">
<h3>1. Which language is used for web development?</h3>
<p>Answer: All of the above (HTML, Python, JavaScript)</p>
</div>

<div class="card">
<h3>2. What does SQL stand for?</h3>
<p>Answer: Structured Query Language</p>
</div>

<div class="card">
<h3>3. What is the main function of an Operating System?</h3>
<p>Answer: To manage computer hardware and software resources</p>
</div>

<div class="card">
<h3>4. What is a loop in programming?</h3>
<p>Answer: A block of code that repeats until a condition is met</p>
</div>

<div class="card">
<h3>5. Which data structure uses FIFO (First In First Out)?</h3>
<p>Answer: Queue</p>
</div>

<div class="card">
<h3>6. What is the time complexity of binary search?</h3>
<p>Answer: O(log n)</p>
</div>

<div class="card">
<h3>7. What is the use of HTML?</h3>
<p>Answer: To structure the content on web pages</p>
</div>

<a href="../practice_subjects.php" class="back">Back</a>

</div>

</body>
</html>
