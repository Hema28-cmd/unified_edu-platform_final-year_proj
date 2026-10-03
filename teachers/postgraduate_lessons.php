<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];

require_once "../config/db.php";

/* ADD LESSON */
if(isset($_POST['add_lesson'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $level = "postgraduate";
    $created_by = $_SESSION['user_id'];
    $status = "pending";

    $stmt = $conn->prepare("
        INSERT INTO lessons
        (title, description, category, level, created_by, status)
        VALUES (?,?,?,?,?,?)
    ");

    $stmt->bind_param("ssssis",
        $title,
        $description,
        $category,
        $level,
        $created_by,
        $status
    );

    $stmt->execute();

    echo "<script>
        alert('✅ Lesson added successfully! Waiting for admin approval');
        window.location.href=window.location.href;
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Lessons | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600&family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Source Sans 3', sans-serif;
    background:linear-gradient(135deg,#f1f5f9,#e0f2fe);
    color:#0f172a;
    padding:22px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(90deg,#020617,#1e293b);
    padding:18px 36px;
    border-radius:18px;
    box-shadow:0 12px 30px rgba(0,0,0,0.35);
}
.navbar h2{
    font-family:'Libre Baskerville', serif;
    color:#38bdf8;
    font-size:22px;
}
.navbar a{
    color:#e2e8f0;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#38bdf8;}

/* BACK BUTTON */
.back{
    margin:22px 0;
}
.back a{
    display:inline-block;
    background:linear-gradient(90deg,#38bdf8,#0ea5e9);
    color:#020617;
    padding:10px 24px;
    border-radius:22px;
    text-decoration:none;
    font-weight:600;
    box-shadow:0 6px 18px rgba(0,0,0,0.2);
}

/* HEADER */
.header{
    background:#ffffff;
    padding:32px;
    border-radius:26px;
    box-shadow:0 14px 34px rgba(0,0,0,0.15);
    margin-bottom:36px;
}
.header h1{
    font-family:'Libre Baskerville', serif;
    font-size:28px;
    color:#020617;
}
.header p{
    margin-top:10px;
    font-size:15px;
    color:#475569;
    line-height:1.6;
}

/* PROGRAM STRUCTURE */
.structure{
    margin-bottom:40px;
}
.structure h2{
    font-size:22px;
    color:#0ea5e9;
    margin-bottom:18px;
}
.module-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:24px;
}
.module{
    background:linear-gradient(135deg,#e0f2fe,#f8fafc);
    padding:24px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.12);
}
.module h3{
    color:#020617;
    margin-bottom:8px;
}
.module p{
    font-size:14px;
    color:#334155;
    margin-bottom:10px;
}
.module ul{
    padding-left:18px;
}
.module li{
    font-size:13px;
    margin-bottom:6px;
}

/* RESEARCH BLOCK */
.research{
    background:linear-gradient(135deg,#020617,#1e293b);
    padding:34px;
    border-radius:28px;
    color:#e5e7eb;
    box-shadow:0 16px 40px rgba(0,0,0,0.4);
    margin-bottom:40px;
}
.research h2{
    color:#38bdf8;
    margin-bottom:14px;
}
.research ul{
    padding-left:20px;
}
.research li{
    font-size:14px;
    margin-bottom:8px;
}

/* SEMESTER FLOW */
.semesters{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:22px;
}
.sem{
    background:#ffffff;
    padding:22px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.15);
}
.sem h4{
    color:#0ea5e9;
    margin-bottom:6px;
}
.sem p{
    font-size:14px;
    color:#475569;
}

/* TIPS */
.tips{
    margin-top:40px;
    background:linear-gradient(135deg,#cffafe,#a5f3fc);
    padding:30px;
    border-radius:26px;
    box-shadow:0 12px 32px rgba(0,0,0,0.15);
}
.tips h3{
    color:#0f172a;
    margin-bottom:12px;
}
.tips p{
    font-size:14px;
    line-height:1.6;
}
.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-box{
    background:#ffffff;
    padding:25px;
    border-radius:20px;
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
    border-radius:8px;
    border:1px solid #ccc;
}

.form-actions{
    display:flex;
    justify-content:space-between;
}

.btn-submit{
    background:#0ea5e9;
    color:#fff;
    padding:10px;
    border:none;
    border-radius:8px;
}

.btn-cancel{
    background:#e5e7eb;
    padding:10px;
    border:none;
    border-radius:8px;
}
.add-lesson-btn{
    margin-top:18px;
    padding:12px 26px;
    border:none;
    border-radius:30px;
    font-size:15px;
    font-weight:600;
    color:#ffffff;
    background:linear-gradient(135deg,#6366f1,#0ea5e9);
    cursor:pointer;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    transition:all 0.3s ease;
}

/* Hover effect */
.add-lesson-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 26px rgba(0,0,0,0.3);
    background:linear-gradient(135deg,#4f46e5,#0284c7);
}

/* Click effect */
.add-lesson-btn:active{
    transform:scale(0.96);
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Postgraduate Lessons</h2>
    <div>
        <a href="postgraduate_lessons.php">Lessons</a>
        <a href="postgraduate_books.php">Books</a>
        <a href="postgraduate_quizzes.php">Quizzes</a>
        <a href="postgraduate_assignments.php">Assignments</a>
        <a href="postgraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK -->
<div class="back">
    <a href="postgraduate.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Advanced Postgraduate Lesson Framework 🎓</h1>
    <p>
        This module focuses on advanced theoretical knowledge, applied research,
        academic writing, and professional skill development required at the
        postgraduate level.
    </p>
<br>
<button class="add-lesson-btn" onclick="openModal()">
    ➕ Add Lesson
</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM lessons
    WHERE level='postgraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$lessons = [];

while($row = $result->fetch_assoc()){
    $lessons[$row['status']][] = $row;
}
?>

<!-- PROGRAM STRUCTURE -->
<div class="structure">
    <h2>📘 Core Academic Modules</h2>
    <div class="module-grid">

        <div class="module">
            <h3>Advanced Theory</h3>
            <p>In-depth conceptual understanding of domain subjects.</p>
            <ul>
                <li>Advanced models & frameworks</li>
                <li>Case-based discussions</li>
                <li>Critical analysis</li>
            </ul>
        </div>

        <div class="module">
            <h3>Applied Learning</h3>
            <p>Real-world implementation of theoretical knowledge.</p>
            <ul>
                <li>Industry case studies</li>
                <li>Simulation & labs</li>
                <li>Tool-based learning</li>
            </ul>
        </div>

        <div class="module">
            <h3>Professional Skills</h3>
            <p>Skills essential for academia and industry.</p>
            <ul>
                <li>Technical documentation</li>
                <li>Presentation skills</li>
                <li>Leadership & ethics</li>
            </ul>
        </div>

    </div>
</div>

<div class="structure">
<h2>📊 Lessons from Database</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Lessons</h3>
<div class="module-grid">

<?php if(isset($lessons['approved'])): ?>
<?php foreach($lessons['approved'] as $l): ?>
<div class="module" style="background:#dcfce7;">
    <h3><?php echo $l['title']; ?></h3>
    <p><?php echo $l['description']; ?></p>
    <small><b>Category:</b> <?php echo $l['category']; ?></small>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved lessons</p>
<?php endif; ?>

</div>

<!-- PENDING -->
<h3 style="color:orange;margin-top:20px;">⏳ Pending Lessons</h3>
<div class="module-grid">

<?php if(isset($lessons['pending'])): ?>
<?php foreach($lessons['pending'] as $l): ?>
<div class="module" style="background:#ffedd5;">
    <h3><?php echo $l['title']; ?></h3>
    <p><?php echo $l['description']; ?></p>
    <small><b>Category:</b> <?php echo $l['category']; ?></small>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending lessons</p>
<?php endif; ?>

</div>
</div>

<!-- RESEARCH -->
<div class="research">
    <h2>🔬 Research & Dissertation Focus</h2>
    <ul>
        <li>Research methodology & literature review</li>
        <li>Data collection and analysis techniques</li>
        <li>Plagiarism awareness & academic ethics</li>
        <li>Conference paper & journal writing</li>
        <li>Dissertation planning and evaluation</li>
    </ul>
</div>

<!-- SEMESTER FLOW -->
<div class="semesters">
    <div class="sem">
        <h4>Semester 1</h4>
        <p>Foundation subjects and research orientation</p>
    </div>
    <div class="sem">
        <h4>Semester 2</h4>
        <p>Advanced specialization and mini-projects</p>
    </div>
    <div class="sem">
        <h4>Semester 3</h4>
        <p>Electives, internships, and seminars</p>
    </div>
    <div class="sem">
        <h4>Semester 4</h4>
        <p>Major project and dissertation submission</p>
    </div>
</div>

<!-- TIPS -->
<div class="tips">
    <h3>🎯 Teaching Tips for Postgraduate Level</h3>
    <p>
        • Encourage independent learning and research reading.<br>
        • Focus on problem-solving and innovation.<br>
        • Use seminars and peer reviews.<br>
        • Align lessons with industry and research trends.
    </p>
</div>

<!-- LESSON MODAL -->
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
<input type="text" name="category" required>
</div>

<div class="form-actions">
<button type="submit" name="add_lesson" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("lessonModal").style.display="flex";
}
function closeModal(){
    document.getElementById("lessonModal").style.display="none";
}
window.onclick = function(e){
    let modal = document.getElementById("lessonModal");
    if(e.target === modal){
        modal.style.display="none";
    }
}
</script>
</body>
</html>
