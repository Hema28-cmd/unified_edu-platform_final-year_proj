<?php
session_start();

// Allow only kindergarten students
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Shapes Game | Kindergarten</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Poppins',sans-serif;
    min-height:100vh;
    background: linear-gradient(135deg,#e0f2fe,#ede9fe);
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

/* 📘 CONTENT */
.content{
    max-width:1200px;
    margin:30px auto;
    padding:0 20px;
    text-align:center;
}
h2{
    font-family:'Baloo 2',cursive;
    font-size:38px;
    color:#1e3a8a;
}
p{
    color:#475569;
    margin-top:8px;
    font-size:16px;
}

/* 🧩 GAME AREA */
.game-area{
    margin-top:40px;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:30px;
}

/* SHAPES */
.shapes{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    justify-content:center;
}

.shape{
    width:90px;
    height:90px;
    cursor:grab;
    display:flex;
    justify-content:center;
    align-items:center;
}

.circle{
    background:#22c55e;
    border-radius:50%;
}
.square{
    background:#3b82f6;
}
.triangle{
    width:0;
    height:0;
    border-left:45px solid transparent;
    border-right:45px solid transparent;
    border-bottom:90px solid #f97316;
}
.rectangle{
    width:120px;
    height:70px;
    background:#ec4899;
}

/* DROP ZONES */
.drop-zones{
    display:flex;
    flex-direction:column;
    gap:20px;
    align-items:center;
}

.drop-box{
    width:160px;
    height:80px;
    border:3px dashed #6366f1;
    border-radius:20px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:20px;
    font-weight:600;
    color:#4338ca;
    background:#fff;
}

/* RESULT */
#result{
    margin-top:30px;
    font-size:22px;
    font-weight:700;
}

/* 🎉 CONFETTI */
#confetti{
    position:fixed;
    inset:0;
    pointer-events:none;
    z-index:999;
}
.confetti{
    position:absolute;
    width:10px;
    height:10px;
    animation:fall 3s linear forwards;
}
@keyframes fall{
    to{
        transform:translateY(100vh) rotate(360deg);
    }
}

/* RESPONSIVE */
@media(max-width:900px){
    .game-area{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div id="confetti"></div>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">🚀 Unified Edu</div>
    <div>
        <a href="games.php"><i class="fa-solid fa-gamepad"></i> Games</a>
        <a href="kindergarten.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<!-- 📘 CONTENT -->
<div class="content">
    <h2>🧩 Shapes Matching Game</h2>
    <p>Drag the shapes to the correct names!</p>

    <div class="game-area">

        <!-- SHAPES -->
        <div class="shapes">
            <div class="shape circle" draggable="true" data-shape="Circle"></div>
            <div class="shape square" draggable="true" data-shape="Square"></div>
            <div class="shape triangle" draggable="true" data-shape="Triangle"></div>
            <div class="shape rectangle" draggable="true" data-shape="Rectangle"></div>
        </div>

        <!-- DROP ZONES -->
        <div class="drop-zones">
            <div class="drop-box" data-match="Circle">Circle</div>
            <div class="drop-box" data-match="Square">Square</div>
            <div class="drop-box" data-match="Triangle">Triangle</div>
            <div class="drop-box" data-match="Rectangle">Rectangle</div>
        </div>

    </div>

    <div id="result">Match all shapes 🎈</div>
</div>

<script>
const shapes = document.querySelectorAll('.shape');
const boxes = document.querySelectorAll('.drop-box');
const result = document.getElementById('result');
let draggedShape = '';

shapes.forEach(s=>{
    s.addEventListener('dragstart',()=>{
        draggedShape = s.dataset.shape;
    });
});

boxes.forEach(box=>{
    box.addEventListener('dragover',e=>e.preventDefault());
    box.addEventListener('drop',()=>{
        if(box.dataset.match === draggedShape){
            box.style.background = '#22c55e';
            box.style.color = '#fff';
            box.textContent = '✔ ' + draggedShape;
            document.querySelector(`[data-shape="${draggedShape}"]`).style.display='none';
            checkWin();
        }else{
            result.textContent = '❌ Try again!';
            result.style.color = '#ef4444';
        }
    });
});

function checkWin(){
    const done = [...boxes].every(b=>b.textContent.includes('✔'));
    if(done){
        result.textContent = '🎉 Great Job! All Shapes Matched!';
        result.style.color = '#16a34a';
        celebrate();
    }
}

/* 🎊 CONFETTI */
function celebrate(){
    const c = document.getElementById('confetti');
    const colors = ['#22c55e','#3b82f6','#facc15','#ec4899','#f97316'];

    for(let i=0;i<120;i++){
        const d = document.createElement('div');
        d.className='confetti';
        d.style.background = colors[Math.floor(Math.random()*colors.length)];
        d.style.left = Math.random()*100+'vw';
        d.style.animationDuration = (2+Math.random()*2)+'s';
        c.appendChild(d);
        setTimeout(()=>d.remove(),3000);
    }
}
</script>

</body>
</html>
