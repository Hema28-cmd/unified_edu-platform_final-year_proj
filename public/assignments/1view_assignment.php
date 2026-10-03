<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'network';
$id = $_GET['id'] ?? '';

/* ASSIGNMENT DATA */
$assignments = [

    'NET-A1' => [
        'title' => 'Network Architecture Design',
        'type' => 'Design Assignment',
        'marks' => 10,
        
        'objective' => 'To understand enterprise-level network architecture design considering scalability, security, and performance.',
        'description' => 'Students are required to design a complete enterprise network architecture suitable for a medium-scale organization.',
        'tasks' => [
            'Identify network requirements and constraints',
            'Design LAN and WAN topology',
            'Select routing and switching devices',
            'Incorporate security mechanisms',
            'Provide justification for design choices'
        ],
        'tools' => 'Cisco Packet Tracer / GNS3 / Draw.io',
        'submission' => 'PDF report including diagrams and explanations (5–7 pages).',
        'learning' => [
            'Enterprise network planning',
            'Network topology design',
            'Security-aware architecture',
            'Technical documentation'
        ]
    ],

    'NET-A2' => [
        'title' => 'Routing Protocol Configuration and Comparison',
        'type' => 'Practical Assignment',
        'marks' => 15,
       
        'objective' => 'To analyze and compare the performance of different routing protocols.',
        'description' => 'Students must configure and test routing protocols such as RIP, OSPF, and EIGRP in a simulated environment.',
        'tasks' => [
            'Configure RIP, OSPF, and EIGRP',
            'Analyze convergence time',
            'Compare routing tables',
            'Prepare comparative report'
        ],
        'tools' => 'Cisco Packet Tracer / GNS3',
        'submission' => 'Simulation files + PDF report (6–8 pages).',
        'learning' => [
            'Routing protocol behavior',
            'Network convergence analysis',
            'Hands-on configuration skills'
        ]
    ],

    'NET-A3' => [
        'title' => 'Network Security Implementation',
        'type' => 'Case Study Assignment',
        'marks' => 15,
        
        'objective' => 'To understand practical network security mechanisms and threat mitigation.',
        'description' => 'This assignment involves designing and implementing security controls for a given network scenario.',
        'tasks' => [
            'Identify security threats',
            'Configure firewall rules',
            'Implement ACLs',
            'Propose IDS/IPS solutions'
        ],
        'tools' => 'Packet Tracer / Firewall Simulator',
        'submission' => 'Detailed case study report with diagrams (7–9 pages).',
        'learning' => [
            'Network security principles',
            'Firewall and ACL configuration',
            'Threat analysis and mitigation'
        ]
    ],

    'NET-A4' => [
        'title' => 'Traffic Analysis Report',
        'type' => 'Analytical Assignment',
        'marks' => 10,
        
        'objective' => 'To analyze and interpret network traffic for performance and security evaluation.',
        'description' => 'Students will capture and analyze network traffic to identify patterns, anomalies, and bottlenecks.',
        'tasks' => [
            'Capture live network traffic',
            'Analyze protocols and bandwidth usage',
            'Identify anomalies',
            'Prepare traffic analysis report'
        ],
        'tools' => 'Wireshark / tcpdump',
        'submission' => 'Traffic analysis report (5–6 pages).',
        'learning' => [
            'Traffic analysis techniques',
            'Protocol-level understanding',
            'Network performance evaluation'
        ]
    ]

];

$assignment = $assignments[$id] ?? null;

if (!$assignment) {
    die("<h2 style='text-align:center;color:red'>Assignment not found</h2>");
}

/* STATUS COLOR */
function statusColor($status){
    return match($status){
        'Open' => '#22c55e',
        'Upcoming' => '#f59e0b',
        'Closed' => '#ef4444',
        default => '#64748b'
    };
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $assignment['title']; ?> | Networking</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#eef2ff);
    color:#0f172a;
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#0f766e,#4338ca);
    color:#fff;
    padding:50px 25px;
}
.header h1{
    margin:0;
    font-size:34px;
}
.header p{
    margin-top:8px;
    opacity:0.9;
}

/* LAYOUT */
.wrapper{
    max-width:1200px;
    margin:-40px auto 60px;
    padding:0 20px;
    display:grid;
    grid-template-columns:320px 1fr;
    gap:30px;
}

/* LEFT PANEL */
.sidebar{
    background:#ffffff;
    border-radius:25px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}
.sidebar h3{
    margin-top:0;
    color:#0f766e;
}
.info{
    font-size:14px;
    margin:10px 0;
    color:#334155;
}
.badge{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    color:#fff;
    font-size:13px;
    margin-top:10px;
}

/* MAIN CONTENT */
.content{
    background:#ffffff;
    border-radius:25px;
    padding:35px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
}
.section{
    margin-bottom:30px;
}
.section h2{
    margin-bottom:10px;
    color:#4338ca;
    font-size:22px;
}
.section p{
    line-height:1.7;
    color:#334155;
}

/* LISTS */
ul{
    padding-left:20px;
}
ul li{
    margin-bottom:8px;
    color:#334155;
}

/* BUTTONS */
.actions{
    margin-top:30px;
    display:flex;
    gap:15px;
}
.actions a{
    text-decoration:none;
    padding:12px 24px;
    border-radius:25px;
    font-weight:600;
    font-size:14px;
}
.submit{
    background:#22c55e;
    color:#fff;
}
.submit:hover{background:#16a34a;}
.back{
    background:#0f172a;
    color:#fff;
}
.back:hover{background:#020617;}

/* RESPONSIVE */
@media(max-width:900px){
    .wrapper{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>📘 <?php echo $assignment['title']; ?></h1>
    <p>Networking · Postgraduate Assignment</p>
</div>

<!-- CONTENT -->
<div class="wrapper">

    <!-- LEFT PANEL -->
    <div class="sidebar">
        <h3>Assignment Info</h3>
        <div class="info"><b>ID:</b> <?php echo $id; ?></div>
        <div class="info"><b>Course:</b> Networking</div>
        <div class="info"><b>Type:</b> <?php echo $assignment['type']; ?></div>
        <div class="info"><b>Marks:</b> <?php echo $assignment['marks']; ?></div>
       

        <span class="badge" style="background:<?php echo statusColor($assignment['status']); ?>">
            <?php echo $assignment['status']; ?>
        </span>
    </div>

    <!-- MAIN PANEL -->
    <div class="content">

        <div class="section">
            <h2>Assignment Description</h2>
            <p><?php echo $assignment['description']; ?></p>
        </div>

        <div class="section">
            <h2>Objective</h2>
            <p><?php echo $assignment['objective']; ?></p>
        </div>

        <div class="section">
            <h2>Tasks to be Performed</h2>
            <ul>
                <?php foreach($assignment['tasks'] as $task){ ?>
                    <li><?php echo $task; ?></li>
                <?php } ?>
            </ul>
        </div>

        <div class="section">
            <h2>Tools & Technologies</h2>
            <p><?php echo $assignment['tools']; ?></p>
        </div>

        <div class="section">
            <h2>Learning Outcomes</h2>
            <ul>
                <?php foreach($assignment['learning'] as $outcome){ ?>
                    <li><?php echo $outcome; ?></li>
                <?php } ?>
            </ul>
        </div>

         <div class="actions">
           
            <a href="assignments.php?course=network" class="back">
                ⬅ Back to Assignments
            </a>
        </div>

    </div>
</div>

</body>
</html>
