<?php
session_start();
require_once "../config/db.php";

/* Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];
$teacher_name = $_SESSION['user_name'];

$success = false;

/* ADD LESSON */
if(isset($_POST['add_lesson'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("
        INSERT INTO lessons (title,description,category,level,created_by,status)
        VALUES (?, ?, ?, 'highschool', ?, 'pending')
    ");
    $stmt->bind_param("sssi",$title,$description,$category,$teacher_id);

    if($stmt->execute()){
        $success = true;
    }
}

/* FETCH LESSONS */
$stmt = $conn->prepare("
SELECT title,description,category,status,created_at
FROM lessons
WHERE created_by=? AND level='highschool'
ORDER BY created_at DESC
");

$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$lessons = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Lessons | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Merriweather:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#f0fdfa,#f8fafc);
    color:#1e293b;
    padding:24px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(90deg,#0f766e,#115e59);
    padding:16px 28px;
    border-radius:16px;
    box-shadow:0 8px 28px rgba(0,0,0,0.2);
}
.navbar h2{
    font-family:'Merriweather', serif;
    color:#ecfeff;
    font-size:22px;
}
.navbar a{
    color:#ccfbf1;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff;}

/* INTRO */
.intro{
    margin:28px 0;
    background:#ffffff;
    padding:28px;
    border-radius:22px;
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
}
.intro h1{
    font-family:'Merriweather', serif;
    font-size:28px;
    color:#0f766e;
}
.intro p{
    margin-top:10px;
    color:#475569;
    font-size:15px;
    line-height:1.7;
}

/* LESSON CARDS */
.lesson-cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:22px;
    margin-top:36px;
}
.lesson-card{
    background:#ffffff;
    border-left:6px solid #14b8a6;
    border-radius:18px;
    padding:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.12);
    transition:0.3s;
}
.lesson-card:hover{
    transform:translateY(-4px);
    box-shadow:0 14px 32px rgba(0,0,0,0.15);
}
.lesson-card h3{
    color:#115e59;
    font-size:20px;
    margin-bottom:6px;
}
.lesson-card span{
    display:block;
    font-size:13px;
    color:#64748b;
    margin-bottom:10px;
}
.lesson-card p{
    font-size:14px;
    color:#334155;
    margin-bottom:8px;
}
.lesson-card ul{
    padding-left:16px;
}
.lesson-card ul li{
    font-size:14px;
    color:#475569;
    margin-bottom:6px;
}

/* OUTCOMES */
.outcomes{
    margin-top:40px;
    background:linear-gradient(135deg,#ecfeff,#f0fdfa);
    padding:26px;
    border-radius:22px;
    box-shadow:0 12px 28px rgba(0,0,0,0.14);
}
.outcomes h2{
    color:#0f766e;
    margin-bottom:14px;
}
.outcomes ul{
    padding-left:20px;
}
.outcomes li{
    font-size:14px;
    color:#334155;
    margin-bottom:8px;
}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-top:36px;
    background:#0f766e;
    color:#ffffff;
    padding:12px 28px;
    border-radius:16px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{
    background:#14b8a6;
}
.modal-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    align-items:center;
    justify-content:center;
    z-index:100;
}

.modal-form{
    background:#fff;
    padding:20px;
    border-radius:12px;
    width:100%;
    max-width:500px;
}

.form-group{margin-bottom:12px;}
.form-group input,
.form-group textarea{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:8px;
}

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.action-btn{
    padding:10px 15px;
    background:#0f766e;
    color:#fff;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>High School Lessons</h2>
    <div>
        <a href="highschool.php">Dashboard</a>
        <a href="highschool_lessons.php">Lessons</a>
        <a href="highschool_books.php">Books</a>
        <a href="highschool_quizzes.php">Quizzes</a>
        <a href="highschool_assignments.php">Assignments</a>
        <a href="highschool_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- INTRO -->
<div class="intro">
    <h1>Unit-wise Lessons</h1>
    <p>Explore the structured lesson plans for high school students, designed to foster conceptual clarity, analytical thinking, and preparation for higher studies.</p>
</div>

<div style="margin-top:20px;">
    <button class="back-btn" onclick="openLessonForm()">➕ Add New Lesson</button>
</div>

<div class="intro" style="background:#f1f5f9;">
    <h1>📚 Curriculum Overview</h1>
    <p>
        This section organizes lessons into structured units for high school learners. Each unit focuses on conceptual clarity,
        real-world applications, and exam-oriented preparation.
    </p>

    <ul style="margin-top:12px; padding-left:18px; color:#475569;">
        <li>Unit-based structured learning</li>
        <li>Concept + Application approach</li>
        <li>Aligned with board exam patterns</li>
        <li>Continuous assessment ready</li>
    </ul>
</div>

<!-- LESSON CARDS -->
<div class="lesson-cards">

<?php
$units = [];

while($row = $lessons->fetch_assoc()){
    $units[$row['category']][] = $row;
}

foreach($units as $unit => $unitLessons):
?>

<div class="lesson-card">
    <h3><?php echo htmlspecialchars($unit); ?></h3>

    <?php foreach($unitLessons as $lesson): ?>
        <p><strong><?php echo htmlspecialchars($lesson['title']); ?></strong></p>

        <p><?php echo htmlspecialchars($lesson['description'] ?? ''); ?></p>

        Status:
        <span class="status <?php echo $lesson['status']; ?>">
            <?php echo ucfirst($lesson['status']); ?>
        </span>

        <hr style="margin:10px 0;">
    <?php endforeach; ?>

</div>

<?php endforeach; ?>

<?php if(empty($units)): ?>
<div style="text-align:center; padding:30px;">
    <h3>📭 No Lessons Yet</h3>
    <p style="color:#64748b;">Start by adding your first lesson to build your course structure.</p>
</div>
<?php endif; ?>

</div>

<!-- OUTCOMES -->
<div class="outcomes">
    <h2>Expected Learning Outcomes</h2>
    <ul>
        <li>Strong conceptual understanding of subject fundamentals</li>
        <li>Ability to apply knowledge in problem-solving contexts</li>
        <li>Improved analytical and reasoning skills</li>
        <li>Preparedness for board exams and higher studies</li>
    </ul>
</div>

<a href="highschool.php" class="back-btn">⬅ Back to Dashboard</a>

<div id="lessonModal" class="modal-overlay">
<form method="POST" class="modal-form">
    <h2>📘 Add New Lesson</h2>

    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" required></textarea>
    </div>

    <div class="form-group">
        <label>Category (Unit)</label>
        <input type="text" name="category" placeholder="Unit 1 / Unit 2..." required>
    </div>

    <div class="form-actions">
        <button type="submit" name="add_lesson" class="action-btn">Save Lesson</button>
        <button type="button" onclick="closeLessonForm()" class="action-btn">Cancel</button>
    </div>
</form>
</div>

<script>
function openLessonForm(){
    document.getElementById('lessonModal').style.display='flex';
}

function closeLessonForm(){
    document.getElementById('lessonModal').style.display='none';
}
</script>

<?php if($success): ?>
<script>
alert("Lesson added successfully!");
window.location.href = window.location.href; // refresh page
</script>
<?php endif; ?>

</body>
</html>
