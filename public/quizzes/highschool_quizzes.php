<?php
session_start();
require_once "../../config/db.php";

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_level'])) {
    header("Location: ../login.php");
    exit;
}  

if ($_SESSION['user_level'] != 'highschool') {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level   = $_SESSION['user_level'];

/* ALL QUIZZES */
$quizResult = $conn->prepare("SELECT * FROM quizzes WHERE level=? ORDER BY class ASC");
$quizResult->bind_param("s", $level);
$quizResult->execute();
$quizResult = $quizResult->get_result();

/* TOTAL QUIZZES */
$totalStmt = $conn->prepare("SELECT COUNT(*) as total FROM quizzes WHERE level=?");
$totalStmt->bind_param("s", $level);
$totalStmt->execute();
$totalQuizzes = $totalStmt->get_result()->fetch_assoc()['total'];

/* COMPLETED */
$completedStmt = $conn->prepare("
    SELECT COUNT(DISTINCT qa.quiz_id) as completed
    FROM quiz_attempts qa
    JOIN quizzes q ON qa.quiz_id = q.id
    WHERE qa.user_id=? AND q.level=?
");
$completedStmt->bind_param("is", $user_id, $level);
$completedStmt->execute();
$completedQuizzes = $completedStmt->get_result()->fetch_assoc()['completed'];

/* CERTIFICATE */
$certificateUnlocked = ($completedQuizzes == $totalQuizzes && $totalQuizzes > 0) ? 1 : 0;

/* UPDATE PROGRESS */
$check = $conn->prepare("SELECT id FROM user_progress WHERE user_id=? AND level=?");
$check->bind_param("is", $user_id, $level);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $update = $conn->prepare("
        UPDATE user_progress 
        SET quizzes_completed=?, certificate_unlocked=? 
        WHERE user_id=? AND level=?
    ");
    $update->bind_param("iiis", $completedQuizzes, $certificateUnlocked, $user_id, $level);
    $update->execute();
} else {
    $insert = $conn->prepare("
        INSERT INTO user_progress (user_id, level, quizzes_completed, certificate_unlocked)
        VALUES (?, ?, ?, ?)
    ");
    $insert->bind_param("isii", $user_id, $level, $completedQuizzes, $certificateUnlocked);
    $insert->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Quizzes</title>
<style>
/* ---------- BODY & CONTAINER ---------- */
body {
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg,#e0f7fa,#f1f8e9,#fff3e0);
}
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 50px;
    background:#ffffffcc;
    backdrop-filter: blur(6px);
    box-shadow:0 3px 10px rgba(0,0,0,0.08);
    position: sticky;
    top:0;
    z-index: 100;
}
.navbar a{
    text-decoration:none;
    font-weight:600;
    color:#1e293b;
    transition:0.2s;
}
.navbar a:hover{ color:#2563eb; }

.container{
    max-width:1200px;
    margin:auto;
    padding:60px 20px 100px;
}
h2{
    text-align:center;
    margin-bottom:50px;
    font-size:32px;
    background: linear-gradient(90deg,#4f46e5,#3b82f6,#22c55e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ---------- CARDS GRID ---------- */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:30px;
}

/* ---------- QUIZ CARD ---------- */
.card{
    background:white;
    border-radius:20px;
    padding:35px 25px;
    text-align:center;
    cursor:pointer;
    position: relative;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    transition:0.4s ease;
    border-top:6px solid #4f46e5;
}
.card:hover{
    transform:translateY(-10px);
    box-shadow:0 18px 35px rgba(0,0,0,0.15);
}
.card h3{
    margin:15px 0 5px;
    font-size:22px;
    color:#1e293b;
}
.card p{
    font-size:15px;
    color:#475569;
}

/* ---------- COMPLETED BADGE ---------- */
.completed::after{
    content:"✔ Completed";
    position:absolute;
    top:15px;
    right:15px;
    background:#22c55e;
    color:white;
    padding:6px 12px;
    border-radius:12px;
    font-size:13px;
    font-weight:bold;
    box-shadow:0 3px 6px rgba(0,0,0,0.15);
}

/* ---------- CERTIFICATE CARD ---------- */
.certificate{
    border-top:6px solid #facc15;
    background:linear-gradient(145deg,#fffbea,#fff8e1);
}
.locked{
    opacity:0.5;
    pointer-events:none;
}

/* ---------- GRADIENT BUTTON INSIDE CARD ---------- */
.card .btn{
    display:inline-block;
    margin-top:15px;
    padding:10px 20px;
    background:linear-gradient(90deg,#22c55e,#3b82f6,#f97316);
    color:white;
    border-radius:20px;
    text-decoration:none;
    font-weight:bold;
    font-size:14px;
    transition:0.3s;
}
.card .btn:hover{
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

/* ---------- RESPONSIVE ---------- */
@media(max-width:768px){
    .navbar{padding:15px 20px;}
    .container{padding:50px 15px 80px;}
}
</style>
</head>
<body>

<div class="navbar">
    <a href="../highschool.php">⬅ Back</a>
    <a href="../logout.php">Logout</a>
</div>

<div class="container">
    <h2>🎓 High School Quizzes</h2>
    <div class="cards">

        <?php while($quiz = $quizResult->fetch_assoc()): 
            $attemptCheck = $conn->prepare("
                SELECT id FROM quiz_attempts 
                WHERE user_id=? AND quiz_id=?
            ");
            $attemptCheck->bind_param("ii", $user_id, $quiz['id']);
            $attemptCheck->execute();
            $isCompleted = $attemptCheck->get_result()->num_rows > 0;
        ?>
        <div class="card <?php echo $isCompleted ? 'completed' : ''; ?>" 
             onclick="location.href='take_quiz.php?quiz_id=<?php echo $quiz['id']; ?>'">
            <h3><?php echo htmlspecialchars($quiz['subject']); ?></h3>
            <p>Class: <?php echo htmlspecialchars($quiz['class']); ?></p>
            <?php if($isCompleted): ?>
                <a class="btn" href="take_quiz.php?quiz_id=<?php echo $quiz['id']; ?>">Review</a>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>

        <!-- CERTIFICATE CARD -->
        <div class="card certificate <?php echo $certificateUnlocked ? '' : 'locked'; ?>"
            <?php if($certificateUnlocked): ?>
                onclick="location.href='../certificate/highschool_certificate.php'"
            <?php endif; ?>>
            <h3>🏅 Certificate</h3>
            <p>
                <?php echo $certificateUnlocked 
                    ? "Unlocked – Download Now" 
                    : "Complete all quizzes to unlock"; ?>
            </p>
            <?php if($certificateUnlocked): ?>
                <a class="btn" href="../certificate/highschool_certificate.php">View Certificate</a>
            <?php endif; ?>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>

<?php if($certificateUnlocked): ?>

window.onload = function(){

    // Main burst
    confetti({
        particleCount: 200,
        spread: 120,
        origin: { y: 0.6 }
    });

    // Extra celebration bursts
    setTimeout(() => {
        confetti({
            particleCount: 150,
            spread: 100,
            origin: { x: 0.1, y: 0.6 }
        });
    }, 400);

    setTimeout(() => {
        confetti({
            particleCount: 150,
            spread: 100,
            origin: { x: 0.9, y: 0.6 }
        });
    }, 800);

};

<?php endif; ?>

</script>

</body>
</html>