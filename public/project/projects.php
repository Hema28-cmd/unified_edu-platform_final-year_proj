<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    die("<h2 style='text-align:center;color:red;'>Access Denied</h2>");
}

$projects = [
    [
        'title' => 'AI-Powered Healthcare Dashboard',
        'description' => 'Develop an intelligent healthcare dashboard that uses machine learning algorithms to predict patient health risks. The system will analyze patient data such as age, medical history, and vital signs to provide early warnings and insights for doctors. This project enhances decision-making in healthcare using AI techniques.',

        'duration' => '6 Months',

        'technologies' => ['Python', 'TensorFlow', 'Flask', 'Chart.js'],

        'objectives' => [
            'Understand healthcare data analysis.',
            'Apply machine learning models for prediction.',
            'Develop interactive dashboards.',
            'Improve patient monitoring systems.'
        ],

        'implementation' => [
            'Collect and preprocess patient dataset.',
            'Train ML model (classification/regression).',
            'Develop backend using Flask.',
            'Design frontend dashboard with charts.',
            'Integrate model predictions into UI.'
        ],

        'output' => 'A working dashboard showing patient risk predictions with graphs and alerts.'
    ],

    [
        'title' => 'Cybersecurity Risk Assessment Tool',
        'description' => 'Build a cybersecurity tool that scans networks to identify vulnerabilities and generates automated security reports. The system will simulate real-world cyber threats and provide recommendations to improve system security and protect data from attacks.',

        'duration' => '5 Months',

        'technologies' => ['Kali Linux', 'Python', 'Nmap', 'Wireshark'],

        'objectives' => [
            'Understand network security concepts.',
            'Identify vulnerabilities in systems.',
            'Analyze cyber threats.',
            'Suggest preventive measures.'
        ],

        'implementation' => [
            'Scan network using Nmap.',
            'Capture packets using Wireshark.',
            'Analyze vulnerabilities.',
            'Generate automated reports.',
            'Suggest security improvements.'
        ],

        'output' => 'A tool that detects vulnerabilities and generates detailed security reports.'
    ],

    [
        'title' => 'Smart IoT Agriculture System',
        'description' => 'Design an IoT-based agriculture system that monitors environmental conditions like soil moisture, temperature, and humidity. The system will automatically control irrigation based on real-time sensor data, improving crop yield and water efficiency.',

        'duration' => '7 Months',

        'technologies' => ['Arduino', 'Raspberry Pi', 'Python', 'AWS IoT'],

        'objectives' => [
            'Understand IoT systems.',
            'Collect real-time sensor data.',
            'Automate irrigation systems.',
            'Improve agricultural efficiency.'
        ],

        'implementation' => [
            'Connect sensors to Arduino.',
            'Collect real-time data.',
            'Send data to cloud platform.',
            'Analyze data using Python.',
            'Automate irrigation system.'
        ],

        'output' => 'A smart irrigation system that operates automatically based on sensor input.'
    ],

    [
        'title' => 'Data Visualization for Social Analytics',
        'description' => 'Analyze social media data to identify trends, user behavior, and engagement patterns. This project focuses on creating interactive dashboards that visually represent complex data, helping businesses make informed decisions.',

        'duration' => '4 Months',

        'technologies' => ['Python', 'Plotly', 'Dash', 'Pandas'],

        'objectives' => [
            'Understand social media analytics.',
            'Process large datasets.',
            'Create interactive dashboards.',
            'Interpret visual data insights.'
        ],

        'implementation' => [
            'Collect social media dataset.',
            'Clean and preprocess data.',
            'Analyze trends using Python.',
            'Create dashboards using Plotly/Dash.',
            'Present insights visually.'
        ],

        'output' => 'Interactive dashboards showing trends, engagement, and analytics.'
    ]
];
function getStatusColor($status){
    return match($status){
        'Completed' => '#16a34a', // green
        'Ongoing' => '#f59e0b',   // orange
        'Upcoming' => '#ef4444',  // red
        default => '#64748b',
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Projects</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: #f5f7fa;
    color:#1f2937;
}
.header {
    background: linear-gradient(135deg,#8b5cf6,#ec4899);
    color:white;
    text-align:center;
    padding:50px 20px;
    border-bottom-left-radius:50px;
    border-bottom-right-radius:50px;
}
.header h1 {margin:0;font-size:36px;}
.header p {margin-top:10px;font-size:18px;opacity:0.85;}

.container {
    max-width:1000px;
    margin:40px auto;
    padding:0 20px;
    display:flex;
    flex-direction:column;
    gap:20px;
}

.card {
    display:flex;
    flex-direction: row;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    overflow:hidden;
    transition:0.3s;
}
.card:nth-child(even) { background: #d1fae5; }  /* pastel mint */
.card:nth-child(odd) { background: #ffe4e6; }   /* pastel peach */

.card-left {
    flex:1;
    padding:25px;
    border-right:2px solid #e5e7eb;
}
.card-right {
    flex:1;
    padding:25px;
}

.card h2 {
    margin-top:0;
    margin-bottom:10px;
    color:#6b21a8;
    font-size:22px;
}
.card p.description {
    line-height:1.5;
    margin-bottom:15px;
}
.meta span {
    display:inline-block;
    margin-right:12px;
    padding:5px 12px;
    border-radius:12px;
    color:white;
    font-weight:600;
}
.status { background: #6366f1; }

.back-btn{
    display:block;
    width:220px;
    margin:40px auto;
    padding:14px;
    background: linear-gradient(135deg,#ec4899,#8b5cf6);
    color:white;
    text-align:center;
    text-decoration:none;
    border-radius:30px;
    font-weight:500;
}
.back-btn:hover{ background: linear-gradient(135deg,#be185d,#6b21a8); }
</style>
</head>
<body>

<div class="header">
    <h1>🛠 Postgraduate Projects</h1>
    <p>Explore all ongoing, completed, and upcoming projects</p>
</div>

<div class="container">
<?php foreach($projects as $p){ ?>
    <div class="card">
        <div class="card-left">
            <h2><?php echo $p['title']; ?></h2>
            <p class="description"><?php echo $p['description']; ?></p>
                    </div>
        <div class="card-right">
            <p><b>Technologies:</b> <?php echo implode(', ', $p['technologies']); ?></p>
                    </div>
    </div>
<?php } ?>
<p><b>Objectives:</b></p>
<ul>
<?php foreach($p['objectives'] as $o){ echo "<li>$o</li>"; } ?>
</ul>

<p><b>Implementation:</b></p>
<ul>
<?php foreach($p['implementation'] as $i){ echo "<li>$i</li>"; } ?>
</ul>

<p><b>Output:</b> <?php echo $p['output']; ?></p>
</div>

<a href="../postgraduate.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
