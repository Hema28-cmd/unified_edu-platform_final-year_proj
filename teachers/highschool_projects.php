<?php
session_start();
require_once "../config/db.php";

/* ADD PROJECT */
if(isset($_POST['create_project'])){

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $domain = trim($_POST['domain']);
    $teacher_id = $_SESSION['user_id'];

    $level = "highschool";
    $role = "teacher";

    $stmt = $conn->prepare("
        INSERT INTO project_topics
        (title, description, level, domain, created_by_role, created_by)
        VALUES (?,?,?,?,?,?)
    ");

    $stmt->bind_param("sssssi",
        $title,
        $description,
        $level,
        $domain,
        $role,
        $teacher_id
    );

    $stmt->execute();

    echo "<script>alert('✅ Project added successfully! Waiting for admin approval'); window.location.href=window.location.href;</script>";
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
<title>High School Projects | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#eef2ff,#f0fdfa);
    padding:24px;
    color:#1f2937;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#312e81,#0f766e);
    padding:18px 34px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}
.navbar h2{
    font-family:'DM Serif Display', serif;
    color:#ecfeff;
    font-size:24px;
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
    margin:36px 0;
    background:#ffffff;
    padding:34px;
    border-radius:28px;
    box-shadow:0 14px 36px rgba(0,0,0,0.15);
}
.intro h1{
    font-family:'DM Serif Display', serif;
    font-size:32px;
    color:#0f766e;
}
.intro p{
    margin-top:12px;
    font-size:15px;
    color:#475569;
    line-height:1.7;
}

/* PROJECT ROADMAP */
.roadmap{
    margin-top:46px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:26px;
}
.stage{
    background:linear-gradient(135deg,#e0e7ff,#ccfbf1);
    padding:26px;
    border-radius:24px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.stage h3{
    font-size:20px;
    color:#312e81;
    margin-bottom:8px;
}
.stage span{
    font-size:13px;
    color:#64748b;
}
.stage ul{
    margin-top:12px;
    padding-left:18px;
}
.stage li{
    font-size:14px;
    margin-bottom:6px;
}

/* PROJECT SHOWCASE */
.showcase{
    margin-top:54px;
}
.showcase h2{
    font-size:24px;
    color:#020617;
    margin-bottom:20px;
}
.project-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:26px;
}
.project{
    background:linear-gradient(135deg,#fff7ed,#fde68a);
    padding:26px;
    border-radius:24px;
    box-shadow:0 12px 28px rgba(0,0,0,0.18);
}
.project h4{
    font-size:18px;
    color:#9a3412;
}
.project p{
    font-size:14px;
    margin-top:8px;
    color:#3f1d0b;
}

/* BASIC PROJECTS */
.basic{
    margin-top:50px;
    background:linear-gradient(135deg,#fce7f3,#ede9fe);
    padding:30px;
    border-radius:28px;
    box-shadow:0 14px 34px rgba(0,0,0,0.2);
}
.basic h3{
    font-size:22px;
    color:#701a75;
}
.basic ul{
    margin-top:14px;
    padding-left:20px;
}
.basic li{
    font-size:14px;
    margin-bottom:8px;
}

/* EVALUATION */
.evaluation{
    margin-top:48px;
    background:linear-gradient(135deg,#cffafe,#fecaca);
    padding:28px;
    border-radius:26px;
    box-shadow:0 14px 34px rgba(0,0,0,0.2);
}
.evaluation h3{
    font-size:20px;
    color:#0c4a6e;
}
.evaluation p{
    font-size:14px;
    margin-top:10px;
    line-height:1.7;
}

/* ACTIONS */
.actions{
    margin-top:46px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#312e81;
    color:#ffffff;
    padding:12px 32px;
    border-radius:18px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#4338ca;}
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
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>High School Projects</h2>
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
    <h1>Project-Based Learning</h1>
    <p>
        Projects empower high school students to apply classroom knowledge
        to real-world problems. This section supports innovation, collaboration,
        and higher-order thinking skills.
    </p>
<button class="back-btn" onclick="openModal()">➕ Add Project</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM project_topics
    WHERE level='highschool'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$projects = [];

while($row = $result->fetch_assoc()){
    $status = $row['status'];
    $projects[$status][] = $row;
}
?>

<!-- ROADMAP -->
<div class="roadmap">

    <div class="stage">
        <h3>Stage 1: Planning</h3>
        <span>Idea Formation</span>
        <ul>
            <li>Topic selection</li>
            <li>Objective definition</li>
            <li>Resource planning</li>
        </ul>
    </div>

    <div class="stage">
        <h3>Stage 2: Research</h3>
        <span>Concept Exploration</span>
        <ul>
            <li>Data collection</li>
            <li>Reference study</li>
            <li>Hypothesis formation</li>
        </ul>
    </div>

    <div class="stage">
        <h3>Stage 3: Implementation</h3>
        <span>Execution</span>
        <ul>
            <li>Model / solution building</li>
            <li>Testing and refinement</li>
            <li>Documentation</li>
        </ul>
    </div>

    <div class="stage">
        <h3>Stage 4: Presentation</h3>
        <span>Showcase</span>
        <ul>
            <li>Report submission</li>
            <li>Oral presentation</li>
            <li>Peer review</li>
        </ul>
    </div>

</div>

<!-- SHOWCASE -->
<div class="showcase">
    <h2>Advanced Project Ideas</h2>
    <div class="project-grid">
        <div class="project">
            <h4>🔬 Science Research Project</h4>
            <p>Experimental investigation with observation and conclusion.</p>
        </div>
        <div class="project">
            <h4>💻 Computer Science Application</h4>
            <p>Mini software, website, or automation tool.</p>
        </div>
        <div class="project">
            <h4>🌍 Social Impact Study</h4>
            <p>Research on social issues with data analysis.</p>
        </div>
        <div class="project">
            <h4>📊 Business & Economics Model</h4>
            <p>Market study, budgeting, and financial planning.</p>
        </div>
    </div>
</div>

<div class="showcase">
<h2>📂 Submitted Projects</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Projects</h3>
<div class="project-grid">

<?php if(isset($projects['approved'])): ?>
<?php foreach($projects['approved'] as $row): ?>
<div class="project" style="background:#dcfce7;">
    <h4><?php echo $row['title']; ?></h4>
    <p><?php echo $row['description']; ?></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved projects</p>
<?php endif; ?>

</div>

<!-- PENDING -->
<h3 style="color:orange; margin-top:20px;">⏳ Pending Approval</h3>
<div class="project-grid">

<?php if(isset($projects['pending'])): ?>
<?php foreach($projects['pending'] as $row): ?>
<div class="project" style="background:#fef9c3;">
    <h4><?php echo $row['title']; ?></h4>
    <p><?php echo $row['description']; ?></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending projects</p>
<?php endif; ?>

</div>

</div>

<!-- BASIC PROJECTS -->
<div class="basic">
    <h3>Basic Projects (For Beginners)</h3>
    <ul>
        <li>Chart & model preparation</li>
        <li>Simple survey and report</li>
        <li>Case study summary</li>
        <li>Technology awareness project</li>
    </ul>
</div>

<!-- EVALUATION -->
<div class="evaluation">
    <h3>Project Evaluation Criteria</h3>
    <p>
        • Originality and creativity<br>
        • Concept understanding<br>
        • Presentation and documentation<br>
        • Teamwork and communication
    </p>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="highschool.php" class="back-btn">⬅ Back</a>
    <div class="note">
        Project-Based Learning • Grades 9 – 12
    </div>
</div>
<!-- MODAL -->
<div id="projectModal" class="modal">

<form method="POST" class="modal-box">

<h2>📚 Add New Project</h2>

<div class="input-group">
<label>Project Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="input-group">
<label>Domain (Subject)</label>
<input type="text" name="domain" placeholder="e.g. Science, Computer" required>
</div>

<div class="form-actions">
<button type="submit" name="create_project" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("projectModal").style.display = "flex";
}

function closeModal(){
    document.getElementById("projectModal").style.display = "none";
}

window.onclick = function(e){
    let modal = document.getElementById("projectModal");
    if(e.target === modal){
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
