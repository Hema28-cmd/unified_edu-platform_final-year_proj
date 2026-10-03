<?php
session_start();

// Only allow postgraduate users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

// ================= SAMPLE SEMINARS =================
$seminars = [
    'S101' => [
        'title' => 'AI in Healthcare',
        'description' => 'This seminar explores how Artificial Intelligence is transforming healthcare through intelligent diagnostics, real-time monitoring, and predictive analytics. Participants will learn how AI improves accuracy, reduces human error, and enhances patient care.',
        
        'topics' => ['Machine Learning', 'Deep Learning', 'Medical Imaging', 'NLP in Healthcare'],
        'materials' => ['slides.pdf', 'dataset.csv'],

        'objectives' => [
            'Understand AI applications in healthcare',
            'Learn predictive modeling techniques',
            'Explore real-world case studies'
        ],

        'outcomes' => [
            'Ability to build simple AI healthcare models',
            'Understanding of patient data analysis',
            'Knowledge of ethical AI usage'
        ],

        'speaker' => 'Dr. Rajesh Kumar (AI Specialist)',
        'schedule' => 'March 25, 2026 | 10:00 AM - 1:00 PM',
        'mode' => 'Online',
        'video' => 'videos/ai_healthcare.mp4'
    ],

    'S102' => [
        'title' => 'Cybersecurity Trends 2025',
        'description' => 'Learn about modern cyber threats, ethical hacking, and defense strategies used to secure systems and networks in 2025 and beyond.',
        
        'topics' => ['Threat Analysis', 'Ethical Hacking', 'Network Security', 'Zero Trust'],
        'materials' => ['handout.pdf', 'tools.zip'],

        'objectives' => [
            'Identify cybersecurity threats',
            'Learn penetration testing basics',
            'Understand security frameworks'
        ],

        'outcomes' => [
            'Ability to detect vulnerabilities',
            'Basic knowledge of ethical hacking tools',
            'Improved system security awareness'
        ],

        'speaker' => 'Ms. Anjali Verma (Cybersecurity Expert)',
        'schedule' => 'April 2, 2026 | 2:00 PM - 5:00 PM',
        'mode' => 'Offline',
        'video' => 'videos/cybersecurity.mp4'
    ]
];

// ================= GET SEMINAR =================
$id = $_GET['id'] ?? '';
$seminar = $seminars[$id] ?? null;

if (!$seminar) {
    die("<h2 style='text-align:center;color:red;'>Seminar not found.</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $seminar['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#eef2ff,#fce7f3);
}

/* HEADER */
.header {
    background: linear-gradient(135deg,#6366f1,#ec4899);
    color:white;
    text-align:center;
    padding:50px 20px;
    border-radius:0 0 40px 40px;
}
.header h1 { margin:0; font-size:34px; }

/* CONTAINER */
.container {
    max-width:900px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
}

/* TEXT */
h2 { color:#4f46e5; }
p { line-height:1.6; }

/* SECTIONS */
.section {
    margin-top:25px;
}
.section h3 {
    margin-bottom:10px;
    color:#ec4899;
}

/* LIST */
ul {
    padding-left:20px;
}

/* VIDEO */
video {
    width:100%;
    border-radius:15px;
    margin-top:15px;
}

/* BUTTON */
.back-btn {
    display:block;
    width:220px;
    margin:30px auto;
    padding:14px;
    background:#6366f1;
    color:white;
    text-align:center;
    text-decoration:none;
    border-radius:30px;
}
.back-btn:hover { background:#4338ca; }

</style>
</head>

<body>

<div class="header">
    <h1>🎓 Seminar Details</h1>
</div>

<div class="container">

    <h2><?php echo $seminar['title']; ?></h2>
    <p><?php echo $seminar['description']; ?></p>

    <!-- Speaker & Schedule -->
    <div class="section">
        <h3>📅 Schedule & Speaker</h3>
        <p><b>Speaker:</b> <?php echo $seminar['speaker']; ?></p>
        <p><b>Date & Time:</b> <?php echo $seminar['schedule']; ?></p>
        <p><b>Mode:</b> <?php echo $seminar['mode']; ?></p>
    </div>

    <!-- Topics -->
    <div class="section">
        <h3>📚 Topics Covered</h3>
        <ul>
            <?php foreach($seminar['topics'] as $t): ?>
                <li><?php echo $t; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Objectives -->
    <div class="section">
        <h3>🎯 Objectives</h3>
        <ul>
            <?php foreach($seminar['objectives'] as $o): ?>
                <li><?php echo $o; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Outcomes -->
    <div class="section">
        <h3>🏆 Learning Outcomes</h3>
        <ul>
            <?php foreach($seminar['outcomes'] as $o): ?>
                <li><?php echo $o; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Materials -->
    <div class="section">
        <h3>📂 Materials Provided</h3>
        <ul>
            <?php foreach($seminar['materials'] as $m): ?>
                <li><?php echo $m; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- VIDEO (NO DOWNLOAD) -->
    <div class="section">
        <h3>🎥 Seminar Video</h3>
        <video controls controlsList="nodownload">
            <source src="<?php echo $seminar['video']; ?>" type="video/mp4">
            Your browser does not support video.
        </video>
    </div>

</div>

<a href="seminars.php" class="back-btn">⬅ Back to Seminars</a>

</body>
</html>