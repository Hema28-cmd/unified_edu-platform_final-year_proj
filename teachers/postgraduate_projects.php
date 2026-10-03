<?php
session_start();

require_once "../config/db.php";

/* ADD PROJECT */
if(isset($_POST['submit_project'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $domain = $_POST['domain'];
    $level = "postgraduate";
    $created_by = $_SESSION['user_id'];
    $role = "teacher";
    $status = "pending";

    $stmt = $conn->prepare("
        INSERT INTO project_topics
        (title, description, level, domain, created_by_role, created_by, status)
        VALUES (?,?,?,?,?,?,?)
    ");

    $stmt->bind_param("sssssis",
        $title,
        $description,
        $level,
        $domain,
        $role,
        $created_by,
        $status
    );

    $stmt->execute();

    echo "<script>
        alert('✅ Project added successfully! Waiting for admin approval');
        window.location.href=window.location.href;
    </script>";
}

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Projects | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#f8fafc,#eef2ff,#ecfeff);
    color:#1e293b;
    padding:26px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#312e81,#0f766e);
    padding:22px 40px;
    border-radius:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 30px rgba(0,0,0,0.15);
}
.navbar h2{
    font-family:'Playfair Display', serif;
    color:#ffffff;
    font-size:24px;
}
.navbar a{
    color:#e0f2fe;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#fde68a;}

/* BACK */
.back{
    margin:30px 0;
}
.back a{
    background:linear-gradient(90deg,#38bdf8,#22c55e);
    color:#022c22;
    padding:12px 34px;
    border-radius:28px;
    text-decoration:none;
    font-weight:600;
    box-shadow:0 6px 18px rgba(0,0,0,0.15);
}

/* INTRO */
.intro{
    background:#ffffff;
    padding:40px;
    border-radius:32px;
    box-shadow:0 18px 40px rgba(0,0,0,0.15);
    margin-bottom:48px;
}
.intro h1{
    font-family:'Playfair Display', serif;
    font-size:32px;
    color:#312e81;
}
.intro p{
    margin-top:14px;
    font-size:15px;
    line-height:1.8;
    color:#475569;
}

/* SECTION */
.section{
    margin-bottom:56px;
}
.section h2{
    font-family:'Playfair Display', serif;
    font-size:26px;
    color:#0f766e;
    margin-bottom:20px;
}

/* PROJECT BLOCK */
.project{
    background:#ffffff;
    padding:28px;
    border-radius:26px;
    margin-bottom:22px;
    border-left:6px solid #6366f1;
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
}
.project h3{
    font-size:20px;
    color:#1e3a8a;
}
.project span{
    font-size:13px;
    color:#64748b;
}
.project p{
    margin-top:10px;
    font-size:14px;
    color:#334155;
}
.project ul{
    margin-top:12px;
    padding-left:20px;
}
.project li{
    font-size:14px;
    margin-bottom:6px;
}

/* SKILLS */
.skills{
    background:linear-gradient(135deg,#eef2ff,#ecfeff);
    padding:40px;
    border-radius:36px;
    box-shadow:0 18px 42px rgba(0,0,0,0.15);
}
.skills h2{
    color:#312e81;
    margin-bottom:16px;
}
.skills ul{
    padding-left:22px;
}
.skills li{
    font-size:14px;
    margin-bottom:10px;
    color:#334155;
}
.add-btn{
    margin-top:16px;
    padding:12px 26px;
    border:none;
    border-radius:26px;
    background:linear-gradient(135deg,#6366f1,#22c55e);
    color:#fff;
    font-weight:600;
    cursor:pointer;
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
    padding:24px;
    width:420px;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    gap:10px;
}

.modal-box input,
.modal-box textarea{
    padding:10px;
    border-radius:10px;
    border:1px solid #ccc;
}

.form-actions{
    display:flex;
    gap:10px;
}

.submit-btn{
    flex:1;
    background:#6366f1;
    border:none;
    padding:10px;
    border-radius:10px;
    color:#fff;
    cursor:pointer;
}

.cancel-btn{
    flex:1;
    background:#e2e8f0;
    border:none;
    padding:10px;
    border-radius:10px;
}

</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Postgraduate Projects</h2>
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

<!-- INTRO -->
<div class="intro">
    <h1>Postgraduate Research & Innovation Projects</h1>
    <p>
        These projects are designed to strengthen research skills,
        promote innovation, and prepare students for industry,
        doctoral studies, and academic research environments.
    </p>
<br>
<button class="add-btn" onclick="openModal()">➕ Add Project</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM project_topics
    WHERE level='postgraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$res = $stmt->get_result();

$data = [];

while($row = $res->fetch_assoc()){
    $data[$row['status']][] = $row;
}
?>

<!-- RESEARCH PROJECTS -->
<div class="section">
    <h2>🔬 Research-Based Projects</h2>

    <div class="project">
        <h3>Comparative Research Analysis</h3>
        <span>Academic Research</span>
        <p>Comparison of existing theories, models, or frameworks.</p>
        <ul>
            <li>Literature review</li>
            <li>Research gap identification</li>
            <li>Critical comparison</li>
        </ul>
    </div>

    <div class="project">
        <h3>Experimental Research Study</h3>
        <span>Empirical Research</span>
        <p>Validation of hypotheses through experiments or simulations.</p>
        <ul>
            <li>Methodology design</li>
            <li>Data collection</li>
            <li>Result interpretation</li>
        </ul>
    </div>
</div>

<!-- TECHNICAL PROJECTS -->
<div class="section">
    <h2>💻 Technical & Applied Projects</h2>

    <div class="project">
        <h3>AI / Data Analytics System</h3>
        <span>Technology Project</span>
        <p>Design intelligent systems using real-world datasets.</p>
        <ul>
            <li>System architecture</li>
            <li>Model development</li>
            <li>Performance evaluation</li>
        </ul>
    </div>

    <div class="project">
        <h3>Industry-Oriented Solution</h3>
        <span>Applied Research</span>
        <p>Solving real industry problems using technology.</p>
        <ul>
            <li>Problem analysis</li>
            <li>Prototype development</li>
            <li>Testing & validation</li>
        </ul>
    </div>
</div>

<h2 style="margin-top:40px;">📊 Projects from Database</h2>

<h3 style="color:green;">✅ Approved</h3>
<?php if(isset($data['approved'])): ?>
<?php foreach($data['approved'] as $p): ?>
<div class="project">
<h3><?php echo $p['title']; ?></h3>
<span><?php echo $p['domain']; ?></span>
<p><?php echo $p['description']; ?></p>
<p>Status: Approved</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved projects</p>
<?php endif; ?>

<h3 style="color:orange;">⏳ Pending</h3>
<?php if(isset($data['pending'])): ?>
<?php foreach($data['pending'] as $p): ?>
<div class="project" style="border-left:6px solid orange;">
<h3><?php echo $p['title']; ?></h3>
<span><?php echo $p['domain']; ?></span>
<p><?php echo $p['description']; ?></p>
<p>Status: Pending</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending projects</p>
<?php endif; ?>

<!-- SKILLS -->
<div class="skills">
    <h2>🎯 Skills Developed</h2>
    <ul>
        <li>Advanced research & analytical thinking</li>
        <li>Technical documentation & reporting</li>
        <li>Innovation and solution design</li>
        <li>Independent problem-solving</li>
        <li>Academic presentation & communication</li>
    </ul>
</div>

<div id="projectModal" class="modal">

<form method="POST" class="modal-box">

<h2>📊 Create Project</h2>

<input type="text" name="title" placeholder="Project Title" required>

<textarea name="description" placeholder="Project Description" required></textarea>

<input type="text" name="domain" placeholder="Domain (AI, Web, Research...)" required>

<div class="form-actions">
<button type="submit" name="submit_project" class="submit-btn">Submit</button>
<button type="button" onclick="closeModal()" class="cancel-btn">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("projectModal").style.display="flex";
}

function closeModal(){
    document.getElementById("projectModal").style.display="none";
}
</script>

</body>
</html>
