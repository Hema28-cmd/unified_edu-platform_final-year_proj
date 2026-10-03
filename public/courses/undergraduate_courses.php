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
<title>Undergraduate Courses</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f8fafc;
}

/* LAYOUT */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#1e293b;
    color:#fff;
    padding:30px 20px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:40px;
    color:#f59e0b;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    margin-bottom:12px;
    color:#e5e7eb;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:#334155;
    color:#f59e0b;
}

/* LOGOUT BUTTON (DIFFERENT COLOR) */
.sidebar a.logout{
    background:#dc2626;
    color:#fff;
    font-weight:600;
}

.sidebar a.logout:hover{
    background:#b91c1c;
    color:#fff;
}

/* MAIN */
.main{
    flex:1;
    padding:30px;
}

/* HEADER */
.header{
    background:#fff;
    padding:20px 30px;
    border-radius:14px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.header h1{
    margin:0;
    font-size:24px;
    color:#1e293b;
}

/* COURSE GRID */
.course-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.course-card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.course-card:hover{
    transform:translateY(-6px);
}

.course-card i{
    font-size:40px;
    margin-bottom:15px;
}

.course-card h3{
    margin-bottom:10px;
    color:#1e293b;
}

.course-card p{
    font-size:14px;
    color:#475569;
    margin-bottom:15px;
}

.course-card a{
    display:inline-block;
    padding:8px 18px;
    background:#1e40af;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:14px;
}

/* ICON COLORS */
.cs i{ color:#3b82f6; }
.mech i{ color:#ef4444; }
.civil i{ color:#f59e0b; }
.ece i{ color:#22c55e; }
.medical i{ color:#ec4899; }
.management i{ color:#8b5cf6; }

/* MOBILE */
@media(max-width:768px){
    .wrapper{
        flex-direction:column;
    }
    .sidebar{
        width:100%;
    }
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

	<a class="active"><i class="fa-solid fa-folder-open"></i> Courses</a>
        <a href="../assignments/undergraduate_assignments.php"><i class="fa-solid fa-pen"></i> Assignments</a>
        <a href="../live/undergraduate_live.php"><i class="fa-solid fa-video"></i> Live Classes</a>
        <a href="../exams/undergraduate_exams.php"><i class="fa-solid fa-calendar-check"></i> Exams</a>
        <a href="../resources/undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="../forums/undergraduate_forums.php"><i class="fa-solid fa-comments"></i> Forums</a>
        <a href="../certificate/undergraduate_certificate.php"><i class="fa-solid fa-certificate"></i> Certificates</a>

        <!-- Move to Next Level Button -->
<form method="post" action="../move_next_under.php">
    <button type="submit" class="move-next-btn">
        <i class="fa-solid fa-arrow-right"></i> Move to Next Level
    </button>
</form>


        <a href="logout.php" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>


    <!-- MAIN -->
    <div class="main">

        <div class="header">
            <h1>Undergraduate Course Categories</h1>
            <p>Select a course category to explore available programs</p>
        </div>

        <div class="course-grid">

            <div class="course-card cs">
                <i class="fa-solid fa-code"></i>
                <h3>Computer Science</h3>
                <p>Programming, software development, data, and AI fundamentals.</p>
                <a href="undergraduate_course_list.php?category=computer_science">View Courses</a>
            </div>

            <div class="course-card mech">
                <i class="fa-solid fa-gears"></i>
                <h3>Mechanical Engineering</h3>
                <p>Design, manufacturing, thermal and mechanical systems.</p>
                <a href="undergraduate_course_list.php?category=mechanical">View Courses</a>
            </div>

            <div class="course-card civil">
                <i class="fa-solid fa-building"></i>
                <h3>Civil Engineering</h3>
                <p>Construction, structures, surveying, and infrastructure.</p>
                <a href="undergraduate_course_list.php?category=civil">View Courses</a>
            </div>

            <div class="course-card ece">
                <i class="fa-solid fa-microchip"></i>
                <h3>Electronics & Communication</h3>
                <p>Electronics, communication systems, and signal processing.</p>
                <a href="undergraduate_course_list.php?category=ece">View Courses</a>
            </div>

            <div class="course-card medical">
                <i class="fa-solid fa-user-doctor"></i>
                <h3>Medical & Health Sciences</h3>
                <p>Healthcare, diagnostics, and medical science basics.</p>
                <a href="undergraduate_course_list.php?category=medical">View Courses</a>
            </div>

            <div class="course-card management">
                <i class="fa-solid fa-chart-line"></i>
                <h3>Management & Commerce</h3>
                <p>Business management, finance, marketing, and economics.</p>
                <a href="undergraduate_course_list.php?category=management">View Courses</a>
            </div>

        </div>
    </div>
</div>

</body>
</html>
