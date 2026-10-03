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
<title>Model Examinations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#eef2ff,#ecfeff);
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#4338ca,#0f766e);
    color:#fff;
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
    max-width:1100px;
    margin:50px auto;
    padding:0 20px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:28px;
}

/* CARD */
.card{
    background:#ffffff;
    border-radius:26px;
    padding:28px;
    box-shadow:0 15px 30px rgba(0,0,0,0.12);
    position:relative;
    overflow:hidden;
}
.card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:linear-gradient(90deg,#4f46e5,#14b8a6);
}
.card h3{
    margin-top:10px;
    color:#1e293b;
}
.card p{
    color:#475569;
    font-size:15px;
    line-height:1.6;
    margin:15px 0;
}
.card ul{
    padding-left:18px;
    color:#334155;
    font-size:14px;
    line-height:1.7;
}

/* BUTTON */
.card a{
    display:inline-block;
    margin-top:20px;
    padding:11px 26px;
    background:#4f46e5;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-size:14px;
    font-weight:600;
}
.card a:hover{
    background:#4338ca;
}

/* NOTICE */
.notice{
    margin-top:60px;
    background:#f0fdfa;
    border-left:6px solid #14b8a6;
    padding:25px;
    border-radius:22px;
    color:#065f46;
    font-size:15px;
}

/* BACK */
.back{
    margin-top:35px;
    display:inline-block;
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
    <h1>Model Examinations</h1>
    <p>Prepare, Practice & Perform better before your final university exams</p>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="grid">

        <div class="card">
            <h3>📘 Theory Model Exam</h3>
            <p>
                Model theory exams simulate the actual university question paper pattern
                to help students evaluate their preparation.
            </p>
            <ul>
                <li>Full syllabus coverage</li>
                <li>University-level questions</li>
                <li>Time-bound assessment</li>
                <li>Performance analysis</li>
            </ul>
            <a href="internal_exam_view.php?exam=model">View Details</a>
        </div>

        <div class="card">
            <h3>🔬 Practical Model Exam</h3>
            <p>
                Practical model exams focus on laboratory skills, accuracy, and execution
                under exam conditions.
            </p>
            <ul>
                <li>Experiment-based evaluation</li>
                <li>Record verification</li>
                <li>Viva preparation</li>
                <li>Improves lab confidence</li>
            </ul>
            <a href="internal_exam_view.php?exam=lab">View Details</a>
        </div>

        <div class="card">
            <h3>🗣️ Viva Model Exam</h3>
            <p>
                Viva model exams help students strengthen conceptual clarity
                and communication skills.
            </p>
            <ul>
                <li>Concept-oriented questions</li>
                <li>Faculty interaction</li>
                <li>Confidence building</li>
                <li>Final revision support</li>
            </ul>
            <a href="internal_exam_view.php?exam=viva">View Details</a>
        </div>

    </div>

    <div class="notice">
        <strong>Important:</strong> Model exams are mandatory for all undergraduate students.
        Attendance and performance may be considered for internal assessment improvements.
    </div>

    <a href="undergraduate_exams.php" class="back">← Back to Exams</a>

</div>

<div class="footer">
    © Unified Edu | Model Examination Portal
</div>

</body>
</html>
