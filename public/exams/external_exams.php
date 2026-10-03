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
<title>External Examinations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(120deg,#f5f3ff,#ecfeff);
}

/* WRAPPER */
.wrapper{
    max-width:1100px;
    margin:60px auto;
    padding:0 20px;
}

/* HEADER */
.header{
    background:linear-gradient(135deg,#7c3aed,#06b6d4);
    color:#fff;
    padding:35px;
    border-radius:26px;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}
.header h1{
    margin:0;
    font-size:30px;
}
.header p{
    margin-top:10px;
    opacity:0.95;
}

/* SECTION TITLE */
.section-title{
    margin:50px 0 20px;
    font-size:22px;
    color:#1e293b;
}

/* GRID */
.exam-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

/* CARD */
.exam-card{
    background:#fff;
    padding:26px;
    border-radius:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    transition:0.3s;
    position:relative;
    overflow:hidden;
}
.exam-card:hover{
    transform:translateY(-6px);
}
.exam-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:6px;
    height:100%;
    background:#7c3aed;
}
.exam-card h3{
    margin:0 0 10px;
    color:#1e293b;
}
.exam-card p{
    font-size:14px;
    color:#475569;
    line-height:1.6;
}
.exam-card i{
    font-size:36px;
    color:#06b6d4;
    margin-bottom:12px;
}
.exam-card a{
    display:inline-block;
    margin-top:15px;
    padding:10px 22px;
    background:#7c3aed;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
}
.exam-card a:hover{
    background:#6d28d9;
}

/* INFO STRIP */
.info-strip{
    margin-top:50px;
    background:#ffffff;
    padding:30px;
    border-radius:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}
.info-box{
    background:#f8fafc;
    border-left:6px solid #06b6d4;
    padding:18px;
    border-radius:16px;
}
.info-box h4{
    margin:0 0 6px;
    color:#1e293b;
}
.info-box p{
    margin:0;
    font-size:14px;
    color:#475569;
}

/* BACK */
.back{
    display:inline-block;
    margin:40px auto 0;
    padding:12px 30px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
}
.back:hover{
    background:#dc2626;
}

/* CENTER */
.center{
    text-align:center;
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- HEADER -->
    <div class="header">
        <h1>External Examinations</h1>
        <p>
            University-level examinations conducted by the affiliating university
            for undergraduate programs.
        </p>
    </div>

    <!-- EXAMS -->
    <h2 class="section-title">Available External Exams</h2>

    <div class="exam-grid">

        <div class="exam-card">
            <i class="fa-solid fa-graduation-cap"></i>
            <h3>University Semester Exam</h3>
            <p>
                End-semester examination conducted by the university
                covering the complete syllabus.
            </p>
            <a href="external_exam_view.php?type=semester">View Details</a>
        </div>

        <div class="exam-card">
            <i class="fa-solid fa-clipboard-check"></i>
            <h3>Supplementary Exam</h3>
            <p>
                Examination for students who could not clear subjects
                in regular semester exams.
            </p>
            <a href="external_exam_view.php?type=supplementary">View Details</a>
        </div>

        <div class="exam-card">
            <i class="fa-solid fa-rotate-right"></i>
            <h3>Revaluation / Rechecking</h3>
            <p>
                Process to apply for revaluation or rechecking
                of answer scripts.
            </p>
            <a href="external_exam_view.php?type=revaluation">View Details</a>
        </div>

        <div class="exam-card">
            <i class="fa-solid fa-award"></i>
            <h3>Final Degree Examination</h3>
            <p>
                Final examination required for degree completion
                and certification.
            </p>
            <a href="external_exam_view.php?type=final">View Details</a>
        </div>

    </div>

    <!-- INFO STRIP -->
    <div class="info-strip">
        <div class="info-box">
            <h4>Exam Authority</h4>
            <p>Conducted by the affiliating university</p>
        </div>
        <div class="info-box">
            <h4>Evaluation</h4>
            <p>Centralized valuation process</p>
        </div>
        <div class="info-box">
            <h4>Results</h4>
            <p>Published on official university portal</p>
        </div>
        <div class="info-box">
            <h4>Certification</h4>
            <p>Degree awarded after successful completion</p>
        </div>
    </div>

    <!-- BACK -->
    <div class="center">
        <a href="undergraduate_exams.php" class="back">← Back to Exams</a>
    </div>

</div>

</body>
</html>
