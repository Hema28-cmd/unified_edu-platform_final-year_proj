<?php
session_start();
require_once "../config/db.php";

/* 🔐 Only Kindergarten users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level = 'kindergarten';

/* 1️⃣ Get total kindergarten quizzes */
$totalQuizStmt = $conn->prepare("
    SELECT COUNT(*) as total_quiz 
    FROM quizzes 
    WHERE level = ?
");
$totalQuizStmt->bind_param("s", $level);
$totalQuizStmt->execute();
$totalQuizResult = $totalQuizStmt->get_result()->fetch_assoc();
$totalQuiz = $totalQuizResult['total_quiz'] ?? 0;


/* 2️⃣ Get completed kindergarten quizzes */
$completedStmt = $conn->prepare("
    SELECT COUNT(DISTINCT qa.quiz_id) as completed
    FROM quiz_attempts qa
    INNER JOIN quizzes q ON qa.quiz_id = q.id
    WHERE qa.user_id = ? 
    AND q.level = ?
");
$completedStmt->bind_param("is", $user_id, $level);
$completedStmt->execute();
$completedResult = $completedStmt->get_result()->fetch_assoc();
$completed = $completedResult['completed'] ?? 0;


/* 3️⃣ Unlock certificate only if all quizzes completed */
$certificateUnlocked = 0;

if ($totalQuiz > 0 && $completed == $totalQuiz) {
    $certificateUnlocked = 1;
}


/* 4️⃣ Insert or Update user_progress */
$updateProgress = $conn->prepare("
    INSERT INTO user_progress 
    (user_id, level, quizzes_completed, certificate_unlocked)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        quizzes_completed = VALUES(quizzes_completed),
        certificate_unlocked = VALUES(certificate_unlocked)
");

if (!$updateProgress) {
    die("Prepare Failed: " . $conn->error);
}

$updateProgress->bind_param("isii", $user_id, $level, $completed, $certificateUnlocked);
$updateProgress->execute();


/* 5️⃣ Fetch kindergarten quizzes for display */
$stmt = $conn->prepare("
    SELECT id, title, subject, total_questions 
    FROM quizzes 
    WHERE level = ?
    ORDER BY created_at ASC
");
$stmt->bind_param("s", $level);
$stmt->execute();
$result = $stmt->get_result();

$congrats = isset($_GET['completed']);
?>

<!DOCTYPE html>
<html>
<head>
<title>Kindergarten Quizzes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    background:linear-gradient(135deg,#fdfbfb,#ebedee);
    padding:30px 20px;
}

/* HEADER */
.header{
    background:linear-gradient(90deg,#667eea,#764ba2);
    padding:20px 30px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
    margin-bottom:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
}

.header h2{
    font-size:26px;
}

.header a{
    color:white;
    text-decoration:none;
    margin-left:10px;
    font-weight:600;
}

/* GRID LAYOUT */
.quiz-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

/* QUIZ CARD */
.quiz-card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 15px 30px rgba(0,0,0,0.08);
    transition:0.4s;
    position:relative;
    overflow:hidden;
}

.quiz-card::before{
    content:"";
    position:absolute;
    width:120%;
    height:120%;
    background:linear-gradient(45deg,#a18cd1,#fbc2eb);
    top:-100%;
    left:-100%;
    transform:rotate(25deg);
    transition:0.6s;
    z-index:0;
}

.quiz-card:hover::before{
    top:-30%;
    left:-30%;
}

.quiz-card:hover{
    transform:translateY(-8px) scale(1.03);
}

.quiz-card h3{
    color:#7c3aed;
    margin-bottom:10px;
    position:relative;
    z-index:1;
}

.quiz-card p{
    margin:5px 0;
    position:relative;
    z-index:1;
}

/* START BUTTON */
.start-btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 18px;
    background:linear-gradient(90deg,#ff9966,#ff5e62);
    color:white;
    border-radius:25px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
    position:relative;
    z-index:1;
}

.start-btn:hover{
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

/* CERTIFICATE BUTTON */
.certificate-btn{
    display:inline-block;
    margin-top:35px;
    padding:14px 28px;
    border-radius:30px;
    font-size:16px;
    font-weight:bold;
    text-decoration:none;
    transition:0.3s;
}

.unlock{
    background:linear-gradient(90deg,#00c6ff,#0072ff);
    color:white;
    box-shadow:0 10px 25px rgba(0,114,255,0.3);
}

.unlock:hover{
    transform:scale(1.07);
}

.locked{
    background:#cbd5e1;
    color:#475569;
    cursor:not-allowed;
}

/* RAINBOW FALL */
.rainbow{
    position:fixed;
    top:-20px;
    font-size:28px;
    animation:fall linear forwards;
    pointer-events:none;
    z-index:9999;
}

@keyframes fall{
    to{
        transform:translateY(100vh);
        opacity:0;
    }
}

/* POPUP */
.congrats-popup{
    position:fixed;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%) scale(0);
    background:linear-gradient(135deg,#ff9a9e,#fad0c4,#fbc2eb,#a18cd1);
    padding:45px;
    border-radius:25px;
    text-align:center;
    color:white;
    font-size:22px;
    font-weight:bold;
    box-shadow:0 25px 50px rgba(0,0,0,0.3);
    z-index:10000;
    transition:0.6s ease;
}

.congrats-popup.show{
    transform:translate(-50%,-50%) scale(1);
}
</style>
</head>

<body>

<div class="header">
    <h2>🎒 Kindergarten Quizzes</h2>
    <div>
        <a href="kindergarten.php">⬅ Dashboard</a> |
        <a href="/unified_edu/public/logout.php">🚪 Logout</a>
    </div>
</div>

<div class="quiz-container">
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="quiz-card">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <p><strong>Subject:</strong> <?= htmlspecialchars($row['subject']) ?></p>
            <p><strong>Total Questions:</strong> <?= $row['total_questions'] ?></p>

            <a class="start-btn"
               href="attend_quiz.php?quiz_id=<?= $row['id'] ?>">
               ▶ Start Quiz
            </a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No quizzes available yet.</p>
<?php endif; ?>
</div>

<div style="text-align:center;">
<?php if($certificateUnlocked == 1): ?>
    <a href="certificate/kindergarten_certificate.php"
       class="certificate-btn unlock">
       🎓 Download Certificate
    </a>
<?php else: ?>
    <button class="certificate-btn locked">
        🔒 Complete All Quizzes to Unlock Certificate
    </button>
<?php endif; ?>
</div>

<?php if($certificateUnlocked == 1): ?>
<script>

// 🌈 Rainbow Shower
function createRainbow() {
    const items = ["🌈","⭐","✨","🎉","🎊"];
    const element = document.createElement("div");
    element.classList.add("rainbow");
    element.innerHTML = items[Math.floor(Math.random() * items.length)];
    element.style.left = Math.random() * window.innerWidth + "px";
    element.style.animationDuration = (2 + Math.random() * 3) + "s";
    document.body.appendChild(element);

    setTimeout(() => {
        element.remove();
    }, 5000);
}

let interval = setInterval(createRainbow, 120);

setTimeout(() => {
    clearInterval(interval);
}, 5000);


// 🎉 Final Congratulations Popup
let popup = document.createElement("div");
popup.classList.add("congrats-popup");
popup.innerHTML = "🎉 CONGRATULATIONS! 🎓<br><br>You have completed all Kindergarten quizzes and unlocked your certificate! 🌟";
document.body.appendChild(popup);

setTimeout(() => {
    popup.classList.add("show");
}, 500);

setTimeout(() => {
    popup.classList.remove("show");
}, 6000);

</script>
<?php endif; ?>

</body>
</html>