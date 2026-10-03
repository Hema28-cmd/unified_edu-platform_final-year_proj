<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Dashboard | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

/* BASE */
body{
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#f5f3ff,#f8fafc);
    color:#0f172a;
    padding:28px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#312e81,#4c1d95);
    padding:24px 36px;
    border-radius:26px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 18px 38px rgba(0,0,0,0.35);
}
.navbar h2{
    font-family:'Playfair Display',serif;
    color:#e9d5ff;
    font-size:26px;
}
.navbar a{
    color:#ddd6fe;
    margin-left:22px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff}

/* HERO */
.hero{
    margin-top:40px;
    background:#ffffff;
    padding:44px;
    border-radius:34px;
    box-shadow:0 18px 34px rgba(0,0,0,0.18);
}
.hero h1{
    font-family:'Playfair Display',serif;
    font-size:32px;
    color:#4c1d95;
}
.hero p{
    margin-top:16px;
    font-size:16px;
    color:#475569;
    line-height:1.8;
}

/* STATS */
.stats{
    margin-top:42px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:24px;
}
.stat{
    background:linear-gradient(135deg,#ede9fe,#f5f3ff);
    padding:26px;
    border-radius:22px;
    box-shadow:0 12px 26px rgba(0,0,0,0.14);
}
.stat h3{
    font-size:22px;
    color:#312e81;
}
.stat span{
    font-size:13px;
    color:#475569;
}

/* MODULES */
.modules{
    margin-top:52px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:28px;
}
.module{
    background:#020617;
    padding:28px;
    border-radius:26px;
    box-shadow:0 16px 30px rgba(0,0,0,0.45);
}
.module h3{
    color:#c4b5fd;
    margin-bottom:10px;
}
.module p{
    font-size:14px;
    color:#cbd5f5;
    line-height:1.6;
}
.module ul{
    margin-top:14px;
    padding-left:18px;
}
.module li{
    font-size:13px;
    margin-bottom:8px;
    color:#e5e7eb;
}
.module a{
    display:inline-block;
    margin-top:16px;
    color:#a5b4fc;
    font-size:14px;
    text-decoration:none;
}
.module a:hover{color:#ffffff}

/* RESEARCH */
.research{
    margin-top:60px;
    background:linear-gradient(135deg,#1e1b4b,#020617);
    padding:46px;
    border-radius:36px;
    color:#e5e7eb;
}
.research h2{
    color:#a5b4fc;
    margin-bottom:14px;
}
.research li{
    margin-bottom:12px;
    font-size:15px;
}

/* ACTIONS */
.actions{
    margin-top:50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#4c1d95;
    color:#ede9fe;
    padding:14px 36px;
    border-radius:20px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#3730a3}
.note{
    font-size:13px;
    color:#475569;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Postgraduate Programme</h2>
    <div>
        <a href="postgraduate_lessons.php">Lessons</a>
        <a href="postgraduate_books.php">Books</a>
        <a href="postgraduate_quizzes.php">Quizzes</a>
        <a href="postgraduate_assignments.php">Assignments</a>
        <a href="postgraduate_projects.php">Projects</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h1>Advanced Learning & Research Excellence</h1>
    <p>
        The postgraduate programme focuses on advanced theoretical knowledge,
        research methodology, critical analysis, and real-world problem solving.
        Students are prepared for academic research, industry leadership,
        and doctoral studies.
    </p>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat">
        <h3>4</h3>
        <span>Core Specialization Areas</span>
    </div>
    <div class="stat">
        <h3>12+</h3>
        <span>Advanced Research Topics</span>
    </div>
    <div class="stat">
        <h3>6</h3>
        <span>Industry-Aligned Projects</span>
    </div>
    <div class="stat">
        <h3>100%</h3>
        <span>Research-Oriented Curriculum</span>
    </div>
</div>

<!-- MODULES -->
<div class="modules">

    <div class="module">
        <h3>📘 Advanced Lessons</h3>
        <p>In-depth subject knowledge with analytical focus.</p>
        <ul>
            <li>Advanced Algorithms & Theory</li>
            <li>Research Methodology</li>
            <li>Case Study Discussions</li>
        </ul>
        <a href="postgraduate_lessons.php">Explore Lessons →</a>
    </div>

    <div class="module">
        <h3>📚 Reference Books</h3>
        <p>International-level academic and research books.</p>
        <ul>
            <li>Springer & IEEE references</li>
            <li>Research journals</li>
            <li>Conference proceedings</li>
        </ul>
        <a href="postgraduate_books.php">View Books →</a>
    </div>

    <div class="module">
        <h3>🧠 Advanced Quizzes</h3>
        <p>Evaluate conceptual clarity and critical thinking.</p>
        <ul>
            <li>Scenario-based questions</li>
            <li>Research-oriented MCQs</li>
            <li>Analytical problem solving</li>
        </ul>
        <a href="postgraduate_quizzes.php">Start Quizzes →</a>
    </div>

    <div class="module">
        <h3>📝 Assignments</h3>
        <p>Focus on analysis, literature review, and implementation.</p>
        <ul>
            <li>Research paper reviews</li>
            <li>System design reports</li>
            <li>Technical documentation</li>
        </ul>
        <a href="postgraduate_assignments.php">View Assignments →</a>
    </div>

    <div class="module">
        <h3>💡 Projects</h3>
        <p>Industry-ready and research-driven projects.</p>
        <ul>
            <li>AI & Data Science projects</li>
            <li>Cybersecurity systems</li>
            <li>Cloud & DevOps solutions</li>
        </ul>
        <a href="postgraduate_projects.php">Explore Projects →</a>
    </div>

</div>

<!-- RESEARCH -->
<div class="research">
    <h2>🔬 Research & Thesis Focus</h2>
    <ul>
        <li>Literature survey & gap identification</li>
        <li>Experimental design & validation</li>
        <li>IEEE / Scopus paper preparation</li>
        <li>Plagiarism standards & ethics</li>
        <li>Thesis writing & viva preparation</li>
    </ul>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="../public/logout.php class="back-btn">⬅ Back to Teacher Dashboard</a>
    <div class="note">
        Postgraduate Curriculum • Research-Oriented Education
    </div>
</div>

</body>
</html>
