<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Projects | Kindergarten</title>
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
    background: linear-gradient(135deg,#fff7ed,#e0f2fe);
    padding:40px;
    color:#1f2937;
}

/* 🔝 HEADER */
.header{
    background: linear-gradient(90deg,#ea580c,#facc15);
    color:#fff;
    padding:30px 35px;
    border-radius:28px;
    box-shadow:0 18px 40px rgba(0,0,0,0.2);
}
.header h1{
    font-size:30px;
}
.header p{
    margin-top:8px;
    opacity:0.9;
}

/* 📦 PROJECT GRID */
.grid{
    margin-top:40px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(260px,1fr));
    gap:28px;
}

/* 📘 PROJECT CARD */
.card{
    background:#ffffff;
    padding:26px;
    border-radius:24px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.card h3{
    color:#c2410c;
    margin-bottom:12px;
}
.card ul{
    padding-left:18px;
}
.card li{
    margin-bottom:8px;
    font-size:15px;
}

/* 📚 SECTION */
.section{
    margin-top:45px;
    background:linear-gradient(135deg,#ecfeff,#f0fdf4);
    padding:32px;
    border-radius:28px;
    box-shadow:0 18px 40px rgba(0,0,0,0.15);
}
.section h2{
    color:#15803d;
    margin-bottom:14px;
}
.section p{
    font-size:15px;
    line-height:1.6;
}

/* 💡 TIPS */
.tip{
    margin-top:15px;
    background:#fef3c7;
    padding:18px;
    border-left:6px solid #f59e0b;
    border-radius:12px;
    font-size:14px;
}

/* 🔙 BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-top:35px;
    padding:14px 28px;
    background:linear-gradient(90deg,#7c3aed,#ec4899);
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
    transition:transform 0.2s;
}
.back-btn:hover{
    transform:translateY(-3px);
}
</style>
</head>

<body>

<!-- 🔝 HEADER -->
<div class="header">
    <h1>🚀 Kindergarten Project Ideas</h1>
    <p>
        Creative and fun projects that help children
        learn through hands-on activities.
    </p>
</div>

<!-- 📦 PROJECT GRID -->
<div class="grid">

    <div class="card">
        <h3>🎨 Art & Creativity</h3>
        <ul>
            <li>🌈 My Favorite Color Chart</li>
            <li>🖍️ My Dream Drawing</li>
            <li>🎭 Paper Mask Making</li>
        </ul>
    </div>

    <div class="card">
        <h3>🏠 Family & Community</h3>
        <ul>
            <li>🏠 My Family Drawing</li>
            <li>🚓 Community Helpers Chart</li>
            <li>🕌 Places Around Me</li>
        </ul>
    </div>

    <div class="card">
        <h3>🐶 Animals & Nature</h3>
        <ul>
            <li>🐶 Animals Around Me</li>
            <li>🌳 Parts of a Tree</li>
            <li>🐠 Aquatic Animals</li>
        </ul>
    </div>

    <div class="card">
        <h3>🍎 Health & Food</h3>
        <ul>
            <li>🍎 Healthy Food Chart</li>
            <li>🥗 Fruits & Vegetables</li>
            <li>🚰 Importance of Water</li>
        </ul>
    </div>

</div>

<!-- 📚 PROJECT GUIDELINES -->
<div class="section">
    <h2>📚 Project Guidelines</h2>
    <p>
        Projects should be simple, age-appropriate,
        and encourage creativity rather than accuracy.
    </p>

    <div class="tip">
        💡 <strong>Tips & Tricks:</strong><br>
        • Allow children to choose colors freely<br>
        • Parents should guide, not do the project<br>
        • Appreciate every effort with positive feedback<br>
        • Display projects in class to motivate students
    </div>
</div>

<!-- 🔙 BACK -->
<a href="kindergarten.php" class="back-btn">⬅ Back to Kindergarten Dashboard</a>

</body>
</html>
