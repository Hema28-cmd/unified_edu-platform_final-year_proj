<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

// Get project type from URL
$type = $_GET['type'] ?? 'mini';

// Project details
$project_details = [
    'mini' => [
        'title' => 'Mini Project',
        'description' => 'A small-scale project to demonstrate your understanding of the subject and apply concepts learned in class.',
        'guidelines' => 'Focus on a single concept or simple application. Include a short report with introduction, method, and conclusion.',
        'tips' => 'Keep it simple, document everything clearly, and use diagrams/screenshots to explain your project.',
        'resources' => 'Example: Simple calculator app, weather app, or basic data analysis project.'
    ],
    'major' => [
        'title' => 'Major Project',
        'description' => 'A comprehensive project that requires significant research and practical implementation.',
        'guidelines' => 'Submit a detailed report including research, methodology, implementation, results, and references.',
        'tips' => 'Plan your project in stages, maintain a timeline, and test thoroughly before submission.',
        'resources' => 'Example: E-commerce website, advanced data visualization, or IoT based project.'
    ],
    'group' => [
        'title' => 'Group Project',
        'description' => 'A project done in collaboration with a team of students to solve a larger problem or create a product.',
        'guidelines' => 'Ensure all group members contribute equally. Submit a single report with individual contributions noted.',
        'tips' => 'Communicate regularly with your team, divide tasks clearly, and integrate work properly.',
        'resources' => 'Example: College event management system, collaborative game development.'
    ],
    'research' => [
        'title' => 'Research Based Project',
        'description' => 'A project focused on academic research, literature review, experiments, or studies to contribute new knowledge.',
        'guidelines' => 'Submit a research paper including hypothesis, methodology, results, discussion, and references.',
        'tips' => 'Be thorough with literature review, keep data organized, and cite sources correctly.',
        'resources' => 'Example: AI model evaluation, renewable energy study, or social science survey.'
    ],
    'capstone' => [
        'title' => 'Capstone Project',
        'description' => 'A final year project integrating all your learning to create a real-world solution or product.',
        'guidelines' => 'Submit a comprehensive report and presentation. Include all stages from conception, design, implementation, testing, and conclusion.',
        'tips' => 'Choose a practical problem, integrate multiple skills, and ensure your solution is well-documented.',
        'resources' => 'Example: Smart home automation system, full-stack web application, or machine learning project.'
    ]
];

$details = $project_details[$type] ?? $project_details['mini'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $details['title']; ?> | Undergraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(to right, #f0f4f8, #e0e7ff);
}
.container{
    max-width:900px;
    margin:50px auto;
    padding:20px;
}
.card{
    background:#fff;
    border-radius:20px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
    overflow:hidden;
    margin-bottom:30px;
}
.card-header{
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color:#fff;
    padding:25px;
    text-align:center;
}
.card-header h2{
    margin:0;
    font-size:28px;
}
.card-section{
    padding:25px;
}
.card-section:nth-child(even){
    background:#f9fafb;
}
.card-section h3{
    color:#1e40af;
    margin-bottom:15px;
    font-size:20px;
}
.card-section p{
    color:#475569;
    font-size:16px;
    line-height:1.7;
}
.back{
    display:inline-block;
    margin-top:20px;
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
@media (max-width:600px){
    .card-section{padding:20px;}
    .card-header h2{font-size:24px;}
}
</style>
</head>
<body>

<div class="container">

<div class="card">
    <div class="card-header">
        <h2><?php echo $details['title']; ?></h2>
    </div>
    <div class="card-section">
        <h3>Description</h3>
        <p><?php echo $details['description']; ?></p>
    </div>
    <div class="card-section">
        <h3>Submission Guidelines</h3>
        <p><?php echo $details['guidelines']; ?></p>
    </div>
    <div class="card-section">
        <h3>Tips & Recommendations</h3>
        <p><?php echo $details['tips']; ?></p>
    </div>
    <div class="card-section">
        <h3>Example Resources / References</h3>
        <p><?php echo $details['resources']; ?></p>
    </div>
</div>

<a href="projects.php" class="back">← Back to Projects</a>
</div>

</body>
</html>
