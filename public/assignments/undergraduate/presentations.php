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
<title>Presentations | Undergraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: #f3f4f6;
}
.container{
    max-width:1200px;
    margin:50px auto;
    padding:20px;
}
h2{
    text-align:center;
    color:#0f172a;
    font-size:36px;
    margin-bottom:50px;
}
.card-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:30px;
}
.card{
    border-radius:20px;
    padding:25px 20px;
    color:#fff;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    overflow: hidden;
}
.card:hover{
    transform: translateY(-6px);
    box-shadow:0 16px 35px rgba(0,0,0,0.15);
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
    color:#0f172a;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}
.card a:hover{
    background:#e2e8f0;
}

/* Gradient backgrounds for each card */
.card.seminar { background: linear-gradient(135deg, #38bdf8, #0ea5e9); }
.card.technical { background: linear-gradient(135deg, #34d399, #059669); }
.card.demo { background: linear-gradient(135deg, #f472b6, #ec4899); }

/* Back button style */
.back{
    display:inline-block;
    margin-top:40px;
    padding:14px 22px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}
.back:hover{
    background:#dc2626;
}

/* Responsive */
@media (max-width:768px){
    h2{font-size:30px;}
    .card-grid{gap:20px;}
    .card{padding:20px;}
}
@media (max-width:480px){
    h2{font-size:26px;}
    .card h3{font-size:20px;}
    .card p{font-size:14px;}
    .card a{padding:10px 16px;}
}
</style>
</head>
<body>

<div class="container">
<h2>Presentations</h2>

<div class="card-grid">
    <div class="card seminar">
        <h3>Seminar Presentation</h3>
        <p>Prepare a topic-based presentation to discuss concepts or research findings.</p>
        <p><strong>Tips:</strong> Keep slides concise, use visuals, practice your speech.</p>
        <a href="presentation_view.php?task=seminar">View Details</a>
    </div>
    <div class="card technical">
        <h3>Technical PPT</h3>
        <p>Create a technology-focused presentation highlighting processes, tools, or innovations.</p>
        <p><strong>Tips:</strong> Include diagrams, flowcharts, and code snippets if needed.</p>
        <a href="presentation_view.php?task=technical">View Details</a>
    </div>
    <div class="card demo">
        <h3>Project Demo</h3>
        <p>Conduct a live demonstration of your project to showcase functionality and results.</p>
        <p><strong>Tips:</strong> Test everything beforehand, prepare backup, explain features clearly.</p>
        <a href="presentation_view.php?task=demo">View Details</a>
    </div>
</div>

<a href="../undergraduate_assignments.php" class="back">← Back</a>
</div>

</body>
</html>
