<?php
session_start();
require_once "../config/db.php";   // ✅ ADD THIS LINE

/* 🔐 Access control */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level = 'kindergarten';

/* 🔍 Check certificate status */
$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress 
    WHERE user_id = ? AND level = ?
");
$stmt->bind_param("is", $user_id, $level);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$certificate_unlocked = $result['certificate_unlocked'] ?? 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kindergarten Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Baloo 2', cursive;
    background:linear-gradient(180deg,#e0f2fe,#fef3c7);
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#38bdf8,#a78bfa);
    padding:18px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:#fff;
}
.navbar-left{
    display:flex;
    align-items:center;
    gap:15px;
}
.navbar h2{margin:0;font-size:26px;}
.navbar a{
    color:#fff;
    text-decoration:none;
    background:rgba(255,255,255,0.2);
    padding:8px 18px;
    border-radius:20px;
}

/* NEXT LEVEL BUTTON */
.next-btn{
    border:none;
    padding:8px 18px;
    border-radius:20px;
    font-family:'Baloo 2', cursive;
    font-size:15px;
}
.next-btn.disabled{
    background:#cbd5e1;
    color:#475569;
    cursor:not-allowed;
}
.next-btn.active{
    background:#22c55e;
    color:#064e3b;
    cursor:pointer;
}

/* HEADER */
.header{text-align:center;padding:25px 15px;}
.header h1{font-size:36px;color:#0f172a;}
.header p{font-size:18px;color:#334155;}

/* GRID */
.grid{
    max-width:900px;
    margin:0 auto 50px;
    padding:20px;
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:30px;
}

/* CARD */
.card{
    border-radius:28px;
    padding:35px 20px;
    text-align:center;
    cursor:pointer;
    box-shadow:0 15px 30px rgba(0,0,0,0.15);
    transition:0.35s;
    color:#fff;
}
.card:hover{transform:translateY(-10px) rotate(-2deg) scale(1.05);}
.card i{font-size:50px;margin-bottom:15px;}
.card h3{font-size:26px;margin:10px 0 5px;}
.card p{font-size:15px;opacity:0.9;}

/* CARD COLORS */
.lessons{background:#60a5fa;}
.books{background:#a78bfa;}
.assignments{background:#34d399;}
.games{background:#fbbf24;color:#78350f;}
.quizzes{background:#fb923c;}
.live{background:#fb7185;}
.certificate{background:#22c55e;}

@media(max-width:600px){
    .grid{grid-template-columns:1fr;}
}
</style>
</head>

<body>
<!-- NAVBAR -->
<div class="navbar">
    <div class="navbar-left">
        <h2>🎨 Kindergarten</h2>

        <!-- Move to Next Level button -->
        <?php if ($certificate_unlocked == 1): ?>
            <button class="next-btn active"
                    onclick="location.href='move_next.php'">
                🚀 Move to Next Level
            </button>
        <?php else: ?>
            <button class="next-btn disabled" disabled>
                🔒 Complete All Quizzes to Unlock
            </button>
        <?php endif; ?>
    </div>

    <a href="logout.php">Logout</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Hello <?php echo htmlspecialchars($_SESSION['user_name']); ?> 🌈</h1>
    <p>Let’s learn & play together!</p>
</div>

<!-- GRID -->
<div class="grid">

    <div class="card lessons" onclick="location.href='lesson.php'">
        <i class="fa-solid fa-book-open"></i>
        <h3>Lessons</h3>
        <p>ABCs & Numbers</p>
    </div>

    <div class="card books" onclick="location.href='books.php'">
        <i class="fa-solid fa-book"></i>
        <h3>Books</h3>
        <p>Story Time</p>
    </div>

    <div class="card assignments" onclick="location.href='assignments.php'">
        <i class="fa-solid fa-pencil"></i>
        <h3>Assignments</h3>
        <p>Draw & Color</p>
    </div>

    <div class="card games" onclick="location.href='games.php'">
        <i class="fa-solid fa-gamepad"></i>
        <h3>Games</h3>
        <p>Fun Learning</p>
    </div>

    <div class="card quizzes" onclick="location.href='quizzes.php'">
        <i class="fa-solid fa-circle-question"></i>
        <h3>Quizzes</h3>
        <p>Quick Fun Tests</p>
    </div>

    <div class="card live" onclick="location.href='live.php'">
        <i class="fa-solid fa-video"></i>
        <h3>Live Class</h3>
        <p>Join Teacher</p>
    </div>

    <!--<div class="card certificate" onclick="<?php echo $certificate_unlocked ? "location.href='certificate.php'" : "alert('Complete the quiz to unlock certificate')"; ?>">
        <i class="fa-solid fa-trophy"></i>
        <h3>Certificate</h3>
        <p>Star Reward ⭐</p>
    </div> -->

</div>

</body>
</html>
