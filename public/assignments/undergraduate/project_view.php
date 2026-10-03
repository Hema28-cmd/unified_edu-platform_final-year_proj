<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

// Get project type from URL
$type = $_GET['type'] ?? 'mini';

// Project details
$project_details = [
    'mini' => [
        'title' => 'Mini Project',
        'description' => 'A small-scale project to demonstrate your understanding of the subject and apply concepts learned in class.',
        'guidelines' => 'Focus on a single concept or simple application. Include a short report with introduction, method, and conclusion.',
        'tips' => 'Keep it simple, document everything clearly, and use diagrams/screenshots to explain your project.',
	'sample' => "
<b>Project Title: Simple Calculator App</b><br><br>

<b>Objective:</b><br>
To develop a basic calculator that performs arithmetic operations.<br><br>

<b>Tools Used:</b><br>
HTML, CSS, JavaScript<br><br>

<b>Methodology:</b><br>
User inputs numbers → clicks operation → result displayed using JS logic.<br><br>

<b>Output:</b><br>
Performs addition, subtraction, multiplication, division.<br><br>

<b>Conclusion:</b><br>
Successfully implemented a simple calculator application.
",
	'implementation' => "
<b>Implementation Steps:</b><br><br>

1. Create a simple UI using HTML for buttons and display.<br>
2. Style the calculator using CSS (grid layout).<br>
3. Use JavaScript to handle button clicks.<br>
4. Store user input in variables.<br>
5. Perform operations (+, -, *, /) using functions.<br>
6. Display result dynamically on screen.<br><br>

<b>Logic:</b><br>
Use event listeners → capture input → evaluate expression → show output.
",
        'resources' => 'Example: Simple calculator app, weather app, or basic data analysis project.'
    ],
    'major' => [
        'title' => 'Major Project',
        'description' => 'A comprehensive project that requires significant research and practical implementation.',
        'guidelines' => 'Submit a detailed report including research, methodology, implementation, results, and references.',
        'tips' => 'Plan your project in stages, maintain a timeline, and test thoroughly before submission.',
	'sample' => "
<b>Project Title: E-Commerce Website</b><br><br>

<b>Objective:</b><br>
To develop a full-stack online shopping system.<br><br>

<b>Tools Used:</b><br>
PHP, MySQL, HTML, CSS, JavaScript<br><br>

<b>Modules:</b><br>
User login, product listing, cart, payment system.<br><br>

<b>Outcome:</b><br>
Users can browse products, add to cart, and place orders.<br><br>

<b>Conclusion:</b><br>
A complete web-based e-commerce platform was developed.
",
	'implementation' => "
<b>Implementation Steps:</b><br><br>

1. Design database (users, products, orders tables).<br>
2. Create frontend pages (home, login, product page).<br>
3. Develop backend using PHP for authentication.<br>
4. Implement cart system using sessions.<br>
5. Connect MySQL database for storing data.<br>
6. Add checkout and order placement module.<br><br>

<b>Architecture:</b><br>
Frontend (HTML/CSS/JS) + Backend (PHP) + Database (MySQL).
",
        'resources' => 'Example: E-commerce website, advanced data visualization, or IoT based project.'
    ],
    'group' => [
        'title' => 'Group Project',
        'description' => 'A project done in collaboration with a team of students to solve a larger problem or create a product.',
        'guidelines' => 'Ensure all group members contribute equally. Submit a single report with individual contributions noted.',
        'tips' => 'Communicate regularly with your team, divide tasks clearly, and integrate work properly.',
	'sample' => "
<b>Project Title: College Event Management System</b><br><br>

<b>Objective:</b><br>
To manage college events digitally with team collaboration.<br><br>

<b>Team Contribution:</b><br>
Frontend - Student A, Backend - Student B, Database - Student C<br><br>

<b>Features:</b><br>
Event creation, registration, notifications.<br><br>

<b>Outcome:</b><br>
Students can register and manage events online.<br><br>

<b>Conclusion:</b><br>
Improved coordination and reduced manual work.
",
	'implementation' => "
<b>Implementation Steps:</b><br><br>

1. Divide tasks among team members (UI, backend, DB).<br>
2. Design event database (events, users, registrations).<br>
3. Create event creation and registration pages.<br>
4. Implement login system for users/admin.<br>
5. Add notification or email feature.<br>
6. Integrate all modules into one system.<br><br>

<b>Team Workflow:</b><br>
Use Git or shared folders for collaboration.
",
        'resources' => 'Example: College event management system, collaborative game development.'
    ],
    'research' => [
        'title' => 'Research Based Project',
        'description' => 'A project focused on academic research, literature review, experiments, or studies to contribute new knowledge.',
        'guidelines' => 'Submit a research paper including hypothesis, methodology, results, discussion, and references.',
        'tips' => 'Be thorough with literature review, keep data organized, and cite sources correctly.',
	'sample' => "
<b>Project Title: Impact of AI in Education</b><br><br>

<b>Objective:</b><br>
To analyze how AI is transforming modern education.<br><br>

<b>Methodology:</b><br>
Literature review, surveys, and data analysis.<br><br>

<b>Findings:</b><br>
AI improves personalized learning but raises privacy concerns.<br><br>

<b>Conclusion:</b><br>
AI has strong potential but must be implemented responsibly.
",
	'implementation' => "
<b>Implementation Steps:</b><br><br>

1. Define research problem and objectives.<br>
2. Collect data from journals, surveys, or online sources.<br>
3. Analyze data using charts or statistical tools.<br>
4. Compare results with existing studies.<br>
5. Write findings and discussion.<br>
6. Add proper references and citations.<br><br>

<b>Tools:</b><br>
Google Scholar, Excel, Python (optional for analysis).
",
        'resources' => 'Example: AI model evaluation, renewable energy study, or social science survey.'
    ],
    'capstone' => [
        'title' => 'Capstone Project',
        'description' => 'A final year project integrating all your learning to create a real-world solution or product.',
        'guidelines' => 'Submit a comprehensive report and presentation. Include all stages from conception, design, implementation, testing, and conclusion.',
        'tips' => 'Choose a practical problem, integrate multiple skills, and ensure your solution is well-documented.',
	'sample' => "
<b>Project Title: Smart Home Automation System</b><br><br>

<b>Objective:</b><br>
To automate home appliances using IoT technology.<br><br>

<b>Tools Used:</b><br>
Arduino, Sensors, Mobile App<br><br>

<b>Features:</b><br>
Control lights, fans, security system remotely.<br><br>

<b>Outcome:</b><br>
Users can manage home devices via smartphone.<br><br>

<b>Conclusion:</b><br>
Developed a real-world automation solution integrating hardware and software.
",
	'implementation' => "
<b>Implementation Steps:</b><br><br>

1. Select hardware (Arduino, sensors, relay modules).<br>
2. Connect appliances with relay circuits.<br>
3. Write Arduino code to control devices.<br>
4. Develop mobile/web app for user interface.<br>
5. Connect system using WiFi/Bluetooth.<br>
6. Test real-time control and automation.<br><br>

<b>System Flow:</b><br>
User → Mobile App → Microcontroller → Device Control.
",
        'resources' => 'Example: Smart home automation system, full-stack web application, or machine learning project.'
    ]
];

$details = $project_details[$type] ?? $project_details['mini'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $details['title']; ?> | Undergraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(to right, #f0f4f8, #e0e7ff);
}
.container{
    max-width:900px;
    margin:50px auto;
    padding:20px;
}
.card{
    background:#fff;
    border-radius:20px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
    overflow:hidden;
    margin-bottom:30px;
}
.card-header{
    background: linear-gradient(135deg, #1e3a8a, #3b82f6);
    color:#fff;
    padding:25px;
    text-align:center;
}
.card-header h2{
    margin:0;
    font-size:28px;
}
.card-section{
    padding:25px;
}
.card-section:nth-child(even){
    background:#f9fafb;
}
.card-section h3{
    color:#1e40af;
    margin-bottom:15px;
    font-size:20px;
}
.card-section p{
    color:#475569;
    font-size:16px;
    line-height:1.7;
}
.back{
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    transition:0.3s;
}
.back:hover{
    background:#dc2626;
}
@media (max-width:600px){
    .card-section{padding:20px;}
    .card-header h2{font-size:24px;}
}
</style>
</head>
<body>

<div class="container">

<div class="card">
    <div class="card-header">
        <h2><?php echo $details['title']; ?></h2>
    </div>
    <div class="card-section">
        <h3>Description</h3>
        <p><?php echo $details['description']; ?></p>
    </div>
    <div class="card-section">
        <h3>Submission Guidelines</h3>
        <p><?php echo $details['guidelines']; ?></p>
    </div>
    <div class="card-section">
        <h3>Tips & Recommendations</h3>
        <p><?php echo $details['tips']; ?></p>
    </div>
    <div class="card-section">
        <h3>Example Resources / References</h3>
        <p><?php echo $details['resources']; ?></p>
    </div>
    <div class="card-section">
    <h3>Sample Project</h3>
    <p><?php echo $details['sample']; ?></p>
    </div>
	<div class="card-section">
    <h3>Implementation / How to Build</h3>
    <p><?php echo $details['implementation']; ?></p>
</div>
</div>

<a href="projects.php" class="back">← Back to Projects</a>
</div>

</body>
</html>
