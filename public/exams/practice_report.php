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
<title>Practice Report</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#f0fdf4;}
.header{background:#16a34a;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:900px;margin:40px auto;padding:20px;}
.tips-card{background:#dcfce7;padding:35px;border-radius:20px;box-shadow:0 12px 28px rgba(0,0,0,0.08);margin-bottom:30px;}
.tips-card h2{color:#15803d;margin-bottom:20px;text-align:center;}
.tips-card ul{color:#065f46;line-height:1.8;font-size:16px;}
.tips-card ul li{margin-bottom:12px;}
.actions{text-align:center;margin-top:30px;}
.button{display:inline-block;padding:14px 30px;background:#16a34a;color:#fff;text-decoration:none;border-radius:30px;transition:0.2s;margin:5px;}
.button:hover{background:#15803d;}
</style>
</head>
<body>

<div class="header">
<h1>Practice Report</h1>
<p>Focus on improving your overall performance</p>
</div>

<div class="container">

<div class="tips-card">
<h2>Tips to Improve Your Performance</h2>
<ul>
<li>Practice regularly to strengthen your understanding of key concepts.</li>
<li>Review topics you find difficult and clarify doubts with reference materials.</li>
<li>Use practice quizzes to identify weak areas and focus on them.</li>
<li>Time yourself while solving problems to improve speed and accuracy.</li>
<li>Take short breaks during study sessions to stay fresh and focused.</li>
<li>Revise notes and important formulas frequently.</li>
<li>Discuss challenging problems with peers or mentors to gain new perspectives.</li>
<li>Maintain a positive mindset and stay consistent with your practice.</li>
<li>Track your progress over time and celebrate small improvements.</li>
<li>Balance practice across all subjects to ensure overall readiness.</li>
</ul>
</div>

<div class="actions">
<a href="practice_exams.php" class="button">Back to Exam</a>

</div>

</div>

</body>
</html>
