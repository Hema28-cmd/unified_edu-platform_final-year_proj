<?php
session_start();

/* 🔐 Teacher-only access */
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
<title>Secondary Dashboard | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Inter', sans-serif;
    background:#f1f5f9;
    color:#1e293b;
    padding:20px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(90deg,#0f766e,#1e40af);
    padding:16px 30px;
    border-radius:14px;
    box-shadow:0 8px 24px rgba(0,0,0,0.2);
}
.navbar h2{
    font-family:'Montserrat', sans-serif;
    font-size:22px;
    color:#fff;
}
.navbar a{
    color:#e0f2fe;
    text-decoration:none;
    margin-left:20px;
    font-weight:500;
}
.navbar a:hover{color:#fcd34d;}

/* HERO */
.hero{
    margin:30px 0;
    padding:30px;
    border-radius:24px;
    background:linear-gradient(135deg,#ccfbf1,#e0e7ff);
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.hero h1{
    font-family:'Montserrat', sans-serif;
    font-size:28px;
    color:#0f172a;
}
.hero p{
    margin-top:10px;
    color:#334155;
}

/* GRID LAYOUT */
.grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
}

/* SECTION CARD */
.card{
    background:#ffffff;
    border-radius:22px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
    margin-bottom:20px;
}
.card h2{
    font-size:20px;
    color:#1e40af;
    margin-bottom:15px;
}

/* SUBJECT LIST */
.subjects{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
}
.subject{
    background:linear-gradient(135deg,#e0f2fe,#bae6fd);
    padding:15px;
    border-radius:18px;
}
.subject h4{
    color:#075985;
}
.subject p{
    font-size:13px;
    margin-top:5px;
}

/* QUIZ SAMPLE */
.quiz{
    background:linear-gradient(135deg,#fef3c7,#fde68a);
    padding:15px;
    border-radius:18px;
    margin-bottom:12px;
}
.quiz strong{color:#92400e;}

/* ASSIGNMENTS */
.assignment{
    background:linear-gradient(135deg,#ede9fe,#c7d2fe);
    padding:15px;
    border-radius:18px;
    margin-bottom:12px;
}

/* PROJECT IDEAS */
.project{
    background:linear-gradient(135deg,#dcfce7,#86efac);
    padding:18px;
    border-radius:18px;
    margin-bottom:15px;
}
.project h4{color:#166534;}
.project ul{
    padding-left:18px;
    margin-top:8px;
}
.project li{font-size:13px;}

/* QUICK LINKS */
.links{
    display:grid;
    gap:15px;
}
.link{
    background:linear-gradient(135deg,#fb7185,#f97316);
    padding:18px;
    border-radius:20px;
    text-align:center;
    color:#fff;
    font-weight:600;
    text-decoration:none;
    box-shadow:0 8px 22px rgba(0,0,0,0.15);
}
.link:hover{
    transform:translateY(-4px);
}

/* RESPONSIVE */
@media(max-width:900px){
    .grid{grid-template-columns:1fr;}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Secondary Section</h2>
    <div>
        <a href="secondary_lessons.php">Lessons</a>
        <a href="secondary_books.php">Books</a>
        <a href="secondary_quizzes.php">Quizzes</a>
        <a href="secondary_assignments.php">Assignments</a>
        <a href="secondary_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 👋</h1>
    <p>Plan lessons, share resources, conduct quizzes, assign work, and guide students with meaningful project ideas.</p>
</div>

<!-- MAIN GRID -->
<div class="grid">

<!-- LEFT CONTENT -->
<div>

<!-- LESSONS -->
<div class="card">
    <h2>📘 Lessons (Secondary Syllabus)</h2>
    <div class="subjects">
        <div class="subject">
            <h4>Mathematics</h4>
            <p>Algebra, Geometry, Trigonometry, Statistics</p>
        </div>
        <div class="subject">
            <h4>Science</h4>
            <p>Physics, Chemistry, Biology (Experiments)</p>
        </div>
        <div class="subject">
            <h4>Social Studies</h4>
            <p>History, Geography, Civics</p>
        </div>
        <div class="subject">
            <h4>Computer Science</h4>
            <p>HTML, Basics of Programming, Digital Skills</p>
        </div>
    </div>
</div>

<!-- SAMPLE QUIZZES -->
<div class="card">
    <h2>📝 Sample Quizzes</h2>
    <div class="quiz">
        <strong>Math:</strong> Solve 5 linear equations
    </div>
    <div class="quiz">
        <strong>Science:</strong> Identify parts of a plant cell
    </div>
    <div class="quiz">
        <strong>Social:</strong> Match historical events with years
    </div>
</div>

<!-- ASSIGNMENTS -->
<div class="card">
    <h2>📂 Assignments</h2>
    <div class="assignment">📌 Write a short note on Renewable Energy</div>
    <div class="assignment">📌 Solve 10 Algebra problems</div>
    <div class="assignment">📌 Prepare a chart on Climate Zones</div>
</div>

</div>

<!-- RIGHT CONTENT -->
<div>

<!-- PROJECT IDEAS -->
<div class="card">
    <h2>🚀 Project Ideas (with Tips)</h2>

    <div class="project">
        <h4>🌱 Science Project</h4>
        <ul>
            <li>Topic: Water Conservation</li>
            <li>Tip: Use charts & real-life examples</li>
            <li>Trick: Add before/after comparison</li>
        </ul>
    </div>

    <div class="project">
        <h4>💻 Computer Project</h4>
        <ul>
            <li>Topic: Simple School Website</li>
            <li>Tip: Use HTML & CSS basics</li>
            <li>Trick: Add navigation menu</li>
        </ul>
    </div>

    <div class="project">
        <h4>📜 Social Studies Project</h4>
        <ul>
            <li>Topic: Indian Freedom Fighters</li>
            <li>Tip: Include timelines</li>
            <li>Trick: Add pictures & maps</li>
        </ul>
    </div>
</div>

<!-- QUICK LINKS -->
<div class="links">
    <a href="secondary_lessons.php" class="link">📘 Manage Lessons</a>
    <a href="secondary_books.php" class="link">📚 View Books</a>
    <a href="secondary_quizzes.php" class="link">📝 Create Quizzes</a>
    <a href="secondary_assignments.php" class="link">📂 Assign Work</a>
</div>

</div>
</div>

</body>
</html>
