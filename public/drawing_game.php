<?php
session_start();

// Allow kindergarten & primary students only
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_level'], ['kindergarten','primary'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Drawing Fun | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#e0f2fe,#fef3c7,#fce7f3);
    min-height:100vh;
}

/* 🌈 NAVBAR */
.navbar{
    background:linear-gradient(90deg,#6366f1,#22c55e,#facc15);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.navbar .logo{
    font-size:24px;
    font-weight:700;
    color:#1e293b;
}
.navbar a{
    text-decoration:none;
    margin-left:15px;
    padding:8px 18px;
    border-radius:20px;
    background:rgba(0,0,0,0.25);
    color:white;
    font-size:15px;
}
.navbar a:hover{
    background:rgba(255,255,255,0.3);
}

/* 🎨 HEADER */
.header{
    text-align:center;
    padding:25px 20px;
}
.header h1{
    font-family:'Baloo 2',cursive;
    font-size:42px;
    color:#1e3a8a;
}
.header p{
    color:#475569;
    font-size:18px;
}

/* 🧩 MAIN LAYOUT */
.container{
    max-width:1200px;
    margin:0 auto 40px;
    padding:0 20px;
    display:grid;
    grid-template-columns:220px 1fr 240px;
    gap:25px;
}

/* 🎛 LEFT TOOLS */
.tools{
    background:#ffffff;
    border-radius:25px;
    padding:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.tools h3{
    text-align:center;
    margin-bottom:15px;
    color:#4338ca;
}
.color-btn{
    width:35px;
    height:35px;
    border-radius:50%;
    border:none;
    margin:5px;
    cursor:pointer;
}
.tool-btn{
    width:100%;
    padding:10px;
    margin-top:10px;
    border:none;
    border-radius:20px;
    font-weight:600;
    cursor:pointer;
}
.clear{background:#ef4444;color:#fff;}
.erase{background:#64748b;color:#fff;}
.finish{background:#22c55e;color:#fff;}

/* 🖌 CANVAS AREA */
.canvas-area{
    background:#fff;
    border-radius:25px;
    padding:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
    text-align:center;
}
canvas{
    border:4px dashed #3b82f6;
    border-radius:20px;
    cursor:crosshair;
}

/* 💡 RIGHT IDEAS */
.ideas{
    background:#ffffff;
    border-radius:25px;
    padding:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.ideas h3{
    color:#16a34a;
    margin-bottom:10px;
}
.ideas ul{
    padding-left:20px;
}
.ideas li{
    margin-bottom:8px;
    color:#334155;
}

/* 🎉 CONFETTI */
.confetti{
    position:fixed;
    width:10px;
    height:10px;
    background:red;
    animation:fall 3s linear forwards;
    z-index:999;
}
@keyframes fall{
    from{transform:translateY(-50px) rotate(0deg);}
    to{transform:translateY(100vh) rotate(360deg);}
}

/* 📱 RESPONSIVE */
@media(max-width:900px){
    .container{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">🚀 Unified Edu</div>
    <div>
        <a href="games.php"><i class="fa-solid fa-gamepad"></i> Games</a>
        <a href="kindergarten.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- 🎨 HEADER -->
<div class="header">
    <h1>🎨 Drawing & Coloring Game</h1>
    <p>Draw, color, and create beautiful pictures!</p>
</div>

<!-- 🧩 MAIN -->
<div class="container">

<!-- 🎛 TOOLS -->
<div class="tools">
    <h3>🖍 Colors</h3>
    <button class="color-btn" style="background:red" onclick="setColor('red')"></button>
    <button class="color-btn" style="background:blue" onclick="setColor('blue')"></button>
    <button class="color-btn" style="background:green" onclick="setColor('green')"></button>
    <button class="color-btn" style="background:orange" onclick="setColor('orange')"></button>
    <button class="color-btn" style="background:purple" onclick="setColor('purple')"></button>
    <button class="color-btn" style="background:black" onclick="setColor('black')"></button>

    <button class="tool-btn erase" onclick="setEraser()">🧽 Eraser</button>
    <button class="tool-btn clear" onclick="clearCanvas()">🗑 Clear</button>
    <button class="tool-btn finish" onclick="finishDrawing()">🎉 Finish</button>
</div>

<!-- 🖌 CANVAS -->
<div class="canvas-area">
    <canvas id="drawCanvas" width="500" height="350"></canvas>
</div>

<!-- 💡 IDEAS -->
<div class="ideas">
    <h3>💡 Draw Ideas</h3>
    <ul>
        <li>🌞 Sun and clouds</li>
        <li>🏠 My house</li>
        <li>🌈 Rainbow</li>
        <li>🐶 My favorite animal</li>
        <li>🌳 Trees and flowers</li>
    </ul>
</div>

</div>

<script>
const canvas = document.getElementById("drawCanvas");
const ctx = canvas.getContext("2d");
let drawing=false;
let color="black";

canvas.addEventListener("mousedown",()=>drawing=true);
canvas.addEventListener("mouseup",()=>drawing=false);
canvas.addEventListener("mouseleave",()=>drawing=false);
canvas.addEventListener("mousemove",draw);

function draw(e){
    if(!drawing) return;
    ctx.fillStyle=color;
    ctx.beginPath();
    ctx.arc(e.offsetX,e.offsetY,4,0,Math.PI*2);
    ctx.fill();
}

function setColor(c){
    color=c;
}

function setEraser(){
    color="#ffffff";
}

function clearCanvas(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
}

function finishDrawing(){
    for(let i=0;i<50;i++){
        const c=document.createElement("div");
        c.className="confetti";
        c.style.left=Math.random()*100+"vw";
        c.style.background=`hsl(${Math.random()*360},100%,50%)`;
        c.style.animationDuration=(2+Math.random()*2)+"s";
        document.body.appendChild(c);
        setTimeout(()=>c.remove(),3000);
    }
    alert("🎉 Great Job! Your drawing is amazing!");
}
</script>

</body>
</html>
