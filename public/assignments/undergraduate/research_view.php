	<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

// Get task from URL
$task = $_GET['task'] ?? 'lit';

// Research tasks details
$tasks = [
    'lit' => [
        'title' => 'Literature Review',
        'description' => 'Survey existing research, summarize key points, and identify gaps relevant to your project.',
        'guidelines' => 'Focus on major papers, organize by themes, and critically evaluate each source.',
        'tips' => 'Use academic databases like Google Scholar, IEEE Xplore, and Scopus.',
        'checklist' => [
            'Identify key papers',
            'Organize by themes',
            'Summarize findings',
            'Highlight research gaps'
        ],
	'sample' => "
<b>Sample Literature Review:</b><br><br>

This study reviews recent advancements in Artificial Intelligence in education. According to Smith (2022), AI improves personalized learning experiences. Johnson (2021) highlights the role of machine learning in student performance prediction.<br><br>

However, gaps exist in accessibility and ethical concerns. Most studies focus on developed countries, leaving a research gap in rural education systems.<br><br>

<b>Conclusion:</b><br>
Further research is needed to address inclusivity and ethical challenges.
",
        'resources' => [
            'Google Scholar' => 'https://scholar.google.com',
            'IEEE Xplore' => 'https://ieeexplore.ieee.org',
            'Scopus' => 'https://www.scopus.com'
        ],
        
    ],
    'draft' => [
        'title' => 'Research Paper Draft',
        'description' => 'Prepare the first draft of your research paper following standard formatting guidelines.',
        'guidelines' => 'Include introduction, methodology, results, discussion, and references.',
        'tips' => 'Start with an outline, ensure proper citation, and write clearly.',
        'checklist' => [
            'Create outline',
            'Write introduction and literature review',
            'Document methodology',
            'Present results',
            'Add discussion and conclusion'
        ],
	'sample' => "
<b>Sample Draft Structure:</b><br><br>

<b>Introduction:</b><br>
Technology has transformed education significantly in recent years.<br><br>

<b>Methodology:</b><br>
Data was collected using online surveys from 100 students.<br><br>

<b>Results:</b><br>
75% of students preferred digital learning platforms.<br><br>

<b>Discussion:</b><br>
The results indicate a shift towards online education.<br><br>

<b>Conclusion:</b><br>
Digital learning is effective but requires proper implementation.
",
        'resources' => [
            'APA Guidelines' => 'https://apastyle.apa.org/',
            'IEEE Author Center' => 'https://journals.ieeeauthorcenter.ieee.org/'
        ],
        
    ],
    'plag' => [
        'title' => 'Plagiarism Check',
        'description' => 'Verify originality of your research work using plagiarism detection tools.',
        'guidelines' => 'Check all content including citations and references for plagiarism.',
        'tips' => 'Use tools like Turnitin, Grammarly, or PlagScan.',
        'checklist' => [
            'Upload your draft to plagiarism tool',
            'Review similarity report',
            'Correct copied content',
            'Ensure proper citations'
        ],
	'sample' => "
<b>Sample Plagiarism Report Summary:</b><br><br>

Total Similarity: 12%<br><br>

<b>Sources:</b><br>
- 5% from journals<br>
- 4% from websites<br>
- 3% from student papers<br><br>

<b>Action Taken:</b><br>
Rephrased duplicated sentences and added proper citations.<br><br>

<b>Result:</b><br>
Document is now within acceptable plagiarism limits.
",
        'resources' => [
            'Turnitin' => 'https://www.turnitin.com/',
            'Grammarly' => 'https://www.grammarly.com/plagiarism-checker',
            'PlagScan' => 'https://www.plagscan.com/'
        ],
        
    ],
    'data' => [
        'title' => 'Data Collection & Analysis',
        'description' => 'Collect data via surveys, experiments, or secondary sources and analyze it appropriately.',
        'guidelines' => 'Ensure data integrity, use proper analysis methods, and present findings clearly.',
        'tips' => 'Use Excel, SPSS, Python, or R for analysis.',
        'checklist' => [
            'Design survey/experiment',
            'Collect data',
            'Clean and preprocess data',
            'Perform statistical analysis',
            'Visualize results'
        ],
	'sample' => "
<b>Sample Data Analysis:</b><br><br>

<b>Data Collection:</b><br>
Survey conducted with 50 students using Google Forms.<br><br>

<b>Analysis:</b><br>
- 60% prefer online classes<br>
- 30% prefer offline<br>
- 10% prefer hybrid<br><br>

<b>Visualization:</b><br>
Bar charts created using Excel.<br><br>

<b>Conclusion:</b><br>
Online learning is the most preferred method among students.
",
        'resources' => [
            'SPSS Tutorials' => 'https://www.ibm.com/analytics/spss-statistics-software',
            'Python for Data Analysis' => 'https://pandas.pydata.org/'
        ],
        
    ],
    'presentation' => [
        'title' => 'Presentation & Report',
        'description' => 'Prepare the final report and presentation slides summarizing your research findings.',
        'guidelines' => 'Highlight key results, use visuals, and maintain clarity.',
        'tips' => 'Practice presenting and ensure slides are concise.',
        'checklist' => [
            'Summarize findings in report',
            'Create visual slides',
            'Prepare executive summary',
            'Rehearse presentation'
        ],
	'sample' => "
<b>Sample Presentation Content:</b><br><br>

Slide 1: Title & Objective<br>
Slide 2: Problem Statement<br>
Slide 3: Methodology<br>
Slide 4: Results (Charts)<br>
Slide 5: Conclusion<br><br>

<b>Report Summary:</b><br>
The project analyzes student preferences in learning methods and concludes that digital learning is highly effective when implemented properly.
",
        'resources' => [
            'Canva' => 'https://www.canva.com/',
            'PowerPoint Tips' => 'https://support.microsoft.com/en-us/powerpoint'
        ],
       
    ]
];

$details = $tasks[$task] ?? $tasks['lit'];

// Gradient colors for header section
$gradients = [
    'lit' => 'linear-gradient(135deg, #38bdf8, #0ea5e9)',
    'draft' => 'linear-gradient(135deg, #34d399, #059669)',
    'plag' => 'linear-gradient(135deg, #facc15, #f59e0b)',
    'data' => 'linear-gradient(135deg, #818cf8, #6366f1)',
    'presentation' => 'linear-gradient(135deg, #f472b6, #ec4899)'
];
$header_bg = $gradients[$task] ?? $gradients['lit'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $details['title']; ?> | Research Task</title>
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

<?php if(!empty($details['resources'])): ?>
<h3>Resources</h3>
<ul>
<?php foreach($details['resources'] as $name => $link): ?>
    <li><a href="<?php echo $link; ?>" target="_blank"><?php echo $name; ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

<?php if(!empty($details['sample'])): ?>
<h3>Sample Content</h3>
<p><?php echo $details['sample']; ?></p>
<?php endif; ?>

<?php if(!empty($details['samples'])): ?>
<h3>Sample Paper</h3>
<a href="<?php echo $details['samples']; ?>" class="sample-link" target="_blank">View Sample PDF</a>
<?php endif; ?>

<a href="research.php" class="back">← Back to Research Tasks</a>
</div>
</div>

</body>
</html>
