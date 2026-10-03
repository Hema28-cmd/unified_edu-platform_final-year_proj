<?php
session_start();
require_once "../config/db.php";

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
$teacher_id = $_SESSION['user_id'];

/* FETCH TEACHER PROJECTS */
$stmt = $conn->prepare("
SELECT * FROM project_topics
WHERE created_by=? AND level='secondary'
ORDER BY created_at DESC
");

$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$project_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Projects | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

<style>

*{margin:0;padding:0;box-sizing:border-box;}

body{
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#f5f3ff,#ecfeff);
color:#1e293b;
padding:22px;
}

/* NAVBAR */

.navbar{
background:linear-gradient(90deg,#6d28d9,#0891b2);
padding:18px 32px;
border-radius:18px;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 12px 28px rgba(0,0,0,0.25);
}

.navbar h2{
font-family:'DM Serif Display',serif;
color:#fff;
font-size:22px;
}

.navbar a{
color:#e0f2fe;
margin-left:18px;
text-decoration:none;
font-weight:500;
}

.navbar a:hover{color:#fde68a;}

/* BACK */

.back{margin:22px 0;}

.back a{
background:linear-gradient(90deg,#22c55e,#16a34a);
padding:10px 26px;
border-radius:30px;
color:#fff;
text-decoration:none;
font-weight:500;
}

/* HEADER */

.header{
background:#ffffff;
padding:32px;
border-radius:30px;
margin-bottom:40px;
box-shadow:0 14px 34px rgba(0,0,0,0.15);
}

.header h1{
font-family:'DM Serif Display',serif;
font-size:30px;
color:#6d28d9;
}

.header p{
margin-top:10px;
font-size:15px;
color:#475569;
}

/* FLOW */

.flow{
display:grid;
grid-template-columns:1fr;
gap:28px;
}

/* DOMAIN BLOCK */

.domain{
background:linear-gradient(135deg,#ffffff,#f0fdfa);
padding:28px;
border-radius:26px;
box-shadow:0 10px 26px rgba(0,0,0,0.12);
}

.domain h2{
color:#0f766e;
margin-bottom:14px;
font-size:22px;
}

/* PROJECT CARD */

.project{
margin-top:18px;
padding:18px 22px;
border-left:6px solid #6d28d9;
background:#fafafa;
border-radius:18px;
}

.project h4{
font-size:16px;
color:#6d28d9;
margin-bottom:6px;
}

.project p{
font-size:14px;
color:#334155;
line-height:1.6;
}

.project span{
display:block;
margin-top:8px;
font-size:13px;
color:#0f766e;
font-weight:500;
}

/* NOTE */

.note{
margin-top:40px;
background:linear-gradient(135deg,#ddd6fe,#ccfbf1);
padding:28px;
border-radius:28px;
box-shadow:0 14px 30px rgba(0,0,0,0.18);
}

.note h3{
color:#4c1d95;
margin-bottom:10px;
}

.note p{
font-size:14px;
line-height:1.7;
}

</style>
</head>
<body>

<!-- NAVBAR -->

<div class="navbar">
<h2>Secondary Projects</h2>

<div>
<a href="secondary_lessons.php">Lessons</a>
<a href="secondary_books.php">Books</a>
<a href="secondary_quizzes.php">Quizzes</a>
<a href="secondary_assignments.php">Assignments</a>
<a href="secondary_projects.php">Projects</a>
<a href="../public/logout.php">Logout</a>
</div>
</div>

<!-- BACK -->

<div class="back">
<a href="secondary.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->

<div class="header">

<h1>Innovative Learning Projects 🚀</h1>

<p>
Projects encourage creativity, research, and problem-solving.
Students apply theoretical knowledge to real-world applications.
</p>

<br><br>

<button id="openProjectPopup"
style="padding:10px 20px;border:none;border-radius:8px;background:#6d28d9;color:white;cursor:pointer;font-weight:500;">
➕ Add New Project
</button>

</div>

<!-- SAMPLE DOMAINS -->

<div class="flow">

<div class="domain">

<h2>💻 Technology Projects</h2>

<div class="project">
<h4>Build a Simple Website</h4>
<p>
Students create a small HTML/CSS website about their favorite topic.
</p>
<span>Focus: Web design & creativity</span>
</div>

<div class="project">
<h4>Basic Programming Logic</h4>
<p>
Write simple algorithms and flowcharts for everyday tasks.
</p>
<span>Focus: Computational thinking</span>
</div>

</div>

<div class="domain">

<h2>🌍 Environmental Projects</h2>

<div class="project">
<h4>Waste Management Study</h4>
<p>
Analyze waste management practices in your locality.
</p>
<span>Focus: Sustainability awareness</span>
</div>

</div>

</div>

<!-- TEACHER PROJECTS -->

<div class="domain">

<h2>📂 Your Projects</h2>

<?php if($project_result->num_rows > 0){ ?>

<?php while($project = $project_result->fetch_assoc()){ ?>

<div class="project">

<h4><?php echo htmlspecialchars($project['title']); ?></h4>

<p><?php echo htmlspecialchars($project['description']); ?></p>

<span>Domain: <?php echo htmlspecialchars($project['domain']); ?></span>

<span>
Status:

<?php
if($project['status']=="pending"){
echo "<span style='color:orange;font-weight:600;'>Pending Approval</span>";
}
elseif($project['status']=="approved"){
echo "<span style='color:green;font-weight:600;'>Approved</span>";
}
else{
echo "<span style='color:red;font-weight:600;'>Rejected</span>";
}
?>

</span>

</div>

<?php } ?>

<?php } else { ?>

<p>No projects created yet.</p>

<?php } ?>

</div>

<!-- NOTE -->

<div class="note">

<h3>📌 Project Guidelines</h3>

<p>
• Encourage creativity and real-world problem solving.<br>
• Allow students to work individually or in groups.<br>
• Focus on presentation and explanation of concepts.<br>
• Projects should involve research, experimentation, or design.
</p>

</div>

<!-- PROJECT POPUP -->

<div id="projectPopup"
style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.5);align-items:center;justify-content:center;">

<div style="background:white;padding:25px;border-radius:12px;width:420px;">

<h3>🚀 Create Project</h3>

<form id="addProjectForm">

<input type="text" name="title" placeholder="Project Title" required
style="width:100%;margin-bottom:10px;padding:8px;">

<textarea name="description" placeholder="Project Description"
required style="width:100%;margin-bottom:10px;padding:8px;"></textarea>

<input type="text" name="domain" placeholder="Project Domain (AI, Web, IoT)"
style="width:100%;margin-bottom:10px;padding:8px;">

<input type="hidden" name="level" value="secondary">

<button type="submit"
style="padding:8px 16px;background:#6d28d9;color:white;border:none;border-radius:6px;">
Submit Project
</button>

<button type="button" id="closeProjectPopup"
style="padding:8px 16px;background:#ccc;border:none;border-radius:6px;">
Cancel
</button>

</form>

</div>
</div>

<script>

const projectPopup = document.getElementById("projectPopup");

document.getElementById("openProjectPopup").onclick = ()=>{
projectPopup.style.display="flex";
}

document.getElementById("closeProjectPopup").onclick = ()=>{
projectPopup.style.display="none";
}

document.getElementById("addProjectForm").onsubmit=function(e){

e.preventDefault();

const formData=new FormData(this);

fetch("add_secondary_project.php",{
method:"POST",
body:formData
})
.then(res=>res.json())
.then(data=>{
alert(data.message);
location.reload();
});

}

</script>

</body>
</html>