<?php
session_start();

/* 🔐 Allow only highschool users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: dashboard.php");
    exit;
}

/* ✅ Promote using SESSION ONLY */
$_SESSION['user_level'] = 'undergraduate';

/* 🔒 Reset next level progress */
$_SESSION['undergraduate_quiz_completed'] = false;
$_SESSION['undergraduate_certificate_unlocked'] = false;

$user_name = $_SESSION['user_name'] ?? 'Student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Level Up! 🎓</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#1e3a8a,#7c3aed,#ec4899);
    overflow:hidden;
}

/* Glass Card */
.card{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(15px);
    padding:60px 50px;
    border-radius:25px;
    text-align:center;
    color:white;
    width:90%;
    max-width:650px;
    box-shadow:0 25px 60px rgba(0,0,0,0.3);
    animation:fadeIn 1s ease-in-out;
    position:relative;
    z-index:10;
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(40px);}
    to{opacity:1; transform:translateY(0);}
}

.card h1{
    font-size:50px;
    font-weight:700;
    margin-bottom:20px;
}

.card h2{
    font-size:28px;
    font-weight:500;
    margin-bottom:20px;
}

.card p{
    font-size:18px;
    line-height:1.6;
    margin-bottom:30px;
    opacity:0.95;
}

/* Feature box */
.features{
    display:flex;
    justify-content:space-around;
    margin-bottom:35px;
    flex-wrap:wrap;
}

.feature{
    margin:10px 15px;
    font-size:15px;
    background:rgba(255,255,255,0.15);
    padding:10px 18px;
    border-radius:20px;
}

/* Button */
.btn{
    padding:14px 35px;
    font-size:17px;
    font-weight:600;
    border:none;
    border-radius:30px;
    cursor:pointer;
    background:linear-gradient(90deg,#facc15,#f97316,#ef4444);
    color:white;
    transition:0.3s;
}

.btn:hover{
    transform:scale(1.08);
    box-shadow:0 10px 25px rgba(0,0,0,0.4);
}

/* Floating circles */
.circle{
    position:absolute;
    border-radius:50%;
    opacity:0.3;
    animation:float 6s infinite ease-in-out;
}

@keyframes float{
    0%,100%{transform:translateY(0);}
    50%{transform:translateY(-30px);}
}

.circle1{
    width:200px;
    height:200px;
    background:#facc15;
    top:-60px;
    left:-60px;
}

.circle2{
    width:150px;
    height:150px;
    background:#22d3ee;
    bottom:-50px;
    right:-50px;
}
</style>
</head>

<body>

<div class="circle circle1"></div>
<div class="circle circle2"></div>

<div class="card">
    <h1>🎓 Level Up!</h1>
    <h2>Congratulations, <?php echo htmlspecialchars($user_name); ?>!</h2>

    <p>
        You have successfully completed your <strong>Highschool Journey</strong> 🎉<br>
        A new academic chapter begins now at the <strong>Undergraduate Level</strong> 🚀
    </p>

    <div class="features">
        <div class="feature">📚 Advanced Courses</div>
        <div class="feature">🧠 Skill Development</div>
        <div class="feature">🏆 New Achievements</div>
    </div>

    <a href="undergraduate.php">
        <button class="btn">
            Enter Undergraduate Dashboard →
        </button>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>

// Confetti celebration when page loads
window.onload = function(){

    // Big center burst
    confetti({
        particleCount: 250,
        spread: 120,
        origin: { y: 0.6 }
    });

    // Left burst
    setTimeout(() => {
        confetti({
            particleCount: 120,
            spread: 90,
            origin: { x: 0.1, y: 0.6 }
        });
    }, 400);

    // Right burst
    setTimeout(() => {
        confetti({
            particleCount: 120,
            spread: 90,
            origin: { x: 0.9, y: 0.6 }
        });
    }, 800);

    // Top rain effect
    setTimeout(() => {

        const duration = 2000;
        const end = Date.now() + duration;

        (function frame() {
            confetti({
                particleCount: 6,
                angle: 60,
                spread: 55,
                origin: { x: 0 }
            });

            confetti({
                particleCount: 6,
                angle: 120,
                spread: 55,
                origin: { x: 1 }
            });

            if (Date.now() < end) {
                requestAnimationFrame(frame);
            }
        }());

    }, 1200);

};

</script>

</body>
</html>