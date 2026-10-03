<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? 'ai';

/* Courses data */
$courses = [
    'ai' => [
        'title' => 'Artificial Intelligence',
        'description' => 'Advanced postgraduate course focusing on intelligent systems, machine learning, and real-world AI applications.',
        'syllabus' => [
            'Foundations of Artificial Intelligence',
            'Problem Solving & Search Techniques',
            'Machine Learning Models',
            'Deep Learning Architectures',
            'Natural Language Processing',
            'Ethical & Responsible AI'
        ],
        'outcomes' => [
            'Build intelligent systems',
            'Apply ML algorithms in real scenarios',
            'Analyze AI-driven solutions',
            'Follow ethical AI practices'
        ],
        'assessments' => [
            'Assignments & Case Studies',
            'Mid-Term Examination',
            'Mini AI Project',
            'Final Capstone Project'
        ],
        'careers' => [
            'AI Engineer',
            'ML Engineer',
            'Data Scientist',
            'Research Associate'
        ],
        'resources' => [
            'Lecture PDFs',
            'Python Lab Notebooks',
            'Research Articles',
            'Industry Case Studies'
        ]
    ],
    'ml' => [
        'title' => 'Machine Learning',
        'description' => 'Postgraduate course covering supervised, unsupervised, and reinforcement learning, regression, classification, and neural networks.',
        'syllabus' => [
            'Introduction to Machine Learning',
            'Supervised Learning Algorithms',
            'Unsupervised Learning & Clustering',
            'Regression & Classification Techniques',
            'Neural Networks & Deep Learning',
            'Model Evaluation & Optimization'
        ],
        'outcomes' => [
            'Design and implement ML models',
            'Analyze datasets for insights',
            'Evaluate and optimize models',
            'Apply ML solutions to real-world problems'
        ],
        'assessments' => [
            'Assignments & Mini Projects',
            'Mid-Term Quiz',
            'Capstone Project'
        ],
        'careers' => [
            'ML Engineer',
            'Data Scientist',
            'AI Researcher',
            'Analytics Consultant'
        ],
        'resources' => [
            'Lecture PDFs',
            'Python Notebooks',
            'ML Tutorials',
            'Research Papers'
        ]
    ],
    'cyber' => [
        'title' => 'Cyber Security',
        'description' => 'Postgraduate course focusing on network security, cryptography, ethical hacking, and risk management.',
        'syllabus' => [
            'Introduction to Cyber Security',
            'Network Security Protocols',
            'Cryptography & Encryption',
            'Ethical Hacking & Penetration Testing',
            'Security Risk Management',
            'Incident Response & Forensics'
        ],
        'outcomes' => [
            'Secure network infrastructures',
            'Perform vulnerability assessment',
            'Implement cryptography solutions',
            'Respond to security incidents'
        ],
        'assessments' => [
            'Lab Assignments',
            'Penetration Testing Projects',
            'Mid-Term Quiz',
            'Final Security Audit Project'
        ],
        'careers' => [
            'Cyber Security Analyst',
            'Penetration Tester',
            'Security Consultant',
            'Network Security Engineer'
        ],
        'resources' => [
            'Security Lab Exercises',
            'Network Capture Files',
            'Cyber Security Articles',
            'Penetration Testing Tools'
        ]
    ],
    'data' => [
        'title' => 'Data Science',
        'description' => 'Postgraduate course focusing on data analysis, visualization, predictive modeling, and business intelligence.',
        'syllabus' => [
            'Data Wrangling & Preprocessing',
            'Exploratory Data Analysis',
            'Statistical Modeling',
            'Machine Learning for Data Science',
            'Data Visualization Techniques',
            'Big Data & Cloud Analytics'
        ],
        'outcomes' => [
            'Analyze complex datasets',
            'Build predictive models',
            'Visualize insights for decision making',
            'Apply data science in real-world scenarios'
        ],
        'assessments' => [
            'Assignments & Mini Projects',
            'Data Analysis Projects',
            'Mid-Term Quiz',
            'Capstone Data Science Project'
        ],
        'careers' => [
            'Data Scientist',
            'Business Analyst',
            'Data Engineer',
            'ML Engineer'
        ],
        'resources' => [
            'Python & R Notebooks',
            'Datasets',
            'Visualization Tools',
            'Research Papers'
        ]
    ],
    'cloud' => [
        'title' => 'Cloud Computing',
        'description' => 'Postgraduate course covering cloud architecture, virtualization, cloud security, and deployment strategies.',
        'syllabus' => [
            'Introduction to Cloud Computing',
            'Virtualization & Containers',
            'Cloud Architecture & Services',
            'Cloud Security & Compliance',
            'Deployment & Orchestration',
            'Monitoring & Cost Optimization'
        ],
        'outcomes' => [
            'Design cloud-based solutions',
            'Deploy applications on cloud platforms',
            'Ensure cloud security & compliance',
            'Optimize cloud resources'
        ],
        'assessments' => [
            'Lab Exercises',
            'Cloud Deployment Projects',
            'Mid-Term Quiz',
            'Capstone Cloud Project'
        ],
        'careers' => [
            'Cloud Solutions Architect',
            'DevOps Engineer',
            'Cloud Security Specialist',
            'Cloud Administrator'
        ],
        'resources' => [
            'Cloud Platform Labs',
            'Deployment Guides',
            'Security Best Practices',
            'Cloud Tutorials'
        ]
    ],
    'network' => [
        'title' => 'Networking',
        'description' => 'Postgraduate course focusing on network protocols, switching, routing, and advanced network management.',
        'syllabus' => [
            'Networking Fundamentals',
            'Switching & Routing Protocols',
            'Wireless & Mobile Networks',
            'Network Management & Monitoring',
            'Network Security Fundamentals',
            'Advanced Networking Concepts'
        ],
        'outcomes' => [
            'Configure network devices',
            'Design and manage networks',
            'Troubleshoot network issues',
            'Ensure network reliability & security'
        ],
        'assessments' => [
            'Lab Exercises',
            'Network Configuration Projects',
            'Mid-Term Quiz',
            'Final Networking Capstone Project'
        ],
        'careers' => [
            'Network Engineer',
            'System Administrator',
            'Network Security Analyst',
            'IT Infrastructure Specialist'
        ],
        'resources' => [
            'Network Lab Exercises',
            'Simulation Tools',
            'Configuration Guides',
            'Networking Articles'
        ]
    ]
];

$course_data = $courses[$course] ?? null;

if(!$course_data){
    die("<h2 style='text-align:center;color:red'>Course not found</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $course_data['title']; ?> | PG Course</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{margin:0;font-family:'Poppins',sans-serif;background:#f1f5f9;color:#1e293b;}
.header{background:linear-gradient(135deg,#0f172a,#1e3a8a);color:#fff;padding:70px 20px;}
.header h1{font-size:40px;margin:0;}
.header p{max-width:700px;margin-top:12px;opacity:0.95;}
.wrapper{max-width:1200px;margin:-40px auto 60px;padding:20px;display:grid;grid-template-columns:320px 1fr;gap:25px;}
.sidebar{background:#111827;color:#e5e7eb;border-radius:22px;padding:25px;}
.sidebar h3{margin-top:0;margin-bottom:15px;}
.sidebar ul{padding-left:18px;}
.sidebar li{margin-bottom:10px;font-size:14px;}
.stat{background:#1f2937;border-radius:16px;padding:15px;margin-bottom:15px;text-align:center;}
.stat h4{margin:0;font-size:14px;color:#94a3b8;}
.stat p{margin:5px 0 0;font-size:20px;font-weight:600;color:#3b82f6;}
.content{background:#fff;border-radius:22px;padding:30px;box-shadow:0 15px 35px rgba(0,0,0,0.08);}
.section{margin-bottom:35px;}
.section h2{margin-bottom:15px;font-size:24px;color:#0f172a;}
.timeline{border-left:3px solid #1e3a8a;padding-left:20px;}
.timeline li{list-style:none;margin-bottom:14px;position:relative;}
.timeline li::before{content:'';width:12px;height:12px;background:#1e3a8a;border-radius:50%;position:absolute;left:-27px;top:6px;}
.tags{display:flex;flex-wrap:wrap;gap:10px;}
.tag{background:#dbeafe;color:#1e40af;padding:8px 14px;border-radius:20px;font-size:14px;}
.actions{display:flex;flex-wrap:wrap;gap:14px;}
.actions a{text-decoration:none;background:#1e3a8a;color:#fff;padding:12px 22px;border-radius:30px;font-size:14px;transition:0.3s;}
.actions a:hover{background:#111e5a;}
.back{display:block;width:240px;margin:40px auto;text-align:center;padding:14px;background:#ef4444;color:#fff;border-radius:30px;text-decoration:none;}
@media(max-width:900px){.wrapper{grid-template-columns:1fr;}}
</style>
</head>
<body>

<div class="header">
    <h1><?php echo $course_data['title']; ?></h1>
    <p><?php echo $course_data['description']; ?></p>
</div>

<div class="wrapper">

<aside class="sidebar">
    <h3>🎓 Academic Focus</h3>
    <ul>
        <?php if($course=='ai'): ?>
            <li>Advanced problem-solving using AI models</li>
            <li>Hands-on implementation with real datasets</li>
            <li>Research-oriented learning approach</li>
            <li>Ethical and responsible AI practices</li>
        <?php elseif($course=='ml'): ?>
            <li>Hands-on ML implementations</li>
            <li>Real-world datasets analysis</li>
            <li>Model evaluation & optimization</li>
            <li>Ethical AI & responsible ML</li>
        <?php elseif($course=='cyber'): ?>
            <li>Network & system security</li>
            <li>Penetration testing</li>
            <li>Cryptography & secure communication</li>
            <li>Risk assessment & incident response</li>
        <?php elseif($course=='ds'): ?>
            <li>Data cleaning & analysis</li>
            <li>Predictive modeling</li>
            <li>Data visualization & reporting</li>
            <li>Big Data techniques</li>
        <?php elseif($course=='cloud'): ?>
            <li>Cloud architecture & deployment</li>
            <li>Virtualization & containers</li>
            <li>Security & compliance</li>
            <li>Resource optimization</li>
        <?php elseif($course=='networking'): ?>
            <li>Network design & implementation</li>
            <li>Routing & switching</li>
            <li>Network monitoring & troubleshooting</li>
            <li>Security & reliability</li>
        <?php endif; ?>
    </ul>

    <div class="stat"><h4>Course Level</h4><p>Postgraduate</p></div>
    <div class="stat"><h4>Expected Weekly Effort</h4><p>8–10 Hours</p></div>
    <div class="stat"><h4>Evaluation Style</h4><p>Continuous Assessment</p></div>

    <h3>📌 Prerequisites</h3>
    <ul>
        <li>Python programming basics</li>
        <li>Data structures fundamentals</li>
        <li>Mathematics & statistics knowledge</li>
    </ul>

    <h3>📈 Skill Development</h3>
    <ul>
        <?php if($course=='ai'): ?>
            <li>Analytical & logical thinking</li>
            <li>Model building & evaluation</li>
            <li>Research documentation</li>
            <li>Team-based project execution</li>
        <?php elseif($course=='ml'): ?>
            <li>ML model building</li>
            <li>Data analysis & interpretation</li>
            <li>Research & documentation</li>
            <li>Project implementation skills</li>
        <?php elseif($course=='cyber'): ?>
            <li>Cybersecurity risk management</li>
            <li>Incident response skills</li>
            <li>Ethical hacking expertise</li>
            <li>Security policy understanding</li>
        <?php elseif($course=='ds'): ?>
            <li>Data wrangling & preprocessing</li>
            <li>Predictive analytics</li>
            <li>Visualization & reporting</li>
            <li>Big Data handling</li>
        <?php elseif($course=='cloud'): ?>
            <li>Cloud deployment skills</li>
            <li>Virtualization & orchestration</li>
            <li>Security compliance</li>
            <li>Monitoring & optimization</li>
        <?php elseif($course=='networking'): ?>
            <li>Network configuration</li>
            <li>Troubleshooting & monitoring</li>
            <li>Security & firewall management</li>
            <li>Network documentation</li>
        <?php endif; ?>
    </ul>
</aside>

<main class="content">
    <div class="section">
        <h2>📘 Course Overview</h2>
        <p>This course combines theoretical knowledge and practical exposure to modern <?php echo strtoupper($course); ?> techniques, preparing students for industry and research roles.</p>
    </div>

    <div class="section">
        <h2>🧠 Syllabus Structure</h2>
        <ul class="timeline">
            <?php foreach($course_data['syllabus'] as $s){ echo "<li>$s</li>"; } ?>
        </ul>
    </div>

    <div class="section">
        <h2>📝 Assessment Pattern</h2>
        <div class="tags">
            <?php foreach($course_data['assessments'] as $a){ echo "<span class='tag'>$a</span>"; } ?>
        </div>
    </div>

    <div class="section">
        <h2>🚀 Career Pathways</h2>
        <div class="tags">
            <?php foreach($course_data['careers'] as $c){ echo "<span class='tag'>$c</span>"; } ?>
        </div>
    </div>

    <div class="section">
        <h2>📚 Academic Resources</h2>
        <ul>
            <?php foreach($course_data['resources'] as $r){ echo "<li>$r</li>"; } ?>
        </ul>
    </div>

    <div class="section">
        <h2>📂 Course Activities</h2>
        <div class="actions">
            <a href="assignments.php?course=<?php echo $course; ?>"><i class="fa-solid fa-pen"></i> Assignments</a>
            <a href="quizzes.php?course=<?php echo $course; ?>"><i class="fa-solid fa-question"></i> Quizzes</a>
            <a href="projects.php?course=<?php echo $course; ?>"><i class="fa-solid fa-diagram-project"></i> Projects</a>
            <a href="materials.php?course=<?php echo $course; ?>"><i class="fa-solid fa-book"></i> Materials</a>
        </div>
    </div>
</main>

</div>

<a href="postgraduate_courses.php" class="back"><i class="fa-solid fa-arrow-left"></i> Back to Dashboard</a>

</body>
</html>
