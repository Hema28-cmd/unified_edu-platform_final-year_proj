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
<title>Primary Class Teacher Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', 'Segoe UI', sans-serif;
}

/* 🌈 BACKGROUND */
body{
    min-height:100vh;
    background: linear-gradient(135deg,#fef3ff,#dbeafe);
    color:#1f2937;
}

/* 🔝 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#3b82f6,#14b8a6);
    color:#fff;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 12px 30px rgba(0,0,0,0.2);
    border-radius:12px;
}
.navbar h2{font-size:22px; font-family: 'Fredoka One', cursive; font-weight:500;}
.navbar a{
    color:#fff;
    text-decoration:none;
    margin-left:20px;
    font-weight:500;
    transition:0.3s;
}
.navbar a:hover{color:#facc15;}

/* 📦 MAIN CONTAINER */
.container{
    max-width:1200px;
    margin:auto;
    padding:40px;
}

/* 👋 WELCOME */
.welcome{
    background:linear-gradient(135deg,#fef3c7,#fde68a);
    padding:35px;
    border-radius:28px;
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
    text-align:center;
}
.welcome h1{
    color:#ca8a04;
    font-size:34px;
    font-weight:500; /* Reduced boldness */
    font-family: 'Fredoka One', cursive;
}
.welcome p{
    margin-top:10px;
    font-size:16px;
    font-weight:400;
    color:#334155;
}

/* 🧩 GRID */
.grid{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
    margin-top:40px;
}

/* 📦 CARDS */
.card{
    background:linear-gradient(135deg,#dbeafe,#bfdbfe);
    padding:28px;
    border-radius:26px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    transition:0.3s;
}
.card:hover{
    transform: translateY(-5px);
    box-shadow:0 20px 40px rgba(0,0,0,0.25);
}
.card h3{
    color:#1e40af;
    margin-bottom:12px;
    font-family: 'Fredoka One', cursive;
    font-weight:500; /* Reduced boldness */
}
.card ul{
    padding-left:18px;
}
.card li{
    margin-bottom:8px;
    font-size:15px;
}

/* 📘 LARGE SECTIONS */
.section{
    margin-top:45px;
    background:linear-gradient(135deg,#d1fae5,#a7f3d0);
    padding:32px;
    border-radius:28px;
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
}
.section h2{
    color:#065f46;
    margin-bottom:18px;
    font-family: 'Fredoka One', cursive;
    font-weight:500; /* Reduced boldness */
}
.section p{
    font-size:15px;
    line-height:1.6;
    color:#334155;
}

/* 🚀 TIPS */
.tip-box{
    margin-top:12px;
    background:#fef9c3;
    padding:16px;
    border-left:6px solid #ca8a04;
    border-radius:12px;
    font-size:14px;
}

/* 🎯 BUTTONS */
.actions{
    margin-top:40px;
    display:flex;
    flex-wrap:wrap;
    gap:18px;
}
.action-btn{
    padding:14px 26px;
    border-radius:30px;
    background:linear-gradient(90deg,#f97316,#facc15);
    color:#fff;
    text-decoration:none;
    font-weight:500;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    transition:0.3s;
}
.action-btn:hover{
    transform: translateY(-3px);
    box-shadow:0 15px 30px rgba(0,0,0,0.25);
}
</style>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Fredoka+One&display=swap" rel="stylesheet">

</head>

<body>

<!-- 🔝 NAVBAR -->
<div class="navbar">
    <h2>👩‍🏫 Primary Class Panel</h2>
    <div>
        <a href="primary_lesson.php">Lessons</a>
        <a href="primary_books.php">Books</a>
        <a href="primary_quizzes.php">Quizzes</a>
        <a href="primary_assignments.php">Assignments</a>
        <a href="primary_project.php">Projects</a>
       
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <!-- 👋 WELCOME -->
    <div class="welcome">
        <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 🌟</h1>
        <p>
            Manage lessons, books, quizzes, assignments, projects, and extra-curricular activities for your primary students efficiently.
        </p>
    </div>

    <!-- 🧩 QUICK OVERVIEW -->
    <div class="grid">

        <div class="card">
            <h3>📘 Lessons</h3>
            <ul>
                <li>Reading & Writing</li>
                <li>Basic Math (Addition/Subtraction)</li>
                <li>Science Experiments</li>
                <li>Social Studies</li>
            </ul>
        </div>

        <div class="card">
            <h3>📚 Books</h3>
            <ul>
                <li>Story Books</li>
                <li>Picture Books</li>
                <li>Workbooks</li>
                <li>Reference Charts</li>
            </ul>
        </div>

        <div class="card">
            <h3>📝 Quizzes</h3>
            <ul>
                <li>Math Practice</li>
                <li>Spelling Tests</li>
                <li>Reading Comprehension</li>
                <li>Interactive Games</li>
            </ul>
        </div>

        <div class="card">
            <h3>🎨 Activities</h3>
            <ul>
                <li>Art & Craft</li>
                <li>Group Activities</li>
                <li>Music & Dance</li>
                <li>Outdoor Games</li>
            </ul>
        </div>

        <div class="card">
            <h3>🖍️ Writing Practice</h3>
            <ul>
                <li>Handwriting Exercises</li>
                <li>Sentence Formation</li>
                <li>Vocabulary Building</li>
            </ul>
        </div>

        <div class="card">
            <h3>🔬 Science Experiments</h3>
            <ul>
                <li>Plant Growth Observation</li>
                <li>Water Cycle Demonstration</li>
                <li>Simple Chemical Reactions</li>
            </ul>
        </div>

        <div class="card">
            <h3>🌍 Social Studies</h3>
            <ul>
                <li>Community Helpers</li>
                <li>Local Environment Awareness</li>
                <li>Festivals & Culture</li>
            </ul>
        </div>

        <div class="card">
            <h3>🎶 Music & Movement</h3>
            <ul>
                <li>Action Rhymes</li>
                <li>Simple Dance Steps</li>
                <li>Instrument Introduction</li>
            </ul>
        </div>

    </div>

    <!-- 📂 ASSIGNMENTS -->
    <div class="section">
        <h2>📂 Assignments</h2>
        <p>
            Assignments for primary students are creative, engaging, and age-appropriate.
        </p>
        <ul>
            <li>🖍️ Color a Picture</li>
            <li>➕ Solve Simple Math Problems</li>
            <li>✏️ Trace Letters & Words</li>
        </ul>
    </div>

    <!-- 🚀 PROJECT IDEAS -->
    <div class="section">
        <h2>🚀 Project Ideas</h2>
        <ul>
            <li>🌈 Color Chart Project</li>
            <li>🏠 My Family Tree Drawing</li>
            <li>🐶 Animal Collage</li>
        </ul>

        <div class="tip-box">
            💡 <strong>Tips:</strong>  
            Encourage creativity, allow light parental guidance, and appreciate all efforts.
        </div>
    </div>

    <!-- 🎯 QUICK ACTIONS -->
    <div class="actions">
        <a href="primary_lesson.php" class="action-btn">📘 View Lessons</a>
        <a href="primary_books.php" class="action-btn">📚 Browse Books</a>
        <a href="primary_quizzes.php" class="action-btn">📝 View Quizzes</a>
        <a href="primary_assignments.php" class="action-btn">📂 Assignments</a>
        <a href="primary_project.php" class="action-btn">🚀 Projects</a>
      
    </div>

</div>

</body>
</html>
