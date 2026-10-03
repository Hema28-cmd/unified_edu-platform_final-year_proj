<?php
session_start();

// Allow only undergraduate users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$student_name = $_SESSION['user_name'] ?? "Undergraduate Student";
$project_title = "Unified Education Management System"; // change if needed
$certificate_id = "UG-PROJ-" . date("Ymd") . "-" . rand(1000,9999);
$date_of_issue = date("d M Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Project Achievement Certificate</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#fef3c7,#ecfeff);
    font-family:'Poppins',sans-serif;
}

.certificate{
    width:900px;
    background:#ffffff;
    border-radius:24px;
    box-shadow:0 25px 55px rgba(0,0,0,0.25);
    padding:65px 55px;
    text-align:center;
    position:relative;
}

.top-strip{
    position:absolute;
    top:0;
    left:0;
    right:0;
    height:14px;
    background:linear-gradient(90deg,#f59e0b,#0ea5e9,#22c55e);
    border-radius:24px 24px 0 0;
}

.badge{
    font-size:64px;
    margin-bottom:18px;
}

h1{
    font-size:40px;
    color:#1e293b;
    margin-bottom:12px;
}

.subtitle{
    font-size:18px;
    color:#475569;
    margin-bottom:32px;
}

.name{
    font-size:36px;
    font-weight:700;
    color:#f59e0b;
    margin:22px 0;
}

.project{
    font-size:22px;
    font-weight:600;
    color:#0ea5e9;
    margin:14px 0 26px;
}

.text{
    font-size:17px;
    color:#334155;
    line-height:1.8;
}

.info{
    margin-top:36px;
    font-size:15px;
    color:#475569;
}

.actions{
    margin-top:45px;
}

.print-btn{
    padding:14px 36px;
    background:#0ea5e9;
    color:#fff;
    border:none;
    border-radius:30px;
    font-size:16px;
    cursor:pointer;
    margin-right:14px;
    transition:0.3s;
}

.print-btn:hover{
    background:#0369a1;
    transform:scale(1.05);
}

.back-btn{
    padding:14px 36px;
    background:#22c55e;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-size:16px;
    font-weight:600;
    transition:0.3s;
}

.back-btn:hover{
    background:#15803d;
    transform:scale(1.05);
}

@media(max-width:900px){
    .certificate{
        padding:45px 25px;
    }
}
</style>
</head>

<body>

<div class="certificate">
    <div class="top-strip"></div>

    <div class="badge">🏆</div>

    <h1>Project Achievement Certificate</h1>
    <p class="subtitle">This certificate is proudly awarded to</p>

    <div class="name"><?php echo htmlspecialchars($student_name); ?></div>

    <p class="text">
        For successfully completing and presenting the academic project titled
    </p>

    <div class="project">"<?php echo htmlspecialchars($project_title); ?>"</div>

    <p class="text">
        as part of the Undergraduate curriculum, demonstrating technical skills,
        problem-solving ability, and practical implementation knowledge.
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

</body>
</html>
