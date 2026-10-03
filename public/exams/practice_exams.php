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
<title>Practice Examinations</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#ecfdf5,#f8fafc);
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#047857,#065f46);
    color:#fff;
    padding:50px 20px;
    text-align:center;
}
.header h1{
    margin:0;
    font-size:36px;
}
.header p{
    margin-top:10px;
    font-size:16px;
    opacity:0.95;
}

/* CONTAINER */
.container{
    max-width:1100px;
    margin:55px auto;
    padding:0 20px;
}

/* INTRO */
.intro{
    background:#ffffff;
    padding:32px;
    border-radius:26px;
    box-shadow:0 14px 30px rgba(0,0,0,0.1);
    margin-bottom:40px;
}
.intro h2{
    color:#065f46;
    margin-top:0;
}
.intro p{
    color:#475569;
    line-height:1.7;
}

/* GRID */
.practice-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

/* CARD */
.practice-card{
    background:#ffffff;
    padding:30px;
    border-radius:24px;
    box-shadow:0 12px 28px rgba(0,0,0,0.1);
    transition:0.3s;
}
.practice-card:hover{
    transform:translateY(-8px);
}
.practice-card h3{
    margin-top:0;
    color:#047857;
}
.practice-card p{
    font-size:14px;
    color:#475569;
    line-height:1.6;
}
.practice-card ul{
    margin-top:14px;
    padding-left:18px;
    font-size:14px;
    color:#334155;
    line-height:1.6;
}
.practice-card a{
    display:inline-block;
    margin-top:18px;
    padding:10px 26px;
    background:#059669;
    color:#fff;
    text-decoration:none;
    border-radius:26px;
    font-weight:600;
    font-size:14px;
}
.practice-card a:hover{
    background:#047857;
}

/* INFO STRIP */
.info-strip{
    margin-top:45px;
    background:#d1fae5;
    border-left:6px solid #059669;
    padding:26px;
    border-radius:22px;
    color:#065f46;
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
    border-radius:28px;
    font-weight:600;
}
.back:hover{
    background:#dc2626;
}

/* FOOTER */
.footer{
    margin-top:70px;
    padding:18px;
    text-align:center;
    background:#e5e7eb;
    color:#475569;
    font-size:13px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>Practice Examinations</h1>
    <p>Self-evaluation and academic preparation before final exams</p>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="intro">
        <h2>📘 Why Practice Exams?</h2>
        <p>
            Practice examinations are designed to help students assess their
            preparation level, identify weak areas, and improve confidence
            before appearing for internal and semester examinations.
        </p>
    </div>

    <div class="practice-grid">

        <div class="practice-card">
            <h3>📗 Subject-wise Practice</h3>
            <p>
                Focused practice tests designed for each subject to strengthen
                understanding and improve problem-solving skills.
            </p>
            <ul>
                <li>Chapter-based questions</li>
                <li>Multiple difficulty levels</li>
                <li>Concept clarity improvement</li>
            </ul>
            
        </div>

        <div class="practice-card">
            <h3>📝 Mock Examinations</h3>
            <p>
                Simulated exam environment to help students experience
                real examination conditions.
            </p>
            <ul>
                <li>Time-based practice</li>
                <li>University exam pattern</li>
                <li>Performance analysis</li>
            </ul>
            <a href="mock_test.php">Take Mock Test</a>
        </div>

        <div class="practice-card">
            <h3>📊 Performance Review</h3>
            <p>
                Analyze your performance through structured evaluation
                and improve accordingly.
            </p>
            <ul>
                <li>Identify strengths & weaknesses</li>
                <li>Score-based insights</li>
                <li>Continuous improvement</li>
            </ul>
            <a href="practice_report.php">View Report</a>
        </div>

        <div class="practice-card">
            <h3>🎯 Targeted Preparation</h3>
            <p>
                Customized practice recommendations based on academic
                progress and previous exam performance.
            </p>
            <ul>
                <li>Personalized suggestions</li>
                <li>Focused revision</li>
                <li>Better exam readiness</li>
            </ul>
            <a href="targeted_preparation.php">Prepare Now</a>
        </div>

    </div>

    <div class="info-strip">
        <strong>Academic Tip:</strong> Regular practice helps improve
        time management, accuracy, and confidence during examinations.
    </div>

    <a href="undergraduate_exams.php" class="back">
        ← Back to Exams
    </a>

</div>

<div class="footer">
    © Unified Edu | Practice Examination Module
</div>

</body>
</html>
