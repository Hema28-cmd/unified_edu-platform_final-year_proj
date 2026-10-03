<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: dashboard.php");
    exit;
}

/* ================= RESEARCH DATA ================= */
$research_projects = [
    [
        'title' => 'AI in Healthcare',
        'description' => 'This research explores how Artificial Intelligence can transform the healthcare sector. It focuses on disease prediction, medical image analysis, virtual assistants for patient care, and automated diagnosis systems. The project also studies ethical concerns, data privacy, and reliability of AI-driven healthcare systems.',
        
        'details' => [
            'Study machine learning models used in disease prediction.',
            'Analyze medical imaging using deep learning techniques.',
            'Develop AI-based virtual assistants for patient interaction.',
            'Evaluate accuracy and ethical challenges in AI healthcare.',
            'Research real-world applications in hospitals and clinics.'
        ],
        
        'technologies' => ['Python', 'TensorFlow', 'NLP', 'Deep Learning']
    ],
    [
        'title' => 'Cybersecurity Threat Analysis',
        'description' => 'This research focuses on identifying and analyzing modern cybersecurity threats such as malware, phishing, ransomware, and network attacks. It also includes developing strategies to detect vulnerabilities and protect systems from cyber risks.',
        
        'details' => [
            'Study different types of cyber attacks and their impact.',
            'Analyze network traffic using security tools.',
            'Identify vulnerabilities in systems and applications.',
            'Develop mitigation strategies and security policies.',
            'Test systems using ethical hacking techniques.'
        ],
        
        'technologies' => ['Wireshark', 'Kali Linux', 'Firewall', 'Network Security']
    ],
    [
        'title' => 'Cloud Cost Optimization',
        'description' => 'This research investigates techniques to reduce cloud infrastructure costs while maintaining performance. It focuses on efficient resource allocation, monitoring usage, and implementing cost-saving strategies in cloud platforms.',
        
        'details' => [
            'Analyze cloud usage patterns and billing data.',
            'Identify underutilized resources.',
            'Implement auto-scaling and load balancing.',
            'Apply cost optimization tools and techniques.',
            'Monitor and evaluate performance vs cost efficiency.'
        ],
       
        'technologies' => ['AWS', 'Terraform', 'Python', 'Cloud Monitoring']
    ],
    [
        'title' => 'Data Science for Social Good',
        'description' => 'This research uses data science techniques to solve social problems such as poverty, education gaps, and healthcare accessibility. It focuses on analyzing datasets to derive meaningful insights that can help improve public welfare programs.',
        
        'details' => [
            'Collect and clean real-world social datasets.',
            'Perform exploratory data analysis (EDA).',
            'Visualize trends and patterns using graphs.',
            'Build predictive models for social improvement.',
            'Provide insights for decision-making and policy planning.'
        ],
        
        'technologies' => ['Python', 'Pandas', 'Matplotlib', 'Data Analysis']
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Research Projects | Postgraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

<style>
body {
    margin:0;
    font-family: 'Roboto', sans-serif;
    background: #f0f4f8;
    color: #1f2937;
}
.header {
    background: linear-gradient(135deg,#6366f1,#f472b6);
    color: white;
    text-align: center;
    padding: 50px 20px;
    border-radius: 0 0 50px 50px;
}
.header h1 { font-size: 36px; margin: 0;}
.header p { opacity: 0.85; font-size: 16px; margin-top: 5px;}

.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit,minmax(320px,1fr));
    gap: 25px;
}

.card {
    background: white;
    border-radius: 25px;
    padding: 25px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 45px rgba(0,0,0,0.15);
}

.card h2 {
    font-size: 22px;
    margin-bottom: 10px;
    color:#4f46e5;
}

.card p {
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 15px;
}

.meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    font-size: 13px;
    margin-bottom: 10px;
}

.meta div {
    background: #e0e7ff;
    padding: 6px 12px;
    border-radius: 15px;
}

.status {
    padding: 6px 12px;
    border-radius: 15px;
    font-weight: 600;
    color:white;
}

.status.Ongoing { background:#f59e0b;}
.status.Completed { background:#16a34a;}
.status.Upcoming { background:#ef4444;}

.details {
    margin-top: 10px;
}

.details li {
    margin-bottom: 8px;
    font-size: 13px;
}

.back-btn {
    display:block;
    width:220px;
    margin: 40px auto;
    padding:14px;
    background:#4f46e5;
    color:white;
    text-align:center;
    text-decoration:none;
    border-radius:30px;
    font-weight:500;
    text-transform: uppercase;
}

.back-btn:hover { background:#4338ca; }
</style>
</head>

<body>

<div class="header">
    <h1>🔬 Postgraduate Research Projects</h1>
    <p>Explore Advanced Research Topics and Implementation Areas</p>
</div>

<div class="container">
<?php foreach($research_projects as $r){ ?>
    <div class="card">
        <h2><?php echo $r['title']; ?></h2>

        <p><?php echo $r['description']; ?></p>

        
        <p><b>Technologies:</b> <?php echo implode(', ', $r['technologies']); ?></p>

        <div class="details">
            <b>🔍 Research Focus:</b>
            <ul>
                <?php foreach($r['details'] as $d){ ?>
                    <li><?php echo $d; ?></li>
                <?php } ?>
            </ul>
        </div>

    </div>
<?php } ?>
</div>

<a href="../postgraduate.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
