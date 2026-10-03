<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Exams</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f8fafc;}
.wrapper{display:flex;min-height:100vh;}

/* SIDEBAR */
.sidebar{
    width:260px;background:#1e293b;color:#fff;padding:30px 20px;
}
.sidebar h2{text-align:center;margin-bottom:40px;color:#f59e0b;}
.sidebar a{
    display:flex;align-items:center;gap:12px;
    padding:14px 16px;margin-bottom:12px;
    color:#e5e7eb;text-decoration:none;
    border-radius:10px;transition:0.3s;
}
.sidebar a:hover,.sidebar a.active{
    background:#334155;color:#f59e0b;
}
.sidebar a.logout{
    background:#dc2626;color:#fff;font-weight:600;
}
.sidebar a.logout:hover{background:#b91c1c;}

/* MAIN */
.main{flex:1;padding:30px;}
.header{
    background:#fff;padding:20px 30px;
    border-radius:14px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}
.header h1{margin:0;font-size:24px;color:#1e293b;}
.header p{margin-top:6px;color:#475569;}

/* EXAM GRID */
.exam-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}
.exam-card{
    background:#fff;padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}
.exam-card:hover{transform:translateY(-6px);}
.exam-card i{font-size:40px;margin-bottom:15px;}
.exam-card h3{margin-bottom:10px;color:#1e293b;}
.exam-card p{font-size:14px;color:#475569;margin-bottom:15px;}
.exam-card a{
    display:inline-block;padding:8px 18px;
    background:#1e40af;color:#fff;
    text-decoration:none;border-radius:20px;font-size:14px;
}

/* ICON COLORS */
.internal i{color:#3b82f6;}
.model i{color:#8b5cf6;}
.mid i{color:#f59e0b;}
.semester i{color:#ef4444;}
.practice i{color:#22c55e;}

/* MOBILE */
@media(max-width:768px){
    .wrapper{flex-direction:column;}
    .sidebar{width:100%;}
}
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

        <a href="../courses/undergraduate_courses.php"><i class="fa-solid fa-book"></i> Courses</a>
        <a href="../assignments/undergraduate_assignments.php"><i class="fa-solid fa-pen"></i> Assignments</a>
        <a href="../live/undergraduate_live.php"><i class="fa-solid fa-video"></i> Live Classes</a>
        <a class="active"><i class="fa-solid fa-folder-open"></i> Exam</a>
        <a href="../resources/undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="../forums/undergraduate_forums.php"><i class="fa-solid fa-comments"></i> Forums</a>
        <a href="../certificate/undergraduate_certificate.php"><i class="fa-solid fa-certificate"></i> Certificates</a>

        <!-- Move to Next Level Button -->
<form method="post" action="../move_next_under.php">
    <button type="submit" class="move-next-btn">
        <i class="fa-solid fa-arrow-right"></i> Move to Next Level
    </button>
</form>


        <a href="../logout.php" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>


<!-- MAIN -->
<div class="main">

    <div class="header">
        <h1>Undergraduate Examinations</h1>
        <p>Select an exam category to proceed</p>
    </div>

    <div class="exam-grid">

        <div class="exam-card internal">
            <i class="fa-solid fa-file-circle-check"></i>
            <h3>Internal Assessments</h3>
            <p>Continuous internal evaluation exams.</p>
            <a href="internal_exams.php">View Exams</a>
        </div>

        <div class="exam-card model">
            <i class="fa-solid fa-clipboard-list"></i>
            <h3>Model Exams</h3>
            <p>Model question papers for preparation.</p>
            <a href="model_exams.php">View Exams</a>
        </div>

        <div class="exam-card mid">
            <i class="fa-solid fa-pen-to-square"></i>
            <h3>Mid Term Exams</h3>
            <p>Mid semester assessments.</p>
            <a href="mid_exams.php">View Exams</a>
        </div>

        <div class="exam-card semester">
            <i class="fa-solid fa-graduation-cap"></i>
            <h3>Semester Exams</h3>
            <p>University end semester exams.</p>
            <a href="semester_exams.php">View Exams</a>
        </div>

        <div class="exam-card practice">
            <i class="fa-solid fa-book-open"></i>
            <h3>Practice Tests</h3>
            <p>Self practice and revision tests.</p>
            <a href="practice_exams.php">Start Practice</a>
        </div>

    </div>
</div>

</div>
</body>
</html>
