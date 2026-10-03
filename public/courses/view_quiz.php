<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

/* ✅ SESSION CHECK */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    die("<h2 style='text-align:center;color:red'>Access Denied: Postgraduate Only</h2>");
}

/* ✅ GET PARAMETERS */
$course = $_GET['course'] ?? 'ai';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

/* ✅ QUIZ DATA FOR ALL COURSES */
$all_quizzes = [
    'ai' => [
        1 => [
            'title' => 'Quiz 1: AI Fundamentals',
            'description' => 'This quiz evaluates foundational knowledge of Artificial Intelligence.',
            'topics' => ['History & Evolution of AI','Intelligent Agents','State Space Search','Applications of AI'],
            'instructions' => ['Multiple-choice questions only','No negative marking','Each question carries equal marks'],
            'format' => 'MCQ','questions' => 15,'duration' => '20 Minutes','marks' => 15,'level' => 'Postgraduate','availability' => 'Open'
        ]
    ],
    'ml' => [
        1 => [
            'title' => 'Quiz 1: ML Fundamentals',
            'description' => 'Basics of Machine Learning including supervised and unsupervised techniques.',
            'topics' => ['Supervised vs Unsupervised Learning','Regression','Classification Algorithms'],
            'instructions' => ['MCQ + conceptual questions','No external tools allowed','Manage your time properly'],
            'format' => 'MCQ + Conceptual','questions' => 20,'duration' => '30 Minutes','marks' => 20,'level' => 'Postgraduate','availability' => 'Open'
        ]
    ],
    'cyber' => [
        1 => [
            'title' => 'Quiz 1: Network Security Basics',
            'description' => 'Covers threats, firewalls, VPNs, and core network security concepts.',
            'topics' => ['Network Threats','Firewalls','VPN Concepts','Security Policies'],
            'instructions' => ['MCQ + scenario-based questions','No external tools allowed','Read questions carefully'],
            'format' => 'MCQ + Scenario','questions' => 15,'duration' => '25 Minutes','marks' => 15,'level' => 'Postgraduate','availability' => 'Open'
        ],
        2 => [
            'title' => 'Quiz 2: Cryptography Fundamentals',
            'description' => 'Evaluates understanding of encryption methods and cryptographic algorithms.',
            'topics' => ['Symmetric Encryption','Asymmetric Encryption','RSA Algorithm','Digital Signatures'],
            'instructions' => ['MCQ + conceptual questions','No calculators','Each question carries equal marks'],
            'format' => 'MCQ + Conceptual','questions' => 20,'duration' => '30 Minutes','marks' => 20,'level' => 'Postgraduate','availability' => 'Upcoming'
        ]
    ],
    'data' => [
        1 => [
            'title' => 'Quiz 1: Data Cleaning & Preprocessing',
            'description' => 'Focus on cleaning datasets, handling missing values, and feature scaling.',
            'topics' => ['Missing Values','Normalization','Encoding','Data Transformation'],
            'instructions' => ['MCQ + practical questions','No external tools allowed','Time management is crucial'],
            'format' => 'MCQ + Practical','questions' => 15,'duration' => '25 Minutes','marks' => 15,'level' => 'Postgraduate','availability' => 'Open'
        ]
    ],
    'cloud' => [
        1 => [
            'title' => 'Quiz 1: Cloud Architecture Design',
            'description' => 'Test knowledge on IaaS, PaaS, SaaS, and scalability.',
            'topics' => ['IaaS, PaaS, SaaS','Scalability','Cloud Design Patterns'],
            'instructions' => ['MCQ + scenario questions','No external tools allowed','Time management important'],
            'format' => 'MCQ + Scenario','questions' => 15,'duration' => '25 Minutes','marks' => 15,'level' => 'Postgraduate','availability' => 'Open'
        ]
    ],
    'network' => [
        1 => [
            'title' => 'Quiz 1: Network Configuration',
            'description' => 'Covers routing, switching, IP addressing, and basic network troubleshooting.',
            'topics' => ['Routing Protocols','Switch Configuration','IP Addressing','Subnetting'],
            'instructions' => ['MCQ + problem-solving questions','No external tools allowed','Read carefully'],
            'format' => 'MCQ + Practical','questions' => 15,'duration' => '25 Minutes','marks' => 15,'level' => 'Postgraduate','availability' => 'Open'
        ]
    ]
];

/* ✅ FALLBACK IF INVALID ID */
$quiz = $all_quizzes[$course][$id] ?? reset($all_quizzes[$course]);

/* HEADER COLORS PER COURSE */
$colors = [
    'ai'=>'linear-gradient(135deg,#4c1d95,#0f766e)',
    'ml'=>'linear-gradient(135deg,#065f46,#10b981)',
    'cyber'=>'linear-gradient(135deg,#6b21a8,#7e22ce)',
    'ds'=>'linear-gradient(135deg,#b45309,#d97706)',
    'cloud'=>'linear-gradient(135deg,#0ea5e9,#0284c7)',
    'networking'=>'linear-gradient(135deg,#dc2626,#b91c1c)'
];
$header_bg = $colors[$course] ?? 'linear-gradient(135deg,#4c1d95,#0f766e)';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $quiz['title']; ?> | Quiz Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f8fafc;}
.header{background:<?php echo $header_bg; ?>;color:#fff;padding:60px 20px;text-align:center;border-radius:0 0 50px 50px;}
.header h1{margin-bottom:10px;font-size:34px;}
.header p{max-width:700px;margin:auto;opacity:0.95;}
.container{max-width:1200px;margin:-40px auto 60px;padding:20px;}
.grid{display:grid;grid-template-columns:2fr 1fr;gap:25px;}
.panel{background:#fff;border-radius:24px;padding:30px;box-shadow:0 12px 30px rgba(0,0,0,0.08);margin-bottom:25px;}
.panel h2{margin-top:0;color:#1e293b;}
.panel ul{padding-left:20px;}
.panel ul li{margin-bottom:10px;color:#475569;}
.info-card{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border-radius:20px;padding:22px;margin-bottom:20px;}
.info-card h3{margin-top:0;}
.badge{display:inline-block;padding:6px 16px;border-radius:20px;background:#22c55e;font-size:13px;margin-bottom:10px;}
.meta{display:grid;grid-template-columns:1fr 1fr;gap:15px;}
.meta div{background:#ecfeff;color:#0f172a;padding:12px;border-radius:14px;font-size:14px;}
.back-btn{display:block;max-width:260px;margin:40px auto;padding:14px;background:#ef4444;color:#fff;text-align:center;border-radius:30px;text-decoration:none;font-weight:500;}
.back-btn:hover{background:#b91c1c;}
@media(max-width:900px){.grid{grid-template-columns:1fr;}}
</style>
</head>
<body>

<div class="header">
    <h1><?php echo $quiz['title']; ?></h1>
    <p><?php echo $quiz['description']; ?></p>
</div>

<div class="container">
    <div class="grid">
        <!-- LEFT SIDE -->
        <div>
            <div class="panel">
                <h2>📘 Topics Covered</h2>
                <ul><?php foreach($quiz['topics'] as $topic) echo "<li>$topic</li>"; ?></ul>
            </div>
            <div class="panel">
                <h2>📝 Instructions</h2>
                <ul><?php foreach($quiz['instructions'] as $inst) echo "<li>$inst</li>"; ?></ul>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div>
            <div class="info-card">
                <h3>📊 Quiz Information</h3>
                <span class="badge"><?php echo $quiz['availability']; ?></span>
                <div class="meta">
                    <div>❓ Questions: <?php echo $quiz['questions']; ?></div>
                    <div>⏱ Duration: <?php echo $quiz['duration']; ?></div>
                    <div>🎯 Marks: <?php echo $quiz['marks']; ?></div>
                    <div>📚 Level: <?php echo $quiz['level']; ?></div>
                    <div>🧠 Format: <?php echo $quiz['format']; ?></div>
                </div>
            </div>
            <div class="info-card" style="background:linear-gradient(135deg,#16a34a,#22c55e);">
                <h3>🎓 Academic Purpose</h3>
                <p>This quiz strengthens conceptual clarity and prepares students for advanced coursework, assignments, and projects.</p>
                <a href="start_quiz.php?course=<?php echo $course; ?>&id=<?php echo $id; ?>" style="display:block;margin-top:25px;padding:16px;text-align:center;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;text-decoration:none;font-size:16px;font-weight:600;border-radius:30px;">
                    🚀 Start Quiz
                </a>
            </div>
        </div>
    </div>
</div>

<a href="quizzes.php?course=<?php echo $course; ?>" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Back to Quizzes
</a>

</body>
</html>
