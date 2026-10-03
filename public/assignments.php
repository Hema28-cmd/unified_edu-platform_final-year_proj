<?php
session_start();

/* 🔐 Allow only kindergarten users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}

/* 🔗 Database connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");
if ($conn->connect_error) {
    die("Database connection failed");
}

/* 📥 Fetch approved kindergarten assignments (NO DUE DATE) */
$sql = "
    SELECT title, subject, description
    FROM assignments
    WHERE level = 'kindergarten'
      AND status = 'approved'
    ORDER BY created_at DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kindergarten Activities | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#fef9c3,#e0f2fe);
    min-height:100vh;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#22c55e,#38bdf8,#a78bfa);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}
.navbar a{
    color:white;
    text-decoration:none;
    margin-left:15px;
    background:rgba(255,255,255,0.25);
    padding:8px 16px;
    border-radius:20px;
}

/* LAYOUT */
.wrapper{
    max-width:1300px;
    margin:35px auto;
    padding:0 20px;
    display:flex;
    gap:25px;
}

.sidebar{
    width:260px;
    background:white;
    border-radius:25px;
    padding:25px;
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

.main{
    flex:1;
}

/* ASSIGNMENTS GRID */
.assignments{
    margin-top:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.assignment{
    background:white;
    border-radius:25px;
    padding:26px 22px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    transition:0.3s;
    text-align:center;
}

.assignment:hover{
    transform:translateY(-6px);
}

.assignment i{
    font-size:44px;
    color:#f97316;
    margin-bottom:12px;
}

.assignment h4{
    margin-bottom:6px;
    color:#1e293b;
    font-family:'Baloo 2',cursive;
    font-size:20px;
}

.assignment .subject{
    font-weight:600;
    color:#2563eb;
    margin-bottom:10px;
    display:block;
}

.assignment .desc{
    font-size:14px;
    color:#475569;
}

.sidebar{
    height: fit-content;
    align-self: flex-start;
    padding-bottom: 20px;
}

.container{
    align-items: flex-start;
}

.side-footer{
    margin-top: 25px;
    padding: 16px;
    background: linear-gradient(135deg,#fde68a,#fca5a5);
    border-radius: 18px;
    text-align: center;
    font-weight: bold;
    color: #78350f;
    font-size: 15px;
}

.side-footer p{
    margin-top: 6px;
    font-size: 13px;
    font-weight: 500;
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

<div class="wrapper">

    <!-- 📌 SIDEBAR -->
    <div class="sidebar">
    <h3>🧸 Activity Corner</h3>

    <div class="side-item">
        <i class="fa-solid fa-font"></i>
        <span>Alphabet Tracing</span>
    </div>

    <div class="side-item">
        <i class="fa-solid fa-hashtag"></i>
        <span>Number Writing</span>
    </div>

    <div class="side-item">
        <i class="fa-solid fa-palette"></i>
        <span>Coloring Sheets</span>
    </div>

    <div class="side-item">
        <i class="fa-solid fa-shapes"></i>
        <span>Shape Matching</span>
    </div>

    <div class="side-item">
        <i class="fa-solid fa-pencil"></i>
        <span>Drawing Practice</span>
    </div>
<div class="side-footer">
    🌟 Great Job!
    <p>Keep learning & smiling 😊</p>
</div>

</div>


    <!-- 📄 MAIN CONTENT -->
    <div class="main">
        <h2>📝 Fun Learning Activities</h2>
        <p>Learn • Play • Enjoy 🎈</p>

        <div class="assignments">

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="assignment">
                   <?php
$icon = match ($row['subject']) {
    'Math' => 'fa-shapes',
    'English' => 'fa-font',
    'EVS' => 'fa-leaf',
    default => 'fa-star'
};
?>
<i class="fa-solid <?= $icon ?>"></i>

                    <h4><?= htmlspecialchars($row['title']) ?></h4>
                    <span class="subject"><?= htmlspecialchars($row['subject']) ?></span>

                    <?php if (!empty($row['description'])): ?>
                        <div class="desc">
                            <?= htmlspecialchars($row['description']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="margin-top:20px;color:#dc2626;">
                No activities available yet 🎨
            </p>
        <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>
