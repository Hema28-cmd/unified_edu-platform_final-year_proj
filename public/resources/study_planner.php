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
<title>Study Planner</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#f0fdfa);
}

/* LAYOUT */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#064e3b;
    padding:30px 20px;
    color:#ecfeff;
}

.sidebar h2{
    text-align:center;
    margin-bottom:40px;
    color:#34d399;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    margin-bottom:12px;
    color:#d1fae5;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a.active,
.sidebar a:hover{
    background:#065f46;
    color:#6ee7b7;
}

.sidebar a.logout{
    background:#991b1b;
    color:#fff;
}

/* MAIN */
.main{
    flex:1;
    padding:35px;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:25px 35px;
    border-radius:18px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.header h1{
    margin:0;
    font-size:26px;
    color:#064e3b;
}

.header p{
    margin-top:6px;
    color:#475569;
}

/* PLANNER SECTIONS */
.planner-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

.planner-card{
    background:#ffffff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
    transition:0.3s;
}

.planner-card:hover{
    transform:translateY(-6px);
}

.planner-card h3{
    margin-bottom:12px;
    color:#065f46;
}

.planner-card ul{
    padding-left:18px;
    color:#475569;
    font-size:14px;
    line-height:1.8;
}

.planner-card i{
    font-size:38px;
    margin-bottom:15px;
}

/* ICON COLORS */
.daily i{ color:#22c55e; }
.weekly i{ color:#14b8a6; }
.monthly i{ color:#0ea5e9; }
.tips i{ color:#f59e0b; }

/* SCHEDULE TABLE */
.schedule{
    margin-top:35px;
    background:#ffffff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

.schedule h2{
    color:#064e3b;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:14px;
    text-align:center;
    border-bottom:1px solid #e5e7eb;
}

th{
    background:#d1fae5;
    color:#065f46;
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
</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>📘 Planner</h2>
        <a href="undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a class="active"><i class="fa-solid fa-calendar"></i> Study Planner</a>
        <a href="exam_tips.php"><i class="fa-solid fa-lightbulb"></i> Exam Tips</a>
        <a href="sample_assignments.php"><i class="fa-solid fa-file-lines"></i> Assignments</a>
        <a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="header">
            <h1>Study Planner</h1>
            <p>Organize your daily, weekly, and monthly study schedule effectively</p>
        </div>

        <div class="planner-grid">

            <div class="planner-card daily">
                <i class="fa-solid fa-clock"></i>
                <h3>Daily Planner</h3>
                <ul>
                    <li>Revise previous day topics</li>
                    <li>Attend lectures & practicals</li>
                    <li>Practice numerical & coding problems</li>
                    <li>Short revision before sleep</li>
                </ul>
            </div>

            <div class="planner-card weekly">
                <i class="fa-solid fa-calendar-week"></i>
                <h3>Weekly Planner</h3>
                <ul>
                    <li>Complete weekly syllabus targets</li>
                    <li>Revise difficult concepts</li>
                    <li>Take at least one mock test</li>
                    <li>Analyze mistakes and improve</li>
                </ul>
            </div>

            <div class="planner-card monthly">
                <i class="fa-solid fa-calendar-days"></i>
                <h3>Monthly Planner</h3>
                <ul>
                    <li>Finish all core topics</li>
                    <li>Work on mini-projects</li>
                    <li>Prepare assignments early</li>
                    <li>Evaluate overall performance</li>
                </ul>
            </div>

            <div class="planner-card tips">
                <i class="fa-solid fa-brain"></i>
                <h3>Smart Study Tips</h3>
                <ul>
                    <li>Use Pomodoro technique</li>
                    <li>Study actively, not passively</li>
                    <li>Revise regularly</li>
                    <li>Maintain healthy sleep cycle</li>
                </ul>
            </div>

        </div>

        <!-- SAMPLE TIMETABLE -->
        <div class="schedule">
            <h2>Sample Daily Study Schedule</h2>

            <table>
                <tr>
                    <th>Time</th>
                    <th>Activity</th>
                </tr>
                <tr>
                    <td>6:00 – 7:00 AM</td>
                    <td>Revision / Reading</td>
                </tr>
                <tr>
                    <td>9:00 – 4:00 PM</td>
                    <td>College / Lectures</td>
                </tr>
                <tr>
                    <td>6:00 – 8:00 PM</td>
                    <td>Assignments & Practice</td>
                </tr>
                <tr>
                    <td>9:00 – 10:00 PM</td>
                    <td>Revision & Planning</td>
                </tr>
            </table>
        </div>

    </div>
</div>

</body>
</html>
