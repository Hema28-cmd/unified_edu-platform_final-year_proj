<?php
session_start();
require_once "../config/db.php"; // Make sure path is correct

// ============================
// ALLOW ONLY HIGHSCHOOL USERS
// ============================
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$student_name = $_SESSION['user_name'] ?? 'Student';

// ============================
// 1️⃣ COUNT TOTAL HIGHSCHOOL QUIZZES
// ============================
$totalQuizQuery = $conn->query("
    SELECT COUNT(*) as total 
    FROM quizzes 
    WHERE level = 'highschool'
");
$totalQuizzes = $totalQuizQuery->fetch_assoc()['total'] ?? 0;


// ============================
// 2️⃣ COUNT COMPLETED QUIZZES BY THIS USER
// ============================
$completedStmt = $conn->prepare("
    SELECT COUNT(DISTINCT quiz_id) as completed
    FROM quiz_attempts
    WHERE user_id = ?
    AND quiz_id IN (
        SELECT id FROM quizzes WHERE level = 'highschool'
    )
");
$completedStmt->bind_param("i", $user_id);
$completedStmt->execute();
$completedResult = $completedStmt->get_result()->fetch_assoc();
$completedQuizzes = $completedResult['completed'] ?? 0;


// ============================
// 3️⃣ CHECK IF CERTIFICATE SHOULD BE UNLOCKED
// ============================
$cert_unlocked = false;

if ($totalQuizzes > 0 && $completedQuizzes == $totalQuizzes) {
    $cert_unlocked = true;
}


// ============================
// 4️⃣ UPDATE OR INSERT INTO user_progress
// ============================
$checkProgress = $conn->prepare("
    SELECT id FROM user_progress 
    WHERE user_id = ? AND level = 'highschool'
");
$checkProgress->bind_param("i", $user_id);
$checkProgress->execute();
$progressResult = $checkProgress->get_result();

if ($progressResult->num_rows > 0) {

    $update = $conn->prepare("
        UPDATE user_progress
        SET quizzes_completed = ?, certificate_unlocked = ?
        WHERE user_id = ? AND level = 'highschool'
    ");
    $update->bind_param("iii", $completedQuizzes, $cert_unlocked, $user_id);
    $update->execute();

} else {

    $insert = $conn->prepare("
        INSERT INTO user_progress (user_id, level, quizzes_completed, certificate_unlocked)
        VALUES (?, 'highschool', ?, ?)
    ");
    $insert->bind_param("iii", $user_id, $completedQuizzes, $cert_unlocked);
    $insert->execute();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Highschool Portal</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f8fafc;
}
.header{
    background:linear-gradient(135deg,#4f46e5,#f43f5e);
    padding:40px 30px 70px;
    color:#fff;
    border-bottom-left-radius:40px;
    border-bottom-right-radius:40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}
.header h1{margin:0;font-size:28px;}
.header p{opacity:0.9;margin-top:5px;}
.move-next-btn{
    padding:12px 25px;
    font-size:16px;
    font-weight:bold;
    border:none;
    border-radius:30px;
    cursor:pointer;
    background: linear-gradient(90deg,#22c55e,#3b82f6,#f97316);
    color:#fff;
    display:inline-flex;
    align-items:center;
    gap:8px;
    transition:0.3s;
}
.move-next-btn:disabled{
    opacity:0.5;
    cursor:not-allowed;
}
.move-next-btn:hover:not(:disabled){
    transform:scale(1.05);
}
.content{
    max-width:1200px;
    margin:-40px auto 40px;
    padding:0 20px;
}
.row{
    display:flex;
    gap:25px;
    margin-bottom:30px;
    flex-wrap:wrap;
}
.row.offset{
    margin-left:80px;
}
.tile{
    flex:1;
    min-width:220px;
    background:#fff;
    border-radius:22px;
    padding:30px 20px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
    cursor:pointer;
    transition:0.3s;
}
.tile:hover{
    transform:translateY(-8px);
}
.tile i{
    font-size:42px;
    margin-bottom:15px;
}
.tile h3{
    margin:8px 0;
    color:#1e293b;
}
.tile p{
    font-size:14px;
    color:#64748b;
}
.t-lessons i{color:#6366f1;}
.t-assignments i{color:#22c55e;}
.t-quizzes i{color:#f59e0b;}
.t-books i{color:#ec4899;}
.t-live i{color:#ef4444;}
.t-certificate i{color:#14b8a6;}
.logout{
    position:fixed;
    bottom:25px;
    right:25px;
    background:#0f172a;
    color:#fff;
    padding:14px 20px;
    border-radius:30px;
    text-decoration:none;
}
.logout:hover{background:#020617;}
@media(max-width:768px){
    .row.offset{margin-left:0;}
    .header{flex-direction:column; gap:15px;}
}
.t-courses i{color:#0ea5e9;}
</style>
</head>

<body>

<div class="header">
    <div>
        <h1>Hi, <?php echo htmlspecialchars($student_name); ?> 👋</h1>
        <p>Welcome to your Highschool Learning Space</p>
        <p>
            Completed: <?php echo $completedQuizzes; ?> / <?php echo $totalQuizzes; ?> Quizzes
        </p>
    </div>

    <button class="move-next-btn" 
        <?php echo $cert_unlocked ? '' : 'disabled'; ?>
        onclick="location.href='move_next_high.php'">
        🎓 Move to Next Level
    </button>
</div>

<div class="content">

   <div class="row">
    <div class="tile t-lessons" onclick="location.href='lessons/highschool_lessons.php'">
        <i class="fa-solid fa-book"></i>
        <h3>Lessons</h3>
        <p>Structured learning</p>
    </div>

    <div class="tile t-assignments" onclick="location.href='assignments/highschool_assignments.php'">
        <i class="fa-solid fa-pen"></i>
        <h3>Assignments</h3>
        <p>Practice tasks</p>
    </div>

    <div class="tile t-quizzes" onclick="location.href='quizzes/highschool_quizzes.php'">
        <i class="fa-solid fa-question"></i>
        <h3>Quizzes</h3>
        <p>Self evaluation</p>
    </div>

    <div class="tile t-courses" onclick="location.href='courses/highschool_courses.php'">
        <i class="fa-solid fa-layer-group"></i>
        <h3>Courses</h3>
        <p>Available subjects</p>
    </div>
</div>

<div class="row offset">
    <div class="tile t-books" onclick="location.href='books/highschool_books.php'">
        <i class="fa-solid fa-book-open"></i>
        <h3>Books</h3>
        <p>Study resources</p>
    </div>

    <div class="tile t-live" onclick="location.href='live/highschool_live.php'">
        <i class="fa-solid fa-video"></i>
        <h3>Live Classes</h3>
        <p>Interactive sessions</p>
    </div>

    <div class="tile t-certificate"
        onclick="<?php echo $cert_unlocked ? "location.href='certificate/highschool_certificate.php'" : ''; ?>">
        <i class="fa-solid fa-trophy"></i>
        <h3>Certificate</h3>
        <p>
            <?php echo $cert_unlocked 
                ? "Unlocked – Download Now" 
                : "Complete all quizzes to unlock"; ?>
        </p>
    </div>
</div>

</div>

<a href="logout.php" class="logout">
    <i class="fa-solid fa-right-from-bracket"></i> Logout
</a>

</body>
</html>