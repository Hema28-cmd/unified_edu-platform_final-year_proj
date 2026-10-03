<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    die("<h2 style='text-align:center;color:red'>Access Denied</h2>");
}

$course = $_GET['course'] ?? 'ai';
$quizId = $_GET['id'] ?? 1;

/* ✅ QUESTIONS FOR ALL COURSES */
$all_quizzes = [
    'ai' => [
        1 => [
            'title' => 'AI Fundamentals',
            'questions' => [
                'What is the primary goal of Artificial Intelligence?',
                'Which of the following is an example of an intelligent agent?',
                'Which search strategy uses heuristics to improve efficiency?',
                'Which area is NOT a real-world application of AI?'
            ]
        ]
    ],
    'ml' => [
        1 => [
            'title' => 'Machine Learning Basics',
            'questions' => [
                'What is supervised learning in Machine Learning?',
                'Explain the difference between classification and regression.',
                'What is overfitting and how can it be prevented?',
                'Describe the role of a training set and a test set.'
            ]
        ]
    ],
    'cyber' => [
        1 => [
            'title' => 'Network Security Basics',
            'questions' => [
                'What is the primary purpose of a firewall?',
                'Define VPN and explain its importance.',
                'List common network security threats.',
                'Explain the difference between symmetric and asymmetric encryption.'
            ]
        ]
    ],
    'data' => [
        1 => [
            'title' => 'Data Science Essentials',
            'questions' => [
                'What is data cleaning and why is it important?',
                'Explain the difference between supervised and unsupervised learning.',
                'What is feature scaling and when should it be applied?',
                'Define outliers and explain how to handle them.'
            ]
        ]
    ],
    'cloud' => [
        1 => [
            'title' => 'Cloud Architecture Basics',
            'questions' => [
                'Define IaaS, PaaS, and SaaS with examples.',
                'Explain the concept of elasticity in cloud computing.',
                'What are the benefits of multi-cloud strategy?',
                'Describe cloud deployment models.'
            ]
        ]
    ],
    'network' => [
        1 => [
            'title' => 'Networking Fundamentals',
            'questions' => [
                'What is the difference between a switch and a router?',
                'Explain subnetting and its purpose.',
                'Define TCP/IP and its layers.',
                'What is NAT and why is it used?'
            ]
        ]
    ]
];

/* ✅ Validate course & quiz */
if (!isset($all_quizzes[$course][$quizId])) {
    die("<h2 style='text-align:center;color:red'>Quiz not found</h2>");
}

$quizTitle = $all_quizzes[$course][$quizId]['title'];
$questions = $all_quizzes[$course][$quizId]['questions'];

/* ✅ Header colors per course */
$colors = [
    'ai' => 'linear-gradient(135deg,#1e3a8a,#0f766e)',
    'ml' => 'linear-gradient(135deg,#065f46,#10b981)',
    'cyber' => 'linear-gradient(135deg,#6b21a8,#7e22ce)',
    'ds' => 'linear-gradient(135deg,#b45309,#d97706)',
    'cloud' => 'linear-gradient(135deg,#0ea5e9,#0284c7)',
    'networking' => 'linear-gradient(135deg,#dc2626,#b91c1c)'
];
$header_bg = $colors[$course] ?? 'linear-gradient(135deg,#1e3a8a,#0f766e)';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $quizTitle; ?> | Important Questions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body { margin:0; font-family:'Segoe UI',sans-serif; background:linear-gradient(135deg,#f0f9ff,#ecfeff);}
.header { background:<?php echo $header_bg; ?>; color:white; padding:40px 20px; text-align:center; border-radius:0 0 40px 40px;}
.header h1 { margin:0; }
.header p { opacity:0.9; }
.container { max-width:800px; margin: -20px auto 50px; padding:20px; }
.question-card { background:white; border-radius:20px; padding:25px; margin-bottom:20px; box-shadow:0 12px 25px rgba(0,0,0,0.08);}
.question-title { font-size:18px; font-weight:600; color:#0f172a; }
.footer { text-align:center; margin-top:40px; }
.back-btn { padding:12px 25px; background:#ef4444; color:white; border-radius:30px; text-decoration:none; font-weight:600; display:inline-block;}
.back-btn:hover { background:#b91c1c; }
</style>
</head>
<body>

<div class="header">
    <h1>📝 <?php echo $quizTitle; ?></h1>
    <p>Important Questions | Postgraduate: <?php echo strtoupper($course); ?></p>
</div>

<div class="container">
    <?php foreach($questions as $index => $q){ ?>
        <div class="question-card">
            <div class="question-title">
                Q<?php echo ($index+1); ?>. <?php echo $q; ?>
            </div>
        </div>
    <?php } ?>

    <div class="footer">
        <a href="quizzes.php?course=<?php echo $course; ?>" class="back-btn">⬅ Back to Quizzes</a>
    </div>
</div>

</body>
</html>
