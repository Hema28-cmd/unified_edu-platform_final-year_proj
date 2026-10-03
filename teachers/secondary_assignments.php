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

$stmt = $conn->prepare("SELECT * FROM assignments WHERE created_by=? ORDER BY created_at DESC");
$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$assignment_result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Assignments | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Poppins', sans-serif;
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
    font-family:'DM Serif Display', serif;
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
.back{
    margin:22px 0;
}
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
    font-family:'DM Serif Display', serif;
    font-size:30px;
    color:#6d28d9;
}
.header p{
    margin-top:10px;
    font-size:15px;
    color:#475569;
}

/* ASSIGNMENT FLOW */
.flow{
    display:grid;
    grid-template-columns:1fr;
    gap:28px;
}

/* SUBJECT BLOCK */
.subject{
    background:linear-gradient(135deg,#ffffff,#f0fdfa);
    padding:28px;
    border-radius:26px;
    box-shadow:0 10px 26px rgba(0,0,0,0.12);
}
.subject h2{
    color:#0f766e;
    margin-bottom:14px;
    font-size:22px;
}

/* TASK */
.task{
    margin-top:18px;
    padding:18px 22px;
    border-left:6px solid #6d28d9;
    background:#fafafa;
    border-radius:18px;
}
.task h4{
    font-size:16px;
    color:#6d28d9;
    margin-bottom:6px;
}
.task p{
    font-size:14px;
    color:#334155;
    line-height:1.6;
}
.task span{
    display:block;
    margin-top:8px;
    font-size:13px;
    color:#0f766e;
    font-weight:500;
}

/* FOOTER NOTE */
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
    <h2>Secondary Assignments</h2>
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
    <h1>Subject-wise Academic Assignments 📂</h1>
    <p>
        This section focuses on written, analytical, and creative assignments
        that help students strengthen conceptual clarity, research ability,
        and independent thinking skills.
    </p>
<br><br>

<button id="openAssignmentPopup"
style="padding:10px 20px;border:none;border-radius:8px;background:#6d28d9;color:white;cursor:pointer;font-weight:500;">
➕ Add New Assignment
</button>

</div>

<!-- ASSIGNMENT FLOW -->
<div class="flow">

<!-- MATHEMATICS -->
<div class="subject">
<h2>📐 Mathematics Assignments</h2>

<div class="task">
<h4>Assignment 1: Algebra Practice</h4>
<p>
Solve real-life word problems based on linear equations and algebraic identities.
Explain each step clearly with reasoning.
</p>
<span>Focus: Accuracy, problem-solving, logical steps</span>
</div>

<div class="task">
<h4>Assignment 2: Geometry Workbook</h4>
<p>
Draw and label diagrams for triangles, angles, and circles.
Calculate area and perimeter using correct formulas.
</p>
<span>Focus: Visualization and presentation</span>
</div>
</div>

<!-- SCIENCE -->
<div class="subject">
<h2>🔬 Science Assignments</h2>

<div class="task">
<h4>Physics: Motion in Daily Life</h4>
<p>
Write short notes explaining motion, speed, and velocity with
examples from daily activities like vehicles and sports.
</p>
<span>Focus: Application-based learning</span>
</div>

<div class="task">
<h4>Biology: Human Body Systems</h4>
<p>
Prepare a brief explanation of digestive and respiratory systems
with labeled diagrams and key functions.
</p>
<span>Focus: Understanding and clarity</span>
</div>
</div>

<!-- SOCIAL STUDIES -->
<div class="subject">
<h2>🌍 Social Studies Assignments</h2>

<div class="task">
<h4>History: Freedom Movement</h4>
<p>
Write a short essay on major events of the Indian freedom struggle
and the role of national leaders.
</p>
<span>Focus: Historical awareness and writing skills</span>
</div>

<div class="task">
<h4>Civics: Democratic Values</h4>
<p>
Explain the importance of democracy, rights, and duties of citizens
with suitable examples.
</p>
<span>Focus: Critical thinking and social awareness</span>
</div>
</div>

</div>

<!-- TEACHER ASSIGNMENTS -->
<div class="subject">

<h2>📝 Your Assignments</h2>

<?php if($assignment_result->num_rows > 0){ ?>

<?php while($assignment = $assignment_result->fetch_assoc()){ ?>

<div class="task">

<h4><?php echo htmlspecialchars($assignment['title']); ?></h4>

<p><?php echo htmlspecialchars($assignment['description']); ?></p>

<span>
Status:
<?php
if($assignment['status']=="pending"){
echo "<span style='color:orange;font-weight:600;'>Pending Approval</span>";
}
elseif($assignment['status']=="approved"){
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

<p>No assignments created yet.</p>

<?php } ?>

</div>

<!-- NOTE -->
<div class="note">
<h3>📌 Assignment Guidelines for Teachers</h3>
<p>
• Encourage neat handwriting and structured answers.<br>
• Focus on concept explanation rather than rote answers.<br>
• Allow creativity in presentation and examples.<br>
• Use assignments to assess understanding beyond exams.
</p>
</div>

<!-- ASSIGNMENT POPUP -->

<div id="assignmentPopup"
style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.5);align-items:center;justify-content:center;">

<div style="background:white;padding:25px;border-radius:12px;width:420px;">

<h3>📂 Create Assignment</h3>

<form id="addAssignmentForm">

<input type="text" name="title" placeholder="Assignment Title" required
style="width:100%;margin-bottom:10px;padding:8px;">

<textarea name="description" placeholder="Assignment Description"
required style="width:100%;margin-bottom:10px;padding:8px;"></textarea>

<select name="subject" required
style="width:100%;margin-bottom:10px;padding:8px;">
<option value="">Select Subject</option>
<option value="Mathematics">Mathematics</option>
<option value="Science">Science</option>
<option value="Social Studies">Social Studies</option>
</select>

<button type="submit"
style="padding:8px 16px;background:#6d28d9;color:white;border:none;border-radius:6px;">
Submit Assignment
</button>

<button type="button" id="closeAssignmentPopup"
style="padding:8px 16px;background:#ccc;border:none;border-radius:6px;">
Cancel
</button>

</form>

</div>
</div>

<script>

const assignmentPopup = document.getElementById("assignmentPopup");

document.getElementById("openAssignmentPopup").onclick = () =>{
assignmentPopup.style.display="flex";
}

document.getElementById("closeAssignmentPopup").onclick = () =>{
assignmentPopup.style.display="none";
}

document.getElementById("addAssignmentForm").onsubmit = function(e){

e.preventDefault();

const formData = new FormData(this);

fetch("add_secondary_assignment.php",{
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
