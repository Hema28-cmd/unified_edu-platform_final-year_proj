<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

// Get task from URL
$task = $_GET['task'] ?? 'seminar';

// Presentation tasks details
$tasks = [
    'seminar' => [
        'title' => 'Seminar Presentation',
        'description' => 'Prepare a topic-based presentation to discuss concepts, ideas, or research findings.',
        'guidelines' => 'Slides should be concise, visually appealing, and organized logically.',
        'tips' => 'Practice your speech, maintain eye contact, and time yourself.',
        'checklist' => [
            'Select topic',
            'Research content thoroughly',
            'Prepare slides with visuals',
            'Rehearse presentation',
            'Get feedback and revise'
        ],
	'sample' => "
<b>Sample Topic: Impact of Social Media on Students</b><br><br>

<b>Slide Structure:</b><br>
1. Introduction – What is social media?<br>
2. Usage Statistics among students<br>
3. Positive Effects (learning, communication)<br>
4. Negative Effects (addiction, distraction)<br>
5. Case Study / Example<br>
6. Conclusion<br><br>

<b>Presentation Tip:</b><br>
Use real-life examples and engage audience with questions.
", 
        'resources' => [
            'Canva for Slides' => 'https://www.canva.com/',
            'Presentation Tips' => 'https://www.toastmasters.org/find-a-club'
        ],
        
    ],
    'technical' => [
        'title' => 'Technical PPT',
        'description' => 'Create a technology-focused presentation highlighting processes, tools, or innovations.',
        'guidelines' => 'Include diagrams, flowcharts, and code snippets where applicable.',
        'tips' => 'Explain technical terms clearly and ensure slides are readable.',
        'checklist' => [
            'Identify technical topic',
            'Prepare content with diagrams/code',
            'Design slides',
            'Review and refine slides',
            'Practice delivery'
        ],
	'sample' => "
<b>Sample Topic: Cloud Computing</b><br><br>

<b>Slide Structure:</b><br>
1. Introduction to Cloud Computing<br>
2. Types (IaaS, PaaS, SaaS)<br>
3. Architecture Diagram<br>
4. Advantages & Disadvantages<br>
5. Real-world Applications<br>
6. Conclusion<br><br>

<b>Example:</b><br>
Use AWS or Google Cloud as case study.<br><br>

<b>Tip:</b><br>
Include diagrams and simple explanations for technical terms.
",
        'resources' => [
            'Microsoft PowerPoint' => 'https://www.microsoft.com/en-us/microsoft-365/powerpoint',
            'Tech Presentation Examples' => 'https://www.slideshare.net/'
        ],
        
    ],
    'demo' => [
        'title' => 'Project Demo',
        'description' => 'Conduct a live demonstration of your project to showcase functionality and results.',
        'guidelines' => 'Ensure demo works smoothly, explain each feature, and be ready for questions.',
        'tips' => 'Prepare backup recordings and a brief explanation for each step.',
        'checklist' => [
            'Test demo thoroughly',
            'Prepare backup slides or video',
            'Explain each feature clearly',
            'Rehearse timing and transitions',
            'Prepare for audience questions'
        ],
	'sample' => "
<b>Sample Project: Online Voting System</b><br><br>

<b>Demo Flow:</b><br>
1. Login Page demonstration<br>
2. Voter Dashboard<br>
3. Casting Vote process<br>
4. Admin Panel overview<br>
5. Result display<br><br>

<b>Explanation:</b><br>
Explain each feature while demonstrating live.<br><br>

<b>Backup Plan:</b><br>
Keep screenshots or recorded video in case of errors.<br><br>

<b>Conclusion:</b><br>
System ensures secure and transparent voting.
",
        'resources' => [
            'Demo Tips' => 'https://www.presentationmagazine.com/',
            'Project Demo Examples' => 'https://www.youtube.com/results?search_query=project+demo+examples'
        ],
        
    ]
];

$details = $tasks[$task] ?? $tasks['seminar'];

// Gradient colors for header
$gradients = [
    'seminar' => 'linear-gradient(135deg, #38bdf8, #0ea5e9)',
    'technical' => 'linear-gradient(135deg, #34d399, #059669)',
    'demo' => 'linear-gradient(135deg, #f472b6, #ec4899)'
];
$header_bg = $gradients[$task] ?? $gradients['seminar'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $details['title']; ?> | Presentation Task</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f0f4f8;
}
.container{
    max-width:950px;
    margin:50px auto;
    padding:0;
}
.header{
    padding:40px 25px;
    border-radius:16px 16px 0 0;
    color:#fff;
    background: <?php echo $header_bg; ?>;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    text-align:center;
}
.header h2{
    font-size:32px;
    margin:0;
}
.content{
    background:#fff;
    padding:30px 25px;
    border-radius:0 0 16px 16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
}
h3{
    color:#1e3a8a;
    margin-top:25px;
    margin-bottom:12px;
}
p{
    font-size:16px;
    color:#334155;
    line-height:1.7;
}
ul{
    margin:0 0 20px 20px;
}
li{
    margin-bottom:8px;
}
.sample-link{
    display:inline-block;
    margin-top:10px;
    padding:12px 18px;
    background:#0ea5e9;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}
.sample-link:hover{
    background:#0284c7;
}
.back{
    display:inline-block;
    margin-top:30px;
    padding:12px 20px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}
.back:hover{
    background:#dc2626;
}
@media(max-width:600px){
    .header h2{font-size:26px;}
    .content{padding:20px;}
    p, li{font-size:15px;}
}
</style>
</head>
<body>

<div class="container">
<div class="header">
    <h2><?php echo $details['title']; ?></h2>
</div>

<div class="content">
<h3>Description</h3>
<p><?php echo $details['description']; ?></p>

<h3>Guidelines</h3>
<p><?php echo $details['guidelines']; ?></p>

<h3>Tips & Recommendations</h3>
<p><?php echo $details['tips']; ?></p>

<?php if(!empty($details['checklist'])): ?>
<h3>Step-by-Step Checklist</h3>
<ul>
<?php foreach($details['checklist'] as $step): ?>
    <li><?php echo $step; ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if(!empty($details['sample'])): ?>
<h3>Sample Presentation Content</h3>
<p><?php echo $details['sample']; ?></p>
<?php endif; ?>

<?php if(!empty($details['resources'])): ?>
<h3>Resources</h3>
<ul>
<?php foreach($details['resources'] as $name => $link): ?>
    <li><a href="<?php echo $link; ?>" target="_blank"><?php echo $name; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if(!empty($details['samples'])): ?>
<h3>Sample Presentation</h3>
<a href="<?php echo $details['samples']; ?>" class="sample-link" target="_blank">View Sample PDF</a>
<?php endif; ?>

<a href="presentations.php" class="back">← Back to Presentations</a>
</div>
</div>

</body>
</html>
