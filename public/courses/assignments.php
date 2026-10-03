<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'ai';

/* Assignments for all courses */
$all_assignments = [
    'ai' => [
        [
            'id' => 1,
            'title' => 'Assignment 1: AI Foundations',
            'desc' => 'Analyze real-world AI applications and explain intelligent behavior models.',
            
            'marks' => 10,
            'status' => 'Open'
        ],
        [
            'id' => 2,
            'title' => 'Assignment 2: Machine Learning Models',
            'desc' => 'Implement regression and classification algorithms using Python.',
            
            'marks' => 15,
            'status' => 'Open'
        ]
    ],
    'ml' => [
        [
            'id' => 1,
            'title' => 'Assignment 1: Supervised Learning',
            'desc' => 'Implement linear and logistic regression models on a dataset.',
           
            'marks' => 10,
            'status' => 'Open'
        ]
    ],
    'cyber' => [
        [
            'id' => 1,
            'title' => 'Assignment 1: Network Security Basics',
            'desc' => 'Analyze network vulnerabilities and propose security measures.',
            
            'marks' => 10,
            'status' => 'Open'
        ],
        [
            'id' => 2,
            'title' => 'Assignment 2: Cryptography Fundamentals',
            'desc' => 'Implement basic encryption/decryption algorithms.',
            
            'marks' => 15,
            'status' => 'Open'
        ]
    ],
    'data' => [
        [
            'id' => 1,
            'title' => 'Assignment 1: Data Cleaning & Preprocessing',
            'desc' => 'Clean a dataset and prepare it for analysis.',
            
            'marks' => 10,
            'status' => 'Open'
        ],
        [
            'id' => 2,
            'title' => 'Assignment 2: Predictive Modeling',
            'desc' => 'Build a predictive model using regression or classification.',
            
            'marks' => 15,
            'status' => 'Open'
        ]
    ],
    'cloud' => [
        [
            'id' => 1,
            'title' => 'Assignment 1: Cloud Architecture Design',
            'desc' => 'Design a cloud solution for a given scenario.',
            
            'marks' => 10,
            'status' => 'Open'
        ],
        [
            'id' => 2,
            'title' => 'Assignment 2: Deployment & Monitoring',
            'desc' => 'Deploy an application to the cloud and monitor its performance.',
            
            'marks' => 15,
            'status' => 'Open'
        ]
    ],
    'network' => [
        [
            'id' => 1,
            'title' => 'Assignment 1: Network Configuration',
            'desc' => 'Configure a basic network with routing and switching.',
            
            'marks' => 10,
            'status' => 'Open'
        ],
        [
            'id' => 2,
            'title' => 'Assignment 2: Network Security Measures',
            'desc' => 'Implement firewall and security policies.',
            
            'marks' => 15,
            'status' => 'Open'
        ]
    ]
];

$assignments = $all_assignments[$course] ?? [];

if (empty($assignments)) {
    die("<h2 style='text-align:center;color:red'>No assignments found for this course</h2>");
}

/* Color scheme */
$colors = [
    'ai' => ['bg' => '#065f46', 'hover' => '#047857'],
    'ml' => ['bg' => '#1e3a8a', 'hover' => '#2563eb'],
    'cyber' => ['bg' => '#6b21a8', 'hover' => '#7e22ce'],
    'data' => ['bg' => '#b45309', 'hover' => '#d97706'],
    'cloud' => ['bg' => '#0ea5e9', 'hover' => '#0284c7'],
    'network' => ['bg' => '#dc2626', 'hover' => '#b91c1c']
];

$color = $colors[$course] ?? ['bg' => '#1e3a8a', 'hover' => '#2563eb'];
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo strtoupper($course); ?> Assignments</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f0fdfa;}
.header{background:<?php echo $color['bg']; ?>;color:#fff;padding:60px 20px;text-align:center;}
.header h1{font-size:36px;margin-bottom:10px;}
.stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;max-width:1100px;margin:-40px auto 40px;padding:0 20px;}
.stat{background:#fff;border-radius:18px;padding:20px;text-align:center;box-shadow:0 10px 25px rgba(0,0,0,0.08);}
.stat h2{margin:0;color:<?php echo $color['bg']; ?>;}
.container{max-width:1100px;margin:auto;padding:20px;}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:25px;}
.card{background:#fff;padding:25px;border-radius:20px;box-shadow:0 10px 25px rgba(0,0,0,0.08);position:relative;}
.badge{position:absolute;top:20px;right:20px;padding:6px 14px;border-radius:20px;font-size:13px;color:#fff;}
.open{background:#16a34a;}
.card p{color:#475569}
.meta{font-size:14px;margin-top:10px;}
.btn{display:inline-block;margin-top:15px;padding:10px 20px;background:<?php echo $color['bg']; ?>;color:#fff;text-decoration:none;border-radius:25px;}
.btn:hover{background:<?php echo $color['hover']; ?>;}
.back-btn{
    display:inline-block;
    margin-top:20px;
    padding:10px 22px;
    background:#ffffff;
    color:<?php echo $color['bg']; ?>;
    border-radius:25px;
    text-decoration:none;
    font-weight:600;
}
</style>
</head>

<body>

<div class="header">
    <h1>📄 <?php echo strtoupper($course); ?> Assignments</h1>
    <p>Strengthen your understanding through structured assignments</p>

    <!-- ✅ FIXED BACK BUTTON -->
    <a class="back-btn" href="course_detail.php?course=<?php echo $course; ?>">
        ← Back to Course
    </a>
</div>

<div class="stats">
    <div class="stat"><h2><?php echo count($assignments); ?></h2>Total Assignments</div>
    <div class="stat"><h2><?php echo array_sum(array_column($assignments,'marks')); ?></h2>Total Marks</div>
    <div class="stat"><h2>Continuous</h2>Evaluation</div>
    <div class="stat"><h2>PG</h2>Level</div>
</div>

<div class="container">
<div class="grid">
<?php foreach($assignments as $a){ ?>
    <div class="card">
        <span class="badge open"><?php echo $a['status']; ?></span>
        <h3><?php echo $a['title']; ?></h3>
        <p><?php echo $a['desc']; ?></p>
        
        <div class="meta">🎯 Marks: <?php echo $a['marks']; ?></div>
        <a class="btn" href="view_assignment.php?course=<?php echo $course; ?>&id=<?php echo $a['id']; ?>">
            View Details
        </a>
    </div>
<?php } ?>
</div>
</div>

</body>
</html>
