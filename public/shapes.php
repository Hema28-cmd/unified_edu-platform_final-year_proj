<?php
session_start();

// Only kindergarten students allowed
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fun Shapes | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Comic Sans MS','Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg,#fef3c7,#e0f2fe,#fae8ff);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#ec4899,#f97316,#22c55e);
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

/* 🔙 BACK BUTTON */
.back-btn{
    display:inline-block;
    margin:20px 30px;
    padding:10px 22px;
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    color:white;
    text-decoration:none;
    border-radius:25px;
    font-weight:bold;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    transition:0.3s;
}
.back-btn:hover{
    transform:translateX(-5px);
}

/* 🟡 HEADER */
.header{
    text-align:center;
    padding:10px 20px 30px;
}
.header h1{
    font-size:42px;
    color:#7c2d12;
}
.header p{
    font-size:18px;
    color:#475569;
    margin-top:10px;
}

/* 🔷 SHAPES GRID */
.shape-grid{
    max-width:1200px;
    margin:0 auto 50px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
    gap:35px;
}

/* 🔄 FLIP CARD */
.flip-card{
    background:transparent;
    perspective:1000px;
}
.flip-inner{
    position:relative;
    width:100%;
    height:280px;
    transition:transform 0.8s;
    transform-style:preserve-3d;
}
.flip-card:hover .flip-inner{
    transform:rotateY(180deg);
}

.flip-front, .flip-back{
    position:absolute;
    width:100%;
    height:100%;
    backface-visibility:hidden;
    border-radius:30px;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    padding:20px;
    text-align:center;
}

/* FRONT */
.flip-front{
    color:white;
}
.circle{ background:linear-gradient(135deg,#22c55e,#4ade80); }
.square{ background:linear-gradient(135deg,#3b82f6,#60a5fa); }
.triangle{ background:linear-gradient(135deg,#f97316,#fb923c); }
.rectangle{ background:linear-gradient(135deg,#ec4899,#f472b6); }
.star{ background:linear-gradient(135deg,#eab308,#fde047); color:#1e293b;}
.heart{ background:linear-gradient(135deg,#ef4444,#f87171); }

.shape-icon{
    font-size:80px;
    margin-bottom:10px;
}
.flip-front h3{
    font-size:26px;
}

/* BACK */
.flip-back{
    background:white;
    transform:rotateY(180deg);
}
.flip-back h4{
    font-size:22px;
    color:#1e293b;
}
.flip-back p{
    font-size:16px;
    color:#475569;
    margin-top:10px;
}
.example{
    font-size:26px;
    margin-top:15px;
}

/* FOOTER */
.footer{
    text-align:center;
    font-size:14px;
    color:#475569;
    margin-bottom:30px;
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

<!-- 🔙 BACK -->
<a href="lesson.php" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Back to Lessons
</a>

<!-- 🟡 HEADER -->
<div class="header">
    <h1>🔺 Fun with Shapes</h1>
    <p>Hover on shapes to learn more</p>
</div>

<!-- 🔷 SHAPES -->
<div class="shape-grid">

<!-- CIRCLE -->
<div class="flip-card">
    <div class="flip-inner">
        <div class="flip-front circle">
            <div class="shape-icon">⚪</div>
            <h3>Circle</h3>
        </div>
        <div class="flip-back">
            <h4>Circle</h4>
            <p>Round shape with no corners</p>
            <div class="example">🍪 ⚽ 🟡</div>
        </div>
    </div>
</div>

<!-- SQUARE -->
<div class="flip-card">
    <div class="flip-inner">
        <div class="flip-front square">
            <div class="shape-icon">⬜</div>
            <h3>Square</h3>
        </div>
        <div class="flip-back">
            <h4>Square</h4>
            <p>Four equal sides</p>
            <div class="example">🟦 🧊 🧩</div>
        </div>
    </div>
</div>

<!-- TRIANGLE -->
<div class="flip-card">
    <div class="flip-inner">
        <div class="flip-front triangle">
            <div class="shape-icon">🔺</div>
            <h3>Triangle</h3>
        </div>
        <div class="flip-back">
            <h4>Triangle</h4>
            <p>Three sides and three corners</p>
            <div class="example">🍕 ⛺ 📐</div>
        </div>
    </div>
</div>

<!-- RECTANGLE -->
<div class="flip-card">
    <div class="flip-inner">
        <div class="flip-front rectangle">
            <div class="shape-icon">▭</div>
            <h3>Rectangle</h3>
        </div>
        <div class="flip-back">
            <h4>Rectangle</h4>
            <p>Opposite sides are equal</p>
            <div class="example">📘 🖥️ 🚪</div>
        </div>
    </div>
</div>

<!-- STAR -->
<div class="flip-card">
    <div class="flip-inner">
        <div class="flip-front star">
            <div class="shape-icon">⭐</div>
            <h3>Star</h3>
        </div>
        <div class="flip-back">
            <h4>Star</h4>
            <p>Five pointed shape</p>
            <div class="example">🌟 🎖️ ✨</div>
        </div>
    </div>
</div>

<!-- HEART -->
<div class="flip-card">
    <div class="flip-inner">
        <div class="flip-front heart">
            <div class="shape-icon">❤️</div>
            <h3>Heart</h3>
        </div>
        <div class="flip-back">
            <h4>Heart</h4>
            <p>Shape of love and care</p>
            <div class="example">💝 💌 🎁</div>
        </div>
    </div>
</div>

</div>

<div class="footer">
    💖 Learning shapes is fun with Unified Edu 💖
</div>

</body>
</html>
