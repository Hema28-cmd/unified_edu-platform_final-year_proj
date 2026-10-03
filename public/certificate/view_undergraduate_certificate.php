<?php
session_start();

// Only allow undergraduate users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$student_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : "Undergraduate Student";
$certificate_id = "UG-" . date("Ymd") . "-" . rand(1000,9999);
$date_of_issue = date("d M Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Certificate</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(120deg,#e0f2fe,#f8fafc);
    font-family:'Poppins',sans-serif;
}

/* MAIN CERTIFICATE */
.certificate{
    display:grid;
    grid-template-columns:280px 1fr;
    width:900px;
    background:#ffffff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 25px 50px rgba(0,0,0,0.25);
}

/* LEFT PANEL */
.left-panel{
    background:linear-gradient(180deg,#1e3a8a,#0f172a);
    color:#ffffff;
    padding:40px 25px;
    text-align:center;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.left-panel h2{
    font-size:26px;
    margin-bottom:12px;
    letter-spacing:1px;
}

.left-panel p{
    font-size:14px;
    opacity:0.85;
}

.badge{
    font-size:60px;
    margin-bottom:20px;
}

/* RIGHT PANEL */
.right-panel{
    padding:50px 60px;
    text-align:center;
}

.right-panel h1{
    font-size:38px;
    color:#1e3a8a;
    margin-bottom:10px;
}

.subtitle{
    font-size:18px;
    color:#64748b;
    margin-bottom:30px;
}

.name{
    font-size:34px;
    font-weight:700;
    color:#f59e0b;
    margin:15px 0;
}

.text{
    font-size:17px;
    color:#334155;
    margin:10px 0;
}

.info{
    margin-top:25px;
    font-size:15px;
    color:#475569;
}

/* BUTTONS */
.actions{
    margin-top:35px;
}

.print-btn{
    padding:12px 30px;
    background:#1e3a8a;
    color:#fff;
    border:none;
    border-radius:30px;
    font-size:15px;
    cursor:pointer;
    margin-right:12px;
    transition:0.3s;
}

.print-btn:hover{
    background:#0f172a;
    transform:scale(1.05);
}

.back-btn{
    padding:12px 30px;
    background:#22c55e;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-size:15px;
    font-weight:600;
    transition:0.3s;
}

.back-btn:hover{
    background:#15803d;
    transform:scale(1.05);
}

/* RESPONSIVE */
@media(max-width:900px){
    .certificate{
        grid-template-columns:1fr;
    }
    .left-panel{
        padding:30px;
    }
}
</style>
</head>

<body>

<div class="certificate">

    <!-- LEFT SIDE -->
    <div class="left-panel">
        <div class="badge">🎓</div>
        <h2>Undergraduate</h2>
        <p>Academic Achievement Certificate</p>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-panel">
        <h1>Certificate of Completion</h1>
        <p class="subtitle">This certificate is proudly presented to</p>

        <div class="name"><?php echo htmlspecialchars($student_name); ?></div>

        <p class="text">
            For successfully completing the<br>
            <strong>Undergraduate Academic Program</strong>
        </p>

        <div class="info">
            Certificate ID: <strong><?php echo $certificate_id; ?></strong><br>
            Date of Issue: <strong><?php echo $date_of_issue; ?></strong>
        </div>

        <div class="actions">
            <button class="print-btn" onclick="window.print()">🖨️ Print / Save</button>
            <a href="undergraduate_certificate.php" class="back-btn">⬅ Back</a>
        </div>
    </div>

</div>

</body>
</html>
