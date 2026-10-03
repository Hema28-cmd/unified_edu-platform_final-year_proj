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
<title>Semester Examinations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#f5f3ff,#eef2ff);
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#6d28d9,#4338ca);
    color:#fff;
    padding:50px 20px;
    text-align:center;
}
.header h1{
    margin:0;
    font-size:36px;
}
.header p{
    margin-top:12px;
    font-size:16px;
    opacity:0.95;
}

/* CONTAINER */
.container{
    max-width:1100px;
    margin:55px auto;
    padding:0 20px;
}

/* GRID */
.exam-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:30px;
}

/* CARD */
.exam-card{
    background:#ffffff;
    padding:32px;
    border-radius:26px;
    box-shadow:0 18px 35px rgba(0,0,0,0.12);
    transition:0.3s;
}
.exam-card:hover{
    transform:translateY(-8px);
}

.exam-card h3{
    margin-top:0;
    color:#312e81;
}
.exam-card p{
    color:#475569;
    font-size:15px;
    line-height:1.7;
}
.exam-card ul{
    margin-top:15px;
    padding-left:20px;
    font-size:14px;
    color:#334155;
    line-height:1.7;
}

/* BUTTON */
.exam-card a{
    display:inline-block;
    margin-top:20px;
    padding:11px 28px;
    background:#4f46e5;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-size:14px;
    font-weight:600;
}
.exam-card a:hover{
    background:#4338ca;
}

/* INFO STRIP */
.info-strip{
    margin-top:50px;
    background:#eef2ff;
    border-left:6px solid #6366f1;
    padding:28px;
    border-radius:24px;
    color:#3730a3;
    font-size:15px;
}

/* BACK */
.back{
    display:inline-block;
    margin-top:40px;
    padding:12px 32px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
}
.back:hover{
    background:#dc2626;
}

/* FOOTER */
.footer{
    margin-top:70px;
    text-align:center;
    padding:20px;
    background:#e5e7eb;
    color:#475569;
    font-size:13px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>Semester Examinations</h1>
    <p>Comprehensive evaluation of academic performance</p>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="exam-grid">

        <div class="exam-card">
            <h3>📘 Odd Semester Examination</h3>
            <p>
                The Odd Semester Examination evaluates all subjects taught
                during the first half of the academic year.
            </p>
            <ul>
                <li>Conducted at the end of Semester I / III / V</li>
                <li>Covers complete syllabus of the semester</li>
                <li>University-level evaluation</li>
                <li>Plays a major role in SGPA calculation</li>
            </ul>
            <a href="semester_exam_view.php?type=odd">View Details</a>
        </div>

        <div class="exam-card">
            <h3>📗 Even Semester Examination</h3>
            <p>
                The Even Semester Examination assesses the subjects
                taught during the second half of the academic year.
            </p>
            <ul>
                <li>Conducted at the end of Semester II / IV / VI</li>
                <li>Comprehensive subject coverage</li>
                <li>External evaluation process</li>
                <li>Important for final academic grading</li>
            </ul>
            <a href="semester_exam_view.php?type=even">View Details</a>
        </div>

        <div class="exam-card">
            <h3>📙 Supplementary Examination</h3>
            <p>
                Supplementary exams provide students an opportunity
                to clear backlogs and improve academic standing.
            </p>
            <ul>
                <li>For students with arrears</li>
                <li>Conducted after regular semester exams</li>
                <li>Same syllabus as semester exam</li>
                <li>Improves overall academic record</li>
            </ul>
            <a href="semester_exam_view.php?type=supplementary">View Details</a>
        </div>

    </div>

    <div class="info-strip">
        <strong>Important Academic Note:</strong> Semester examinations are conducted
        as per university regulations. Students must complete all internal
        assessments to be eligible.
    </div>

    <a href="undergraduate_exams.php" class="back">← Back to Exams</a>

</div>

<div class="footer">
    © Unified Edu | Semester Examination Module
</div>

</body>
</html>
