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
<title>Internal Exams</title>
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
    color:#22c55e;
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
    color:#22c55e;
}

/* LOGOUT */
.sidebar a.logout{
    background:#dc2626;
    color:#fff;
    font-weight:600;
}

.sidebar a.logout:hover{
    background:#b91c1c;
}

/* MAIN */
.main{
    flex:1;
    padding:30px;
}

/* HEADER */
.header{
    background:#fff;
    padding:22px 30px;
    border-radius:16px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.header h1{
    margin:0;
    font-size:24px;
    color:#1e293b;
}

.header p{
    margin-top:6px;
    color:#475569;
}

/* EXAM GRID */
.exam-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.exam-card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 22px rgba(0,0,0,0.08);
    transition:0.3s;
}

.exam-card:hover{
    transform:translateY(-6px);
}

.exam-card i{
    font-size:42px;
    margin-bottom:16px;
}

.exam-card h3{
    margin-bottom:10px;
    color:#1e293b;
}

.exam-card p{
    font-size:14px;
    color:#475569;
    margin-bottom:18px;
}

.exam-card a{
    display:inline-block;
    padding:9px 20px;
    background:#16a34a;
    color:#fff;
    text-decoration:none;
    border-radius:22px;
    font-size:14px;
}

/* ICON COLORS */
.mid1 i{ color:#3b82f6; }
.mid2 i{ color:#f97316; }
.model i{ color:#8b5cf6; }
.lab i{ color:#ef4444; }
.viva i{ color:#22c55e; }

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
        <h2>📝 Exams</h2>

        <a href="undergraduate_exams.php">
            <i class="fa-solid fa-calendar-check"></i> Exams Home
        </a>

        <a href="internal_exams.php" class="active">
            <i class="fa-solid fa-clipboard-list"></i> Internal Exams
        </a>

        <a href="external_exams.php">
            <i class="fa-solid fa-graduation-cap"></i> External Exams
        </a>

        <a href="../logout.php" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="header">
            <h1>Internal Assessment Exams</h1>
            <p>View and access all internal assessment related exams</p>
        </div>

        <div class="exam-grid">

            <div class="exam-card mid1">
                <i class="fa-solid fa-pen-to-square"></i>
                <h3>Mid-Term Exam 1</h3>
                <p>First internal assessment covering initial units.</p>
                <a href="internal_exam_view.php?exam=mid1">View Details</a>

            </div>

            <div class="exam-card mid2">
                <i class="fa-solid fa-file-pen"></i>
                <h3>Mid-Term Exam 2</h3>
                <p>Second internal exam covering remaining syllabus.</p>
                <a href="internal_exam_view.php?exam=mid2">View Details</a>
            </div>

            <div class="exam-card model">
                <i class="fa-solid fa-file-lines"></i>
                <h3>Model Exam</h3>
                <p>Practice exam conducted before final assessments.</p>
                <a href="internal_exam_view.php?exam=model">View Details</a>
            </div>

            <div class="exam-card lab">
                <i class="fa-solid fa-flask"></i>
                <h3>Internal Lab Exam</h3>
                <p>Lab performance and practical evaluation.</p>
                <a href="internal_exam_view.php?exam=lab">View Details</a>
            </div>

            <div class="exam-card viva">
                <i class="fa-solid fa-comments"></i>
                <h3>Viva / Oral Exam</h3>
                <p>Concept clarity and oral assessment.</p>
                <a href="internal_exam_view.php?exam=viva">View Details</a>
            </div>

        </div>

    </div>
</div>

</body>
</html>
