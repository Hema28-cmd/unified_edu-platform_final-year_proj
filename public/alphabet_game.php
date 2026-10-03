
<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Alphabet Drag & Drop Levels</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600&family=Fredoka:wght@500&display=swap" rel="stylesheet">

<style>

body{
margin:0;
font-family:'Fredoka', sans-serif;
background:linear-gradient(135deg,#fde68a,#fca5a5,#93c5fd);
text-align:center;
}

.navbar{
background:linear-gradient(90deg,#6366f1,#22c55e,#facc15,#fb7185);
padding:15px;
color:white;
font-size:24px;
font-weight:bold;
}

.header{
padding:20px;
}

.level{
font-size:22px;
color:#1e3a8a;
margin-bottom:10px;
}

.game-container{
max-width:900px;
margin:auto;
padding:20px;
}

.letters{
display:flex;
flex-wrap:wrap;
justify-content:center;
gap:20px;
margin-bottom:30px;
}

.letter{
width:80px;
height:80px;
border-radius:20px;
display:flex;
align-items:center;
justify-content:center;
font-size:34px;
color:white;
font-weight:bold;
cursor:grab;
animation:float 2s infinite ease-in-out;
}

.letter:nth-child(1){background:#fb7185;}
.letter:nth-child(2){background:#60a5fa;}
.letter:nth-child(3){background:#34d399;}
.letter:nth-child(4){background:#facc15;}
.letter:nth-child(5){background:#a78bfa;}
.letter:nth-child(6){background:#f97316;}

@keyframes float{
0%{transform:translateY(0)}
50%{transform:translateY(-8px)}
100%{transform:translateY(0)}
}

.drop-zones{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(150px,1fr));
gap:20px;
}

.zone{
background:white;
border-radius:18px;
padding:25px;
font-size:20px;
font-weight:bold;
border:3px dashed #94a3b8;
min-height:80px;
}

.correct{
background:#22c55e !important;
color:white;
border:none;
}

.score{
font-size:22px;
margin-top:20px;
font-weight:bold;
}

.next-btn{
display:none;
margin-top:25px;
padding:12px 30px;
background:#22c55e;
color:white;
border:none;
border-radius:25px;
font-size:18px;
cursor:pointer;
}

.back-btn{
display:inline-block;
margin-top:30px;
padding:10px 25px;
background:#ec4899;
color:white;
text-decoration:none;
border-radius:25px;
}

/* CONFETTI */

.confetti{
position:fixed;
width:10px;
height:10px;
top:-10px;
animation:fall linear forwards;
}

@keyframes fall{
to{
transform:translateY(100vh) rotate(720deg);
}
}

</style>
</head>

<body>

<div class="navbar">
🚀 Unified Edu – Alphabet Levels Game
</div>

<div class="header">
<h1>Drag the Letter to the Correct Word</h1>
<div class="level">Level <span id="level">1</span></div>
</div>

<div class="game-container">

<div class="letters" id="letters"></div>

<div class="drop-zones" id="zones"></div>

<div class="score">
⭐ Score: <span id="score">0</span>
</div>

<button class="next-btn" id="nextBtn">Next Level ➜</button>

<br>

<a href="games.php" class="back-btn">⬅ Back to Games</a>

</div>

<script>

/* LEVEL DATA */

const levels=[
[
{letter:"A",word:"Apple 🍎"},
{letter:"B",word:"Ball ⚽"},
{letter:"C",word:"Cat 🐱"},
{letter:"D",word:"Dog 🐶"},
{letter:"E",word:"Elephant 🐘"},
{letter:"F",word:"Fish 🐟"}
],
[
{letter:"G",word:"Grapes 🍇"},
{letter:"H",word:"Hat 🎩"},
{letter:"I",word:"Ice Cream 🍦"},
{letter:"J",word:"Juice 🧃"},
{letter:"K",word:"Kite 🪁"},
{letter:"L",word:"Lion 🦁"}
],
[
{letter:"M",word:"Mango 🥭"},
{letter:"N",word:"Nest 🪺"},
{letter:"O",word:"Orange 🍊"},
{letter:"P",word:"Parrot 🦜"},
{letter:"Q",word:"Queen 👑"},
{letter:"R",word:"Rabbit 🐰"}
],
[
{letter:"S",word:"Sun ☀️"},
{letter:"T",word:"Tiger 🐯"},
{letter:"U",word:"Umbrella ☂️"},
{letter:"V",word:"Van 🚐"},
{letter:"W",word:"Whale 🐳"},
{letter:"Z",word:"Zebra 🦓"}
]
];

let level=0;
let score=0;

const lettersDiv=document.getElementById("letters");
const zonesDiv=document.getElementById("zones");

function loadLevel(){

lettersDiv.innerHTML="";
zonesDiv.innerHTML="";
score=0;

document.getElementById("score").innerText=score;
document.getElementById("level").innerText=level+1;

levels[level].forEach(item=>{

let l=document.createElement("div");
l.className="letter";
l.id=item.letter;
l.innerText=item.letter;
l.draggable=true;

l.addEventListener("dragstart",e=>{
e.dataTransfer.setData("text",item.letter);
});

lettersDiv.appendChild(l);

let z=document.createElement("div");
z.className="zone";
z.dataset.letter=item.letter;
z.innerText=item.word;

z.addEventListener("dragover",e=>e.preventDefault());

z.addEventListener("drop",dropLetter);

zonesDiv.appendChild(z);

});

document.getElementById("nextBtn").style.display="none";

}

function dropLetter(e){

let letter=e.dataTransfer.getData("text");
let correct=e.target.dataset.letter;

if(letter===correct){

e.target.classList.add("correct");
e.target.innerHTML=letter+" ✓";

document.getElementById(letter).style.display="none";

score++;
document.getElementById("score").innerText=score;

if(score===6){

launchConfetti();
document.getElementById("nextBtn").style.display="inline-block";

}

}

}

document.getElementById("nextBtn").onclick=function(){

level++;

if(level<levels.length){

loadLevel();

}else{

alert("🎉 Congratulations! You finished all alphabet levels!");

}

};

/* CONFETTI */

function launchConfetti(){

for(let i=0;i<120;i++){

let conf=document.createElement("div");
conf.className="confetti";

conf.style.left=Math.random()*100+"vw";
conf.style.background="hsl("+Math.random()*360+",100%,50%)";
conf.style.animationDuration=(Math.random()*3+2)+"s";

document.body.appendChild(conf);

setTimeout(()=>conf.remove(),5000);

}

}

loadLevel();

</script>

</body>
</html>

