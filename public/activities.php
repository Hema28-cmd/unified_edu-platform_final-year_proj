<?php
session_start();

/* Allow only kindergarten users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fun Activities | Kindergarten</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Baloo 2', cursive;
    background:linear-gradient(180deg,#fef3c7,#e0f2fe);
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#fb7185,#f59e0b,#60a5fa);
    padding:18px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:#fff;
}
.navbar h2{margin:0;}
.navbar a{
    color:#fff;
    text-decoration:none;
    background:rgba(255,255,255,0.25);
    padding:8px 18px;
    border-radius:20px;
}
.navbar a:hover{background:rgba(255,255,255,0.4);}

/* HEADER */
.header{
    text-align:center;
    padding:35px 20px;
}
.header h1{
    font-size:38px;
    color:#1e293b;
}
.header p{
    font-size:18px;
    color:#475569;
}

/* ACTIVITIES GRID */
.activities{
    max-width:1100px;
    margin:0 auto 60px;
    padding:20px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:30px;
}

/* ACTIVITY CARD */
.card{
    background:white;
    border-radius:30px;
    padding:30px 20px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    transition:0.3s;
    cursor:pointer;
}
.card:hover{
    transform:translateY(-10px) scale(1.05);
}

/* ICON */
.icon{
    width:90px;
    height:90px;
    margin:0 auto 15px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:40px;
    color:white;
}

/* COLORS */
.draw{background:#fb7185;}
.craft{background:#f59e0b;}
.music{background:#22c55e;}
.match{background:#6366f1;}
.puzzle{background:#0ea5e9;}
.role{background:#a855f7;}

.card h3{
    font-size:24px;
    margin-bottom:10px;
    color:#1e293b;
}
.card p{
    font-size:15px;
    color:#64748b;
}

/* FOOTER */
.footer{
    text-align:center;
    padding:30px;
    font-size:14px;
    color:#475569;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>🎨 Fun Activities</h2>
    <a href="kindergarten.php">⬅ Back</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>🌟 Learning Through Activities</h1>
    <p>Play, explore, and learn with joyful activities</p>
</div>

<!-- ACTIVITIES -->
<div class="activities">

    <div class="card">
        <div class="icon draw"><i class="fa-solid fa-paintbrush"></i></div>
        <h3>Drawing Time</h3>
        <p>Draw animals, fruits, and objects using colors</p>
    </div>

    <div class="card">
        <div class="icon craft"><i class="fa-solid fa-scissors"></i></div>
        <h3>Paper Crafts</h3>
        <p>Fold, cut, and create fun paper models</p>
    </div>

    <div class="card">
        <div class="icon music"><i class="fa-solid fa-music"></i></div>
        <h3>Music & Dance</h3>
        <p>Move and sing along with joyful rhymes</p>
    </div>

    <div class="card">
        <div class="icon match"><i class="fa-solid fa-link"></i></div>
        <h3>Matching Games</h3>
        <p>Match shapes, colors, and pictures</p>
    </div>

    <div class="card">
        <div class="icon puzzle"><i class="fa-solid fa-puzzle-piece"></i></div>
        <h3>Puzzles</h3>
        <p>Solve simple puzzles to improve thinking</p>
    </div>

    <div class="card">
        <div class="icon role"><i class="fa-solid fa-people-group"></i></div>
        <h3>Role Play</h3>
        <p>Act as doctor, teacher, or helper</p>
    </div>

</div>

<div class="footer">
    🌈 Unified Education Management System – Kindergarten
</div>

</body>
</html>
