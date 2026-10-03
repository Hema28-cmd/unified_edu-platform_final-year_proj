<?php
session_start();

// Allow only kindergarten students
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: ../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kindergarten Learning | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Comic Sans MS','Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg,#fef3c7,#e0f2fe);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#f97316,#ec4899,#6366f1);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}
.navbar .logo{
    font-size:22px;
    font-weight:bold;
}
.navbar a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:600;
}
.navbar a:hover{
    text-decoration:underline;
}

/* 📘 CONTENT */
.content{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px;
    text-align:center;
}
.content h2{
    font-size:36px;
    color:#1e3a8a;
}
.content p{
    margin-top:10px;
    font-size:18px;
    color:#475569;
}

/* 🧸 CARDS GRID */
.cards{
    margin-top:40px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* 🔗 CLICKABLE CARD */
.card-link{
    text-decoration:none;
    color:inherit;
}

/* 🎨 CARD */
.card{
    background:white;
    border-radius:25px;
    padding:30px 20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    transition:0.3s;
    cursor:pointer;
    position:relative;
}
.card:hover{
    transform: translateY(-8px) scale(1.03);
    box-shadow:0 25px 50px rgba(0,0,0,0.2);
}

/* ICON CIRCLE */
.icon{
    width:80px;
    height:80px;
    margin:0 auto 15px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:36px;
    color:white;
}

.alpha{ background:#f97316; }
.numbers{ background:#22c55e; }
.shapes{ background:#6366f1; }
.colors{ background:#ec4899; }
.rhymes{ background:#0ea5e9; }
.games{ background:#facc15; color:#1e293b; }

.card h3{
    font-size:22px;
    margin-bottom:10px;
    color:#1e293b;
}
.card p{
    font-size:15px;
    color:#64748b;
}

/* FOOTER */
.footer{
    margin:40px 0;
    text-align:center;
    font-size:14px;
    color:#475569;
}
</style>
</head>

<body>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <div>
        <a href="kindergarten.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- 📘 CONTENT -->
<div class="content">
    <h2>🎉 Welcome to Kindergarten Learning</h2>
    <p>Let’s learn with fun, colors, and joy!</p>

    <div class="cards">

        <a href="alphabet.php" class="card-link">
            <div class="card">
                <div class="icon alpha"><i class="fa-solid fa-a"></i></div>
                <h3>Alphabet World</h3>
                <p>Learn A–Z with pictures and sounds</p>
            </div>
        </a>

        <a href="numbers.php" class="card-link">
            <div class="card">
                <div class="icon numbers"><i class="fa-solid fa-1"></i></div>
                <h3>Number Fun</h3>
                <p>Counting numbers with easy examples</p>
            </div>
        </a>

        <a href="shapes.php" class="card-link">
            <div class="card">
                <div class="icon shapes"><i class="fa-solid fa-shapes"></i></div>
                <h3>Shapes & Objects</h3>
                <p>Identify shapes around us</p>
            </div>
        </a>

        <a href="colors.php" class="card-link">
            <div class="card">
                <div class="icon colors"><i class="fa-solid fa-palette"></i></div>
                <h3>Colors & Drawing</h3>
                <p>Learn colors with drawing fun</p>
            </div>
        </a>

        <a href="rhymes.php" class="card-link">
            <div class="card">
                <div class="icon rhymes"><i class="fa-solid fa-music"></i></div>
                <h3>Rhymes & Songs</h3>
                <p>Sing and learn with joyful rhymes</p>
            </div>
        </a>

       <a href="activities.php" class="card-link">
    <div class="card">
        <div class="icon games"><i class="fa-solid fa-scissors"></i></div>
        <h3>Activities & Crafts</h3>
        <p>Paper craft, drawing & fun activities</p>
    </div>
</a>


    </div>
</div>

<div class="footer">
    Unified Education Management System 🌟
</div>

</body>
</html>
