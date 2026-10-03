<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'ai';

/* ✅ PROJECTS DATA FOR ALL COURSES */
$all_projects = [
    'ai' => [
        ['title' => 'AI Chatbot Development','description' => 'Develop a chatbot capable of answering student queries using NLP.','duration' => '3 Months'],
        
        ['title' => 'Predictive Analytics for Student Performance','description' => 'Analyze student data to predict academic outcomes using AI.','duration' => '4 Months']
    ],
    'ml' => [
        ['title' => 'ML Model for Stock Prediction','description' => 'Build a regression model to predict stock prices using historical data.','duration' => '3 Months'],
        ['title' => 'Image Classification with CNN','description' => 'Implement convolutional neural networks to classify images into categories.','duration' => '4 Months'],
        ['title' => 'Recommendation System Development','description' => 'Create a machine learning based recommendation engine for e-commerce.','duration' => '5 Months']
    ],
    'cyber' => [
        ['title' => 'Network Penetration Testing','description' => 'Simulate attacks on network systems to identify vulnerabilities.','duration' => '3 Months'],
        ['title' => 'Cybersecurity Risk Assessment','description' => 'Evaluate and mitigate security risks in enterprise systems.','duration' => '4 Months'],
        ['title' => 'Secure Coding Practices','description' => 'Develop secure software by applying coding best practices.','duration' => '2 Months']
    ],
    'data' => [
        ['title' => 'Data Cleaning & Preprocessing','description' => 'Prepare datasets for analysis and modeling.','duration' => '2 Months'],
        ['title' => 'Exploratory Data Analysis','description' => 'Visualize and analyze datasets to find patterns and insights.','duration' => '3 Months'],
        ['title' => 'Data Pipeline Automation','description' => 'Automate data collection, cleaning, and storage processes.','duration' => '4 Months']
    ],
    'cloud' => [
        ['title' => 'Cloud Infrastructure Setup','description' => 'Deploy cloud infrastructure for scalable applications.','duration' => '3 Months'],
        ['title' => 'Serverless Application Development','description' => 'Develop applications using serverless architecture.','duration' => '4 Months'],
        ['title' => 'Cloud Cost Optimization','description' => 'Analyze and reduce cloud infrastructure costs.','duration' => '2 Months']
    ],
    'network' => [
        ['title' => 'LAN & WAN Setup','description' => 'Design and implement LAN and WAN networks for organizations.','duration' => '3 Months'],
        ['title' => 'Network Troubleshooting','description' => 'Diagnose and fix common network issues.','duration' => '2 Months'],
        ['title' => 'VPN & Remote Access Implementation','description' => 'Set up secure VPN and remote access for employees.','duration' => '3 Months']
    ]
];

$projects = $all_projects[$course] ?? [];

/* ✅ Header gradient per course */
$colors = [
    'ai' => 'linear-gradient(135deg,#ff6b6b,#f06595)',
    'ml' => 'linear-gradient(135deg,#16a34a,#4ade80)',
    'cyber' => 'linear-gradient(135deg,#6b21a8,#9333ea)',
    'ds' => 'linear-gradient(135deg,#d97706,#facc15)',
    'cloud' => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
    'networking' => 'linear-gradient(135deg,#dc2626,#f87171)'
];

$header_bg = $colors[$course] ?? 'linear-gradient(135deg,#ff6b6b,#f06595)';
$btn_bg = $colors[$course] ?? '#4ade80';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo strtoupper($course); ?> Projects | Postgraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f5f7fa;}
.header{background:<?php echo $header_bg; ?>;color:white;padding:50px 20px;text-align:center;border-radius:0 0 40px 40px;}
.header h1{font-size:36px;margin:0;}
.header p{margin:5px 0 0 0;opacity:0.9;}
.container{max-width:1100px;margin:auto;padding:30px 20px;display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:25px;}
.project-card{background:#fff;border-radius:25px;padding:25px;box-shadow:0 15px 35px rgba(0,0,0,0.08);display:flex;flex-direction:column;justify-content:space-between;transition:0.3s;}
.project-card:hover{transform:translateY(-5px);box-shadow:0 20px 40px rgba(0,0,0,0.12);}
.project-title{font-size:20px;font-weight:700;color:#22223b;margin-bottom:10px;}
.project-description{font-size:15px;color:#4a4e69;margin-bottom:15px;}
.project-meta{display:flex;flex-wrap:wrap;gap:10px;font-size:14px;}
.project-meta div{background:#e0e1dd;padding:6px 12px;border-radius:15px;color:#22223b;}
.status{padding:6px 12px;border-radius:15px;color:white;font-weight:500;}
.status.Ongoing{background:#06d6a0;}
.status.Completed{background:#1b9aaa;}
.status.Upcoming{background:#ff6b6b;}
.project-footer{margin-top:15px;text-align:right;}
.view-btn{padding:8px 18px;background:<?php echo $btn_bg; ?>;color:white;text-decoration:none;border-radius:20px;font-weight:500;transition:0.3s;}
.view-btn:hover{opacity:0.85;}
.back-btn{display:block;width:240px;margin:40px auto;padding:14px;background:<?php echo $btn_bg; ?>;color:#fff;text-align:center;text-decoration:none;border-radius:30px;}
.back-btn:hover{opacity:0.85;}
</style>
</head>
<body>

<div class="header">
    <h1>🖥 <?php echo strtoupper($course); ?> Projects</h1>
    <p>Postgraduate Course: <?php echo strtoupper($course); ?></p>
</div>

<div class="container">
<?php foreach($projects as $p){ ?>
    <div class="project-card">
        <div>
            <div class="project-title"><?php echo $p['title']; ?></div>
            <div class="project-description"><?php echo $p['description']; ?></div>
            <div class="project-meta">
                
                
            </div>
        </div>
        <div class="project-footer">
            
                <div class="project-footer">
    <a href="project_details.php?course=<?php echo $course; ?>&title=<?php echo urlencode($p['title']); ?>" class="view-btn">
        View Details
    </a>
</div>
        </div>
    </div>
<?php } ?>
</div>

<a href="course_detail.php?course=<?php echo $course; ?>" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
