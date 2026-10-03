<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'ai';

/* QUIZZES DATA FOR ALL COURSES */
$all_quizzes = [
    'ai' => [
        [
            'id' => 1,
            'title' => 'Quiz 1: AI Fundamentals',
            'topics' => 'History of AI, Intelligent Agents, Search Techniques',
            'questions' => 15,
            'duration' => '20 Minutes',
            'marks' => 15,
            'status' => 'Open'
            
        ],
        [
            'id' => 2,
            'title' => 'Quiz 2: Machine Learning Basics',
            'topics' => 'Supervised vs Unsupervised Learning, Regression',
            'questions' => 20,
            'duration' => '30 Minutes',
            'marks' => 20,
            'status' => 'Upcoming'
           
        ]
    ],
    'ml' => [
        [
            'id' => 1,
            'title' => 'Quiz 1: ML Fundamentals',
            'topics' => 'Supervised vs Unsupervised Learning, Regression',
            'questions' => 20,
            'duration' => '30 Minutes',
            'marks' => 20,
            'status' => 'Open'
            
        ]
    ],
    'cyber' => [
        [
            'id' => 1,
            'title' => 'Quiz 1: Network Security Basics',
            'topics' => 'Threats, Firewalls, VPNs',
            'questions' => 15,
            'duration' => '25 Minutes',
            'marks' => 15,
            'status' => 'Open'
            
        ],
        [
            'id' => 2,
            'title' => 'Quiz 2: Cryptography Fundamentals',
            'topics' => 'Symmetric & Asymmetric Encryption, RSA',
            'questions' => 20,
            'duration' => '30 Minutes',
            'marks' => 20,
            'status' => 'Upcoming'
            
        ]
    ],
    'data' => [
        [
            'id' => 1,
            'title' => 'Quiz 1: Data Cleaning & Preprocessing',
            'topics' => 'Missing Values, Normalization, Encoding',
            'questions' => 15,
            'duration' => '25 Minutes',
            'marks' => 15,
            'status' => 'Open'
        ],
        [
            'id' => 2,
            'title' => 'Quiz 2: Predictive Modeling',
            'topics' => 'Regression, Classification, Evaluation',
            'questions' => 20,
            'duration' => '30 Minutes',
            'marks' => 20,
            'status' => 'Upcoming'
            
        ]
    ],
    'cloud' => [
        [
            'id' => 1,
            'title' => 'Quiz 1: Cloud Architecture Design',
            'topics' => 'IaaS, PaaS, SaaS, Scalability',
            'questions' => 15,
            'duration' => '25 Minutes',
            'marks' => 15,
            'status' => 'Open'
          
        ],
        [
            'id' => 2,
            'title' => 'Quiz 2: Deployment & Monitoring',
            'topics' => 'Deploy apps, Monitoring, Optimization',
            'questions' => 20,
            'duration' => '30 Minutes',
            'marks' => 20,
            'status' => 'Upcoming'
            
        ]
    ],
    'network' => [
        [
            'id' => 1,
            'title' => 'Quiz 1: Network Configuration',
            'topics' => 'Routing, Switching, IP Addressing',
            'questions' => 15,
            'duration' => '25 Minutes',
            'marks' => 15,
            'status' => 'Open'
                   ],
        [
            'id' => 2,
            'title' => 'Quiz 2: Network Security Measures',
            'topics' => 'Firewalls, ACLs, Security Testing',
            'questions' => 20,
            'duration' => '30 Minutes',
            'marks' => 20,
            'status' => 'Upcoming'
            
        ]
    ]
];

/* SELECT QUIZZES BASED ON COURSE */
$quizzes = $all_quizzes[$course] ?? [];

if(empty($quizzes)){
    die("<h2 style='text-align:center;color:red'>No quizzes found for this course</h2>");
}

/* HEADER COLORS PER COURSE */
$colors = [
    'ai'=>'linear-gradient(135deg,#1e3a8a,#2563eb,#06b6d4)',
    'ml'=>'linear-gradient(135deg,#065f46,#10b981)',
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
<title><?php echo strtoupper($course); ?> Quizzes | PG</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f0f9ff;}
.header{background:<?php echo $header_bg; ?>;color:#fff;padding:60px 20px;text-align:center;border-radius:0 0 50px 50px;}
.header h1{font-size:36px;margin-bottom:10px;}
.stats{max-width:1100px;margin:-40px auto 40px;padding:0 20px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;}
.stat{background:#fff;border-radius:20px;padding:22px;text-align:center;box-shadow:0 10px 25px rgba(0,0,0,0.08);}
.stat h2{margin:0;color:#2563eb;}
.container{max-width:1100px;margin:auto;padding:20px;}
.quiz-card{background:#fff;border-radius:22px;padding:25px;margin-bottom:25px;box-shadow:0 12px 30px rgba(0,0,0,0.08);position:relative;overflow:hidden;}
.quiz-card::before{content:'';position:absolute;left:0;top:0;height:100%;width:6px;background:<?php echo $header_bg; ?>;}
.quiz-header{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;}
.quiz-header h3{margin:0;color:#1e293b;}
.badge{padding:6px 16px;border-radius:20px;font-size:13px;font-weight:500;color:#fff;}
.open{background:#16a34a;}
.upcoming{background:#f59e0b;}
.quiz-body{margin-top:15px;color:#475569;}
.meta{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:15px;margin-top:15px;}
.meta div{background:#eff6ff;padding:12px;border-radius:14px;font-size:14px;}
.actions{margin-top:18px;}
.actions a{display:inline-block;padding:10px 22px;color:#fff;text-decoration:none;border-radius:25px;font-weight:500;transition:0.3s;}
.actions a.enabled{background:#2563eb;}
.actions a.enabled:hover{background:#1e40af;}
.actions a.disabled{background:#94a3b8; cursor:not-allowed;}
.back-btn{display:block;width:240px;margin:40px auto;padding:14px;background:#ef4444;color:#fff;text-align:center;text-decoration:none;border-radius:30px;}
.back-btn:hover{background:#b91c1c;}
</style>
</head>

<body>
<div class="header">
    <h1>🧠 <?php echo strtoupper($course); ?> Quizzes</h1>
    <p>Evaluate your conceptual and analytical understanding through structured assessments</p>
</div>

<div class="stats">
    <div class="stat"><h2><?php echo count($quizzes); ?></h2>Total Quizzes</div>
    <div class="stat"><h2><?php echo array_sum(array_column($quizzes,'marks')); ?></h2>Total Marks</div>
    <div class="stat"><h2>MCQ + Case</h2>Quiz Pattern</div>
    <div class="stat"><h2>PG Level</h2>Difficulty</div>
</div>

<div class="container">
<?php foreach($quizzes as $q){ ?>
    <div class="quiz-card">
        <div class="quiz-header">
            <h3><?php echo $q['title']; ?></h3>
            <span class="badge <?php echo strtolower($q['status']); ?>">
                <?php echo $q['status']; ?>
            </span>
        </div>
        <div class="quiz-body">
            <p><strong>Topics Covered:</strong> <?php echo $q['topics']; ?></p>
        </div>
        <div class="meta">
            
            <div>❓ Questions: <?php echo $q['questions']; ?></div>
            <div>⏱ Duration: <?php echo $q['duration']; ?></div>
            <div>🎯 Marks: <?php echo $q['marks']; ?></div>
        </div>
        <div class="actions">
            <?php if(strtolower($q['status']) === 'upcoming'){ ?>
                <a href="javascript:void(0);" class="disabled" title="Quiz not yet available">View Quiz Details</a>
            <?php } else { ?>
                <a href="view_quiz.php?course=<?php echo $course; ?>&id=<?php echo $q['id']; ?>" class="enabled">View Quiz Details</a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
</div>

<a href="course_detail.php?course=<?php echo $course; ?>" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
</a>
</body>
</html>
