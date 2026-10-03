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
<title>Sample Assignments</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#f8fafc);
}

/* LAYOUT */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#0f172a;
    color:#e5e7eb;
    padding:30px 20px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:40px;
    color:#38bdf8;
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
    background:#1e293b;
    color:#38bdf8;
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
    border-radius:22px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    margin-bottom:35px;
}

.header h1{
    margin:0;
    font-size:28px;
    color:#0f172a;
}

.header p{
    margin-top:8px;
    color:#475569;
}

/* CATEGORY GRID */
.category-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
    margin-bottom:50px;
}

.category-card{
    background:#ffffff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.3s;
}

.category-card:hover{
    transform:translateY(-6px);
}

.category-card i{
    font-size:38px;
    margin-bottom:12px;
}

.category-card h3{
    margin-bottom:8px;
    color:#0f172a;
}

.category-card p{
    font-size:14px;
    color:#475569;
}

/* ICON COLORS */
.math{color:#3b82f6;}
.physics{color:#22c55e;}
.chem{color:#f97316;}
.cs{color:#8b5cf6;}

/* ASSIGNMENT LIST */
.assignment-section{
    background:#ffffff;
    padding:30px;
    border-radius:22px;
    box-shadow:0 12px 28px rgba(0,0,0,0.08);
}

.assignment-section h2{
    margin-bottom:20px;
    color:#0f172a;
}

.assignment{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 18px;
    border-bottom:1px solid #e5e7eb;
}

.assignment:last-child{
    border-bottom:none;
}

.assignment-info h4{
    margin:0;
    color:#0f172a;
}

.assignment-info p{
    margin:4px 0 0;
    font-size:13px;
    color:#475569;
}

.assignment span{
    background:#e0f2fe;
    color:#0369a1;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
}

/* MOBILE */
@media(max-width:768px){
    .wrapper{
        flex-direction:column;
    }
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>📂 Resources</h2>
        <a href="undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="study_planner.php"><i class="fa-solid fa-calendar"></i> Study Planner</a>
        <a href="exam_tips.php"><i class="fa-solid fa-lightbulb"></i> Exam Tips</a>
        <a class="active"><i class="fa-solid fa-file-lines"></i> Sample Assignments</a>
        <a href="../logout.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="header">
            <h1>Sample Assignments</h1>
            <p>Explore reference assignments to understand structure, formatting, and expectations</p>
        </div>

        <!-- CATEGORIES -->
        <div class="category-grid">

            <div class="category-card">
                <i class="fa-solid fa-calculator math"></i>
                <h3>Mathematics</h3>
                <p>Problem-solving, derivations, and numerical analysis assignments.</p>
            </div>

            <div class="category-card">
                <i class="fa-solid fa-atom physics"></i>
                <h3>Physics</h3>
                <p>Conceptual questions, experiments, and numerical-based assignments.</p>
            </div>

            <div class="category-card">
                <i class="fa-solid fa-flask chem"></i>
                <h3>Chemistry</h3>
                <p>Reaction mechanisms, equations, and lab-based reports.</p>
            </div>

            <div class="category-card">
                <i class="fa-solid fa-code cs"></i>
                <h3>Computer Science</h3>
                <p>Programming tasks, algorithms, and mini-project documentation.</p>
            </div>

        </div>

        <!-- ASSIGNMENT LIST -->
        <div class="assignment-section">
            <h2>Available Sample Assignments</h2>

            <div class="assignment">
                <div class="assignment-info">
                    <h4>Calculus – Differentiation Assignment</h4>
                    <p>Step-by-step solutions and graph-based explanation</p>
                </div>
                <span>Mathematics</span>
            </div>

            <div class="assignment">
                <div class="assignment-info">
                    <h4>Newton’s Laws – Numerical Problems</h4>
                    <p>Application-based physics problems with answers</p>
                </div>
                <span>Physics</span>
            </div>

            <div class="assignment">
                <div class="assignment-info">
                    <h4>Organic Chemistry – Reaction Mechanisms</h4>
                    <p>Detailed explanation of organic reactions</p>
                </div>
                <span>Chemistry</span>
            </div>

            <div class="assignment">
                <div class="assignment-info">
                    <h4>Sorting Algorithms – Analysis Report</h4>
                    <p>Time complexity and code explanation</p>
                </div>
                <span>Computer Science</span>
            </div>

            <div class="assignment">
                <div class="assignment-info">
                    <h4>Mini Project Documentation Sample</h4>
                    <p>Format, diagrams, and evaluation criteria</p>
                </div>
                <span>General</span>
            </div>

        </div>

    </div>
</div>

</body>
</html>
