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
<title>🎨 Color Memory Game</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Comic Sans MS', cursive;
    background:linear-gradient(135deg,#fde68a,#bfdbfe);
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

/* 🎮 GAME AREA */
.container{
    max-width:900px;
    margin:20px auto;
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.15);
    text-align:center;
}

h1{
    color:#7c3aed;
    margin-bottom:10px;
}
.instructions{
    font-size:18px;
    color:#374151;
}

/* 🧠 MEMORY GRID */
.game-board{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:15px;
    margin-top:25px;
}

/* 🃏 CARD */
.card{
    height:120px;
    border-radius:16px;
    cursor:pointer;
    position:relative;
    transform-style:preserve-3d;
    transition:transform .5s;
}

.card.flip{
    transform:rotateY(180deg);
}

.card-face{
    position:absolute;
    width:100%;
    height:100%;
    backface-visibility:hidden;
    border-radius:16px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:26px;
    font-weight:bold;
}

.front{
    background:#f3f4f6;
    color:#6b7280;
}

.back{
    transform:rotateY(180deg);
}

/* 🎉 RESULT */
#result{
    font-size:22px;
    margin-top:20px;
    font-weight:bold;
}

/* 🎊 CONFETTI */
#confetti-container{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    pointer-events:none;
    z-index:9999;
}

.confetti{
    position:absolute;
    width:10px;
    height:10px;
    animation:fall 3s linear forwards;
    opacity:.8;
}

@keyframes fall{
    0%{transform:translateY(-10px) rotate(0deg);}
    100%{transform:translateY(100vh) rotate(360deg);}
}

/* 🔁 BUTTON */
button{
    margin-top:20px;
    background:#22c55e;
    color:white;
    border:none;
    padding:12px 30px;
    font-size:18px;
    border-radius:30px;
    cursor:pointer;
}
button:hover{
    background:#16a34a;
}
</style>
</head>

<body>

<div id="confetti-container"></div>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">🚀 Unified Edu</div>
    <div>
        <a href="games.php"><i class="fa-solid fa-gamepad"></i> Games</a>
        <a href="kindergarten.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</div>

<div class="container">
    <h1>🎨 Color Memory Game</h1>
    <p class="instructions">Flip the cards and match the same colors!</p>

    <div class="game-board" id="gameBoard"></div>

    <div id="result"></div>
    <button onclick="startGame()">🔄 Play Again</button>
</div>

<script>
const colors = [
    '#ef4444','#3b82f6','#22c55e','#facc15',
    '#ec4899','#8b5cf6'
];

let cards = [];
let firstCard = null;
let secondCard = null;
let lockBoard = false;
let matchedPairs = 0;

function startGame(){
    const board = document.getElementById('gameBoard');
    board.innerHTML='';
    matchedPairs = 0;
    document.getElementById('result').textContent='';

    cards = [...colors, ...colors]
        .sort(() => 0.5 - Math.random());

    cards.forEach(color => {
        const card = document.createElement('div');
        card.className='card';
        card.dataset.color = color;

        card.innerHTML = `
            <div class="card-face front">❓</div>
            <div class="card-face back" style="background:${color}"></div>
        `;

        card.addEventListener('click', () => flipCard(card));
        board.appendChild(card);
    });
}

function flipCard(card){
    if(lockBoard || card === firstCard) return;

    card.classList.add('flip');

    if(!firstCard){
        firstCard = card;
        return;
    }

    secondCard = card;
    lockBoard = true;

    if(firstCard.dataset.color === secondCard.dataset.color){
        matchedPairs++;
        resetTurn();

        if(matchedPairs === colors.length){
            document.getElementById('result').textContent='🎉 You did it! Amazing!';
            document.getElementById('result').style.color='#16a34a';
            launchConfetti();
        }
    } else {
        setTimeout(()=>{
            firstCard.classList.remove('flip');
            secondCard.classList.remove('flip');
            resetTurn();
        },800);
    }
}

function resetTurn(){
    [firstCard, secondCard] = [null, null];
    lockBoard = false;
}

/* 🎊 CONFETTI */
function launchConfetti(){
    const container = document.getElementById('confetti-container');
    const confettiColors = ['#ef4444','#3b82f6','#22c55e','#facc15','#ec4899','#8b5cf6'];

    for(let i=0;i<120;i++){
        const confetti = document.createElement('div');
        confetti.className='confetti';
        confetti.style.backgroundColor = confettiColors[Math.floor(Math.random()*confettiColors.length)];
        confetti.style.left = Math.random()*100 + 'vw';
        confetti.style.animationDuration = (2 + Math.random()*2)+'s';
        confetti.style.width = confetti.style.height = (6 + Math.random()*8)+'px';
        container.appendChild(confetti);

        setTimeout(()=>confetti.remove(),3000);
    }
}

startGame();
</script>

</body>
</html>
