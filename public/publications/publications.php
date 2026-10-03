<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_name = $_SESSION['user_name'];

/* 🔹 PUBLICATIONS DATA */
$publications = [
    'PUB001' => [
        'title' => 'Artificial Intelligence in Smart Education Systems',
        'meta'  => 'Journal of Emerging Technologies · 2024 · Scopus Indexed',
        'authors' => 'Dr. Meena R., Prof. Arjun K.',
        'keywords' => ['AI', 'Smart Learning', 'Automation'],
        'citations' => 25,
        'desc'  => 'This paper explores how Artificial Intelligence enhances personalized learning environments through adaptive systems, automated grading, and intelligent tutoring systems. It highlights real-world implementations in smart classrooms and e-learning platforms.'
    ],
    'PUB002' => [
        'title' => 'Cyber Security Challenges in Modern Web Applications',
        'meta'  => 'International Conference on Cyber Systems · 2023',
        'authors' => 'Dr. Rahul S., Ms. Kavya N.',
        'keywords' => ['Cybersecurity', 'Web Security', 'Threat Detection'],
        'citations' => 18,
        'desc'  => 'Focuses on identifying vulnerabilities such as SQL injection, XSS, and CSRF. It also presents modern security practices including encryption, authentication models, and secure coding standards.'
    ],
    'PUB003' => [
        'title' => 'Data Analytics for Academic Performance Prediction',
        'meta'  => 'International Journal of Data Science · 2022',
        'authors' => 'Prof. Vinay K., Dr. Shreya M.',
        'keywords' => ['Data Science', 'Prediction', 'Education'],
        'citations' => 30,
        'desc'  => 'Introduces machine learning models to predict student performance using historical data. Helps institutions take early interventions and improve academic outcomes.'
    ]
];

/* 🔹 RECENT RESEARCHES */
$recent_research = [
    [
        'title' => 'Blockchain in Education Systems',
        'desc' => 'Ensures secure academic records, transparent certification, and tamper-proof student data management.'
    ],
    [
        'title' => 'Edge Computing for IoT Applications',
        'desc' => 'Improves real-time processing by reducing latency in smart devices and IoT ecosystems.'
    ],
    [
        'title' => 'AI Chatbots in Student Support Systems',
        'desc' => 'Enhances student engagement by providing 24/7 automated assistance and guidance.'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Publications | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}

body{
    background:linear-gradient(135deg,#f8fafc,#eef2ff);
    color:#1e293b;
}

/* NAV */
.navbar{
    background:linear-gradient(90deg,#0f766e,#0ea5e9);
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    color:white;
}

/* HEADER */
.header{text-align:center;padding:50px 20px;}
.header h1{font-size:38px;}
.header p{margin-top:10px;color:#475569;}

/* STATS */
.stats{
    max-width:1000px;
    margin:20px auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
}
.stat-box{
    background:white;
    padding:25px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 10px 20px rgba(0,0,0,0.08);
}

/* CONTAINER */
.container{
    max-width:1100px;
    margin:40px auto;
    padding:0 20px;
}

/* PUBLICATION */
.publication{
    background:white;
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.pub-title{font-size:22px;color:#0f766e;}
.pub-meta{font-size:14px;color:#64748b;margin-top:5px;}
.pub-authors{margin-top:8px;font-size:14px;}

.pub-desc{margin-top:12px;line-height:1.6;}

/* TAGS */
.tags{margin-top:10px;}
.tag{
    display:inline-block;
    background:#e0f2fe;
    padding:5px 10px;
    border-radius:12px;
    margin-right:5px;
    font-size:12px;
}

/* ACTION */
.pub-actions{margin-top:15px;}
.view{
    background:#0ea5e9;
    color:white;
    padding:8px 15px;
    border-radius:20px;
    text-decoration:none;
}

/* RECENT RESEARCH */
.research{
    margin-top:50px;
}
.research-card{
    background:#fff;
    padding:20px;
    border-left:6px solid #0ea5e9;
    margin-bottom:15px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

/* FOOTER */
.footer{text-align:center;padding:30px;color:#64748b;}
</style>
</head>

<body>

<div class="navbar">
    <h2>📚 Publications</h2>
    <a href="../postgraduate.php" style="color:white;">Dashboard</a>
</div>

<div class="header">
    <h1>Research & Academic Publications</h1>
    <p>Explore journals, conferences, and latest innovations</p>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat-box"><h3>48</h3><p>Total Publications</p></div>
    <div class="stat-box"><h3>22</h3><p>Journal Papers</p></div>
    <div class="stat-box"><h3>14</h3><p>Conference Papers</p></div>
    <div class="stat-box"><h3>12</h3><p>Indexed Papers</p></div>
</div>

<!-- PUBLICATIONS -->
<div class="container">

<h2>📄Publications</h2>

<?php foreach ($publications as $id => $pub): ?>
<div class="publication">

    <div class="pub-title"><?php echo $pub['title']; ?></div>
    <div class="pub-meta"><?php echo $pub['meta']; ?></div>

    <div class="pub-authors">
        👨‍🏫 <b>Authors:</b> <?php echo $pub['authors']; ?>
    </div>

    <div class="pub-desc"><?php echo $pub['desc']; ?></div>

    <div class="tags">
        <?php foreach($pub['keywords'] as $tag): ?>
            <span class="tag"><?php echo $tag; ?></span>
        <?php endforeach; ?>
    </div>

    <div class="pub-actions">
        📊 Citations: <?php echo $pub['citations']; ?>
        <br><br>
        <a href="view_publication.php?id=<?php echo $id; ?>" class="view">View Details</a>
    </div>

</div>
<?php endforeach; ?>

<!-- RECENT RESEARCH -->
<div class="research">
    <h2>🚀 Latest Research Trends</h2>

    <?php foreach($recent_research as $r): ?>
        <div class="research-card">
            <h3><?php echo $r['title']; ?></h3>
            <p><?php echo $r['desc']; ?></p>
        </div>
    <?php endforeach; ?>

</div>

</div>

<div class="footer">
© <?php echo date('Y'); ?> Unified Education System · Research & Innovation
</div>

</body>
</html>
