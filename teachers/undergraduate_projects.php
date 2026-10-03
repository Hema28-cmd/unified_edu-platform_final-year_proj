<?php
session_start();

require_once "../config/db.php";

/* ADD PROJECT */
if(isset($_POST['add_project'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $domain = $_POST['domain'];

    $level = "undergraduate";
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
/* 🔐 Teacher access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Projects | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

/* BASE */
body{
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#eef2ff);
    color:#0f172a;
    padding:26px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#0f766e,#1e3a8a);
    padding:22px 34px;
    border-radius:24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 16px 36px rgba(0,0,0,0.3);
}
.navbar h2{
    font-family:'Poppins',sans-serif;
    color:#ecfeff;
    font-size:26px;
}
.navbar a{
    color:#bae6fd;
    margin-left:20px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff}

/* HEADER */
.header{
    margin-top:36px;
    background:#ffffff;
    padding:38px;
    border-radius:30px;
    box-shadow:0 14px 30px rgba(0,0,0,0.15);
}
.header h1{
    font-family:'Poppins',sans-serif;
    color:#0f766e;
    font-size:30px;
}
.header p{
    margin-top:14px;
    font-size:16px;
    line-height:1.7;
    color:#475569;
}

/* TIMELINE */
.timeline{
    margin-top:50px;
    display:grid;
    gap:40px;
}

/* STAGE */
.stage{
    background:linear-gradient(135deg,#f0fdfa,#e0e7ff);
    padding:34px;
    border-radius:28px;
    box-shadow:0 12px 26px rgba(0,0,0,0.15);
}
.stage h2{
    color:#1e3a8a;
    font-size:22px;
    margin-bottom:12px;
}
.stage p{
    font-size:14px;
    color:#334155;
    margin-bottom:18px;
}

/* PROJECT GRID */
.projects{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:22px;
}

/* PROJECT CARD */
.project{
    background:#ffffff;
    padding:22px;
    border-radius:20px;
    box-shadow:0 10px 22px rgba(0,0,0,0.12);
}
.project h3{
    font-size:17px;
    color:#0f766e;
    margin-bottom:6px;
}
.project span{
    font-size:12px;
    color:#475569;
}
.project ul{
    margin-top:10px;
    padding-left:18px;
}
.project li{
    font-size:13px;
    margin-bottom:6px;
}

/* SKILLS */
.skills{
    margin-top:12px;
    background:#f0fdfa;
    padding:10px;
    border-radius:12px;
    font-size:12px;
    color:#065f46;
}

/* RESEARCH SECTION */
.research{
    margin-top:56px;
    background:#020617;
    padding:40px;
    border-radius:32px;
    color:#e5e7eb;
}
.research h2{
    color:#67e8f9;
    margin-bottom:14px;
}
.research li{
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
    background:#0f766e;
    color:#ecfeff;
    padding:14px 34px;
    border-radius:18px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#115e59}
.note{
    font-size:13px;
    color:#475569;
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
    background:#0f766e;
    color:#fff;
    padding:10px 16px;
    border:none;
    border-radius:8px;
}

.btn-cancel{
    background:#e5e7eb;
    padding:10px 16px;
    border:none;
    border-radius:8px;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Undergraduate Projects</h2>
    <div>
        <a href="undergraduate_lessons.php">Lessons</a>
        <a href="undergraduate_books.php">Books</a>
        <a href="undergraduate_quizzes.php">Quizzes</a>
        <a href="undergraduate_assignments.php">Assignments</a>
        <a href="undergraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Project-Based Learning for Undergraduates</h1>
    <p>
        These projects are structured to improve problem-solving,
        teamwork, documentation, and real-world technical skills.
        They can be assigned as mini projects, semester projects,
        or final-year projects.
    </p><br>
<br>
<button class="back-btn" onclick="openModal()">➕ Add Project</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM project_topics
    WHERE level='undergraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$projects_db = [];

while($row = $result->fetch_assoc()){
    $projects_db[$row['status']][] = $row;
}
?>

<div class="stage">
<h2>📊 Projects from Database</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Projects</h3>
<div class="projects">

<?php if(isset($projects_db['approved'])): ?>
<?php foreach($projects_db['approved'] as $p): ?>
<div class="project" style="background:#dcfce7;">
    <h3><?php echo $p['title']; ?></h3>
    <span><?php echo $p['domain']; ?></span>
    <p><?php echo $p['description']; ?></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved projects</p>
<?php endif; ?>

</div>

<!-- PENDING -->
<h3 style="color:orange;margin-top:20px;">⏳ Pending Projects</h3>
<div class="projects">

<?php if(isset($projects_db['pending'])): ?>
<?php foreach($projects_db['pending'] as $p): ?>
<div class="project" style="background:#ffedd5;">
    <h3><?php echo $p['title']; ?></h3>
    <span><?php echo $p['domain']; ?></span>
    <p><?php echo $p['description']; ?></p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending projects</p>
<?php endif; ?>

</div>
</div>

<!-- TIMELINE -->
<div class="timeline">

    <!-- MINI PROJECTS -->
    <div class="stage">
        <h2>🔹 Mini Projects (1st–2nd Year)</h2>
        <p>Focus on fundamentals, logic, and tool familiarity.</p>

        <div class="projects">
            <div class="project">
                <h3>Student Result Management System</h3>
                <span>Web Application</span>
                <ul>
                    <li>CRUD operations</li>
                    <li>Login authentication</li>
                    <li>Basic reports</li>
                </ul>
                <div class="skills">Skills: PHP, MySQL, HTML, CSS</div>
            </div>

            <div class="project">
                <h3>Library Book Tracker</h3>
                <span>Desktop / Web</span>
                <ul>
                    <li>Book issue & return</li>
                    <li>Search & filters</li>
                    <li>Simple UI</li>
                </ul>
                <div class="skills">Skills: Java / Python, SQL</div>
            </div>
        </div>
    </div>

    <!-- MAJOR PROJECTS -->
    <div class="stage">
        <h2>🔹 Major Projects (3rd–4th Year)</h2>
        <p>Focus on system design, scalability, and documentation.</p>

        <div class="projects">
            <div class="project">
                <h3>Online Learning Management System</h3>
                <span>Full-Stack</span>
                <ul>
                    <li>Role-based access</li>
                    <li>Course & quiz modules</li>
                    <li>Progress tracking</li>
                </ul>
                <div class="skills">Skills: PHP / Django / MERN</div>
            </div>

            <div class="project">
                <h3>Smart Attendance Using QR</h3>
                <span>Automation Project</span>
                <ul>
                    <li>QR code scanning</li>
                    <li>Attendance analytics</li>
                    <li>Export reports</li>
                </ul>
                <div class="skills">Skills: Python, OpenCV, Database</div>
            </div>
        </div>
    </div>

</div>

<!-- RESEARCH -->
<div class="research">
    <h2>🔬 Research & Industry-Oriented Ideas</h2>
    <ul>
        <li>AI-based Student Performance Prediction</li>
        <li>Cybersecurity Threat Detection System</li>
        <li>IoT-based Smart Campus Solutions</li>
        <li>Blockchain-based Certificate Verification</li>
        <li>Cloud-based College ERP System</li>
    </ul>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="undergraduate.php" class="back-btn">⬅ Back to Undergraduate</a>
    <div class="note">
        Undergraduate Project Module • Skill-Driven Learning
    </div>
</div>

<!-- PROJECT MODAL -->
<div id="projectModal" class="modal">

<form method="POST" class="modal-box">

<h2>📌 Add New Project</h2>

<div class="input-group">
<label>Project Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="input-group">
<label>Domain</label>
<input type="text" name="domain" required>
</div>

<div class="form-actions">
<button type="submit" name="add_project" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
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
window.onclick = function(e){
    let modal = document.getElementById("projectModal");
    if(e.target === modal){
        modal.style.display="none";
    }
}
</script>

</body>
</html>
