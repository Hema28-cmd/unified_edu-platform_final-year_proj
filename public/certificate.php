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
<title>Kindergarten Certificate</title>

<!-- Google Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{min-height:100vh;background:linear-gradient(135deg,#fff1f3,#e0f7fa);}

/* 🌈 NAVBAR */
.navbar{
    background:linear-gradient(90deg,#f472b6,#8b5cf6,#22d3ee);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}
.navbar .logo{font-size:22px;font-weight:bold;}
.navbar a{
    color:white;text-decoration:none;margin-left:20px;font-weight:600;
}
.navbar a:hover{text-decoration:underline;}

/* 🏆 CONTENT */
.content{
    max-width:900px;
    margin:40px auto;
    text-align:center;
}
.content h2{
    font-family:'Baloo 2',cursive;
    font-size:36px;
    color:#7c2d12;
    margin-bottom:20px;
}
.cards{
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
    margin-top:30px;
}
.card{
    border-radius:25px;
    padding:25px 20px;
    cursor:pointer;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
    transition:0.3s;
    position:relative;
}
.card:hover{
    transform: scale(1.05);
}

/* 🎉 CARD COLORS */
.card-congrats{
    background:linear-gradient(135deg,#facc15,#f97316);
    color:white;
}
.card-lock{
    background:linear-gradient(135deg,#60a5fa,#14b8a6);
    color:white;
}

/* ICON */
.card i{
    font-size:40px;
    margin-bottom:15px;
}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-top:30px;
    padding:12px 25px;
    background:linear-gradient(90deg,#f472b6,#8b5cf6);
    color:white;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}
.back-btn:hover{transform:translateY(-3px);}

/* 🎊 CONFETTI ANIMATION */
.confetti-piece{
    position:absolute;
    width:10px;
    height:10px;
    background:random;
    top:-10px;
    animation:fall 3s linear infinite;
    opacity:0.8;
    border-radius:50%;
}
@keyframes fall{
    0%{transform:translateY(0) rotate(0deg);}
    100%{transform:translateY(600px) rotate(360deg);}
}
</style>
</head>
<body>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <div>
        <a href="kindergarten.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- 🏆 CONTENT -->
<div class="content">
    <h2>🏆 Kindergarten Certificate</h2>

    <div class="cards">

    <?php if (isset($_SESSION['quiz_completed']) && $_SESSION['quiz_completed'] === true): ?>
        <!-- 🎓 UNLOCKED CERTIFICATE -->
        <div class="card card-congrats" onclick="window.open('certificate/kindergarten_certificate.php','_blank')">
            <i class="fa-solid fa-award"></i>
            <h3>Congratulations!</h3>
            <p>You have successfully completed the quiz 🎉</p>
            <p><strong>Click to view your certificate</strong></p>
        </div>

        <!-- 🎊 CONFETTI -->
        <?php for($i=0;$i<40;$i++): ?>
            <div class="confetti-piece" style="left:<?=rand(0,90)?>%; background: hsl(<?=rand(0,360)?>,80%,60%); animation-delay: <?=rand(0,300)/100?>s;"></div>
        <?php endfor; ?>

    <?php else: ?>
        <!-- 🔒 LOCKED CERTIFICATE -->
        <div class="card card-lock">
            <i class="fa-solid fa-lock"></i>
            <h3>Certificate Locked</h3>
            <p>Complete the quiz to unlock your certificate 🔒</p>
        </div>
    <?php endif; ?>

    </div>

    <!-- BACK BUTTON -->
    <a href="kindergarten.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Homepage</a>
</div>

</body>
</html>
