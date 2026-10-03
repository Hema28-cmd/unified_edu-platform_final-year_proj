<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? '';
$projectTitle = urldecode($_GET['title'] ?? '');

/* ================= PROJECT DATA ================= */
$all_projects = [

/* ================= AI ================= */
'ai' => [

    'AI Chatbot Development' => [
        'description' => 'This project focuses on developing an intelligent chatbot that can understand and respond to user queries using Natural Language Processing (NLP). The chatbot can be used in educational platforms to assist students by answering common questions.',

        'duration' => '3 Months',

        'detailed_steps' => [
            'Step 1: Understand the basic concepts of Artificial Intelligence and Natural Language Processing. Learn how chatbots work and study existing chatbot systems.',
            
            'Step 2: Collect sample data such as frequently asked questions and answers. This dataset will be used to train the chatbot.',
            
            'Step 3: Design the chatbot conversation flow. Define how the chatbot should respond to different types of questions.',
            
            'Step 4: Develop the chatbot using a programming language like Python. Use libraries such as NLTK or rule-based logic.',
            
            'Step 5: Test the chatbot with real users. Identify errors and improve responses to make it more accurate.'
        ],

        'after_project' => [
            'Deploy the chatbot on a website or mobile application.',
            'Improve chatbot accuracy using real-time data.',
            'Add voice interaction features.',
            'Use this project in your resume or portfolio.'
        ]
    ],

    'Predictive Analytics for Student Performance' => [
        'description' => 'This project aims to analyze student academic data and predict their future performance using machine learning techniques. It helps educational institutions identify weak students and improve learning outcomes.',

        'duration' => '4 Months',

        'detailed_steps' => [
            'Step 1: Collect student data such as marks, attendance, and assignments.',
            'Step 2: Clean and preprocess the dataset.',
            'Step 3: Apply machine learning algorithms.',
            'Step 4: Evaluate model accuracy.',
            'Step 5: Visualize results using graphs.'
        ],

        'after_project' => [
            'Implement the system in educational institutions.',
            'Improve prediction accuracy.',
            'Create dashboards for visualization.',
            'Use it for data science portfolio.'
        ]
    ]

], 

/* ================= ML ================= */
'ml' => [

    'ML Model for Stock Prediction' => [
        'description' => 'Build a regression model to predict stock prices using historical data and machine learning techniques.',
        'duration' => '3 Months',
        'detailed_steps' => [
            'Step 1: Collect historical stock price data.',
            'Step 2: Clean and preprocess the dataset.',
            'Step 3: Apply regression algorithms like Linear Regression.',
            'Step 4: Train and test the model.',
            'Step 5: Evaluate accuracy and visualize predictions.'
        ],
        'after_project' => [
            'Deploy model in web apps.',
            'Improve prediction using deep learning.',
            'Use for financial analytics projects.'
        ]
    ],

    'Image Classification with CNN' => [
        'description' => 'Implement Convolutional Neural Networks (CNN) to classify images into different categories.',
        'duration' => '4 Months',
        'detailed_steps' => [
            'Step 1: Collect image dataset.',
            'Step 2: Preprocess images (resize, normalize).',
            'Step 3: Build CNN model.',
            'Step 4: Train using TensorFlow/PyTorch.',
            'Step 5: Test accuracy and improve model.'
        ],
        'after_project' => [
            'Use in real-time image recognition.',
            'Deploy in mobile apps.',
            'Extend to object detection.'
        ]
    ],

    'Recommendation System Development' => [
        'description' => 'Develop a recommendation system using collaborative filtering or content-based filtering.',
        'duration' => '5 Months',
        'detailed_steps' => [
            'Step 1: Collect user-item interaction data.',
            'Step 2: Preprocess dataset.',
            'Step 3: Apply recommendation algorithms.',
            'Step 4: Evaluate system performance.',
            'Step 5: Improve recommendations.'
        ],
        'after_project' => [
            'Use in e-commerce platforms.',
            'Enhance personalization features.',
            'Deploy scalable systems.'
        ]
    ]
],

/* ================= CYBER ================= */
'cyber' => [

    'Network Penetration Testing' => [
        'description' => 'Simulate cyber attacks to identify vulnerabilities in network systems.',
        'duration' => '3 Months',
        'detailed_steps' => [
            'Step 1: Learn ethical hacking basics.',
            'Step 2: Set up testing environment.',
            'Step 3: Scan network vulnerabilities.',
            'Step 4: Perform penetration testing.',
            'Step 5: Document findings.'
        ],
        'after_project' => [
            'Work as ethical hacker.',
            'Improve network security.',
            'Use in real-world audits.'
        ]
    ],

    'Cybersecurity Risk Assessment' => [
        'description' => 'Analyze and evaluate security risks in enterprise systems.',
        'duration' => '4 Months',
        'detailed_steps' => [
            'Step 1: Identify assets.',
            'Step 2: Analyze threats.',
            'Step 3: Evaluate risks.',
            'Step 4: Suggest mitigation.',
            'Step 5: Prepare report.'
        ],
        'after_project' => [
            'Apply in companies.',
            'Improve security planning.',
            'Work in cybersecurity domain.'
        ]
    ],

    'Secure Coding Practices' => [
        'description' => 'Develop software with secure coding standards.',
        'duration' => '2 Months',
        'detailed_steps' => [
            'Step 1: Learn security principles.',
            'Step 2: Identify vulnerabilities.',
            'Step 3: Apply secure coding.',
            'Step 4: Test security.',
            'Step 5: Fix issues.'
        ],
        'after_project' => [
            'Develop secure applications.',
            'Avoid cyber attacks.',
            'Improve coding standards.'
        ]
    ]
],

/* ================= DATA ================= */
'data' => [

    'Data Cleaning & Preprocessing' => [
        'description' => 'Prepare raw data for analysis by cleaning and transforming it.',
        'duration' => '2 Months',
        'detailed_steps' => [
            'Step 1: Collect raw data.',
            'Step 2: Remove duplicates.',
            'Step 3: Handle missing values.',
            'Step 4: Normalize data.',
            'Step 5: Prepare final dataset.'
        ],
        'after_project' => [
            'Use in ML projects.',
            'Improve data quality.',
            'Apply in analytics.'
        ]
    ],

    'Exploratory Data Analysis' => [
        'description' => 'Analyze datasets to find patterns using visualization.',
        'duration' => '3 Months',
        'detailed_steps' => [
            'Step 1: Load dataset.',
            'Step 2: Perform statistical analysis.',
            'Step 3: Create visualizations.',
            'Step 4: Identify trends.',
            'Step 5: Report insights.'
        ],
        'after_project' => [
            'Use in data science.',
            'Improve decision making.',
            'Build dashboards.'
        ]
    ],

    'Data Pipeline Automation' => [
        'description' => 'Automate data collection and processing.',
        'duration' => '4 Months',
        'detailed_steps' => [
            'Step 1: Design pipeline.',
            'Step 2: Collect data.',
            'Step 3: Process automatically.',
            'Step 4: Store in database.',
            'Step 5: Monitor pipeline.'
        ],
        'after_project' => [
            'Build scalable systems.',
            'Use in big data.',
            'Automate workflows.'
        ]
    ]
],

/* ================= CLOUD ================= */
'cloud' => [

    'Cloud Infrastructure Setup' => [
        'description' => 'Set up scalable cloud infrastructure using AWS or Azure.',
        'duration' => '3 Months',
        'detailed_steps' => [
            'Step 1: Learn cloud basics.',
            'Step 2: Create cloud account.',
            'Step 3: Deploy servers.',
            'Step 4: Configure storage.',
            'Step 5: Monitor usage.'
        ],
        'after_project' => [
            'Deploy real apps.',
            'Work as cloud engineer.',
            'Optimize performance.'
        ]
    ],

    'Serverless Application Development' => [
        'description' => 'Develop applications without managing servers.',
        'duration' => '4 Months',
        'detailed_steps' => [
            'Step 1: Learn serverless.',
            'Step 2: Use AWS Lambda.',
            'Step 3: Build backend.',
            'Step 4: Integrate APIs.',
            'Step 5: Deploy.'
        ],
        'after_project' => [
            'Build scalable apps.',
            'Reduce costs.',
            'Improve efficiency.'
        ]
    ],

    'Cloud Cost Optimization' => [
        'description' => 'Reduce cloud costs by analyzing usage.',
        'duration' => '2 Months',
        'detailed_steps' => [
            'Step 1: Analyze usage.',
            'Step 2: Identify waste.',
            'Step 3: Optimize resources.',
            'Step 4: Apply policies.',
            'Step 5: Monitor savings.'
        ],
        'after_project' => [
            'Reduce expenses.',
            'Improve efficiency.',
            'Apply in companies.'
        ]
    ]
],

/* ================= NETWORK ================= */
'network' => [

    'LAN & WAN Setup' => [
        'description' => 'Design and implement network systems.',
        'duration' => '3 Months',
        'detailed_steps' => [
            'Step 1: Understand networking basics.',
            'Step 2: Design network.',
            'Step 3: Configure routers.',
            'Step 4: Test connectivity.',
            'Step 5: Troubleshoot issues.'
        ],
        'after_project' => [
            'Set up enterprise networks.',
            'Improve connectivity.',
            'Work as network engineer.'
        ]
    ],

    'Network Troubleshooting' => [
        'description' => 'Identify and fix network issues.',
        'duration' => '2 Months',
        'detailed_steps' => [
            'Step 1: Identify issue.',
            'Step 2: Diagnose problem.',
            'Step 3: Fix configuration.',
            'Step 4: Test network.',
            'Step 5: Document solution.'
        ],
        'after_project' => [
            'Improve debugging skills.',
            'Maintain networks.',
            'Reduce downtime.'
        ]
    ],

    'VPN & Remote Access Implementation' => [
        'description' => 'Set up secure VPN connections.',
        'duration' => '3 Months',
        'detailed_steps' => [
            'Step 1: Learn VPN basics.',
            'Step 2: Install VPN server.',
            'Step 3: Configure users.',
            'Step 4: Test connection.',
            'Step 5: Secure network.'
        ],
        'after_project' => [
            'Enable remote work.',
            'Improve security.',
            'Deploy in companies.'
        ]
    ]
]

];

/* ================= VALIDATION ================= */
if (!isset($all_projects[$course][$projectTitle])) {
    die("<h2 style='text-align:center;color:red'>❌ Project Not Found</h2>");
}

$project = $all_projects[$course][$projectTitle];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $projectTitle; ?></title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:#f1f5f9;
}
.container{
    max-width:900px;
    margin:40px auto;
    background:#fff;
    padding:30px;
    border-radius:20px;
    box-shadow:0 12px 30px rgba(0,0,0,0.1);
}
h1{
    color:#1e3a8a;
}
p{
    line-height:1.6;
}
.section-title{
    margin-top:25px;
    font-size:18px;
    font-weight:600;
    color:#0f172a;
}
ul{
    margin-top:10px;
}
li{
    margin-bottom:10px;
}
.back{
    display:inline-block;
    margin-top:30px;
    padding:12px 22px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    border-radius:25px;
}
.back:hover{
    background:#1e40af;
}
</style>
</head>

<body>

<div class="container">

<h1><?php echo $projectTitle; ?></h1>

<p><b>Course:</b> <?php echo strtoupper($course); ?></p>
<p><b>Duration:</b> <?php echo $project['duration']; ?></p>

<div class="section-title">📖 Project Description</div>
<p><?php echo $project['description']; ?></p>

<div class="section-title">📌 Step-by-Step Implementation</div>
<ul>
<?php
foreach($project['detailed_steps'] as $step){
    echo "<li>$step</li>";
}
?>
</ul>

<div class="section-title">🚀 After Completing the Project</div>
<ul>
<?php
foreach($project['after_project'] as $step){
    echo "<li>$step</li>";
}
?>
</ul>

<a class="back" href="projects.php?course=<?php echo $course; ?>">
⬅ Back to Projects
</a>

</div>

</body>
</html>