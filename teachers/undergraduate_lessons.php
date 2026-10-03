<?php
session_start();
require_once "../config/db.php";

/* ADD LESSON */
if(isset($_POST['create_lesson'])){

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $teacher_id = $_SESSION['user_id'];

    $level = "undergraduate";

    $stmt = $conn->prepare("
        INSERT INTO lessons
        (title, description, category, level, created_by)
        VALUES (?,?,?,?,?)
    ");

    $stmt->bind_param("ssssi",
        $title,
        $description,
        $category,
        $level,
        $teacher_id
    );

    $stmt->execute();

    echo "<script>alert('✅ Lesson added successfully! Waiting for admin approval'); window.location.href=window.location.href;</script>";
}
/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Lessons | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

/* PAGE BASE */
body{
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#f0fdfa,#f8fafc);
    color:#0f172a;
    padding:28px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#0f766e,#064e3b);
    padding:22px 40px;
    border-radius:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 34px rgba(0,0,0,0.3);
}
.navbar h2{
    font-family:'Playfair Display',serif;
    color:#ecfeff;
    font-size:26px;
}
.navbar a{
    color:#d1fae5;
    margin-left:24px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#fde68a}

/* INTRO */
.intro{
    margin-top:34px;
    background:#ffffff;
    padding:36px;
    border-radius:28px;
    box-shadow:0 14px 34px rgba(0,0,0,0.12);
}
.intro h1{
    font-family:'Playfair Display',serif;
    font-size:32px;
    color:#0f766e;
}
.intro p{
    margin-top:12px;
    max-width:900px;
    font-size:16px;
    line-height:1.7;
    color:#334155;
}

/* LESSON STRUCTURE */
.structure{
    margin-top:42px;
}
.structure h2{
    font-size:24px;
    margin-bottom:16px;
    color:#115e59;
}
.module-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:26px;
}
.module{
    background:linear-gradient(135deg,#ecfeff,#f8fafc);
    padding:28px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.1);
}
.module h3{
    color:#0f766e;
    margin-bottom:10px;
    font-size:18px;
}
.module ul{
    padding-left:18px;
}
.module li{
    margin-bottom:8px;
    font-size:14px;
}

/* TEACHING APPROACH */
.approach{
    margin-top:46px;
    background:linear-gradient(135deg,#ede9fe,#faf5ff);
    padding:36px;
    border-radius:28px;
}
.approach h2{
    font-family:'Playfair Display',serif;
    font-size:26px;
    color:#5b21b6;
}
.approach p{
    margin-top:12px;
    font-size:15px;
    line-height:1.7;
}

/* WEEKLY FLOW */
.weekly{
    margin-top:46px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:22px;
}
.week-card{
    background:#ffffff;
    padding:26px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.12);
}
.week-card h4{
    color:#0f766e;
    margin-bottom:8px;
}

/* OUTCOMES */
.outcomes{
    margin-top:46px;
    background:#020617;
    padding:36px;
    border-radius:30px;
    color:#e5e7eb;
}
.outcomes h2{
    color:#fde68a;
    margin-bottom:14px;
}
.outcomes ul{
    padding-left:20px;
}
.outcomes li{
    margin-bottom:10px;
    font-size:14px;
}

/* FOOTER ACTIONS */
.actions{
    margin-top:46px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#0f766e;
    color:#ecfeff;
    padding:14px 28px;
    border-radius:16px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#115e59}
.note{
    font-size:13px;
    color:#64748b;
}
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-box{
    background:#fff;
    padding:25px;
    border-radius:15px;
    width:400px;
}

.input-group{
    margin-bottom:12px;
}

.input-group input,
.input-group textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
}

.form-actions{
    display:flex;
    justify-content:space-between;
}

.btn-submit{
    background:#0f766e;
    color:#fff;
    padding:10px 15px;
    border:none;
    border-radius:8px;
}

.btn-cancel{
    background:#e5e7eb;
    padding:10px 15px;
    border:none;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Undergraduate Lessons</h2>
    <div>
        <a href="undergraduate_lessons.php">Lessons</a>
        <a href="undergraduate_books.php">Books</a>
        <a href="undergraduate_quizzes.php">Quizzes</a>
        <a href="undergraduate_assignments.php">Assignments</a>
        <a href="undergraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- INTRO -->
<div class="intro">
    <h1>Academic Lesson Framework</h1>
    <p>
        Undergraduate lessons focus on deep conceptual understanding, analytical thinking,
        practical exposure, and preparation for industry, research, and higher studies.
    </p><br>
<button class="back-btn" onclick="openModal()">➕ Add Lesson</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM lessons
    WHERE level='undergraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$lessons = [];

while($row = $result->fetch_assoc()){
    $status = $row['status'];
    $lessons[$status][] = $row;
}
?>

<!-- STRUCTURE -->
<div class="structure">
    <h2>Lesson Modules</h2>
    <div class="module-grid">
        <div class="module">
            <h3>Module 1: Core Foundations</h3>
            <ul>
                <li>Introduction to key concepts</li>
                <li>Mathematical & theoretical background</li>
                <li>Concept clarification sessions</li>
            </ul>
        </div>

        <div class="module">
            <h3>Module 2: Applied Learning</h3>
            <ul>
                <li>Case studies and examples</li>
                <li>Problem-solving workshops</li>
                <li>Hands-on lab or coding sessions</li>
            </ul>
        </div>

        <div class="module">
            <h3>Module 3: Advanced Topics</h3>
            <ul>
                <li>Research-oriented discussions</li>
                <li>Recent trends & technologies</li>
                <li>Seminar presentations</li>
            </ul>
        </div>

        <div class="module">
            <h3>Module 4: Integration & Review</h3>
            <ul>
                <li>Revision and doubt clearing</li>
                <li>Mini assessments</li>
                <li>Exam preparation strategies</li>
            </ul>
        </div>
    </div>
</div>

<div class="structure">
<h2>📚 Added Lessons</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Lessons</h3>
<div class="module-grid">

<?php if(isset($lessons['approved'])): ?>
<?php foreach($lessons['approved'] as $row): ?>
<div class="module" style="background:#dcfce7;">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['description']; ?></p>
    <small><?php echo $row['category']; ?></small>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved lessons</p>
<?php endif; ?>

</div>

<!-- PENDING -->
<h3 style="color:orange; margin-top:20px;">⏳ Pending Lessons</h3>
<div class="module-grid">

<?php if(isset($lessons['pending'])): ?>
<?php foreach($lessons['pending'] as $row): ?>
<div class="module" style="background:#fef9c3;">
    <h3><?php echo $row['title']; ?></h3>
    <p><?php echo $row['description']; ?></p>
    <small><?php echo $row['category']; ?></small>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending lessons</p>
<?php endif; ?>

</div>

</div>

<!-- APPROACH -->
<div class="approach">
    <h2>Teaching Methodology</h2>
    <p>
        Lessons are delivered using blended learning methods including lectures,
        interactive discussions, flipped classrooms, project-based learning,
        and continuous assessments.
    </p>
</div>

<!-- WEEKLY FLOW -->
<div class="weekly">
    <div class="week-card">
        <h4>Weekly Plan</h4>
        <p>3 theory classes, 1 practical/lab, 1 tutorial.</p>
    </div>
    <div class="week-card">
        <h4>Evaluation</h4>
        <p>Quizzes, assignments, mid-sem tests, presentations.</p>
    </div>
    <div class="week-card">
        <h4>Student Support</h4>
        <p>Mentoring, remedial sessions, enrichment tasks.</p>
    </div>
</div>

<!-- OUTCOMES -->
<div class="outcomes">
    <h2>Learning Outcomes</h2>
    <ul>
        <li>Strong subject fundamentals</li>
        <li>Improved analytical and problem-solving skills</li>
        <li>Readiness for internships and placements</li>
        <li>Foundation for higher studies and research</li>
    </ul>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="undergraduate.php" class="back-btn">⬅ Back to Undergraduate</a>
    <div class="note">
        Undergraduate Curriculum • Outcome-Based Education
    </div>
</div>

<!-- MODAL -->
<div id="lessonModal" class="modal">

<form method="POST" class="modal-box">

<h2>📘 Add New Lesson</h2>

<div class="input-group">
<label>Lesson Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="input-group">
<label>Category</label>
<input type="text" name="category" placeholder="e.g. Mathematics, Science" required>
</div>

<div class="form-actions">
<button type="submit" name="create_lesson" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("lessonModal").style.display = "flex";
}

function closeModal(){
    document.getElementById("lessonModal").style.display = "none";
}

window.onclick = function(e){
    let modal = document.getElementById("lessonModal");
    if(e.target === modal){
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
