<?php
session_start();

/* 🔐 Allow only primary users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../highschool.php");
    exit;
}

/* 🔗 Database Connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

/* 📥 Fetch ONLY APPROVED HIGHSCHOOL assignments */
$sql = "
    SELECT title, subject, description
    FROM assignments
    WHERE level = 'highschool'
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
background:linear-gradient(120deg,#f0fdf4,#ecfdf5,#f5f3ff);
min-height:100vh;
}

/* NAVBAR */

.navbar{
background:linear-gradient(90deg,#6d28d9,#7c3aed,#22c55e);
padding:16px 30px;
display:flex;
justify-content:space-between;
align-items:center;
color:white;
box-shadow:0 5px 20px rgba(0,0,0,0.15);
}

.navbar a{
color:white;
text-decoration:none;
margin-left:15px;
padding:8px 16px;
border-radius:20px;
background:rgba(255,255,255,0.25);
transition:0.3s;
}

.navbar a:hover{
background:white;
color:#4c1d95;
}

/* LAYOUT */

.wrapper{
max-width:1400px;
margin:40px auto;
padding:0 20px;
display:grid;
grid-template-columns:260px 1fr 260px;
gap:25px;
}

/* SIDEBAR */

.sidebar{
background:white;
border-radius:22px;
padding:25px;
box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

.sidebar h3{
margin-bottom:15px;
color:#4c1d95;
}

.sidebar p{
margin:10px 0;
color:#374151;
}

/* RIGHT PANEL */

.rightpanel{
background:white;
border-radius:22px;
padding:25px;
box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

.rightpanel h3{
color:#4c1d95;
margin-bottom:15px;
}

.announcement{
background:#ecfdf5;
padding:12px;
border-radius:12px;
margin-bottom:10px;
font-size:14px;
color:#065f46;
}

/* MAIN CONTENT */

.main{
padding:5px;
}

.main h2{
color:#1f2937;
}

.main p{
color:#4b5563;
}

/* ASSIGNMENT GRID */

.assignments{
margin-top:25px;
display:grid;
grid-template-columns:repeat(3, 1fr);
gap:25px;
}

/* ASSIGNMENT CARD */

.assignment{
background:white;
border-radius:22px;
padding:28px 22px;
text-align:center;
box-shadow:0 15px 35px rgba(0,0,0,0.15);
transition:0.3s;
position:relative;
overflow:hidden;
}

.assignment::before{
content:'';
position:absolute;
top:0;
left:0;
width:100%;
height:6px;
background:linear-gradient(90deg,#7c3aed,#22c55e);
}

.assignment:hover{
transform:translateY(-8px);
box-shadow:0 20px 45px rgba(0,0,0,0.2);
}

.assignment i{
font-size:45px;
margin-bottom:14px;
color:#7c3aed;
}

.assignment h4{
font-size:20px;
margin-bottom:6px;
font-family:'Baloo 2',cursive;
color:#1e293b;
}

.assignment .subject{
display:block;
font-weight:600;
color:#16a34a;
margin-bottom:10px;
}

.assignment .desc{
font-size:14px;
color:#475569;
}

/* MOTIVATION CARD */

.motivation{
margin-top:25px;
padding:18px;
border-radius:18px;
background:linear-gradient(135deg,#ede9fe,#dcfce7);
text-align:center;
color:#4c1d95;
font-weight:600;
}
</style>
</head>

<body>

<!-- 🔵 NAVBAR -->
<div class="navbar">
    <div class="logo">📘 HighSchool Section</div>
    <div>
        <a href="../highschool.php">Dashboard</a>
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
        <p>🌍 Physics Activities</p>

        <div class="side-footer">
            🌟 Keep Going!
            <p>You are doing amazing 💙</p>
        </div>
    </div>

    <!-- 📄 MAIN CONTENT -->
    <div class="main">
        <h2>📝 HighSchool Assignments</h2>
        <p>Explore • Learn • Achieve 🚀</p>

        <div class="assignments">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>

                <?php
                $icon = match ($row['subject']) {
                    'Math' => 'fa-calculator',
                    'Science' => 'fa-flask',
                    'English' => 'fa-book',
                    'Physics' => 'fa-leaf',
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
                No highschool assignments available yet 📘
            </p>
        <?php endif; ?>

        </div>
    </div>
</div>

</body>
</html>