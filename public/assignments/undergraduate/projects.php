<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}
$user_name = $_SESSION['user_name'] ?? 'Student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Projects | Undergraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#eef2f7;
}
.container{
    max-width:1100px;
    margin:40px auto;
    padding:20px;
}
h2{
    text-align:center;
    color:#0f172a;
    font-size:34px;
    margin-bottom:40px;
}
.card-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}
.card{
    background:#fff;
    border-left:6px solid #2563eb;
    border-radius:16px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:transform 0.3s, box-shadow 0.3s;
}
.card:hover{
    transform:translateY(-8px);
    box-shadow:0 14px 28px rgba(0,0,0,0.15);
}
.card h3{
    margin-bottom:12px;
    color:#1e3a8a;
    font-size:22px;
}
.card p{
    font-size:15px;
    color:#475569;
    line-height:1.6;
    margin-bottom:20px;
}
.card a{
    display:inline-block;
    padding:10px 18px;
    background:#1e3a8a;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}
.card a:hover{
    background:#2563eb;
}
.back{
    display:inline-block;
    margin-top:40px;
    padding:12px 20px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    transition:0.3s;
}
.back:hover{
    background:#dc2626;
}
</style>
</head>
<body>

<div class="container">
<h2>Undergraduate Projects</h2>

<div class="card-grid">
    <div class="card">
        <h3>Mini Project</h3>
        <p>Small-scale projects aimed at enhancing learning and practical skills.</p>
        <a href="project_view.php?type=mini">View Details</a>
    </div>
    <div class="card">
        <h3>Major Project</h3>
        <p>Comprehensive projects demonstrating mastery of concepts, including detailed documentation.</p>
        <a href="project_view.php?type=major">View Details</a>
    </div>
    <div class="card">
        <h3>Group Project</h3>
        <p>Collaborative projects where teams develop solutions, promoting teamwork and problem-solving.</p>
        <a href="project_view.php?type=group">View Details</a>
    </div>
    <div class="card">
        <h3>Research Based Project</h3>
        <p>Projects integrating research methodology, analysis, and application.</p>
        <a href="project_view.php?type=research">View Details</a>
    </div>
    <div class="card">
        <h3>Capstone Project</h3>
        <p>Final-year projects that consolidate skills and knowledge acquired throughout the course.</p>
        <a href="project_view.php?type=capstone">View Details</a>
    </div>
</div>

<a href="../undergraduate_assignments.php" class="back">← Back to Assignments</a>
</div>

</body>
</html>
