<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

/* 🎓 Teacher's default level */
$teacherLevel = $_SESSION['user_level'] ?? 'secondary';

/* 🌍 Selected level (switchable) */
$level = $_GET['level'] ?? $teacherLevel;

/* 🛡 Allowed levels */
$allowedLevels = [
    'kindergarten',
    'primary',
    'secondary',
    'highschool',
    'undergraduate',
    'postgraduate'
];

if (!in_array($level, $allowedLevels)) {
    $level = $teacherLevel;
}

/* 📂 Public base path */
$basePath = "../public/$level/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Teacher Dashboard | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{margin:0;font-family:Segoe UI;background:#f1f5f9}
.header{
    background:linear-gradient(90deg,#4f46e5,#0ea5e9);
    color:#fff;padding:22px
}
.container{padding:40px}
.section{
    background:#fff;padding:30px;margin-bottom:40px;
    border-radius:22px;box-shadow:0 10px 25px rgba(0,0,0,.1)
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:20px
}
.card{
    background:#f8fafc;padding:22px;border-radius:18px;
    border-left:6px solid #6366f1
}
.btn{
    display:inline-block;margin-top:10px;
    padding:10px 20px;border-radius:22px;
    text-decoration:none;color:#fff;
    background:#4f46e5;font-weight:600
}
.btn-alt{background:#16a34a}
.level-switch a{
    margin-right:10px;text-decoration:none;
    padding:8px 14px;border-radius:18px;
    background:#e0e7ff;color:#1e3a8a;font-weight:600
}
.level-switch a.active{
    background:#4f46e5;color:#fff
}
h2{color:#4338ca;margin-bottom:15px}
</style>
</head>

<body>

<div class="header">
    <h1>👩‍🏫 Teacher Dashboard</h1>
    <p>Current Level: <b><?= ucfirst($level) ?></b></p>
</div>

<div class="container">

<!-- 🔄 LEVEL SWITCHER -->
<div class="section">
<h2>🔄 Switch Academic Level</h2>
<div class="level-switch">
<?php foreach ($allowedLevels as $lvl): ?>
    <a class="<?= $lvl === $level ? 'active' : '' ?>"
       href="?level=<?= $lvl ?>">
       <?= ucfirst($lvl) ?>
    </a>
<?php endforeach; ?>
</div>
</div>

<!-- 📘 LESSONS -->
<div class="section">
<h2>📘 Lessons (<?= ucfirst($level) ?>)</h2>
<div class="grid">
    <div class="card">
        <h3>View Lessons</h3>
        <a class="btn" href="<?= $basePath ?>" target="_blank">View</a>
    </div>
    <div class="card">
        <h3>Add Lesson</h3>
        <a class="btn btn-alt" href="add_lesson.php?level=<?= $level ?>">Add</a>
    </div>
</div>
</div>

<!-- 📗 COURSES -->
<div class="section">
<h2>📗 Courses</h2>
<div class="grid">
    <div class="card">
        <h3>View Courses</h3>
        <a class="btn" href="<?= $basePath ?>" target="_blank">View</a>
    </div>
    <div class="card">
        <h3>Add Course</h3>
        <a class="btn btn-alt" href="add_course.php?level=<?= $level ?>">Add</a>
    </div>
</div>
</div>

<!-- 📝 QUIZZES -->
<div class="section">
<h2>📝 Quizzes</h2>
<div class="grid">
    <div class="card">
        <h3>View Quizzes</h3>
        <a class="btn" href="<?= $basePath ?>quizzes/" target="_blank">View</a>
    </div>
    <div class="card">
        <h3>Create Quiz</h3>
        <a class="btn btn-alt" href="add_quiz.php?level=<?= $level ?>">Create</a>
    </div>
</div>
</div>

<!-- 📂 ASSIGNMENTS -->
<div class="section">
<h2>📂 Assignments</h2>
<div class="grid">
    <div class="card">
        <h3>View Assignments</h3>
        <a class="btn" href="<?= $basePath ?>assignments/" target="_blank">View</a>
    </div>
    <div class="card">
        <h3>Add Assignment</h3>
        <a class="btn btn-alt" href="add_assignment.php?level=<?= $level ?>">Add</a>
    </div>
</div>
</div>

<!-- 🚀 PROJECT IDEAS -->
<div class="section">
<h2>🚀 Projects & Research</h2>
<div class="grid">
    <div class="card">
        <h3>View Projects</h3>
        <a class="btn" href="<?= $basePath ?>research.php" target="_blank">View</a>
    </div>
    <div class="card">
        <h3>Add Project</h3>
        <a class="btn btn-alt" href="add_project.php?level=<?= $level ?>">Add</a>
    </div>
</div>
</div>

</div>
</body>
</html>
