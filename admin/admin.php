<?php
session_start();
$conn = new mysqli("localhost","root","","unified_edu");

if ($conn->connect_error) {
    die("Database connection failed");
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

/* =========================
   USER COUNTS BY LEVEL
========================= */
$levels = ['kindergarten','primary','secondary','highschool','undergraduate','postgraduate'];
$user_counts = [];

foreach ($levels as $level) {

    // students
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE level=? AND role='student'");
    $stmt->bind_param("s", $level);
    $stmt->execute();
    $stmt->bind_result($students);
    $stmt->fetch();
    $stmt->close();

    // teachers
    $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE level=? AND role='teacher'");
    $stmt->bind_param("s", $level);
    $stmt->execute();
    $stmt->bind_result($teachers);
    $stmt->fetch();
    $stmt->close();

    $user_counts[$level] = [
        'students' => $students,
        'teachers' => $teachers
    ];
}

/* =========================
   PENDING CONTENT COUNTS
========================= */

$pending = [];

// assignments
$q = $conn->query("SELECT COUNT(*) as total FROM assignments WHERE status='pending'");
$pending['assignments'] = $q->fetch_assoc()['total'];

// books
$q = $conn->query("SELECT COUNT(*) as total FROM books WHERE status='pending'");
$pending['books'] = $q->fetch_assoc()['total'];

// lessons
$q = $conn->query("SELECT COUNT(*) as total FROM lessons WHERE status='pending'");
$pending['lessons'] = $q->fetch_assoc()['total'];

// primary lessons
$q = $conn->query("SELECT COUNT(*) as total FROM primary_lessons WHERE status='pending'");
$pending['primary_lessons'] = $q->fetch_assoc()['total'];

// quizzes
$q = $conn->query("SELECT COUNT(*) as total FROM quizzes1 WHERE status='pending'");
$pending['quizzes'] = $q->fetch_assoc()['total'];

// projects
$q = $conn->query("SELECT COUNT(*) as total FROM project_topics WHERE status='pending'");
$pending['projects'] = $q->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    margin:0;
    background:linear-gradient(135deg,#eef2ff,#fdf4ff,#ecfeff);
    color:#1e293b;
}

/* HEADER */
.header{
    padding:45px;
    background:linear-gradient(90deg,#6366f1,#ec4899,#22c55e);
    border-bottom-left-radius:45px;
    border-bottom-right-radius:45px;
    color:white;
}

/* CONTAINER */
.container{
    max-width:1400px;
    margin:-60px auto 50px;
    padding:20px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

/* CARD */
.card{
    background:white;
    padding:26px;
    border-radius:26px;
    box-shadow:0 18px 35px rgba(0,0,0,.12);
    transition:.3s;
}
.card:hover{
    transform:translateY(-6px);
}

/* USER CARD */
.user-card{
    text-align:center;
}

/* HORIZONTAL COUNTS */
.count-row{
    display:flex;
    justify-content:space-around;
    align-items:center;
    margin-top:20px;
}

.count-box{
    width:45%;
}

.stat{
    font-size:36px;
    font-weight:800;
}

.student{ color:#2563eb; }
.teacher{ color:#16a34a; }

.label{
    font-size:14px;
    font-weight:600;
    color:#475569;
}

/* CONTENT CARDS */
.manage-card{
    cursor:pointer;
    text-align:center;
    font-size:17px;
    font-weight:700;
}
.manage-card span{
    display:block;
    margin-top:10px;
    font-size:13px;
    font-weight:600;
    color:#475569;
}

.course{border-left:6px solid #6366f1;}
.lesson{border-left:6px solid #22c55e;}
.book{border-left:6px solid #ec4899;}
.assign{border-left:6px solid #f97316;}
.quiz{border-left:6px solid #3b82f6;}
.project{border-left:6px solid #14b8a6;}
.live{border-left:6px solid #f43f5e;}

h2{
    margin:50px 0 22px;
}

.logout-btn{
    background:white;
    color:#1e293b;
    padding:10px 22px;
    border-radius:30px;
    font-weight:700;
    text-decoration:none;
    box-shadow:0 10px 20px rgba(0,0,0,.15);
    transition:.3s;
}

.logout-btn:hover{
    background:#fee2e2;
    color:#b91c1c;
    transform:translateY(-2px);
}

/* POPUP NOTIFICATION */

.popup-overlay{
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
display:flex;
justify-content:center;
align-items:center;
z-index:9999;
}

.popup-box{
background:white;
width:420px;
padding:25px;
border-radius:20px;
box-shadow:0 15px 40px rgba(0,0,0,.3);
animation:popupShow .4s ease;
}

@keyframes popupShow{
from{transform:scale(.8);opacity:0}
to{transform:scale(1);opacity:1}
}

.popup-box h3{
margin-bottom:15px;
}

.notify-item{
display:flex;
justify-content:space-between;
align-items:center;
background:#f1f5f9;
padding:10px 12px;
border-radius:10px;
margin-bottom:8px;
}

.view-btn{
background:#6366f1;
color:white;
padding:6px 12px;
border-radius:8px;
text-decoration:none;
font-size:13px;
font-weight:600;
}

.close-btn{
margin-top:10px;
background:#ef4444;
color:white;
border:none;
padding:8px 15px;
border-radius:10px;
cursor:pointer;
}

</style>
</head>

<body>

<?php
$total_pending = array_sum($pending);
if($total_pending > 0):
?>

<div class="popup-overlay" id="notificationPopup">

<div class="popup-box">

<h3>🔔 Pending Approvals</h3>

<?php if($pending['assignments'] > 0): ?>
<div class="notify-item">
Assignments (<?php echo $pending['assignments']; ?>)
<a href="assignments.php" class="view-btn">View</a>
</div>
<?php endif; ?>

<?php if($pending['books'] > 0): ?>
<div class="notify-item">
Books (<?php echo $pending['books']; ?>)
<a href="books.php" class="view-btn">View</a>
</div>
<?php endif; ?>

<?php if($pending['lessons'] > 0): ?>
<div class="notify-item">
Lessons (<?php echo $pending['lessons']; ?>)
<a href="lesson_notes.php?type=lessons" class="view-btn">View</a>
</div>
<?php endif; ?>

<?php if($pending['primary_lessons'] > 0): ?>
<div class="notify-item">
Primary Lessons (<?php echo $pending['primary_lessons']; ?>)
<a href="lesson_notes.php?type=primary" class="view-btn">View</a>
</div>
<?php endif; ?>

<?php if($pending['quizzes'] > 0): ?>
<div class="notify-item">
Quizzes (<?php echo $pending['quizzes']; ?>)
<a href="quizzes.php" class="view-btn">View</a>
</div>
<?php endif; ?>

<?php if($pending['projects'] > 0): ?>
<div class="notify-item">
Projects (<?php echo $pending['projects']; ?>)
<a href="projects.php" class="view-btn">View</a>
</div>
<?php endif; ?>

<?php if(!empty($pending['live_classes']) && $pending['live_classes'] > 0): ?>
<div class="notify-item">
Live Classes (<?php echo $pending['live_classes']; ?>)
<a href="live_classes.php" class="view-btn">View</a>
</div>
<?php endif; ?>

<button class="close-btn" onclick="closePopup()">Close</button>

</div>
</div>

<?php endif; ?>

<div class="header">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <div>
            <h1>👑 Admin Dashboard</h1>
            <p>Unified Edu – User & Content Management</p>
        </div>

        <a href="../public/logout.php" class="logout-btn">🚪 Logout</a>

    </div>
</div>

<div class="container">

<!-- USERS -->
<h2>📊 Users by Education Level</h2>
<div class="grid">
<?php foreach($user_counts as $level=>$data): ?>
    <div class="card user-card">
        <h3><?php echo ucfirst($level); ?></h3>

        <div class="count-row">
            <div class="count-box">
                <div class="stat student"><?php echo $data['students']; ?></div>
                <div class="label">Students</div>
            </div>

            <div class="count-box">
                <div class="stat teacher"><?php echo $data['teachers']; ?></div>
                <div class="label">Teachers</div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<!-- CONTENT MANAGEMENT -->
<h2>📚 Content Management</h2>
<div class="grid">
    <div class="card manage-card course" onclick="location.href='course.php'">
        📘 Courses
        <span>Add • View • Approve</span>
    </div>

    <div class="card manage-card lesson" onclick="location.href='lesson_notes.php'">
        📝 Lesson Notes
        <span>View • Upload • Approve • Review</span>
    </div>

    <div class="card manage-card book" onclick="location.href='books.php'">
        📕 Book PDFs
        <span>View • Upload • Approve • Review • Download</span>
    </div>

    <div class="card manage-card assign" onclick="location.href='assignments.php'">
        📂 Assignments
        <span>Manage • Assign • Approve • Review</span>
    </div>

    <div class="card manage-card quiz" onclick="location.href='quizzes.php'">
        🧠 Quizzes
        <span>Review • Publish</span>
    </div>

    <div class="card manage-card project" onclick="location.href='projects.php'">
        🚀 Project Topics
        <span>Approve</span>
    </div>

<div class="card manage-card live" onclick="location.href='live_classes.php'">
    🎥 Live Classes
    <span>Schedule • Join • Manage • Monitor</span>
</div>
</div>

</div>

<script>
function closePopup(){
document.getElementById("notificationPopup").style.display="none";
}
</script>
</body>
</html>
