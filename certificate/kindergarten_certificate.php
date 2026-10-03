<?php
session_start();
require_once "../../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: ../kindergarten.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level = 'kindergarten';

/* ✅ Check certificate unlock status from user_progress */
$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress 
    WHERE user_id = ? AND level = ?
");
$stmt->bind_param("is", $user_id, $level);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result || $result['certificate_unlocked'] != 1) {
    header("Location: ../kindergarten.php");
    exit;
}

/* ✅ Get Student Name */
$userStmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$userStmt->bind_param("i", $user_id);
$userStmt->execute();
$userResult = $userStmt->get_result()->fetch_assoc();

$student_name = $userResult['name'] ?? 'Student';

/* ✅ Generate Certificate ID */
$certificate_id = "KG-" . $user_id . "-" . date("Ymd");

/* ✅ Set Date of Issue */
$date_of_issue = date("F d, Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kindergarten Certificate</title>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@700&display=swap');

    body {
        font-family: 'Baloo 2', cursive;
        background: linear-gradient(135deg, #ffe082, #ffcc80);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .certificate {
        background: #fff8e1;
        border: 8px dashed #ffb300;
        border-radius: 25px;
        padding: 60px 40px;
        text-align: center;
        width: 650px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        position: relative;
    }

    .certificate::before,
    .certificate::after {
        content: "🎈";
        font-size: 50px;
        position: absolute;
    }

    .certificate::before { top: -20px; left: 20px; }
    .certificate::after { bottom: -20px; right: 20px; }

    .certificate h1 {
        color: #ff6f00;
        font-size: 36px;
        margin-bottom: 15px;
    }

    .certificate h2 {
        color: #d84315;
        font-size: 30px;
        margin: 15px 0;
    }

    .certificate p {
        font-size: 18px;
        margin: 8px 0;
    }

    .highlight {
        font-weight: bold;
        color: #ef6c00;
    }

    .print-btn {
        margin-top: 30px;
        padding: 12px 25px;
        background: #ef6c00;
        color: white;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s;
    }

    .print-btn:hover {
        background: #d84315;
        transform: scale(1.05);
    }

</style>
</head>
<body>

<div class="certificate">
    <h1>🎉 Certificate of Achievement 🎉</h1>
    <p>This certificate is proudly awarded to</p>
    <h2 class="highlight"><?php echo htmlspecialchars($student_name); ?></h2>
    <p>For successfully completing the</p>
    <p class="highlight">Kindergarten Learning Program</p>
    <p>Certificate ID: <span class="highlight"><?php echo $certificate_id; ?></span></p>
    <p>Date of Issue: <span class="highlight"><?php echo $date_of_issue; ?></span></p>

    <button class="print-btn" onclick="window.print()">🖨️ Print / Save as PDF</button>
</div>

</body>
</html>
