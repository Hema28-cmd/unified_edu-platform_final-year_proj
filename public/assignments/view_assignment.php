<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: dashboard.php");
    exit;
}

// ================= ALL ASSIGNMENTS =================
$assignments = [
    'PG301' => [
        'title' => 'Machine Learning Experimentation',
        'description' => 'This assignment focuses on implementing and analyzing various machine learning algorithms. Students will work with real-world datasets to understand model behavior, accuracy, and performance metrics.',
        
        'objectives' => [
            'Understand supervised learning concepts.',
            'Implement classification and regression models.',
            'Evaluate model performance using metrics.',
            'Learn data preprocessing and feature selection.'
        ],

        'implementation' => [
            'Load dataset using Python (Pandas).',
            'Perform data cleaning and preprocessing.',
            'Apply algorithms like Linear Regression, Decision Trees.',
            'Train and test models.',
            'Evaluate using accuracy, precision, recall.',
            'Visualize results using graphs.'
        ],

        'expected_output' => 'A complete Jupyter Notebook with code, graphs, and analysis explaining model performance.',

        'type' => 'Practical',
        'resources' => ['Python', 'Scikit-learn', 'Jupyter Notebook'],
        'topics' => ['Classification', 'Regression', 'Data Preprocessing'],
        'instructions' => 'Submit notebook and PDF report with explanation.'
    ],

    'PG302' => [
        'title' => 'Cloud Security Case Study',
        'description' => 'This assignment involves analyzing real-world cloud security incidents and understanding vulnerabilities in cloud infrastructure. Students will propose security measures and mitigation strategies.',

        'objectives' => [
            'Understand cloud architecture and risks.',
            'Analyze real-world cyber attacks.',
            'Learn security frameworks.',
            'Propose mitigation strategies.'
        ],

        'implementation' => [
            'Select a real-world cloud attack case.',
            'Analyze cause of security breach.',
            'Identify vulnerabilities.',
            'Propose security solutions.',
            'Create diagrams explaining attack flow.'
        ],

        'expected_output' => 'A detailed report explaining attack, vulnerabilities, and mitigation strategies with diagrams.',

        'type' => 'Case Study',
        'resources' => ['AWS', 'Azure', 'Kali Linux'],
        'topics' => ['Cloud Security', 'Threat Analysis', 'Risk Management'],
        'instructions' => 'Submit a structured report with diagrams.'
    ],

    'PG303' => [
        'title' => 'IoT Sensor Data Analysis',
        'description' => 'This assignment focuses on analyzing IoT sensor data to detect patterns, trends, and anomalies using statistical and visualization techniques.',

        'objectives' => [
            'Understand IoT data structure.',
            'Perform data analysis.',
            'Detect anomalies.',
            'Visualize trends effectively.'
        ],

        'implementation' => [
            'Import dataset into Python.',
            'Clean and preprocess sensor data.',
            'Analyze trends using statistical methods.',
            'Create graphs and charts.',
            'Identify unusual patterns or anomalies.'
        ],

        'expected_output' => 'A dataset analysis report with visualizations and insights.',

        'type' => 'Report',
        'resources' => ['Python', 'Pandas', 'Matplotlib', 'Excel'],
        'topics' => ['IoT', 'Data Analysis', 'Visualization'],
        'instructions' => 'Submit dataset and PDF report.'
    ],

    'PG304' => [
        'title' => 'Natural Language Processing Project',
        'description' => 'This project involves building an NLP model for tasks such as sentiment analysis or text classification using real datasets.',

        'objectives' => [
            'Understand NLP techniques.',
            'Preprocess text data.',
            'Build classification models.',
            'Evaluate model performance.'
        ],

        'implementation' => [
            'Collect text dataset.',
            'Perform text preprocessing (tokenization, stopword removal).',
            'Convert text to numerical form (TF-IDF).',
            'Train classification model.',
            'Evaluate accuracy and improve model.'
        ],

        'expected_output' => 'Working NLP model with accuracy results and explanation.',

        'type' => 'Project',
        'resources' => ['Python', 'NLTK', 'Scikit-learn'],
        'topics' => ['NLP', 'Text Classification', 'Sentiment Analysis'],
        'instructions' => 'Submit code and report.'
    ],

    'PG305' => [
        'title' => 'Data Visualization Mini-Project',
        'description' => 'This assignment focuses on presenting data using visual storytelling techniques through charts and graphs.',

        'objectives' => [
            'Understand data visualization principles.',
            'Create meaningful charts.',
            'Interpret data visually.',
            'Improve storytelling skills.'
        ],

        'implementation' => [
            'Collect or use sample dataset.',
            'Clean and prepare data.',
            'Create bar, line, and pie charts.',
            'Use advanced visualization tools.',
            'Interpret and explain findings.'
        ],

        'expected_output' => 'At least 3 visualizations with explanation of insights.',

        'type' => 'Project',
        'resources' => ['Python', 'Matplotlib', 'Seaborn', 'Plotly'],
        'topics' => ['Data Visualization', 'Charts', 'Data Storytelling'],
        'instructions' => 'Submit visuals and report.'
    ],

'PG306' => [
    'title' => 'Deep Learning for Image Recognition',
    'description' => 'This assignment focuses on building deep learning models for image classification using Convolutional Neural Networks (CNN). Students will explore how neural networks process visual data and improve model accuracy using advanced techniques.',

    'objectives' => [
        'Understand fundamentals of deep learning.',
        'Learn CNN architecture and layers.',
        'Train models on image datasets.',
        'Improve accuracy using tuning techniques.'
    ],

    'implementation' => [
        'Collect or use datasets like MNIST or CIFAR-10.',
        'Preprocess images (resize, normalize).',
        'Build CNN model using TensorFlow or PyTorch.',
        'Train model and evaluate accuracy.',
        'Optimize using dropout and hyperparameter tuning.'
    ],

    'expected_output' => 'A trained CNN model with accuracy report and visual performance graphs.',

    'type' => 'Project',
    'resources' => ['Python', 'TensorFlow', 'Keras', 'OpenCV'],
    'topics' => ['Deep Learning', 'CNN', 'Image Processing'],
    'instructions' => 'Submit code, trained model results, and explanation report.'
],

'PG307' => [
    'title' => 'Big Data Analytics using Hadoop',
    'description' => 'This assignment introduces students to big data technologies. It focuses on processing large-scale datasets using Hadoop ecosystem tools such as HDFS and MapReduce.',

    'objectives' => [
        'Understand big data concepts.',
        'Learn Hadoop architecture.',
        'Process large datasets efficiently.',
        'Analyze distributed computing systems.'
    ],

    'implementation' => [
        'Set up Hadoop environment.',
        'Load dataset into HDFS.',
        'Write MapReduce programs.',
        'Execute data processing tasks.',
        'Analyze output results.'
    ],

    'expected_output' => 'Processed dataset with insights and execution logs.',

    'type' => 'Practical',
    'resources' => ['Hadoop', 'HDFS', 'MapReduce', 'Linux'],
    'topics' => ['Big Data', 'Distributed Systems', 'Data Processing'],
    'instructions' => 'Submit execution screenshots and report.'
],

'PG308' => [
    'title' => 'Blockchain-Based Secure Transactions',
    'description' => 'This assignment explores blockchain technology and its application in secure digital transactions. Students will understand how decentralized systems work and implement a basic blockchain model.',

    'objectives' => [
        'Understand blockchain fundamentals.',
        'Learn about cryptographic hashing.',
        'Explore decentralized systems.',
        'Implement basic blockchain structure.'
    ],

    'implementation' => [
        'Study blockchain concepts and architecture.',
        'Create simple blockchain using Python.',
        'Implement hashing using SHA algorithms.',
        'Simulate transaction validation.',
        'Analyze security and transparency features.'
    ],

    'expected_output' => 'A working blockchain simulation with transaction records.',

    'type' => 'Project',
    'resources' => ['Python', 'Cryptography', 'Blockchain Libraries'],
    'topics' => ['Blockchain', 'Cryptography', 'Security'],
    'instructions' => 'Submit code and explanation of blockchain working.'
],
];

// ================= GET ASSIGNMENT =================
$id = $_GET['id'] ?? '';
$assignment = $assignments[$id] ?? null;

if (!$assignment) {
    die("<h2 style='text-align:center;color:red;'>Assignment not found.</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $assignment['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(120deg,#fef3c7,#e0f7fa);
}
.header {
    background: linear-gradient(135deg,#6366f1,#f472b6);
    color:white;
    text-align:center;
    padding:50px;
}
.container {
    max-width:800px;
    margin:40px auto;
    padding:25px;
    background:white;
    border-radius:20px;
}
h2 { color:#4f46e5; }

.section {
    margin-top:20px;
}
.section h3 {
    color:#db2777;
}
ul li {
    margin-bottom:6px;
}

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
</style>
</head>

<body>

<div class="header">
    <h1>📄 Assignment Details</h1>
</div>

<div class="container">

<h2><?php echo $assignment['title']; ?></h2>
<p><?php echo $assignment['description']; ?></p>

<div class="section">
<h3>🎯 Objectives</h3>
<ul>
<?php foreach($assignment['objectives'] as $obj){ echo "<li>$obj</li>"; } ?>
</ul>
</div>

<div class="section">
<h3>⚙ Implementation Steps</h3>
<ul>
<?php foreach($assignment['implementation'] as $step){ echo "<li>$step</li>"; } ?>
</ul>
</div>

<div class="section">
<h3>📚 Resources</h3>
<ul>
<?php foreach($assignment['resources'] as $res){ echo "<li>$res</li>"; } ?>
</ul>
</div>

<div class="section">
<h3>📌 Topics Covered</h3>
<ul>
<?php foreach($assignment['topics'] as $topic){ echo "<li>$topic</li>"; } ?>
</ul>
</div>

<div class="section">
<h3>📤 Expected Output</h3>
<p><?php echo $assignment['expected_output']; ?></p>
</div>

<div class="section">
<h3>📝 Instructions</h3>
<p><?php echo $assignment['instructions']; ?></p>
</div>

</div>

<a href="postgraduate_assignments.php" class="back-btn">⬅ Back</a>

</body>
</html>