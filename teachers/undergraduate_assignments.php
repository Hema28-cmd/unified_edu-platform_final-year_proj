<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];

require_once "../config/db.php";

/* ADD ASSIGNMENT */
if(isset($_POST['add_assignment'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $subject = $_POST['subject'];

    $level = "undergraduate";
    $created_by = $_SESSION['user_id'];
    $role = "teacher";
    $status = "pending";

    $stmt = $conn->prepare("
        INSERT INTO assignments
        (title, description, level, subject, created_by_role, status, created_by)
        VALUES (?,?,?,?,?,?,?)
    ");

    $stmt->bind_param("ssssssi",
        $title,
        $description,
        $level,
        $subject,
        $role,
        $status,
        $created_by
    );

    $stmt->execute();

    echo "<script>alert('✅ Assignment added successfully! Waiting for admin approval'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Assignments | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Roboto+Slab:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

/* BASE */
body{
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#fdf2f8,#f8fafc);
    color:#1e293b;
    padding:26px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#7c2d12,#9a3412);
    padding:22px 36px;
    border-radius:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 34px rgba(0,0,0,0.3);
}
.navbar h2{
    font-family:'Roboto Slab',serif;
    color:#fff7ed;
    font-size:26px;
}
.navbar a{
    color:#fed7aa;
    margin-left:22px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff}

/* INTRO */
.intro{
    margin-top:34px;
    background:#ffffff;
    padding:36px;
    border-radius:28px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.intro h1{
    font-family:'Roboto Slab',serif;
    color:#7c2d12;
    font-size:30px;
}
.intro p{
    margin-top:12px;
    font-size:16px;
    line-height:1.7;
    color:#475569;
}

/* ASSIGNMENT SECTIONS */
.section{
    margin-top:46px;
}
.section h2{
    font-size:22px;
    margin-bottom:18px;
    color:#9a3412;
}

/* ASSIGNMENT GRID */
.assignment-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:28px;
}

/* ASSIGNMENT CARD */
.assignment{
    background:linear-gradient(135deg,#fff7ed,#ffedd5);
    padding:28px;
    border-radius:24px;
    box-shadow:0 10px 26px rgba(0,0,0,0.15);
}
.assignment h3{
    font-size:18px;
    color:#7c2d12;
    margin-bottom:8px;
}
.assignment p{
    font-size:14px;
    margin-bottom:6px;
    color:#475569;
}
.assignment ul{
    margin-top:10px;
    padding-left:18px;
}
.assignment li{
    font-size:14px;
    margin-bottom:6px;
}

/* SAMPLE TASK */
.sample{
    margin-top:14px;
    background:#fff;
    padding:14px;
    border-radius:14px;
    font-size:13px;
    color:#7c2d12;
    border-left:4px solid #9a3412;
}

/* EVALUATION */
.evaluation{
    margin-top:50px;
    background:linear-gradient(135deg,#020617,#020617);
    padding:38px;
    border-radius:30px;
    color:#e5e7eb;
}
.evaluation h2{
    color:#fdba74;
    margin-bottom:14px;
}
.evaluation li{
    margin-bottom:10px;
    font-size:14px;
}

/* ACTIONS */
.actions{
    margin-top:50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#7c2d12;
    color:#fff7ed;
    padding:14px 32px;
    border-radius:18px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#9a3412}
.note{
    font-size:13px;
    color:#475569;
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
    background:#7c2d12;
    color:#fff;
    padding:10px;
    border:none;
    border-radius:8px;
}

.btn-cancel{
    background:#ccc;
    padding:10px;
    border:none;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Undergraduate Assignments</h2>
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
    <h1>Academic & Skill-Based Assignments</h1>
    <p>
        Assignments are designed to enhance conceptual clarity,
        analytical thinking, research ability, and professional writing
        skills among undergraduate students.
    </p><br>
<button class="back-btn" onclick="openModal()">➕ Add Assignment</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM assignments
    WHERE level='undergraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$assignments = [];

while($row = $result->fetch_assoc()){
    $assignments[$row['status']][] = $row;
}
?>

<!-- ASSIGNMENTS -->
<div class="section">
    <h2>📘 Core Subject Assignments</h2>

    <div class="assignment-grid">

        <div class="assignment">
            <h3>Programming Assignment</h3>
            <p><b>Focus:</b> Logic building & coding standards</p>
            <ul>
                <li>Implement sorting algorithms</li>
                <li>Analyze time complexity</li>
                <li>Write clean, documented code</li>
            </ul>
            <div class="sample">
                <b>Sample Task:</b> Compare Bubble Sort and Quick Sort using sample data.
            </div>
        </div>

        <div class="assignment">
            <h3>Database Assignment</h3>
            <p><b>Focus:</b> Query design & normalization</p>
            <ul>
                <li>Design ER diagrams</li>
                <li>Write SQL queries</li>
                <li>Apply normalization rules</li>
            </ul>
            <div class="sample">
                <b>Sample Task:</b> Design a database for a college management system.
            </div>
        </div>

        <div class="assignment">
            <h3>Operating Systems Assignment</h3>
            <p><b>Focus:</b> System-level understanding</p>
            <ul>
                <li>CPU scheduling algorithms</li>
                <li>Deadlock handling</li>
                <li>Memory allocation</li>
            </ul>
            <div class="sample">
                <b>Sample Task:</b> Analyze Round Robin scheduling with different time quanta.
            </div>
        </div>

        <div class="assignment">
            <h3>Software Engineering Assignment</h3>
            <p><b>Focus:</b> Documentation & design</p>
            <ul>
                <li>SDLC models comparison</li>
                <li>Requirement analysis</li>
                <li>UML diagrams</li>
            </ul>
            <div class="sample">
                <b>Sample Task:</b> Prepare SRS for an online examination system.
            </div>
        </div>

    </div>
</div>

<div class="section">
<h2>📊 Created Assignments</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Assignments</h3>
<div class="assignment-grid">

<?php if(isset($assignments['approved'])): ?>
<?php foreach($assignments['approved'] as $a): ?>
<div class="assignment" style="background:#dcfce7;">
    <h3><?php echo $a['title']; ?></h3>
    <p><?php echo $a['description']; ?></p>
    <p><b>Subject:</b> <?php echo $a['subject']; ?></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved assignments</p>
<?php endif; ?>

</div>

<!-- PENDING -->
<h3 style="color:orange;margin-top:20px;">⏳ Pending Assignments</h3>
<div class="assignment-grid">

<?php if(isset($assignments['pending'])): ?>
<?php foreach($assignments['pending'] as $a): ?>
<div class="assignment" style="background:#ffedd5;">
    <h3><?php echo $a['title']; ?></h3>
    <p><?php echo $a['description']; ?></p>
    <p><b>Subject:</b> <?php echo $a['subject']; ?></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending assignments</p>
<?php endif; ?>

</div>
</div>

<!-- EVALUATION -->
<div class="evaluation">
    <h2>📊 Evaluation & Submission Guidelines</h2>
    <ul>
        <li>Assignments should be original and plagiarism-free</li>
        <li>Use proper formatting, diagrams, and references</li>
        <li>Include screenshots/code where applicable</li>
        <li>Marks based on understanding, clarity, and innovation</li>
        <li>Late submissions may attract penalties</li>
    </ul>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="undergraduate.php" class="back-btn">⬅ Back to Undergraduate</a>
    <div class="note">
        Undergraduate Assignment Module • Academic Excellence
    </div>
</div>

<!-- ASSIGNMENT MODAL -->
<div id="assignmentModal" class="modal">

<form method="POST" class="modal-box">

<h2>📝 Create Assignment</h2>

<div class="input-group">
<label>Assignment Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="input-group">
<label>Subject</label>
<input type="text" name="subject" required>
</div>

<div class="form-actions">
<button type="submit" name="add_assignment" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("assignmentModal").style.display="flex";
}

function closeModal(){
    document.getElementById("assignmentModal").style.display="none";
}

window.onclick = function(e){
    let modal = document.getElementById("assignmentModal");
    if(e.target === modal){
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
