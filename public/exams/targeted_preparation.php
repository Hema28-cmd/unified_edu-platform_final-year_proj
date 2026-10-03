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
<title>Targeted Preparation</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#fefce8;}
.header{background:#b45309;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.2em;}
.grid{max-width:1200px;margin:40px auto;display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:30px;padding:20px;}
.card{background:#fff7ed;padding:30px;border-radius:25px;box-shadow:0 12px 28px rgba(0,0,0,0.1);transition:0.3s;display:flex;flex-direction:column;justify-content:space-between;}
.card:hover{transform:translateY(-5px);box-shadow:0 15px 35px rgba(0,0,0,0.15);}
.card h3{color:#9a3412;margin-bottom:15px;font-size:1.5em;}
.card p{color:#78350f;line-height:1.6;}
.card .icon{font-size:40px;margin-bottom:15px;color:#d97706;}
.actions{text-align:center;margin-top:30px;}
.button{display:inline-block;padding:14px 30px;background:#b45309;color:#fff;text-decoration:none;border-radius:30px;transition:0.2s;margin:5px;}
.button:hover{background:#9a3412;}
</style>
</head>
<body>

<div class="header">
<h1>Targeted Preparation</h1>
<p>Smart learning strategies based on your performance</p>
</div>

<div class="grid">
<div class="card">
<div class="icon">📌</div>
<h3>Weak Area Focus</h3>
<p>Identify your weak topics and focus your studies on chapters that need improvement to boost scores efficiently.</p>
</div>

<div class="card">
<div class="icon">📅</div>
<h3>Revision Plan</h3>
<p>Create a structured daily and weekly revision schedule to consolidate learning and retain key concepts effectively.</p>
</div>

<div class="card">
<div class="icon">📝</div>
<h3>Practice Boost</h3>
<p>Access additional practice sets, quizzes, and problem-solving exercises to strengthen your understanding of difficult topics.</p>
</div>

<div class="card">
<div class="icon">⏱️</div>
<h3>Time Management</h3>
<p>Learn to manage your study and exam time effectively to maximize performance during assessments and practice tests.</p>
</div>

<div class="card">
<div class="icon">📚</div>
<h3>Resource Recommendations</h3>
<p>Get curated study materials, notes, and reference books tailored to your weak areas and overall preparation needs.</p>
</div>

<div class="card">
<div class="icon">🎯</div>
<h3>Goal Setting</h3>
<p>Set clear daily, weekly, and monthly learning targets to track your progress and stay motivated throughout your preparation.</p>
</div>
</div>

<div class="actions">
<a href="practice_exams.php" class="button">Back to Exam</a>

</div>

</body>
</html>
