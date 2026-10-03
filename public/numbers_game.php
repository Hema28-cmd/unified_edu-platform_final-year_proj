<?php
session_start();

// Only allow kindergarten students
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Numbers Matching Game | Kindergarten</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background: linear-gradient(135deg,#fef08a,#fbcfe8);
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

/* 📘 CONTENT */
.content{
    max-width:1200px;
    margin:30px auto;
    padding:0 20px;
    text-align:center;
}
.content h2{
    font-family:'Baloo 2',cursive;
    font-size:36px;
    color:#1e3a8a;
}

/* 🎲 GAME */
.drag-grid, .drop-grid{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
    margin-top:30px;
}

.number-card{
    width:80px;
    height:80px;
    background: linear-gradient(135deg,#22c55e,#16a34a);
    border-radius:20px;
    font-size:32px;
    color:white;
    font-weight:700;
    display:flex;
    justify-content:center;
    align-items:center;
    cursor:grab;
}

.drop-box{
    width:80px;
    height:80px;
    border:3px dashed #4338ca;
    border-radius:20px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:32px;
    font-weight:700;
    color:#4338ca;
}

/* 🎉 RESULT */
.result{
    margin-top:30px;
    font-size:22px;
    font-weight:700;
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
}

@keyframes fall{
    0%{transform:translateY(-10px) rotate(0deg);}
    100%{transform:translateY(100vh) rotate(360deg);}
}

/* FOOTER */
.footer{
    text-align:center;
    margin:40px 0;
    font-size:14px;
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

<div class="content">
    <h2>🎯 Numbers Matching Game</h2>
    <p>Drag the numbers into the correct boxes!</p>

    <div class="drag-grid">
        <?php
        $numbers = range(1,6);
        shuffle($numbers);
        foreach($numbers as $num): ?>
            <div class="number-card" draggable="true" id="num<?php echo $num; ?>">
                <?php echo $num; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="drop-grid">
        <?php foreach(range(1,6) as $n): ?>
            <div class="drop-box" data-number="<?php echo $n; ?>">?</div>
        <?php endforeach; ?>
    </div>

    <div class="result" id="result">Match all numbers 🎈</div>
</div>

<div class="footer">
    🌟 Kindergarten Numbers Game — Unified Edu
</div>

<script>
const cards = document.querySelectorAll('.number-card');
const boxes = document.querySelectorAll('.drop-box');
const result = document.getElementById('result');
let dragged = null;

cards.forEach(card => {
    card.addEventListener('dragstart', () => {
        dragged = card.id.replace('num','');
    });
});

boxes.forEach(box => {
    box.addEventListener('dragover', e => e.preventDefault());
    box.addEventListener('drop', function(){
        if(this.dataset.number === dragged){
            this.textContent = dragged;
            this.style.background = '#22c55e';
            this.style.color = '#fff';
            document.getElementById('num'+dragged).style.display = 'none';
            checkWin();
        } else {
            result.textContent = '❌ Try again!';
            result.style.color = '#ef4444';
        }
    });
});

function checkWin(){
    const allFilled = [...boxes].every(b => b.textContent !== '?');
    if(allFilled){
        result.textContent = '🎉 Yay! You did it!';
        result.style.color = '#16a34a';
        launchConfetti();
    }
}

/* 🎊 CONFETTI FUNCTION */
function launchConfetti(){
    const container = document.getElementById('confetti-container');
    const colors = ['#ef4444','#22c55e','#3b82f6','#facc15','#ec4899'];

    for(let i=0;i<120;i++){
        const c = document.createElement('div');
        c.className = 'confetti';
        c.style.backgroundColor = colors[Math.floor(Math.random()*colors.length)];
        c.style.left = Math.random()*100 + 'vw';
        c.style.animationDuration = (2 + Math.random()*2)+'s';
        container.appendChild(c);
        setTimeout(()=>c.remove(),3000);
    }
}
</script>

</body>
</html>
