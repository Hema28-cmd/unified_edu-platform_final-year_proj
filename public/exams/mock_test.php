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
<title>Start Mock Test</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#f0f9ff;}
.header{background:#0284c7;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:900px;margin:40px auto;padding:20px;}
.card{background:#e0f2fe;padding:30px;border-radius:20px;margin-bottom:25px;box-shadow:0 12px 28px rgba(0,0,0,0.08);transition:0.3s;}
.card:hover{transform:translateY(-5px);box-shadow:0 18px 35px rgba(0,0,0,0.12);}
.card h2{color:#0369a1;margin-bottom:15px;}
.card ul{color:#1e293b;line-height:1.8;margin-left:20px;}
.card li{margin-bottom:12px;}
.actions{display:flex;justify-content:space-between;flex-wrap:wrap;margin-top:20px;}
.button{display:inline-block;padding:12px 30px;background:#0284c7;color:#fff;text-decoration:none;border-radius:30px;transition:0.2s;margin-top:10px;}
.button:hover{background:#0369a1;}
.section{margin-top:20px;}
.section h3{color:#075985;margin-bottom:10px;}
.section p{color:#334155;line-height:1.6;}
</style>
</head>
<body>

<div class="header">
<h1>Start Mock Test</h1>
<p>Simulated exam to assess your knowledge across subjects</p>
</div>

<div class="container">

<div class="card">
<h2>Instructions Before Starting</h2>
<ul>
<li>Ensure a stable internet connection during the test.</li>
<li>All questions are mandatory unless specified.</li>
<li>Each question has a time limit; auto submission occurs after time expires.</li>
<li>No backtracking on certain sections (e.g., timed numerical questions).</li>
<li>Keep pen and paper handy for rough work.</li>
<li>Read questions carefully before answering.</li>
<li>Score will be displayed immediately after submission.</li>
</ul>
</div>

<div class="card section">
<h3>Sections in This Mock Test</h3>
<p>This mock test consists of multiple sections covering key undergraduate subjects:</p>
<ul>
<li><strong>Mathematics:</strong> Problem-solving, algebra, calculus, and formulas.</li>
<li><strong>Physics:</strong> Numerical, conceptual, and derivation-based questions.</li>
<li><strong>Chemistry:</strong> Reactions, equations, and logical reasoning.</li>
<li><strong>Computer Science:</strong> Programming, logic, and theoretical knowledge.</li>
</ul>
</div>

<div class="card section">
<h3>Tips for Maximizing Score</h3>
<ul>
<li>Attempt easier questions first to secure marks.</li>
<li>Keep track of time for each section.</li>
<li>Double-check answers if time permits.</li>
<li>Stay calm and focus on one question at a time.</li>
<li>Do not refresh or close the browser during the test.</li>
</ul>
</div>

<div class="actions">
<a href="mock_test_start.php" class="button">Start Mock Test</a>
<a href="practice_exams.php" class="button">Back</a>
</div>

</div>

</body>
</html>
