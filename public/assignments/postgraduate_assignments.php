<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: dashboard.php");
    exit;
}

$assignments = [
    [
        'id' => 'PG301',
        'title' => 'Machine Learning Experimentation',
        'description' => 'Conduct experiments on classification and regression algorithms with real datasets.',
        
        'priority' => 'High',
        
        'type' => 'Practical',
    ],
    [
        'id' => 'PG302',
        'title' => 'Cloud Security Case Study',
        'description' => 'Analyze security breaches in cloud deployments and propose mitigation strategies.',
        
        'priority' => 'Medium',
        
        'type' => 'Case Study',
    ],
    [
        'id' => 'PG303',
        'title' => 'IoT Sensor Data Analysis',
        'description' => 'Analyze IoT sensor data to identify trends and anomalies.',
        
        'priority' => 'High',
        
        'type' => 'Report',
    ],
     [
        'id' => 'PG304',
        'title' => 'Natural Language Processing',
        'description' => 'Build models for sentiment analysis and text classification using real-world datasets.',
        'priority' => 'High',
        'type' => 'Project',
    ],
    [
        'id' => 'PG305',
        'title' => 'Data Visualization Project',
        'description' => 'Create meaningful charts and dashboards to represent complex data visually.',
        'priority' => 'Low',
        'type' => 'Project',
    ],
    [
        'id' => 'PG306',
        'title' => 'Deep Learning Image Classification',
        'description' => 'Implement CNN-based models to classify images and improve prediction accuracy.',
        'priority' => 'High',
        'type' => 'Project',
    ],
   [
        'id' => 'PG307',
        'title' => 'Big Data Processing using Hadoop',
        'description' => 'Process and analyze large datasets using Hadoop and MapReduce techniques.',
        'priority' => 'Medium',
        'type' => 'Practical',
    ],
     [
        'id' => 'PG308',
        'title' => 'Blockchain Fundamentals',
        'description' => 'Develop a basic blockchain system and understand secure transaction mechanisms.',
        'priority' => 'High',
        'type' => 'Project',
    ],
];

function getStatusColor($status){
    return match($status){
        'Completed' => '#16a34a',
        'Ongoing' => '#f59e0b',
        'Upcoming' => '#ef4444',
        default => '#64748b',
    };
}

function getPriorityColor($priority){
    return match($priority){
        'High' => '#dc2626',
        'Medium' => '#f97316',
        'Low' => '#2563eb',
        default => '#64748b',
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Assignments</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Inter', sans-serif;
    background:#f1f5f9;
    color:#1e293b;
}

/* HEADER */
.header{
    background:linear-gradient(90deg,#4338ca,#6366f1);
    color:white;
    padding:50px 40px;
}
.header h1{
    margin:0;
    font-size:34px;
}
.header p{
    opacity:0.9;
    margin-top:6px;
}

/* MAIN LAYOUT */
.main{
    max-width:1200px;
    margin:40px auto;
    display:grid;
    grid-template-columns:280px 1fr;
    gap:30px;
    padding:0 20px;
}

/* SIDEBAR */
.sidebar{
    background:white;
    border-radius:20px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}
.sidebar h3{
    margin-bottom:20px;
}
.sidebar p{
    font-size:14px;
    margin-bottom:12px;
    color:#475569;
}

/* ASSIGNMENT LIST */
.list{
    display:flex;
    flex-direction:column;
    gap:20px;
}

.row{
    background:white;
    border-radius:18px;
    padding:25px;
    display:grid;
    grid-template-columns:1fr auto;
    gap:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    transition:0.3s;
}
.row:hover{
    transform:translateY(-4px);
}

.row h2{
    margin:0;
    font-size:22px;
    color:#4338ca;
}
.row p{
    margin:8px 0;
    color:#475569;
    line-height:1.5;
    font-size:14px;
}

.meta{
    font-size:13px;
    color:#64748b;
}

.badges span{
    display:inline-block;
    padding:6px 14px;
    border-radius:14px;
    font-size:12px;
    font-weight:600;
    color:white;
    margin-right:8px;
}

.action{
    display:flex;
    align-items:center;
}
.action a{
    text-decoration:none;
    padding:10px 22px;
    background:#4338ca;
    color:white;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
}
.action a:hover{
    background:#312e81;
}

/* BACK */
.back{
    display:block;
    width:230px;
    margin:60px auto;
    padding:14px;
    text-align:center;
    background:#ec4899;
    color:white;
    text-decoration:none;
    border-radius:30px;
}
.back:hover{
    background:#be185d;
}

@media(max-width:900px){
    .main{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="header">
    <h1>📘 Postgraduate Assignments</h1>
    <p>Track, manage and complete your academic tasks efficiently</p>
</div>

<div class="main">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>📊 Overview</h3>
        <p>Total Assignments: <b><?php echo count($assignments); ?></b></p>
        <p>High Priority Tasks</p>
        
   </div>

    <!-- LIST -->
    <div class="list">
        <?php foreach($assignments as $a){ ?>
        <div class="row">
            <div>
                <h2><?php echo $a['title']; ?></h2>
                <p><?php echo $a['description']; ?></p>

                <div class="meta">
                    ID: <?php echo $a['id']; ?> |
                    Type: <?php echo $a['type']; ?> 
                    
                </div>

                
            </div>

            <div class="action">
                <a href="view_assignment.php?id=<?php echo $a['id']; ?>">View</a>
            </div>
        </div>
        <?php } ?>
    </div>

</div>

<a href="../postgraduate.php" class="back">⬅ Back to Dashboard</a>

</body>
</html>
