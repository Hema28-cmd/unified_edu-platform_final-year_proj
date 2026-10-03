<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: dashboard.php");
    exit;
}

require_once '../config/db.php';

$certificateUnlocked = false;

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress 
    WHERE user_id=? AND level='secondary'
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ((int)$row['certificate_unlocked'] === 1) {
        $certificateUnlocked = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Dashboard</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', Arial, sans-serif;
    background: linear-gradient(135deg, #e0f2fe, #ecfeff);
}

/* NAVBAR */
.navbar {
    background: linear-gradient(90deg, #0369a1, #0f766e);
    color: #fff;
    padding: 16px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.nav-left h2 {
    margin: 0;
    font-size: 24px;
}

.nav-right {
    display: flex;
    gap: 12px;
    align-items: center;
}

.navbar a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    background: rgba(255,255,255,0.15);
    padding: 8px 16px;
    border-radius: 20px;
    transition: 0.3s;
}

.navbar a:hover {
    background: rgba(255,255,255,0.3);
}

/* MOVE NEXT BUTTON */
.next-level {
    background: linear-gradient(90deg, #22c55e, #4ade80);
    color: #064e3b;
}

.next-level.disabled {
    opacity: 0.45;
    cursor: not-allowed;
    pointer-events: none;
}

/* CONTENT */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
}

.welcome {
    text-align: center;
    margin-bottom: 40px;
}

.welcome h1 {
    color: #0f172a;
}

.welcome p {
    color: #475569;
    font-size: 18px;
}

.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 25px;
}

.card {
    background: #ffffff;
    border-radius: 18px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    cursor: pointer;
    transition: 0.3s;
    border-top: 6px solid #0284c7;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.15);
}

.card i {
    font-size: 42px;
    margin-bottom: 15px;
    display: block;
}

.lessons { border-top-color: #0284c7; color: #0284c7; }
.assignments { border-top-color: #16a34a; color: #16a34a; }
.quizzes { border-top-color: #0f766e; color: #0f766e; }
.books { border-top-color: #7c3aed; color: #7c3aed; }
.live { border-top-color: #dc2626; color: #dc2626; }
.certificate { border-top-color: #ca8a04; color: #ca8a04; }

.card h3 {
    margin: 10px 0;
    color: #0f172a;
}

.card p {
    font-size: 14px;
    color: #475569;
}

.footer {
    text-align: center;
    margin: 40px 0 20px;
    color: #64748b;
}

.courses { 
    border-top-color: #6366f1; 
    color: #6366f1; 
}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="nav-left">
        <h2>📘 Secondary Education</h2>
    </div>

    <div class="nav-right">
        <a href="move_next_sec.php"
           class="next-level <?php echo !$certificateUnlocked ? 'disabled' : ''; ?>">
            🚀 Move to High School
        </a>

        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="welcome">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> 👋</h1>
        <p>Secondary Level Academic Dashboard</p>
    </div>

    <div class="cards">

        <div class="card lessons" onclick="location.href='lessons/secondary_lessons.php'">
            <i>📚</i><h3>Lessons</h3><p>View subject-wise lessons</p>
        </div>

<div class="card courses" onclick="location.href='../public/courses/secondary_courses.php'">
    <i>📘</i>
    <h3>Courses</h3>
    <p>View all approved secondary level courses</p>
</div>

        <div class="card assignments" onclick="location.href='assignments/secondary_assignments.php'">
            <i>📝</i><h3>Assignments</h3><p>Download & submit assignments</p>
        </div>

        <div class="card quizzes" onclick="location.href='quizzes/secondary_quizzes.php'">
            <i>❓</i><h3>Quizzes</h3><p>Attempt quizzes and check scores</p>
        </div>

        <div class="card books" onclick="location.href='books/secondary_books.php'">
            <i>📖</i><h3>Books</h3><p>Access textbooks & PDFs</p>
        </div>

        <div class="card live" onclick="location.href='live/secondary_live.php'">
            <i>🎥</i><h3>Live Classes</h3><p>Join online classes</p>
        </div>

        <div class="card certificate" onclick="location.href='certificate/secondary_certificate.php'">
            <i>🏆</i><h3>Certificate</h3><p>Download completion certificate</p>
        </div>

    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> Smart Education Platform – Secondary Level
</div>

</body>
</html>
