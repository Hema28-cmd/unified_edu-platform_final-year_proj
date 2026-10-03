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
<title>Research Tasks | Undergraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(to right, #e0f2fe, #f0f9ff);
}
.container{
    max-width:1100px;
    margin:40px auto;
    padding:20px;
}
h2{
    text-align:center;
    color:#1e3a8a;
    font-size:34px;
    margin-bottom:40px;
}
.card-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}
.card{
    border-radius:20px;
    padding:25px;
    color:#fff;
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}
.card:hover{
    transform: translateY(-8px);
    box-shadow:0 16px 35px rgba(0,0,0,0.2);
}
.card h3{
    margin-bottom:12px;
    font-size:22px;
}
.card p{
    font-size:15px;
    line-height:1.6;
    margin-bottom:20px;
}
.card a{
    display:inline-block;
    padding:10px 18px;
    background:#fff;
    color:#1e3a8a;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}
.card a:hover{
    background:#e0e7ff;
}
.back{
    display:inline-block;
    margin-top:40px;
    padding:12px 20px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    transition:0.3s;
}
.back:hover{
    background:#dc2626;
}

/* Gradient colors for each card */
.card.lit { background: linear-gradient(135deg, #2563eb, #3b82f6);}
.card.draft { background: linear-gradient(135deg, #059669, #10b981);}
.card.plag { background: linear-gradient(135deg, #b45309, #f59e0b);}
.card.data { background: linear-gradient(135deg, #8b5cf6, #a78bfa);}
.card.presentation { background: linear-gradient(135deg, #e11d48, #f43f5e);}

@media (max-width:600px){
    .card-grid{gap:20px;}
    .card{padding:20px;}
    h2{font-size:28px;}
}
</style>
</head>
<body>

<div class="container">
<h2>Research Tasks</h2>

<div class="card-grid">
    <div class="card lit">
        <h3>Literature Review</h3>
        <p>Survey and summarize existing research related to your topic. Identify gaps and key contributions.</p>
        <a href="research_view.php?task=lit">View Details</a>
    </div>
    <div class="card draft">
        <h3>Research Paper Draft</h3>
        <p>Prepare the first draft of your research paper in IEEE or APA format.</p>
        <a href="research_view.php?task=draft">View Details</a>
    </div>
    <div class="card plag">
        <h3>Plagiarism Check</h3>
        <p>Verify originality of your work using plagiarism checking tools.</p>
        <a href="research_view.php?task=plag">View Details</a>
    </div>
    <div class="card data">
        <h3>Data Collection & Analysis</h3>
        <p>Gather and analyze data required for your research, including surveys, experiments, or secondary data.</p>
        <a href="research_view.php?task=data">View Details</a>
    </div>
    <div class="card presentation">
        <h3>Presentation & Report</h3>
        <p>Prepare final report and presentation slides summarizing your research findings effectively.</p>
        <a href="research_view.php?task=presentation">View Details</a>
    </div>
</div>

<a href="../undergraduate_assignments.php" class="back">← Back</a>
</div>

</body>
</html>
