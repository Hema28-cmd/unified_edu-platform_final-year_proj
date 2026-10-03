<?php
session_start();
require_once "../config/db.php";

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
/* ADD ASSIGNMENT */
if(isset($_POST['create_assignment'])){

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $subject = trim($_POST['subject']);
    $teacher_id = $_SESSION['user_id'];
    $level = "highschool";
    $role = "teacher";

    $stmt = $conn->prepare("
        INSERT INTO assignments 
        (title, description, level, subject, created_by_role, created_by)
        VALUES (?,?,?,?,?,?)
    ");

    $stmt->bind_param("sssssi",
        $title,
        $description,
        $level,
        $subject,
        $role,
        $teacher_id
    );

    $stmt->execute();

    echo "<script>alert('✅ Assignment created!'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Assignments | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#f8fafc,#ecfeff);
    padding:24px;
    color:#1f2937;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#020617,#065f46);
    padding:18px 32px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}
.navbar h2{
    font-family:'Libre Baskerville', serif;
    color:#ecfeff;
}
.navbar a{
    color:#a7f3d0;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff;}

/* INTRO */
.intro{
    margin:34px 0;
    background:#ffffff;
    padding:32px;
    border-radius:26px;
    box-shadow:0 14px 34px rgba(0,0,0,0.15);
}
.intro h1{
    font-family:'Libre Baskerville', serif;
    font-size:30px;
    color:#065f46;
}
.intro p{
    margin-top:12px;
    font-size:15px;
    color:#475569;
    line-height:1.7;
}

/* ASSIGNMENT FLOW */
.flow{
    margin-top:44px;
    border-left:4px solid #10b981;
    padding-left:30px;
}
.block{
    position:relative;
    margin-bottom:18px; /* reduced space */
    background:linear-gradient(135deg,#ecfeff,#fefce8);
    padding:14px; /* smaller card */
    border-radius:14px;
    box-shadow:0 6px 14px rgba(0,0,0,0.12);
}
.block::before{
    content:'';
    position:absolute;
    left:-42px;
    top:24px;
    width:18px;
    height:18px;
    background:#10b981;
    border-radius:50%;
}
.block h3{
    font-size:16px;
    color:#064e3b;
}
.block span{
    font-size:13px;
    color:#64748b;
    display:block;
    margin-top:4px;
}
.block p{
    font-size:13px;
    margin-top:6px;
    color:#374151;
}
.block ul{
    margin-top:10px;
    padding-left:18px;
}
.block ul li{
    font-size:14px;
    margin-bottom:6px;
}

/* SUBJECT GRID */
.subjects{
    margin-top:50px;
}
.subjects h2{
    font-size:22px;
    color:#020617;
    margin-bottom:18px;
}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:24px;
}
.card{
    background:linear-gradient(135deg,#cffafe,#ede9fe);
    padding:24px;
    border-radius:22px;
    box-shadow:0 12px 28px rgba(0,0,0,0.15);
}
.card h4{
    font-size:18px;
    color:#1e40af;
    margin-bottom:8px;
}
.card p{
    font-size:14px;
    color:#374151;
}

/* GUIDELINES */
.guidelines{
    margin-top:48px;
    background:linear-gradient(135deg,#fde68a,#fecaca);
    padding:28px;
    border-radius:26px;
    box-shadow:0 14px 32px rgba(0,0,0,0.2);
}
.guidelines h3{
    font-size:20px;
    color:#7c2d12;
}
.guidelines p{
    margin-top:10px;
    font-size:14px;
    line-height:1.7;
    color:#3f1d0b;
}

/* ACTIONS */
.actions{
    margin-top:44px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#065f46;
    color:#ffffff;
    padding:12px 30px;
    border-radius:16px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#047857;}
.footer-note{
    font-size:13px;
    color:#64748b;
}
/* MODAL */
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

.modal-box input,
.modal-box textarea{
    width:100%;
    padding:10px;
    margin-top:10px;
    border-radius:8px;
    border:1px solid #ccc;
}
/* BACKGROUND OVERLAY */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:linear-gradient(135deg,rgba(0,0,0,0.7),rgba(30,41,59,0.8));
    backdrop-filter:blur(6px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

/* MODAL BOX */
.modal-box{
    background:linear-gradient(135deg,#ffffff,#f0f9ff);
    padding:30px;
    border-radius:20px;
    width:420px;
    box-shadow:0 20px 50px rgba(0,0,0,0.35);
    animation:popup 0.3s ease;
}

/* ANIMATION */
@keyframes popup{
    from{
        transform:scale(0.8);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

/* TITLE */
.modal-box h2{
    text-align:center;
    color:#1e3a8a;
    margin-bottom:20px;
    font-size:22px;
}

/* INPUT GROUP */
.input-group{
    margin-bottom:15px;
}

.input-group label{
    font-size:13px;
    font-weight:600;
    color:#374151;
}

.input-group input,
.input-group textarea{
    width:100%;
    padding:10px;
    margin-top:6px;
    border-radius:10px;
    border:1px solid #d1d5db;
    outline:none;
    transition:0.3s;
}

/* FOCUS EFFECT */
.input-group input:focus,
.input-group textarea:focus{
    border-color:#6366f1;
    box-shadow:0 0 8px rgba(99,102,241,0.3);
}

/* BUTTONS */
.form-actions{
    display:flex;
    justify-content:space-between;
    margin-top:20px;
}

.btn-submit{
    background:linear-gradient(90deg,#4f46e5,#9333ea);
    color:#fff;
    padding:10px 18px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-weight:600;
}

.btn-submit:hover{
    opacity:0.9;
}

.btn-cancel{
    background:#e5e7eb;
    color:#374151;
    padding:10px 18px;
    border:none;
    border-radius:12px;
    cursor:pointer;
}

.btn-cancel:hover{
    background:#d1d5db;
}
.assignment-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:16px;
    margin-top:10px;
}

/* Make headings full width */
.assignment-grid h4{
    grid-column:1 / -1;
}
@media(max-width:900px){
    .assignment-grid{
        grid-template-columns:repeat(2, 1fr);
    }
}

@media(max-width:500px){
    .assignment-grid{
        grid-template-columns:1fr;
    }
}
.card:nth-child(even){
    background:linear-gradient(135deg,#ecfeff,#e0f2fe);
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>High School Assignments</h2>
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

    <h1>Assignments & Academic Tasks</h1>
    <p>
        Assignments are designed to strengthen subject understanding, promote
        independent thinking, and prepare students for examinations and higher studies.
    </p>
<button class="back-btn" onclick="openModal()">➕ Create Assignment</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM assignments 
    WHERE level = 'highschool' 
    AND status IN ('pending','approved')
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$assignments = [];

while($row = $result->fetch_assoc()){
    $subject = $row['subject'];
    $status = $row['status'];

    $assignments[$subject][$status][] = $row;
}

if(!empty($assignments)):
?>

<?php foreach($assignments as $subject => $statuses): ?>

<div class="subjects">
<h2>📘 <?php echo $subject; ?></h2>

<div class="grid">

<!-- APPROVED -->
<?php if(isset($statuses['approved'])): ?>
<?php foreach($statuses['approved'] as $row): ?>
<div class="card">
    <h4>✅ <?php echo $row['title']; ?></h4>
    <p><?php echo $row['description']; ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>

<!-- PENDING -->
<?php if(isset($statuses['pending'])): ?>
<?php foreach($statuses['pending'] as $row): ?>
<div class="card">
    <h4>⏳ <?php echo $row['title']; ?></h4>
    <p><?php echo $row['description']; ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>

</div>
</div>

<?php endforeach; ?>   <!-- 🔥 THIS WAS MISSING -->

<?php else: ?>
<p style="margin-top:20px;color:#64748b;">No assignments available.</p>
<?php endif; ?>

<!-- FLOW -->
<div class="flow">

    <div class="block">
        <h3>Written Assignments</h3>
        <span>Weekly / Fortnightly</span>
        <p>Structured written work aligned with curriculum outcomes.</p>
        <ul>
            <li>Numerical problem solving</li>
            <li>Short & long answer questions</li>
            <li>Diagram-based explanations</li>
        </ul>
    </div>

    <div class="block">
        <h3>Application-Based Tasks</h3>
        <span>Real-world Learning</span>
        <p>Encourages application of concepts beyond textbooks.</p>
        <ul>
            <li>Case study analysis</li>
            <li>Situation-based questions</li>
            <li>Critical thinking exercises</li>
        </ul>
    </div>

    <div class="block">
        <h3>Research & Investigation</h3>
        <span>Skill Development</span>
        <p>Promotes inquiry, exploration, and presentation skills.</p>
        <ul>
            <li>Mini research topics</li>
            <li>Data collection & interpretation</li>
            <li>Report writing</li>
        </ul>
    </div>

</div>

<!-- SUBJECT ASSIGNMENTS -->
<div class="subjects">
    <h2>Subject-wise Assignment Types</h2>
    <div class="grid">
        <div class="card">
            <h4>📐 Mathematics</h4>
            <p>Problem sets, derivations, real-life numerical applications.</p>
        </div>
        <div class="card">
            <h4>🔬 Science</h4>
            <p>Experiments, observations, scientific explanations.</p>
        </div>
        <div class="card">
            <h4>🌍 Social Studies</h4>
            <p>Maps, timelines, source-based questions.</p>
        </div>
        <div class="card">
            <h4>📖 Language</h4>
            <p>Essays, comprehension, creative writing tasks.</p>
        </div>
        <div class="card">
            <h4>💻 Computer Science</h4>
            <p>Algorithms, coding exercises, logic building.</p>
        </div>
    </div>
</div>

<!-- GUIDELINES -->
<div class="guidelines">
    <h3>Assignment Evaluation Guidelines</h3>
    <p>
        • Encourage originality and clarity<br>
        • Focus on concept understanding over memorization<br>
        • Provide constructive feedback<br>
        • Use rubrics for fair assessment
    </p>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="highschool.php" class="back-btn">⬅ Back</a>
    <div class="footer-note">
        Academic Assignments • Grades 9 – 12
    </div>
</div>

<!-- MODAL -->

<div id="assignmentModal" class="modal">

<form method="POST" class="modal-box fancy-form">

<h2>📚 Create Assignment</h2>

<div class="input-group">
<label>Assignment Title</label>
<input type="text" name="title" placeholder="Enter assignment title" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" placeholder="Write assignment details..." required></textarea>
</div>

<div class="input-group">
<label>Subject</label>
<input type="text" name="subject" placeholder="e.g. Mathematics" required>
</div>

<div class="form-actions">
<button type="submit" name="create_assignment" class="btn-submit">🚀 Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("assignmentModal").style.display = "flex";
}

function closeModal(){
    document.getElementById("assignmentModal").style.display = "none";
}

/* close when clicking outside */
window.onclick = function(e){
    let modal = document.getElementById("assignmentModal");
    if(e.target === modal){
        modal.style.display = "none";
    }
}
</script>
</body>
</html>
