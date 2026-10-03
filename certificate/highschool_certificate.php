<?php
session_start();

// Include database connection
require_once "../../config/db.php"; // Adjust path if needed

// Only highschool students
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool'){
    header("Location: ../dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$student_name = $_SESSION['user_name'] ?? 'Student';

// ============================
// FETCH CERTIFICATE STATUS FROM DATABASE
// ============================
$stmt = $conn->prepare("
    SELECT certificate_unlocked
    FROM user_progress
    WHERE user_id = ? AND level = 'highschool'
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$completed_quizzes = ($result['certificate_unlocked'] ?? 0) == 1;

// Generate certificate details
$certificate_id = "HS-" . date("Ymd") . "-" . rand(1000,9999);
$date_of_issue = date("d M Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Certificate</title>
<style>
/* ... keep your CSS as is ... */
body { font-family: 'Segoe UI',sans-serif; background: linear-gradient(135deg,#fef3c7,#e0f2fe,#f0fdfa); display:flex; flex-direction:column; justify-content:flex-start; align-items:center; min-height:100vh; margin:0; padding:50px 20px; }
.certificate { background: #ffffff; border: 8px solid #4f46e5; border-radius: 25px; width: 750px; padding: 60px 50px; text-align: center; position: relative; box-shadow: 0 20px 50px rgba(0,0,0,0.2); transition: transform 0.3s ease; }
.certificate:hover { transform: scale(1.02); }
.ribbon { position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: linear-gradient(90deg,#f59e0b,#fbbf24); padding: 12px 60px; color: #fff; font-weight: bold; font-size: 22px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
.certificate h1 { color:#4f46e5; font-size:40px; margin-bottom:12px; }
.certificate h2 { font-size:34px; color:#1e3a8a; margin:12px 0; }
.highlight { font-weight:bold; color:#d97706; }
p { font-size:18px; color:#334155; margin:8px 0; }
.quote { font-style: italic; color:#64748b; margin:25px 0; }
.buttons { margin-top:30px; display:flex; flex-wrap:wrap; justify-content:center; gap:20px; }
.print-btn { padding:14px 36px; background: #4f46e5; color:#fff; border:none; border-radius:14px; cursor:pointer; font-size:16px; font-weight:600; transition:0.2s; }
.print-btn:hover { background:#3730a3; }
.btn-next { padding:14px 36px; background:linear-gradient(90deg,#22c55e,#3b82f6,#f97316); color:#fff; border-radius:30px; font-size:16px; text-decoration:none; font-weight:600; transition:0.3s; }
.btn-next:hover { transform: scale(1.05); }
.locked h2 { color:#dc2626; font-size:38px; margin-bottom:12px; }
.locked p { color:#475569; font-size:18px; margin-bottom:15px; }
.locked a { display:inline-block; margin-top:10px; padding:10px 25px; background:#facc15; color:#1e293b; font-weight:600; border-radius:12px; text-decoration:none; transition:0.2s; }
.locked a:hover { background:#f59e0b; }
.footer { margin-top:40px; font-size:14px; color:#64748b; text-align:center; }
</style>
</head>
<body>

<?php if($completed_quizzes): ?>
    <div class="certificate">
        <div class="ribbon">🏅 High School Achievement</div>

        <h1>Certificate of Excellence</h1>
        <p>This is proudly presented to</p>
        <h2 class="highlight"><?php echo htmlspecialchars($student_name); ?></h2>
        <p>for successfully completing the</p>
        <p class="highlight">High School Academic Program</p>

        <p>Certificate ID: <span class="highlight"><?php echo $certificate_id; ?></span></p>
        <p>Date of Issue: <span class="highlight"><?php echo $date_of_issue; ?></span></p>

        <p class="quote">"Education is the passport to the future, for tomorrow belongs to those who prepare for it today." – Malcolm X</p>
    </div>

    <div class="buttons">
        <button class="print-btn" onclick="window.print()">🖨️ Print / Save PDF</button>
    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Unified Edu. All rights reserved.
    </div>

<?php else: ?>
    <div class="certificate locked">
        <h2>🔒 Certificate Locked</h2>
        <p>Please complete all High School quizzes to unlock your certificate.</p>
        <a href="../quizzes/highschool_quizzes.php">Go to Quizzes</a>
    </div>
<?php endif; ?>

</body>
</html>