<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary') {
    header("Location: ../primary.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$selected_class = $_GET['class'] ?? '';

/* =============================
   FETCH DISTINCT CLASSES
============================= */
$class_stmt = $conn->prepare("SELECT DISTINCT class 
                              FROM quizzes 
                              WHERE level='primary' 
                              ORDER BY class");
$class_stmt->execute();
$class_result = $class_stmt->get_result();

$classes = [];
while ($row = $class_result->fetch_assoc()) {
    $classes[] = $row['class'];
}

/* =============================
   FETCH QUIZZES FOR SELECTED CLASS
============================= */
$quizzes = [];
if ($selected_class) {
    $quiz_stmt = $conn->prepare("SELECT id, subject, title, total_questions 
                                 FROM quizzes 
                                 WHERE level='primary' AND class=?");
    $quiz_stmt->bind_param("s", $selected_class);
    $quiz_stmt->execute();
    $quiz_result = $quiz_stmt->get_result();

    while ($row = $quiz_result->fetch_assoc()) {
        $quizzes[] = $row;
    }
}

/* =============================
   CHECK CERTIFICATE STATUS
============================= */
$isUnlocked = false;
$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress 
    WHERE user_id=? AND level='primary'
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    if ($row['certificate_unlocked'] == 1) {
        $isUnlocked = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Primary Quizzes</title>

<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #dbeafe, #f0f9ff);
    padding: 20px;
}

.container { max-width:1100px; margin:auto; }

h2 {
    text-align:center;
    color:#1e3a8a;
    margin-bottom:30px;
}

.cards {
    display:flex;
    flex-wrap:wrap;
    gap:25px;
    justify-content:center;
}

.card {
    width:240px;
    background:white;
    border-radius:15px;
    padding:25px;
    text-align:center;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover {
    transform:translateY(-8px);
}

button {
    padding:10px 18px;
    border:none;
    border-radius:25px;
    background:#2563eb;
    color:white;
    cursor:pointer;
    margin-top:12px;
    font-size:14px;
}

button:hover {
    background:#1d4ed8;
}

.disabled-btn {
    background:#9ca3af !important;
    cursor:not-allowed;
}

.congrats {
    background:#16a34a;
    color:white;
    padding:15px;
    border-radius:10px;
    text-align:center;
    margin-bottom:25px;
    font-size:18px;
}

.back-link {
    text-align:center;
    margin-top:25px;
}

a {
    text-decoration:none;
    color:#1e3a8a;
    font-weight:bold;
}
/* ================= POPUP MODAL ================= */

.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 999;
}

.popup-box {
    background: white;
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    width: 400px;
    animation: pop 0.4s ease-in-out;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

@keyframes pop {
    from { transform: scale(0.7); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.popup-box h2 {
    color: #16a34a;
    margin-bottom: 15px;
}

.popup-btn {
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 25px;
    background: #2563eb;
    color: white;
    cursor: pointer;
}
</style>
</head>

<body>

<div class="container">

<h2>📘 Primary School Quizzes</h2>

<?php if ($isUnlocked): ?>
<div class="congrats">
    🎉 Congratulations! You have successfully completed all Primary quizzes.
</div>
<?php endif; ?>

<?php if (!$selected_class): ?>

    <!-- SHOW CLASSES -->
    <div class="cards">
        <?php foreach($classes as $class): ?>
            <div class="card">
                <h3><?php echo $class; ?></h3>
                <button onclick="window.location.href='primary_quizzes.php?class=<?php echo urlencode($class); ?>'">
                    View Subjects
                </button>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <!-- SHOW SUBJECTS -->
    <h3 style="text-align:center; margin-bottom:20px;">
        <?php echo $selected_class; ?> - Subjects
    </h3>

    <div class="cards">
        <?php foreach($quizzes as $quiz): ?>
            <div class="card">
                <h3><?php echo $quiz['subject']; ?></h3>
                <p><?php echo $quiz['title']; ?></p>
                <p><?php echo $quiz['total_questions']; ?> Questions</p>

                <button onclick="window.location.href='start_quiz.php?id=<?php echo $quiz['id']; ?>'">
                    Attend Quiz
                </button>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="back-link">
        <a href="primary_quizzes.php">⬅ Back to Classes</a>
    </div>

<?php endif; ?>

<!-- CERTIFICATE BUTTON -->
<div class="back-link" style="margin-top:40px;">
<?php if ($isUnlocked): ?>
    <button onclick="window.location.href='../certificate/primary_certificate.php'">
        🎓 View Certificate
    </button>
<?php else: ?>
    <button class="disabled-btn">
        🔒 Certificate Locked
    </button>
<?php endif; ?>
</div>

<div class="back-link">
    <a href="../primary.php">⬅ Back to Dashboard</a>
</div>

</div>

<?php if ($isUnlocked): ?>
<div class="popup-overlay" id="congratsPopup">
    <div class="popup-box">
        <h2>🎉 Congratulations!</h2>
        <p>You have successfully completed all Primary quizzes.</p>
        <p>Your Certificate is now unlocked 🎓</p>

        <button class="popup-btn"
            onclick="window.location.href='../certificate/primary_certificate.php'">
            View Certificate
        </button>

        <br><br>
        <button class="popup-btn"
            onclick="closePopup()">
            Close
        </button>
    </div>
</div>
<?php endif; ?>
<script>
function closePopup() {
    document.getElementById("congratsPopup").style.display = "none";
}

window.onload = function() {
    <?php if ($isUnlocked): ?>
        document.getElementById("congratsPopup").style.display = "flex";
    <?php endif; ?>
};
</script>
</body>
</html>