<?php
session_start();

/* 🔐 Allow only logged-in secondary users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: dashboard.php");
    exit;
}

/* ✅ Move user to highschool level */
$_SESSION['user_level'] = 'highschool';


/* 🔒 LOCK Primary progress */
$_SESSION['highschool_quiz_completed'] = false;
$_SESSION['highschool_certificate_unlocked'] = false;

/* Store name safely */
$user_name = $_SESSION['user_name'] ?? 'Student';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Level Up! 🎉</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
    min-height:100vh;
    background:linear-gradient(135deg,#f5f7fa,#c3cfe2);
    display:flex;
    justify-content:center;
    align-items:center;
    flex-direction:column;
    overflow:hidden;
}

/* 🎉 LEVEL UP CARD */
.card{
    background:linear-gradient(135deg,#34d399,#3b82f6,#f472b6);
    padding:50px 40px;
    border-radius:30px;
    text-align:center;
    color:white;
    box-shadow:0 25px 50px rgba(0,0,0,0.2);
    animation:fadeIn 1s ease-out;
    max-width:600px;
    width:90%;
    position:relative;
    z-index:10;
}

/* Animations */
@keyframes fadeIn{
    0%{opacity:0; transform:scale(0.7);}
    100%{opacity:1; transform:scale(1);}
}

/* HEADINGS */
.card h1{
    font-family:'Baloo 2',cursive;
    font-size:48px;
    margin-bottom:15px;
    text-shadow:2px 2px 6px rgba(0,0,0,0.3);
}
.card h2{
    font-size:28px;
    margin-bottom:25px;
}

/* BUTTONS */
.btn{
    padding:12px 25px;
    font-size:16px;
    border:none;
    border-radius:25px;
    cursor:pointer;
    font-weight:bold;
    transition:0.3s;
    margin:10px;
    text-decoration:none;
    display:inline-block;
}

/* Primary button */
.btn-primary{
    background:linear-gradient(90deg,#facc15,#f97316);
    color:white;
}
.btn-primary:hover{
    transform:scale(1.05);
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

/* Secondary button */
.btn-secondary{
    background:linear-gradient(90deg,#6366f1,#22d3ee);
    color:white;
}
.btn-secondary:hover{
    transform:scale(1.05);
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}

/* 🎊 CONFETTI PIECES */
.confetti-piece{
    position:absolute;
    width:12px;
    height:12px;
    border-radius:50%;
    opacity:0.9;
    animation:fall 3s linear infinite;
}
@keyframes fall{
    0%{transform:translateY(0) rotate(0deg);}
    100%{transform:translateY(700px) rotate(360deg);}
}
</style>
</head>
<body>

<!-- 🎉 LEVEL UP CARD -->
<div class="card">
    <h1>🎉 Level Up! 🎉</h1>
    <h2>Congratulations, <?php echo htmlspecialchars($user_name); ?>!</h2>
    <p>
        You have successfully completed <strong>Secondary</strong>  
        and now moving to the <strong>High-School Level</strong>! 🚀
    </p>


    <a href="secondary.php" class="btn btn-primary">
        <i class="fa-solid fa-arrow-right"></i> Go to High-School Level
    </a>
</div>

<!-- 🎊 CONFETTI ANIMATION -->
<?php for ($i = 0; $i < 50; $i++): ?>
    <div class="confetti-piece"
        style="
            left: <?= rand(0,95) ?>%;
            background: hsl(<?= rand(0,360) ?>,80%,60%);
            animation-delay: <?= rand(0,300)/100 ?>s;
        ">
    </div>
<?php endfor; ?>

</body>
</html>
