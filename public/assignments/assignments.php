<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'network';

/* NETWORK ASSIGNMENTS DATA */
$assignments = [
    [
        'id' => 'NET-A1',
        'title' => 'Network Architecture Design',
        'description' => 'Design a scalable enterprise network architecture considering performance, security, and fault tolerance.',
       
        'marks' => 10,
        'type' => 'Design'
        
    ],
    [
        'id' => 'NET-A2',
        'title' => 'Routing Protocol Analysis',
        'description' => 'Compare RIP, OSPF, and BGP protocols with practical configurations.',
        
        'marks' => 15,
        'type' => 'Practical'
    ],
    [
        'id' => 'NET-A3',
        'title' => 'Network Security Implementation',
        'description' => 'Configure firewall rules and intrusion detection mechanisms.',
        
        'marks' => 15,
        'type' => 'Lab'
    ],
    [
        'id' => 'NET-A4',
        'title' => 'Traffic Analysis Report',
        'description' => 'Capture and analyze network traffic using Wireshark.',
        
        'marks' => 20,
        'type' => 'Report'
    ]
];

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
<title>Networking Assignments | Postgraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:linear-gradient(180deg,#f1f5f9,#e0f2fe);
    color:#0f172a;
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#0f172a,#1e293b);
    color:#fff;
    padding:55px 25px;
    text-align:center;
}
.header h1{
    font-size:36px;
    margin-bottom:8px;
}
.header p{
    opacity:0.85;
    font-size:17px;
}

/* STATS BAR */
.stats{
    max-width:1100px;
    margin:-40px auto 40px;
    padding:0 20px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}
.stat{
    background:#fff;
    border-radius:20px;
    padding:22px;
    text-align:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}
.stat h2{
    margin:0;
    color:#0ea5e9;
}
.stat span{
    font-size:14px;
    color:#475569;
}

/* MAIN CONTAINER */
.container{
    max-width:1200px;
    margin:auto;
    padding:20px;
}

/* ASSIGNMENT TIMELINE */
.timeline{
    display:grid;
    gap:25px;
}

/* ASSIGNMENT CARD */
.assignment{
    background:#fff;
    border-radius:25px;
    padding:30px;
    position:relative;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
    transition:0.3s;
}
.assignment:hover{
    transform:translateY(-6px);
}

/* LEFT BORDER */
.assignment::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:8px;
    height:100%;
    border-radius:25px 0 0 25px;
    background:#0ea5e9;
}

/* TITLE */
.assignment h3{
    margin-top:0;
    font-size:22px;
    color:#0f172a;
}

/* META */
.meta{
    margin:10px 0;
    font-size:14px;
    color:#475569;
}
.meta span{
    margin-right:15px;
}

/* STATUS */
.status{
    display:inline-block;
    padding:6px 14px;
    border-radius:20px;
    color:#fff;
    font-size:13px;
    margin-top:10px;
}

/* ACTION BUTTONS */
.actions{
    margin-top:18px;
}
.actions a{
    text-decoration:none;
    padding:10px 20px;
    border-radius:22px;
    font-size:14px;
    font-weight:500;
    margin-right:10px;
    display:inline-block;
}
.view{
    background:#0ea5e9;
    color:#fff;
}
.view:hover{background:#0284c7;}
.submit{
    background:#22c55e;
    color:#fff;
}
.submit:hover{background:#16a34a;}

/* BACK BUTTON */
.back-btn{
    display:block;
    width:260px;
    margin:60px auto 80px;
    padding:15px;
    text-align:center;
    background:#1e293b;
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
}
.back-btn:hover{
    background:#0f172a;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>📘 Networking Assignments</h1>
    <p>Advanced assignments designed to strengthen practical and analytical skills</p>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat">
        <h2><?php echo count($assignments); ?></h2>
        <span>Total Assignments</span>
    </div>
    <div class="stat">
        <h2><?php echo array_sum(array_column($assignments,'marks')); ?></h2>
        <span>Total Marks</span>
    </div>
    <div class="stat">
        <h2>PG</h2>
        <span>Academic Level</span>
    </div>
    <div class="stat">
        <h2>Continuous</h2>
        <span>Evaluation Mode</span>
    </div>
</div>

<!-- ASSIGNMENTS -->
<div class="container">
    <div class="timeline">

        <?php foreach($assignments as $a){ ?>
        <div class="assignment">
            <h3><?php echo $a['title']; ?></h3>
            <p><?php echo $a['description']; ?></p>

            <div class="meta">
                <span>📌 ID: <?php echo $a['id']; ?></span>
                <span>📄 Type: <?php echo $a['type']; ?></span>
                <span>🎯 Marks: <?php echo $a['marks']; ?></span>
                
            </div>

            

            <div class="actions">
                <a class="view" href="1view_assignment.php?course=network&id=<?php echo $a['id']; ?>">
                    View Details
                </a>
                
            </div>
        </div>
        <?php } ?>

    </div>
</div>

<!-- BACK -->
<a href="../network/networking.php" class="back-btn">
    ⬅ Back to Networking Course
</a>

</body>
</html>
