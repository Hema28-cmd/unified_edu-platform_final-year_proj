<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: dashboard.php");
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'Student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Dashboard</title>
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

.sidebar a, .sidebar .move-next-btn{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    margin-bottom:12px;
    color:#e5e7eb;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
    font-size:15px;
}

.sidebar a:hover, .sidebar .move-next-btn:hover{
    background:#334155;
    color:#f59e0b;
}

.sidebar a i, .sidebar .move-next-btn i{
    font-size:18px;
}

/* MOVE TO NEXT LEVEL BUTTON */
.move-next-btn{
    background:linear-gradient(90deg,#22c55e,#3b82f6,#f97316);
    color:white;
    font-weight:bold;
    justify-content:center;
    border:none;
    cursor:pointer;
    width:100%;
    text-align:center;
}
.move-next-btn:hover{
    transform:scale(1.05);
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
}

/* LOGOUT */
.logout{
    margin-top:10px;
    display:block;
    background:#ef4444;
    color:#fff;
    text-align:center;
    padding:12px;
    border-radius:25px;
    text-decoration:none;
    font-weight:bold;
}
.logout:hover{
    background:#dc2626;
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
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
}

.header h1{
    font-size:24px;
    color:#1e293b;
}

.header span{
    color:#f59e0b;
}

/* GENERAL CENTER CONTENT */
.dashboard-content{
    margin-top:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:25px;
}

.panel{
    background:#fff;
    padding:25px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.panel h3{
    margin-bottom:15px;
    color:#1e293b;
}

.panel p,
.panel li{
    color:#475569;
    font-size:15px;
    margin-bottom:8px;
}

.panel ul{
    padding-left:20px;
}

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

        <a href="courses/undergraduate_courses.php"><i class="fa-solid fa-book"></i> Courses</a>
        <a href="assignments/undergraduate_assignments.php"><i class="fa-solid fa-pen"></i> Assignments</a>
        <a href="live/undergraduate_live.php"><i class="fa-solid fa-video"></i> Live Classes</a>
        <a href="exams/undergraduate_exams.php"><i class="fa-solid fa-calendar-check"></i> Exams</a>
        <a href="resources/undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="forums/undergraduate_forums.php"><i class="fa-solid fa-comments"></i> Forums</a>
        <a href="certificate/undergraduate_certificate.php"><i class="fa-solid fa-certificate"></i> Certificates</a>

        <!-- Move to Next Level Button -->
<form method="post" action="move_next_under.php">
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

        <!-- HEADER -->
        <div class="header">
            <h1>Welcome, <span><?php echo htmlspecialchars($user_name); ?></span></h1>
            <p>Undergraduate Dashboard</p>
        </div>

        <!-- GENERAL CENTER CONTENT -->
        <div class="dashboard-content">

            <div class="panel">
                <h3>ℹ️ Platform Overview</h3>
                <p>This dashboard provides access to courses, assignments, live sessions, resources, and discussion forums.</p>
                <p>Use the left navigation panel to explore available sections.</p>
            </div>

            <div class="panel">
                <h3>🛠 System Updates</h3>
                <ul>
                    <li>New learning resources added regularly</li>
                    <li>Improved assignment submission system</li>
                    <li>Live class performance enhancements</li>
                </ul>
            </div>

            <div class="panel">
                <h3>📘 Learning Tips</h3>
                <ul>
                    <li>Review course materials frequently</li>
                    <li>Participate in discussion forums</li>
                    <li>Manage time effectively for assignments</li>
                </ul>
            </div>

            <div class="panel">
                <h3>🆘 Help & Support</h3>
                <p>For technical assistance or queries, please contact the system administrator or refer to the help section.</p>
                <p>Ensure you log out after completing your session.</p>
            </div>

        </div>
    </div>
</div>

</body>
</html>
