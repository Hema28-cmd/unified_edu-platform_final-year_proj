<?php
session_start();

/* 🔐 Allow only primary users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary') {
    header("Location: ../primary.php");
    exit;
}

/* 🔗 Database Connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/* 📥 Fetch ONLY APPROVED PRIMARY assignments */
$sql = "
    SELECT title, subject, description
    FROM assignments
    WHERE level = 'primary'
      AND status = 'approved'
    ORDER BY created_at DESC
";

$result = $conn->query($sql);

if (!$result) {
    die("Query Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Assignments | Unified Edu</title>
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
    background:linear-gradient(135deg,#e0f2fe,#f0f9ff);
    min-height:100vh;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#2563eb,#0ea5e9,#6366f1);
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

/* ASSIGNMENT GRID */
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
    color:#2563eb;
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
    color:#0ea5e9;
    margin-bottom:10px;
    display:block;
}

.assignment .desc{
    font-size:14px;
    color:#475569;
    margin-bottom:10px;
}

/* SIDEBAR FOOTER */
.side-footer{
    margin-top: 25px;
    padding: 16px;
    background: linear-gradient(135deg,#bfdbfe,#c7d2fe);
    border-radius: 18px;
    text-align: center;
    font-weight: bold;
    color: #1e3a8a;
    font-size: 15px;
}
</style>
</head>

<body>

<!-- 🔵 NAVBAR -->
<div class="navbar">
    <div class="logo">📘 Primary Section</div>
    <div>
        <a href="../primary.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="wrapper">

    <!-- 📌 SIDEBAR -->
    <div class="sidebar">
        <h3>📚 Learning Zone</h3>

        <p style="margin-top:15px;">🧮 Math Practice</p>
        <p>🔬 Science Projects</p>
        <p>📖 English Writing</p>
        <p>🌍 EVS Activities</p>

        <div class="side-footer">
            🌟 Keep Going!
            <p>You are doing amazing 💙</p>
        </div>
    </div>

    <!-- 📄 MAIN CONTENT -->
    <div class="main">
        <h2>📝 Primary Assignments</h2>
        <p>Explore • Learn • Achieve 🚀</p>

        <div class="assignments">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>

                <?php
                $icon = match ($row['subject']) {
                    'Math' => 'fa-calculator',
                    'Science' => 'fa-flask',
                    'English' => 'fa-book',
                    'EVS' => 'fa-leaf',
                    default => 'fa-star'
                };
                ?>

                <div class="assignment">
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
                No primary assignments available yet 📘
            </p>
        <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>