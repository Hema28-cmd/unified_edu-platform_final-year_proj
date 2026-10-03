<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$studentName = $_SESSION['user_name'] ?? 'Student Name';
$date = date("d F Y");

// Check certificate status from DATABASE
$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress
    WHERE user_id = ?
    AND level = 'secondary'
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$isUnlocked = false;

if ($row = $result->fetch_assoc()) {
    $isUnlocked = $row['certificate_unlocked'] == 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Level Certificate</title>

<style>
body{
    margin:0;
    padding:40px;
    font-family:'Roboto',sans-serif;
    background:linear-gradient(120deg,#e0f2fe,#fef3c7);
}

/* CERTIFICATE */
.certificate{
    max-width:950px;
    margin:auto;
    background:#ffffff;
    border-radius:18px;
    padding:60px;
    border:8px solid #38bdf8;
    position:relative;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

/* TOP STRIP */
.top-strip{
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:14px;
    background:linear-gradient(90deg,#22c55e,#38bdf8,#fb7185);
    border-top-left-radius:10px;
    border-top-right-radius:10px;
}

/* HEADER */
.header{
    text-align:center;
    margin-top:20px;
}
.header h1{
    font-family:'Playfair Display',serif;
    font-size:46px;
    color:#0f172a;
}
.header h3{
    font-weight:400;
    color:#475569;
}

/* CONTENT */
.content{
    text-align:center;
    margin:50px 0;
}
.content p{
    font-size:20px;
    color:#334155;
}
.student{
    font-family:'Playfair Display',serif;
    font-size:38px;
    font-weight:700;
    color:#22c55e;
    margin:18px 0;
}
.level{
    font-family:'Playfair Display',serif;
    font-size:24px;
    color:#0284c7;
    font-weight:600;
}

/* FOOTER */
.footer{
    display:flex;
    justify-content:space-between;
    margin-top:70px;
    font-size:18px;
    color:#334155;
}

/* BUTTONS */
.buttons{
    text-align:center;
    margin-top:30px;
}
.buttons button{
    padding:12px 30px;
    margin:10px;
    font-size:16px;
    border:none;
    border-radius:30px;
    cursor:pointer;
}
.print{background:#38bdf8;color:#fff;}
.pdf{background:#22c55e;color:#fff;}
.back{background:#fb7185;color:#fff;}

/* LOCKED */
.locked{
    text-align:center;
}
.locked h2{
    font-family:'Playfair Display',serif;
    color:#dc2626;
    font-size:36px;
}
.locked p{
    font-size:20px;
    color:#475569;
}

/* PRINT */
@media print{
    body{background:#fff;}
    .buttons{display:none;}
}

.cert-icon{
    font-size:60px;
    margin-bottom:10px;
    animation:float 3s ease-in-out infinite;
}
@keyframes float{
    0%{transform:translateY(0);}
    50%{transform:translateY(-8px);}
    100%{transform:translateY(0);}
}
</style>
</head>

<body>

<?php if ($isUnlocked): ?>

<div class="certificate">
    <div class="top-strip"></div>

    <div class="header">
        <div class="cert-icon">🎓</div>
        <h1>Certificate of Completion</h1>
        <h3>Unified Digital Education Platform</h3>
    </div>

    <div class="content">
        <p>This is to proudly certify that</p>
        <div class="student"><?php echo htmlspecialchars($studentName); ?></div>
        <p>has successfully completed the</p>
        <div class="level">Secondary Level Academic Program</div>
        <p style="margin-top:25px;">
            and demonstrated consistent performance in all subject quizzes.
        </p>
    </div>

    <div class="footer">
        <div>
            <strong>Date Issued</strong><br>
            <?php echo $date; ?>
        </div>
        <div style="text-align:right;">
            <strong>Verified Certificate</strong><br>
            <span style="font-size:14px;color:#64748b;">
                Unified Digital Education Platform
            </span>
        </div>
    </div>
</div>

<div class="buttons">
    <button class="print" onclick="window.print()">🖨 Print</button>
    <button class="pdf" onclick="window.print()">📄 Save PDF</button>
    <button class="back" onclick="location.href='../secondary.php'">⬅ Dashboard</button>
</div>

<?php else: ?>

<div class="certificate locked">
    <h2>🔒 Certificate Locked</h2>
    <p>Please complete all secondary subject quizzes to unlock this certificate.</p>
</div>

<div class="buttons">
    <button class="back" onclick="location.href='../quizzes/secondary_quizzes.php'">
        📝 Go to Quizzes
    </button>
</div>

<?php endif; ?>

</body>
</html>
