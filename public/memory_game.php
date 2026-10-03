<?php
session_start();

/* 🔐 Allow only kindergarten users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Space Memory Game | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Baloo 2', cursive;
}

/* 🌌 BACKGROUND */
body{
    min-height:100vh;
    background:radial-gradient(circle at top,#1e3a8a,#020617);
    color:white;
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

/* HEADER */
.header{
    padding:30px 20px 10px;
    text-align:center;
}
.header h1{
    font-size:38px;
    color:#fde68a;
}
.header p{
    font-size:18px;
    color:#e0f2fe;
}

/* GAME CONTAINER */
.container{
    max-width:900px;
    margin:auto;
    padding:20px;
    text-align:center;
}

/* GRID */
.grid{
    margin-top:35px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(110px,1fr));
    gap:22px;
}

/* CARD */
.card{
    height:120px;
    background:#0f172a;
    border-radius:18px;
    font-size:52px;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
    transition:0.3s;
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}
.card:hover{
    transform:scale(1.1);
}
.card.open{
    background:#fde047;
    color:#1e293b;
}
.card.matched{
    background:#22c55e;
    color:white;
}

/* 🚀 ROCKET */
.rocket{
    font-size:90px;
    margin-top:15px;
}
.launch{
    animation:fly 2s ease-in-out infinite;
}
@keyframes fly{
    0%{transform:translateY(0);}
    50%{transform:translateY(-45px);}
    100%{transform:translateY(0);}
}

/* 🎉 CHEER */
.cheer{
    display:none;
    margin-top:25px;
    animation:pulse 1s infinite;
}
@keyframes pulse{
    0%{transform:scale(1);}
    50%{transform:scale(1.15);}
    100%{transform:scale(1);}
}
.cheer h2{
    font-size:34px;
    color:#22c55e;
}
.cheer .stars{
    font-size:60px;
}

/* BUTTON */
button{
    margin-top:18px;
    padding:12px 32px;
    border:none;
    border-radius:30px;
    background:#6366f1;
    color:white;
    font-size:18px;
    cursor:pointer;
}
button:hover{
    background:#4f46e5;
}

/* FOOTER */
.footer{
    text-align:center;
    margin:40px 0;
    font-size:14px;
    color:#cbd5f5;
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

<!-- HEADER -->
<div class="header">
    <h1>🌌 Space Explorer Memory Game</h1>
    <p>Match space friends to help the rocket fly!</p>
</div>

<div class="container">

    <div class="rocket" id="rocket">🚀</div>

    <div class="grid" id="grid"></div>

    <div class="cheer" id="cheer">
        <h2>🎉 Rocket Launched Successfully!</h2>
        <div class="stars">⭐ 🪐 🌙 ⭐</div>
        <button onclick="restart()">Play Again</button>
    </div>

</div>

<div class="footer">
    🌟 Unified Education Management System — Kindergarten Learning
</div>

<script>
const items = ['🌞','🌙','⭐','🪐','👽','🚀'];
let cards = [];
let openCards = [];
let matched = 0;

function shuffle(arr){
    return arr.sort(() => Math.random() - 0.5);
}

function init(){
    const grid = document.getElementById('grid');
    grid.innerHTML='';
    openCards=[];
    matched=0;
    document.getElementById('rocket').classList.remove('launch');
    document.getElementById('cheer').style.display='none';

    cards = shuffle([...items, ...items]);

    cards.forEach(icon=>{
        const card = document.createElement('div');
        card.className='card';
        card.dataset.icon=icon;
        card.innerHTML='❓';
        card.onclick=()=>flip(card);
        grid.appendChild(card);
    });
}

function flip(card){
    if(openCards.length===2 || card.classList.contains('open')) return;

    card.classList.add('open');
    card.innerHTML=card.dataset.icon;
    openCards.push(card);

    if(openCards.length===2){
        setTimeout(checkMatch,700);
    }
}

function checkMatch(){
    const [a,b] = openCards;
    if(a.dataset.icon === b.dataset.icon){
        a.classList.add('matched');
        b.classList.add('matched');
        matched += 2;
    } else {
        a.classList.remove('open');
        b.classList.remove('open');
        a.innerHTML='❓';
        b.innerHTML='❓';
    }
    openCards=[];

    if(matched === cards.length){
        document.getElementById('rocket').classList.add('launch');
        document.getElementById('cheer').style.display='block';
    }
}

function restart(){
    init();
}

init();
</script>

</body>
</html>
