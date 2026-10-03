<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>General Assignments</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#e0f2fe,#f8fafc);
}

.container{
    max-width:1200px;
    margin:40px auto;
    padding:30px;
}

/* HEADER */
.header{
    background:#0f172a;
    color:#fff;
    padding:30px;
    border-radius:18px;
    margin-bottom:35px;
}
.header h2{
    margin:0;
    font-size:28px;
}
.header p{
    color:#cbd5f5;
    margin-top:8px;
}

/* GRID */
.card-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:30px;
}

/* CARD */
.card{
    background:#ffffff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    transition:0.3s;
    position:relative;
    overflow:hidden;
}

.card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    height:5px;
    width:100%;
    background:linear-gradient(90deg,#14b8a6,#6366f1);
}

.card:hover{
    transform:translateY(-8px);
}

.card h3{
    margin:15px 0 10px;
    color:#0f172a;
}

.card p{
    color:#475569;
    font-size:14px;
    line-height:1.5;
}

.icon{
    font-size:36px;
    color:#14b8a6;
}

/* VIEW BUTTON */
.card a{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:18px;
    padding:10px 20px;
    background:#6366f1;
    color:#fff;
    text-decoration:none;
    border-radius:25px;
    font-size:14px;
    transition:0.3s;
}

.card a:hover{
    background:#4f46e5;
}

/* BACK */
.back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:35px;
    color:#0f172a;
    font-weight:600;
    text-decoration:none;
}
.back:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2>📘 General Assignments</h2>
        <p>View assignment details and academic expectations</p>
    </div>

    <div class="card-grid">

        <div class="card">
            <i class="fa-solid fa-brain icon"></i>
            <h3>Critical Thinking Essay</h3>
            <p>Analytical essay focusing on modern education systems and innovations.</p>

            <a href="assignment_view.php?id=essay">
                <i class="fa-solid fa-eye"></i> View Details
            </a>
        </div>

        <div class="card">
            <i class="fa-solid fa-briefcase icon"></i>
            <h3>Case Study Analysis</h3>
            <p>Study and evaluate a real-world academic or industry-related case.</p>

            <a href="assignment_view.php?id=case-study">
                <i class="fa-solid fa-eye"></i> View Details
            </a>
        </div>

        
    </div>

    <a href="../undergraduate_assignments.php" class="back">
        ← Back to Assignments
    </a>

</div>

</body>
</html>
