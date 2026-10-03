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
<title>Exam Tips & Strategies</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#f5f3ff,#eef2ff);
}

/* LAYOUT */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#312e81;
    padding:30px 20px;
    color:#e0e7ff;
}

.sidebar h2{
    text-align:center;
    margin-bottom:40px;
    color:#c7d2fe;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    margin-bottom:12px;
    color:#e0e7ff;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:#4338ca;
    color:#facc15;
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
    padding:30px 35px;
    border-radius:20px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    margin-bottom:35px;
}

.header h1{
    margin:0;
    font-size:28px;
    color:#312e81;
}

.header p{
    margin-top:8px;
    color:#475569;
}

/* TIMELINE */
.timeline{
    position:relative;
    max-width:900px;
    margin:auto;
}

.timeline::after{
    content:'';
    position:absolute;
    width:4px;
    background:#6366f1;
    top:0;
    bottom:0;
    left:50%;
    margin-left:-2px;
}

.step{
    padding:20px 40px;
    position:relative;
    width:50%;
}

.step::after{
    content:'';
    position:absolute;
    width:22px;
    height:22px;
    right:-11px;
    background:#ffffff;
    border:4px solid #6366f1;
    top:30px;
    border-radius:50%;
}

.left{
    left:0;
}

.right{
    left:50%;
}

.right::after{
    left:-11px;
}

.step-content{
    background:#ffffff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.step-content h3{
    color:#4338ca;
    margin-bottom:10px;
}

.step-content p{
    font-size:14px;
    color:#475569;
    line-height:1.7;
}

/* STRATEGY CARDS */
.strategy-grid{
    margin-top:50px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}

.strategy{
    background:#ffffff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
    transition:0.3s;
}

.strategy:hover{
    transform:translateY(-6px);
}

.strategy i{
    font-size:36px;
    margin-bottom:12px;
}

.strategy h4{
    color:#312e81;
    margin-bottom:8px;
}

.strategy p{
    font-size:14px;
    color:#475569;
}

/* ICON COLORS */
.icon1{color:#22c55e;}
.icon2{color:#f97316;}
.icon3{color:#0ea5e9;}
.icon4{color:#eab308;}

/* MOBILE */
@media(max-width:768px){
    .wrapper{
        flex-direction:column;
    }
    .timeline::after{
        left:20px;
    }
    .step{
        width:100%;
        padding-left:60px;
        padding-right:25px;
    }
    .right{
        left:0;
    }
    .step::after{
        left:9px;
    }
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>📘 Exam Help</h2>
        <a href="undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="study_planner.php"><i class="fa-solid fa-calendar"></i> Study Planner</a>
        <a class="active"><i class="fa-solid fa-lightbulb"></i> Exam Tips</a>
        <a href="sample_assignments.php"><i class="fa-solid fa-file-lines"></i> Assignments</a>
        <a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="header">
            <h1>Exam Tips & Smart Strategies</h1>
            <p>Learn how to prepare, revise, and perform confidently in examinations</p>
        </div>

        <!-- TIMELINE -->
        <div class="timeline">

            <div class="step left">
                <div class="step-content">
                    <h3>📅 Before the Exam</h3>
                    <p>
                        Plan your syllabus early, revise notes regularly, solve previous question papers,
                        and focus more on high-weightage topics.
                    </p>
                </div>
            </div>

            <div class="step right">
                <div class="step-content">
                    <h3>🧠 During Preparation</h3>
                    <p>
                        Use active learning techniques such as self-testing, teaching others, and concept mapping.
                        Avoid last-minute cramming.
                    </p>
                </div>
            </div>

            <div class="step left">
                <div class="step-content">
                    <h3>📝 On Exam Day</h3>
                    <p>
                        Stay calm, read questions carefully, manage time wisely, and attempt easier questions first
                        to build confidence.
                    </p>
                </div>
            </div>

            <div class="step right">
                <div class="step-content">
                    <h3>📊 After the Exam</h3>
                    <p>
                        Analyze your mistakes, note weak areas, and adjust your study plan for upcoming exams.
                    </p>
                </div>
            </div>

        </div>

        <!-- STRATEGY CARDS -->
        <div class="strategy-grid">

            <div class="strategy">
                <i class="fa-solid fa-stopwatch icon1"></i>
                <h4>Time Management</h4>
                <p>Divide time based on marks and difficulty level. Never spend too long on a single question.</p>
            </div>

            <div class="strategy">
                <i class="fa-solid fa-pen-to-square icon2"></i>
                <h4>Answer Writing</h4>
                <p>Write clearly, use headings and diagrams, and underline key points to gain examiner attention.</p>
            </div>

            <div class="strategy">
                <i class="fa-solid fa-brain icon3"></i>
                <h4>Memory Techniques</h4>
                <p>Use mnemonics, charts, and short notes for quick revision before exams.</p>
            </div>

            <div class="strategy">
                <i class="fa-solid fa-heart icon4"></i>
                <h4>Health & Focus</h4>
                <p>Maintain proper sleep, hydration, and a balanced diet to stay focused and energetic.</p>
            </div>

        </div>

    </div>
</div>

</body>
</html>
