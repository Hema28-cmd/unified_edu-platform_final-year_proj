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
<title>High School Dashboard | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#ecfeff,#f8fafc);
    color:#1f2937;
    padding:24px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(90deg,#0f766e,#065f46);
    padding:18px 36px;
    border-radius:16px;
    box-shadow:0 8px 26px rgba(0,0,0,0.2);
}
.navbar h2{
    font-family:'Playfair Display', serif;
    color:#fff;
}
.navbar a{
    color:#d1fae5;
    margin-left:20px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#fde68a;}

/* HERO */
.hero{
    margin:30px 0;
    padding:34px;
    background:#ffffff;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.14);
}
.hero h1{
    font-family:'Playfair Display', serif;
    font-size:30px;
    color:#064e3b;
}
.hero p{
    margin-top:12px;
    font-size:16px;
    color:#475569;
}

/* FOCUS CARDS */
.focus{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:24px;
    margin-top:30px;
}
.focus-card{
    background:linear-gradient(135deg,#fef3c7,#fde68a);
    padding:24px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.15);
}
.focus-card h3{
    color:#92400e;
    margin-bottom:8px;
}
.focus-card p{
    font-size:14px;
    color:#4b5563;
}

/* SUBJECTS */
.subjects{
    margin-top:45px;
}
.subjects h2{
    font-size:22px;
    color:#065f46;
    margin-bottom:18px;
}
.subject-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:26px;
}
.subject-card{
    background:#ffffff;
    padding:22px;
    border-radius:22px;
    box-shadow:0 10px 28px rgba(0,0,0,0.15);
}
.subject-card h3{
    color:#0f766e;
}
.subject-card p{
    font-size:14px;
    margin-top:6px;
    color:#475569;
}

/* STRATEGY */
.strategy{
    margin-top:45px;
    background:linear-gradient(135deg,#e0f2fe,#bae6fd);
    padding:30px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.strategy h2{
    color:#075985;
    margin-bottom:12px;
}
.strategy ul{
    padding-left:20px;
}
.strategy li{
    margin-bottom:10px;
    font-size:14px;
}

/* TOOLS */
.tools{
    margin-top:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:18px;
}
.tool-card{
    background:linear-gradient(135deg,#a7f3d0,#34d399);
    padding:18px;
    border-radius:20px;
    text-align:center;
    font-weight:600;
    color:#064e3b;
    text-decoration:none;
    box-shadow:0 8px 24px rgba(0,0,0,0.15);
    transition:0.3s;
}
.tool-card:hover{
    transform:translateY(-5px);
}

/* NOTE */
.note{
    margin-top:45px;
    background:linear-gradient(135deg,#ede9fe,#ddd6fe);
    padding:28px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.18);
}
.note h3{
    color:#5b21b6;
}
.note p{
    font-size:14px;
    margin-top:8px;
    line-height:1.6;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>High School Section</h2>
    <div>
        <a href="highschool_lessons.php">Lessons</a>
        <a href="highschool_books.php">Books</a>
        <a href="highschool_quizzes.php">Quizzes</a>
        <a href="highschool_assignments.php">Assignments</a>
        <a href="highschool_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 👋</h1>
    <p>
        This dashboard helps you plan, deliver, and manage high school academics
        with a strong focus on conceptual clarity, skill development,
        and career readiness.
    </p>
</div>

<!-- FOCUS AREAS -->
<div class="focus">
    <div class="focus-card">
        <h3>📘 Concept Mastery</h3>
        <p>Strengthening fundamentals through structured lessons, examples, and guided practice.</p>
    </div>
    <div class="focus-card">
        <h3>🧠 Critical Thinking</h3>
        <p>Encouraging analysis, reasoning, and problem-solving across subjects.</p>
    </div>
    <div class="focus-card">
        <h3>🚀 Skill Development</h3>
        <p>Building communication, collaboration, and digital skills.</p>
    </div>
</div>

<!-- SUBJECTS -->
<div class="subjects">
    <h2>High School Curriculum Overview</h2>
    <div class="subject-grid">
        <div class="subject-card">
            <h3>📐 Mathematics</h3>
            <p>Advanced algebra, trigonometry, calculus foundations, and statistics.</p>
        </div>
        <div class="subject-card">
            <h3>🔬 Science</h3>
            <p>Physics, Chemistry, Biology with experiments and real-world applications.</p>
        </div>
        <div class="subject-card">
            <h3>📖 Languages</h3>
            <p>Reading comprehension, writing skills, literature analysis.</p>
        </div>
        <div class="subject-card">
            <h3>🌍 Social Sciences</h3>
            <p>History, Geography, Civics, and Economics for global awareness.</p>
        </div>
        <div class="subject-card">
            <h3>💻 Computer Science</h3>
            <p>Programming basics, algorithms, and digital literacy.</p>
        </div>
    </div>
</div>

<!-- STRATEGY -->
<div class="strategy">
    <h2>Teaching & Assessment Strategy</h2>
    <ul>
        <li>Blend lectures with activities and discussions</li>
        <li>Use quizzes as formative assessments</li>
        <li>Promote project-based and inquiry learning</li>
        <li>Encourage presentations and peer learning</li>
    </ul>
</div>

<!-- TOOLS -->
<div class="tools">
    <a href="highschool_lessons.php" class="tool-card">📚 Lessons</a>
    <a href="highschool_books.php" class="tool-card">📖 Books</a>
    <a href="highschool_quizzes.php" class="tool-card">📝 Sample Quizzes</a>
    <a href="highschool_assignments.php" class="tool-card">📂 Assignments</a>
    <a href="highschool_projects.php" class="tool-card">🚀 Project Ideas</a>
</div>

<!-- NOTE -->
<div class="note">
    <h3>Teacher Tip</h3>
    <p>
        High school students benefit most from real-world examples,
        interdisciplinary projects, and consistent feedback.
        Encourage independent learning and career exploration.
    </p>
</div>

</body>
</html>
