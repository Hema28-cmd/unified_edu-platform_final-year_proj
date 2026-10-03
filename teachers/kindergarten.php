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
<title>Kindergarten Teacher Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* 🌈 BACKGROUND */
body{
    min-height:100vh;
    background: linear-gradient(120deg,#fef3c7,#dbeafe);
    color:#1f2937;
}

/* 🔝 TOP BAR */
.navbar{
    background: linear-gradient(90deg,#7c3aed,#ec4899);
    color:#fff;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 12px 30px rgba(0,0,0,0.2);
}
.navbar h2{
    font-size:22px;
}
.navbar a{
    color:#fff;
    text-decoration:none;
    margin-left:20px;
    font-weight:600;
}

/* 📦 MAIN CONTAINER */
.container{
    max-width:1200px;
    margin:auto;
    padding:40px;
}

/* 👋 WELCOME */
.welcome{
    background:#ffffff;
    padding:35px;
    border-radius:28px;
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
}
.welcome h1{
    color:#7c3aed;
    font-size:32px;
}
.welcome p{
    margin-top:10px;
    font-size:16px;
    color:#555;
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
    background:linear-gradient(135deg,#ffffff,#fdf4ff);
    padding:28px;
    border-radius:26px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.card h3{
    color:#db2777;
    margin-bottom:14px;
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
    background:#ffffff;
    padding:32px;
    border-radius:28px;
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
}
.section h2{
    color:#2563eb;
    margin-bottom:18px;
}
.section p{
    font-size:15px;
    line-height:1.6;
    color:#444;
}

/* 🚀 TIPS */
.tip-box{
    margin-top:12px;
    background:#ecfeff;
    padding:16px;
    border-left:6px solid #06b6d4;
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
    background:linear-gradient(90deg,#22c55e,#16a34a);
    color:#fff;
    text-decoration:none;
    font-weight:600;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}
</style>
</head>

<body>

<!-- 🔝 NAVBAR -->
<div class="navbar">
    <h2>👩‍🏫 Kindergarten Teacher Panel</h2>
    <div>
        <a href="lessons.php">Lessons</a>
<a href="books.php">Books</a>
<a href="quizzes.php">Quizzes</a>
<a href="projects.php">Projects</a>

        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<div class="container">

    <!-- 👋 WELCOME -->
    <div class="welcome">
        <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 🌟</h1>
        <p>
            This panel helps you plan lessons, explore books, review quizzes,
            assign creative projects, and guide kindergarten students effectively.
        </p>
    </div>

    <!-- 🧩 QUICK OVERVIEW -->
    <div class="grid">

        <div class="card">
            <h3>📘 Lessons</h3>
            <ul>
                <li>Alphabet Recognition</li>
                <li>Basic Numbers (1–20)</li>
                <li>Shapes & Colors</li>
                <li>Good Habits</li>
            </ul>
        </div>

        <div class="card">
            <h3>📚 Recommended Books</h3>
            <ul>
                <li>Picture Story Books</li>
                <li>Alphabet Rhymes</li>
                <li>Moral Story Series</li>
                <li>Early Learning Charts</li>
            </ul>
        </div>

        <div class="card">
            <h3>📝 Sample Quizzes</h3>
            <ul>
                <li>Identify Colors</li>
                <li>Match Shapes</li>
                <li>Count Objects</li>
                <li>Letter Sounds</li>
            </ul>
        </div>

        <div class="card">
            <h3>🎨 Activities</h3>
            <ul>
                <li>Coloring & Drawing</li>
                <li>Clay Modeling</li>
                <li>Action Rhymes</li>
                <li>Group Games</li>
            </ul>
        </div>

    </div>

    <!-- 📂 ASSIGNMENTS -->
    <div class="section">
        <h2>📂 Assignment List</h2>
        <p>
            Assignments are designed to be simple, creative, and engaging.
        </p>
        <ul>
            <li>🎨 Color the given picture</li>
            <li>🔢 Circle the correct number</li>
            <li>🔤 Trace alphabet letters</li>
        </ul>
    </div>

    <!-- 🚀 PROJECT IDEAS -->
    <div class="section">
        <h2>🚀 Project Ideas</h2>
        <ul>
            <li>🌈 My Favorite Color Chart</li>
            <li>🏠 My Family Drawing</li>
            <li>🐶 Animals Around Me</li>
        </ul>

        <div class="tip-box">
            💡 <strong>Tips & Tricks:</strong>  
            Encourage parents to help lightly. Focus on creativity,
            not perfection. Appreciate every effort.
        </div>
    </div>

    <!-- 🎯 QUICK ACTIONS -->
    <div class="actions">
        <a href="lessons.php" class="action-btn">📘 View Lessons</a>
        <a href="books.php" class="action-btn">📚 Browse Books</a>
        <a href="quizzes.php" class="action-btn">📝 View Quizzes</a>
        <a href="projects.php" class="action-btn">🚀 Project Ideas</a>
    </div>

</div>

</body>
</html>
