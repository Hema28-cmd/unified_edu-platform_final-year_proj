<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'ai';
$assignment_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

/* ASSIGNMENTS DATA */
$all_assignments = [
    'ai' => [
        1 => [
            'title' => 'Assignment 1: Introduction to Artificial Intelligence',
            'description' => 'Learn core AI concepts and understand how AI is applied in real-world systems.',
            'issued' => '05 Jan 2025',
            
            'marks' => 10,
            'status' => 'Completed',
            'content' => [
                'Define Artificial Intelligence',
                'Explain weak AI vs strong AI',
                'List real-world AI applications'
            ]
        ],
        2 => [
            'title' => 'Assignment 2: Machine Learning Basics',
            'description' => 'Understand supervised and unsupervised learning algorithms.',
            'issued' => '20 Jan 2025',
           
            'marks' => 15,
            'status' => 'Open',
            'content' => [
                'Explain machine learning workflow',
                'Implement linear regression',
                'Compare classification algorithms'
            ]
        ]
    ],
    'ml' => [
        1 => [
            'title' => 'Assignment 1: Supervised Learning',
            'description' => 'Implement linear and logistic regression models on a dataset.',
            'issued' => '05 Jan 2025',
          
            'marks' => 10,
            'status' => 'Open',
            'content' => [
                'Explain supervised learning workflow',
                'Implement linear regression in Python',
                'Compare performance of classification algorithms'
            ]
        ]
    ],
    'cyber' => [
        1 => [
            'title' => 'Assignment 1: Network Security Basics',
            'description' => 'Analyze network vulnerabilities and propose security measures.',
            'issued' => '05 Jan 2025',
            
            'marks' => 10,
            'status' => 'Open',
            'content' => [
                'Identify common network threats',
                'Explain security protocols (SSL/TLS, VPN)',
                'Propose basic security measures'
            ]
        ],
        2 => [
            'title' => 'Assignment 2: Cryptography Fundamentals',
            'description' => 'Implement basic encryption and decryption algorithms.',
            'issued' => '21 Jan 2025',
                        'marks' => 15,
            'status' => 'Open',
            'content' => [
                'Explain symmetric and asymmetric encryption',
                'Implement Caesar and Vigenère ciphers',
                'Demonstrate basic RSA encryption'
            ]
        ]
    ],
    'data' => [
        1 => [
            'title' => 'Assignment 1: Data Cleaning & Preprocessing',
            'description' => 'Clean and prepare a dataset for analysis.',
            'issued' => '05 Jan 2025',
            
            'marks' => 10,
            'status' => 'Open',
            'content' => [
                'Handle missing data',
                'Normalize and standardize features',
                'Encode categorical variables'
            ]
        ],
        2 => [
            'title' => 'Assignment 2: Predictive Modeling',
            'description' => 'Build a predictive model using regression or classification.',
            'issued' => '21 Jan 2025',
           
            'marks' => 15,
            'status' => 'Open',
            'content' => [
                'Split dataset into train/test',
                'Train a regression model',
                'Evaluate performance metrics'
            ]
        ]
    ],
    'cloud' => [
        1 => [
            'title' => 'Assignment 1: Cloud Architecture Design',
            'description' => 'Design a cloud solution for a given scenario.',
            'issued' => '05 Jan 2025',
           
            'marks' => 10,
            'status' => 'Open',
            'content' => [
                'Describe cloud service models (IaaS, PaaS, SaaS)',
                'Design scalable architecture',
                'Select suitable cloud providers'
            ]
        ],
        2 => [
            'title' => 'Assignment 2: Deployment & Monitoring',
            'description' => 'Deploy an application to the cloud and monitor its performance.',
            'issued' => '21 Jan 2025',
            
            'marks' => 15,
            'status' => 'Open',
            'content' => [
                'Deploy a sample web application',
                'Configure monitoring and alerts',
                'Optimize cloud resources'
            ]
        ]
    ],
    'network' => [
        1 => [
            'title' => 'Assignment 1: Network Configuration',
            'description' => 'Configure a basic network with routing and switching.',
            'issued' => '05 Jan 2025',
            
            'marks' => 10,
            'status' => 'Open',
            'content' => [
                'Configure routers and switches',
                'Setup IP addressing',
                'Test network connectivity'
            ]
        ],
        2 => [
            'title' => 'Assignment 2: Network Security Measures',
            'description' => 'Implement firewall and security policies.',
            'issued' => '21 Jan 2025',
            
            'marks' => 15,
            'status' => 'Open',
            'content' => [
                'Setup basic firewall rules',
                'Implement access control lists',
                'Test network security configurations'
            ]
        ]
    ]
];

/* SAFETY CHECK */
if (!isset($all_assignments[$course][$assignment_id])) {
    die("<h2 style='text-align:center;color:red'>❌ Invalid Assignment</h2>");
}

$a = $all_assignments[$course][$assignment_id];

/* Header colors for each course */
$colors = [
    'ai'=>'linear-gradient(135deg,#0ea5e9,#10b981)',
    'ml'=>'linear-gradient(135deg,#1e3a8a,#2563eb)',
    'cyber'=>'linear-gradient(135deg,#6b21a8,#7e22ce)',
    'ds'=>'linear-gradient(135deg,#b45309,#d97706)',
    'cloud'=>'linear-gradient(135deg,#0ea5e9,#0284c7)',
    'networking'=>'linear-gradient(135deg,#dc2626,#b91c1c)'
];

$header_bg = $colors[$course] ?? 'linear-gradient(135deg,#1e3a8a,#2563eb)';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $a['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f8fafc;}
.header{background:<?php echo $header_bg; ?>;color:#fff;padding:45px 20px;text-align:center;border-radius:0 0 40px 40px;}
.header h1{margin:0;font-size:32px;}
.header p{opacity:.9;margin-top:10px;}
.container{max-width:1000px;margin:-30px auto 60px;padding:20px;}
.info{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:30px;}
.box{background:#fff;padding:20px;border-radius:18px;text-align:center;box-shadow:0 8px 20px rgba(0,0,0,.08);}
.box h4{margin:0;color:#64748b;}
.box p{margin-top:8px;font-weight:600;font-size:17px;}
.section{background:#fff;padding:30px;border-radius:20px;box-shadow:0 8px 22px rgba(0,0,0,.08);}
.section h2{margin-top:0;color:#1e293b;}
.section ul{padding-left:20px;}
.section li{margin-bottom:10px;color:#475569;}
.back{display:block;width:230px;margin:40px auto;padding:14px;text-align:center;background:#ef4444;color:#fff;text-decoration:none;border-radius:30px;font-weight:500;}
.back:hover{background:#b91c1c;}
</style>
</head>

<body>

<div class="header">
    <h1><?php echo $a['title']; ?></h1>
    <p><?php echo $a['description']; ?></p>
</div>

<div class="container">
    <div class="info">
        <div class="box">
            <h4>Issued Date</h4>
            <p><?php echo $a['issued']; ?></p>
        </div>
        
        <div class="box">
            <h4>Marks</h4>
            <p><?php echo $a['marks']; ?></p>
        </div>
        <div class="box">
            <h4>Status</h4>
            <p><?php echo $a['status']; ?></p>
        </div>
    </div>

    <div class="section">
        <h2>📘 Assignment Instructions</h2>
        <ul>
            <?php foreach($a['content'] as $c){ echo "<li>$c</li>"; } ?>
        </ul>
    </div>
</div>

<a href="assignments.php?course=<?php echo $course; ?>" class="back">
    <i class="fa-solid fa-arrow-left"></i> Back to Assignments
</a>

</body>
</html>
