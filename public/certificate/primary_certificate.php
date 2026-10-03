<?php
session_start();
require_once '../../config/db.php';

$user_id = $_SESSION['user_id'] ?? 0;
$isUnlocked = false;

if ($user_id > 0) {
    $stmt = $conn->prepare("
        SELECT certificate_unlocked 
        FROM user_progress 
        WHERE user_id = ? AND level = 'primary'
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['certificate_unlocked'] == 1) {
            $isUnlocked = true;
        }
    }
}

/* Certificate Data */
$studentName = $_SESSION['user_name'] ?? 'Student Name';
$score = $_SESSION['final_score'] ?? 'Excellent';
$date = date("d M Y");
$certificateId = "SEP-PRI-" . rand(1000, 9999);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Certificate</title>

<style>
body {
    font-family: Georgia, serif;
    background: #f0f9ff;
    padding: 30px;
}

/* COMMON CARD */
.certificate-container {
    max-width: 900px;
    margin: auto;
    background: #fff;
    padding: 50px;
    border-radius: 15px;
    position: relative;
}

/* UNLOCKED */
.unlocked {
    border: 12px solid #0369a1;
}

.badge {
    position: absolute;
    top: -30px;
    right: -30px;
    background: #16a34a;
    color: #fff;
    padding: 20px;
    border-radius: 50%;
    font-weight: bold;
}

/* LOCKED */
.locked {
    border: 12px solid #dc2626;
    text-align: center;
}

.locked .badge {
    background: #dc2626;
}

.buttons {
    text-align: center;
    margin-top: 30px;
}

button {
    padding: 12px 26px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
    font-size: 16px;
    margin: 10px;
}

.back-btn {
    background: #64748b;
    color: #fff;
}

.print-btn {
    background: #0284c7;
    color: #fff;
}
</style>
</head>

<body>

<?php if ($isUnlocked): ?>
<!-- ================= CERTIFICATE UNLOCKED ================= -->

<div class="certificate-container unlocked">
    <div class="badge">✔ Certified</div>

    <h1 style="text-align:center;">Certificate of Achievement</h1>
    <h3 style="text-align:center;">Smart Education Platform</h3>

    <p style="text-align:center;font-size:20px;">This certifies that</p>

    <h2 style="text-align:center;color:#16a34a;">
        <?php echo htmlspecialchars($studentName); ?>
    </h2>

    <p style="text-align:center;">has successfully completed</p>
    <p style="text-align:center;"><strong>Primary Level Academic Program</strong></p>

    <p style="text-align:center;color:#0284c7;">
        Overall Performance: <strong><?php echo htmlspecialchars($score); ?></strong>
    </p>

    <div style="display:flex;justify-content:space-between;margin-top:40px;">
        <div>Date Issued:<br><?php echo $date; ?></div>
        <div style="text-align:right;">
            Certificate ID:<br><?php echo $certificateId; ?>
        </div>
    </div>
</div>

<div class="buttons">
    <button class="print-btn" onclick="window.print()">🖨 Print</button>
    <button class="back-btn" onclick="location.href='../primary.php'">⬅ Dashboard</button>
</div>

<?php else: ?>
<!-- ================= CERTIFICATE LOCKED ================= -->

<div class="certificate-container locked">
    <div class="badge">🔒</div>

    <h1>Certificate Locked</h1>
    <p style="font-size:20px;">
        You have not completed the required quizzes.
    </p>
    <p>Please complete all quizzes to unlock your certificate.</p>
</div>

<div class="buttons">
    <button class="back-btn" onclick="location.href='../quizzes/primary_quizzes.php'">
        📘 Go to Quizzes
    </button>
    <button class="back-btn" onclick="location.href='../primary.php'">
        ⬅ Dashboard
    </button>
</div>

<?php endif; ?>

</body>
</html>
