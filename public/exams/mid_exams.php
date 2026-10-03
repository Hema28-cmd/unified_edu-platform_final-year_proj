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
<title>Mid-Term Examinations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#fffbeb);
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#0f766e,#f59e0b);
    color:#ffffff;
    padding:45px 20px;
    text-align:center;
}
.header h1{
    margin:0;
    font-size:34px;
}
.header p{
    margin-top:12px;
    font-size:16px;
    opacity:0.95;
}

/* CONTAINER */
.container{
    max-width:1000px;
    margin:55px auto;
    padding:0 20px;
}

/* TIMELINE */
.timeline{
    position:relative;
    padding-left:30px;
}
.timeline::before{
    content:'';
    position:absolute;
    left:8px;
    top:0;
    bottom:0;
    width:4px;
    background:#0f766e;
    border-radius:5px;
}

/* ITEM */
.item{
    position:relative;
    background:#ffffff;
    margin-bottom:30px;
    padding:30px;
    border-radius:24px;
    box-shadow:0 15px 30px rgba(0,0,0,0.12);
}
.item::before{
    content:'';
    position:absolute;
    left:-37px;
    top:35px;
    width:22px;
    height:22px;
    background:#f59e0b;
    border-radius:50%;
    border:4px solid #0f766e;
}
.item h3{
    margin-top:0;
    color:#1e293b;
}
.item p{
    color:#475569;
    font-size:15px;
    line-height:1.7;
}
.item ul{
    margin-top:15px;
    padding-left:20px;
    color:#334155;
    font-size:14px;
    line-height:1.7;
}

/* BUTTON */
.item a{
    display:inline-block;
    margin-top:20px;
    padding:10px 26px;
    background:#0f766e;
    color:#ffffff;
    text-decoration:none;
    border-radius:30px;
    font-size:14px;
    font-weight:600;
}
.item a:hover{
    background:#115e59;
}

/* NOTE */
.note{
    margin-top:55px;
    background:#fffbeb;
    border-left:6px solid #f59e0b;
    padding:25px;
    border-radius:22px;
    color:#92400e;
    font-size:15px;
}

/* BACK */
.back{
    display:inline-block;
    margin-top:35px;
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

/* FOOTER */
.footer{
    margin-top:60px;
    text-align:center;
    padding:18px;
    background:#f1f5f9;
    color:#64748b;
    font-size:13px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>Mid-Term Examinations</h1>
    <p>Assess your progress and strengthen your preparation</p>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="timeline">

        <div class="item">
            <h3>📘 Mid-Term Examination I</h3>
            <p>
                Mid-Term I evaluates the student's understanding of the initial units
                taught during the semester.
            </p>
            <ul>
                <li>Covers Units 1 & 2</li>
                <li>Objective & descriptive questions</li>
                <li>Internal assessment contribution</li>
                <li>Helps identify weak areas</li>
            </ul>
            <a href="internal_exam_view.php?exam=mid1">View Details</a>
        </div>

        <div class="item">
            <h3>📗 Mid-Term Examination II</h3>
            <p>
                Mid-Term II focuses on the remaining syllabus and evaluates
                conceptual depth and application skills.
            </p>
            <ul>
                <li>Covers Units 3, 4 & 5</li>
                <li>Analytical and problem-solving questions</li>
                <li>Improves final exam readiness</li>
                <li>Marks considered for internals</li>
            </ul>
            <a href="internal_exam_view.php?exam=mid2">View Details</a>
        </div>

    </div>

    <div class="note">
        <strong>Academic Note:</strong> Mid-term exam performance plays a crucial role in
        internal assessment calculations. Regular preparation is strongly advised.
    </div>

    <a href="undergraduate_exams.php" class="back">← Back to Exams</a>

</div>

<div class="footer">
    © Unified Edu | Mid-Term Examination Module
</div>

</body>
</html>
