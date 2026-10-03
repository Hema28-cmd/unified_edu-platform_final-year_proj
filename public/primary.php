<?php
session_start();

/* Only allow primary school users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary') {
    header("Location: dashboard.php");
    exit;
}

/* Role handling */
$role = $_SESSION['role'] ?? 'student';
$css_file = "../assets/css/primary_student.css";
if ($role === 'teacher') {
    $css_file = "../assets/css/primary_teacher.css";
}

require_once '../config/db.php';

$certificateUnlocked = false;

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress 
    WHERE user_id=? AND level='primary'
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
    <title>Primary School Dashboard</title>
    <link rel="stylesheet" href="<?php echo $css_file; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }

        .nav-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .next-level-btn {
            background: #16a34a;
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .next-level-btn:hover {
            background: #15803d;
        }

        .next-level-btn.disabled {
            background: #94a3b8;
            cursor: not-allowed;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>

    <div class="nav-actions">
        <!-- Move to Next Level Button -->
        <?php if ($certificateUnlocked): ?>
            <a href="move_next_primary.php" class="next-level-btn">
                🚀 Move to Next Level
            </a>
        <?php else: ?>
            <button class="next-level-btn disabled" disabled>
                🔒 Move to Next Level
            </button>
        <?php endif; ?>

        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- CONTENT -->
<div class="content">
    <h2>Welcome to Primary School Dashboard 📚</h2>

    <div class="cards">

        <div class="card" onclick="window.location='lessons/primary_lessons.php'">
            <i class="fa-solid fa-book-open"></i>
            <h3>Lessons</h3>
            <p>Math, English, Science, Social Studies.</p>
        </div>

<div class="card" onclick="window.location='../public/courses/primary_courses.php'">
    <i class="fa-solid fa-layer-group"></i>
    <h3>Courses</h3>
    <p>Explore courses available for the next level.</p>
</div>

        <div class="card" onclick="window.location='books/primary_books.php'">
            <i class="fa-solid fa-book"></i>
            <h3>Books</h3>
            <p>PDF books for all primary subjects.</p>
        </div>

        <div class="card" onclick="window.location='assignments/primary_assignments.php'">
            <i class="fa-solid fa-pencil"></i>
            <h3>Assignments</h3>
            <p>Practice exercises and worksheets.</p>
        </div>

        <div class="card" onclick="window.location='quizzes/primary_quizzes.php'">
            <i class="fa-solid fa-question-circle"></i>
            <h3>Quizzes</h3>
            <p>Test your knowledge in each subject.</p>
        </div>

        <div class="card" onclick="window.location='live/primary_live.php'">
            <i class="fa-solid fa-video"></i>
            <h3>Live Classes</h3>
            <p>Join interactive sessions with teachers.</p>
        </div>

        <div class="card" onclick="window.location='certificate/primary_certificate.php'">
            <i class="fa-solid fa-trophy"></i>
            <h3>Certificate</h3>
            <p>Earn certificates after completing quizzes.</p>
        </div>

        <!-- TEACHER ONLY -->
        <?php if ($role === 'teacher'): ?>
            <div class="card" onclick="window.location='assignments/upload_assignment.php'">
                <i class="fa-solid fa-upload"></i>
                <h3>Upload Assignment</h3>
                <p>Upload assignments for students.</p>
            </div>

            <div class="card" onclick="window.location='quizzes/create_quiz.php'">
                <i class="fa-solid fa-plus"></i>
                <h3>Create Quiz</h3>
                <p>Add new quizzes for students.</p>
            </div>
        <?php endif; ?>

    </div>
</div>

</body>
</html>
