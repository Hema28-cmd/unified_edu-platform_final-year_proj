<?php
session_start();

/* 🔐 Allow only secondary users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../dashboard.php");
    exit;
}

/* 🔗 Database Connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/* 📥 Fetch ONLY APPROVED SECONDARY assignments */
$sql = "
    SELECT title, subject, description, created_at
    FROM assignments
    WHERE level = 'secondary'
      AND status = 'approved'
    ORDER BY created_at DESC
";

$result = $conn->query($sql);
$totalAssignments = $result->num_rows;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Secondary Assignments | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#0f0c29,#302b63,#24243e);
    min-height:100vh;
    color:#fff;
}

/* NAVBAR */
.navbar{
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:rgba(0,0,0,0.4);
    backdrop-filter:blur(10px);
}
.navbar a{
    color:#fff;
    text-decoration:none;
    margin-left:20px;
    font-weight:600;
}
.navbar a:hover{color:#00f5d4;}

/* HEADER SECTION */
.header{
    text-align:center;
    padding:40px 20px;
}
.header h1{
    font-family:'Orbitron',sans-serif;
    font-size:32px;
    margin-bottom:10px;
    letter-spacing:2px;
}
.header p{
    color:#cbd5e1;
}

/* STATS */
.stats{
    display:flex;
    justify-content:center;
    gap:30px;
    margin:20px 0 40px;
}
.stat-box{
    background:rgba(255,255,255,0.1);
    padding:20px 40px;
    border-radius:20px;
    text-align:center;
    backdrop-filter:blur(15px);
}
.stat-box h2{
    font-size:28px;
    color:#00f5d4;
}

/* GRID */
.container{
    max-width:1200px;
    margin:auto;
    padding:0 20px 50px;
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(270px,1fr));
    gap:30px;
}

/* CARD */
.card{
    background:rgba(255,255,255,0.08);
    border-radius:25px;
    padding:30px;
    backdrop-filter:blur(15px);
    transition:0.4s;
    position:relative;
    overflow:hidden;
}
.card:hover{
    transform:translateY(-10px);
    box-shadow:0 20px 40px rgba(0,0,0,0.5);
}

.card i{
    font-size:38px;
    margin-bottom:15px;
}

.card h3{
    margin-bottom:8px;
    font-size:20px;
}

.subject{
    font-weight:600;
    color:#00f5d4;
    margin-bottom:10px;
    display:block;
}

.desc{
    font-size:14px;
    color:#e2e8f0;
    margin-bottom:12px;
}

.date{
    font-size:12px;
    color:#94a3b8;
}

/* Glow Effect */
.card::before{
    content:"";
    position:absolute;
    top:-50%;
    left:-50%;
    width:200%;
    height:200%;
    background:linear-gradient(60deg,transparent,#00f5d4,transparent);
    transform:rotate(25deg);
    opacity:0;
    transition:0.5s;
}
.card:hover::before{
    opacity:0.15;
}
</style>
</head>
<body>

<div class="navbar">
    <div style="font-family:Orbitron;font-size:20px;">🚀 Secondary Zone</div>
    <div>
        <a href="../secondary.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="header">
    <h1>📝 Secondary Assignments</h1>
    <p>Challenge Yourself • Improve Skills • Achieve Excellence</p>
</div>

<div class="stats">
    <div class="stat-box">
        <h2><?= $totalAssignments ?></h2>
        <p>Total Assignments</p>
    </div>
    <div class="stat-box">
        <h2><?= date("M Y") ?></h2>
        <p>Current Month</p>
    </div>
</div>

<div class="container">
    <div class="grid">

    <?php if ($totalAssignments > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>

            <?php
            $icon = match ($row['subject']) {
                'Mathematics' => 'fa-calculator',
                'English' => 'fa-book-open',
                'Biology' => 'fa-leaf',
                'Chemistry' => 'fa-flask',
                'History' => 'fa-landmark',
                'Computer Science' => 'fa-laptop-code',
                default => 'fa-file-lines'
            };
            ?>

            <div class="card">
                <i class="fa-solid <?= $icon ?>" style="color:#00f5d4;"></i>
                <h3><?= htmlspecialchars($row['title']) ?></h3>
                <span class="subject"><?= htmlspecialchars($row['subject']) ?></span>
                <div class="desc">
                    <?= htmlspecialchars($row['description']) ?>
                </div>
                </div>

        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;color:#f87171;">
            No secondary assignments available yet 📄
        </p>
    <?php endif; ?>

    </div>
</div>

</body>
</html>