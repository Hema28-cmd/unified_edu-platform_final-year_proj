<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Academic Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

body{
    font-family:'Inter',sans-serif;
    background:#f4f6f9;
    color:#1e293b;
    padding:28px;
}

/* 🌟 UPDATED NAVBAR */
.navbar{
    background:linear-gradient(135deg,#064e3b,#022c22);
    padding:22px 40px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 36px rgba(0,0,0,0.35);
}
.navbar h2{
    font-family:'Playfair Display',serif;
    font-size:26px;
    font-weight:700;
    color:#ecfeff;
    letter-spacing:0.6px;
}
.navbar .nav-links a{
    color:#d1fae5;
    text-decoration:none;
    margin-left:26px;
    font-size:14px;
    font-weight:500;
    position:relative;
}
.navbar .nav-links a::after{
    content:'';
    position:absolute;
    left:0;
    bottom:-6px;
    width:0;
    height:2px;
    background:#facc15;
    transition:0.3s;
}
.navbar .nav-links a:hover::after{
    width:100%;
}
.navbar .nav-links a:hover{
    color:#fde68a;
}

/* OVERVIEW */
.overview{
    margin:32px 0;
    background:linear-gradient(135deg,#0f766e,#0f172a);
    color:#ecfeff;
    padding:36px;
    border-radius:26px;
}
.overview h1{
    font-family:'Playfair Display',serif;
    font-size:34px;
}
.overview p{
    margin-top:12px;
    max-width:900px;
    line-height:1.7;
    font-size:16px;
}

/* SPLIT PANEL */
.split{
    display:grid;
    grid-template-columns:1.2fr 1fr;
    gap:28px;
    margin-top:40px;
}

.panel{
    background:#ffffff;
    padding:32px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.1);
}
.panel h3{
    font-size:22px;
    margin-bottom:12px;
    color:#0f766e;
}
.panel ul{padding-left:18px}
.panel li{
    margin-bottom:8px;
    font-size:15px;
}

.side-panel{
    background:#fefce8;
    padding:32px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.1);
}
.side-panel h3{
    font-size:20px;
    color:#92400e;
}
.side-panel p{
    margin-top:10px;
    font-size:14px;
    line-height:1.6;
}

/* TRACKS */
.tracks{
    margin-top:46px;
}
.tracks h2{
    font-family:'Playfair Display',serif;
    font-size:26px;
    margin-bottom:18px;
}
.track-row{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:22px;
}
.track{
    background:linear-gradient(135deg,#ecfeff,#f8fafc);
    padding:26px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.12);
}
.track h4{
    color:#075985;
    font-size:17px;
    margin-bottom:8px;
}

/* PROJECTS */
.projects{
    margin-top:48px;
    background:#ffffff;
    padding:36px;
    border-radius:28px;
    box-shadow:0 14px 34px rgba(0,0,0,0.14);
}
.projects h2{
    font-family:'Playfair Display',serif;
    font-size:26px;
    margin-bottom:18px;
}
.project-list{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
}
.project{
    background:#f1f5f9;
    padding:24px;
    border-radius:20px;
}
.project b{color:#0f172a}

/* CAREER */
.career{
    margin-top:46px;
    background:linear-gradient(135deg,#ede9fe,#faf5ff);
    padding:36px;
    border-radius:28px;
}
.career h2{
    font-size:26px;
    color:#5b21b6;
}
.career ul{
    margin-top:12px;
    padding-left:20px;
}

/* FOOTER */
.footer{
    margin-top:50px;
    text-align:center;
    font-size:13px;
    color:#64748b;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Undergraduate Academic Panel</h2>
    <div class="nav-links">
        <a href="undergraduate_lessons.php">Lessons</a>
        <a href="undergraduate_books.php">Books</a>
        <a href="undergraduate_quizzes.php">Quizzes</a>
        <a href="undergraduate_assignments.php">Assignments</a>
        <a href="undergraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- OVERVIEW -->
<div class="overview">
    <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?></h1>
    <p>
        This undergraduate academic framework emphasizes deep conceptual learning,
        industry exposure, research orientation, and professional readiness.
    </p>
</div>

<!-- (Rest of the page content remains the same) -->

<div class="footer">
    Undergraduate Academic Management • Unified Edu System
</div>

</body>
</html>


<!-- SPLIT -->
<div class="split">

    <div class="panel">
        <h3>📘 Academic Components</h3>
        <ul>
            <li>Core & elective subject modules</li>
            <li>Outcome-based lesson planning</li>
            <li>Continuous internal evaluation</li>
            <li>Research & seminar integration</li>
            <li>Practical and lab-oriented learning</li>
        </ul>
    </div>

    <div class="side-panel">
        <h3>📌 Teaching Focus</h3>
        <p>
            Emphasis on analytical thinking, problem solving, peer collaboration,
            and ethical academic practices. Encourage independent learning
            and innovation among students.
        </p>
    </div>

</div>

<!-- TRACKS -->
<div class="tracks">
    <h2>🎯 Learning Tracks</h2>
    <div class="track-row">
        <div class="track">
            <h4>Technical Mastery</h4>
            Programming, data structures, databases, system design
        </div>
        <div class="track">
            <h4>Research & Innovation</h4>
            Literature survey, paper writing, experimentation
        </div>
        <div class="track">
            <h4>Assessment & Evaluation</h4>
            Quizzes, assignments, presentations, viva
        </div>
        <div class="track">
            <h4>Professional Skills</h4>
            Communication, teamwork, leadership
        </div>
    </div>
</div>

<!-- PROJECTS -->
<div class="projects">
    <h2>🚀 Suggested Student Projects</h2>
    <div class="project-list">
        <div class="project"><b>Web Application</b><br>CRUD system with authentication</div>
        <div class="project"><b>Data Analytics</b><br>Dataset analysis & visualization</div>
        <div class="project"><b>AI / ML</b><br>Prediction or recommendation system</div>
        <div class="project"><b>Mini Research</b><br>Survey + implementation</div>
        <div class="project"><b>Capstone</b><br>Industry-oriented final project</div>
    </div>
</div>

<!-- CAREER -->
<div class="career">
    <h2>🎓 Career & Industry Readiness</h2>
    <ul>
        <li>Internship preparation & guidance</li>
        <li>Placement-oriented skill mapping</li>
        <li>Resume & portfolio development</li>
        <li>Open-source & GitHub exposure</li>
        <li>Ethics, professionalism & teamwork</li>
    </ul>
</div>

<div class="footer">
    Undergraduate Academic Management • Unified Edu System
</div>

</body>
</html>
