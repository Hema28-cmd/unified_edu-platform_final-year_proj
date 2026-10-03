<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'Student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Assignments</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f8fafc;}
.wrapper{display:flex;min-height:100vh;}
.sidebar{width:260px;background:#1e293b;color:#fff;padding:30px 20px;}
.sidebar h2{text-align:center;margin-bottom:40px;color:#f59e0b;}
.sidebar a{display:flex;align-items:center;gap:12px;padding:14px 16px;margin-bottom:12px;color:#e5e7eb;text-decoration:none;border-radius:10px;transition:0.3s;}
.sidebar a:hover,.sidebar a.active{background:#334155;color:#f59e0b;}
.sidebar a i{ font-size:18px;}
.sidebar a.logout{background:#dc2626;color:#fff;font-weight:600;}
.sidebar a.logout:hover{background:#b91c1c;}
.main{flex:1;padding:30px;}
.header{background:#fff;padding:20px 30px;border-radius:14px;box-shadow:0 6px 20px rgba(0,0,0,0.08);margin-bottom:30px;}
.header h1{margin:0;font-size:24px;color:#1e293b;}
.header p{margin-top:6px;color:#475569;}
.assignment-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:25px;}
.assignment-card{background:#fff;padding:25px;border-radius:18px;box-shadow:0 8px 20px rgba(0,0,0,0.08);transition:0.3s;}
.assignment-card:hover{transform:translateY(-6px);}
.assignment-card i{font-size:38px;margin-bottom:15px;}
.assignment-card h3{margin-bottom:8px;color:#1e293b;}
.assignment-card p{font-size:14px;color:#475569;margin-bottom:15px;}
.assignment-card a{display:inline-block;padding:8px 18px;background:#1e40af;color:#fff;text-decoration:none;border-radius:20px;font-size:14px;}
.general i{ color:#3b82f6; }
.lab i{ color:#22c55e; }
.project i{ color:#f59e0b; }
.research i{ color:#8b5cf6; }
.presentation i{ color:#ec4899; }
@media(max-width:768px){.wrapper{flex-direction:column;}.sidebar{width:100%;}}
/* MOVE TO NEXT LEVEL BUTTON */
.move-next-btn{
    background: transparent;         /* no background */
    color: #fff;                     /* white text */
    border: 2px solid #fff;          /* white border */
    font-weight:bold;
    justify-content:center;
    border-radius:10px;
    cursor:pointer;
    width:100%;
    text-align:center;
    padding:14px 16px;
    margin-bottom:12px;
    display:flex;
    align-items:center;
    gap:12px;
    font-size:15px;
    transition:0.3s;
}
.move-next-btn:hover{
    background: rgba(255,255,255,0.1);  /* subtle hover effect */
    transform:scale(1.03);
}

</style>
</head>
<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>🎓 Undergraduate</h2>

        <a href="/unified_edu/public/courses/undergraduate_courses.php"><i class="fa-solid fa-book"></i> Courses</a>
	<a class="active"><i class="fa-solid fa-folder-open"></i> Assignments</a>
        <a href="/unified_edu/public/live/undergraduate_live.php"><i class="fa-solid fa-video"></i> Live Classes</a>
        <a href="/unified_edu/public/exams/undergraduate_exams.php"><i class="fa-solid fa-calendar-check"></i> Exams</a>
        <a href="/unified_edu/public/resources/undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="/unified_edu/public/forums/undergraduate_forums.php"><i class="fa-solid fa-comments"></i> Forums</a>
        <a href="/unified_edu/public/certificate/undergraduate_certificate.php"><i class="fa-solid fa-certificate"></i> Certificates</a>

        <!-- Move to Next Level Button -->
<form method="post" action="/unified_edu/public/move_next_under.php">
    <button type="submit" class="move-next-btn">
        <i class="fa-solid fa-arrow-right"></i> Move to Next Level
    </button>
</form>


        <a href="/unified_edu/public/logout.php" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>

   
    <!-- MAIN -->
    <div class="main">

        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($user_name); ?></h1>
            <p>Access and submit assignments, projects, and academic tasks</p>
        </div>

        <div class="assignment-grid">

            <div class="assignment-card general">
    <i class="fa-solid fa-file-lines"></i>
    <h3>General Assignments</h3>
    <p>Regular academic assignments for undergraduate students.</p>
    <a href="/unified_edu/public/assignments/undergraduate/assignment.php">View Assignments</a>
</div>

<div class="assignment-card lab">
    <i class="fa-solid fa-flask"></i>
    <h3>Lab Work</h3>
    <p>Practical and laboratory-based assignments.</p>
    <a href="/unified_edu/public/assignments/undergraduate/labs.php">View Labs</a>
</div>

<div class="assignment-card project">
    <i class="fa-solid fa-diagram-project"></i>
    <h3>Mini & Major Projects</h3>
    <p>Project submissions and evaluations.</p>
    <a href="/unified_edu/public/assignments/undergraduate/projects.php">View Projects</a>
</div>

<div class="assignment-card research">
    <i class="fa-solid fa-book-open-reader"></i>
    <h3>Research Tasks</h3>
    <p>Research papers, reviews, and academic writing.</p>
    <a href="/unified_edu/public/assignments/undergraduate/research.php">View Research</a>
</div>

<div class="assignment-card presentation">
    <i class="fa-solid fa-chalkboard-user"></i>
    <h3>Presentations</h3>
    <p>Seminar, PPT, and presentation-based assignments.</p>
    <a href="/unified_edu/public/assignments/undergraduate/presentations.php">View Topics</a>
</div>

        </div>
    </div>
</div>

</body>
</html>
