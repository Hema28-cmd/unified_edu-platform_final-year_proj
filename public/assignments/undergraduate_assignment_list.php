<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$type = $_GET['type'] ?? 'general';

$assignments = [
    'general' => [
        ['title'=>'Critical Thinking Essay','desc'=>'Write an essay on modern education systems'],
        ['title'=>'Case Study Analysis','desc'=>'Analyze a real-world academic case'],
        ['title'=>'Weekly Assignment','desc'=>'Short answer questions submission']
    ],
    'lab' => [
        ['title'=>'Programming Lab 1','desc'=>'Basic programming experiments'],
        ['title'=>'Database Lab','desc'=>'SQL queries and table creation'],
        ['title'=>'Electronics Lab','desc'=>'Circuit design experiments']
    ],
    'project' => [
        ['title'=>'Mini Project','desc'=>'Small application or system'],
        ['title'=>'Major Project','desc'=>'Final year project submission'],
        ['title'=>'Group Project','desc'=>'Team-based system development']
    ],
    'research' => [
        ['title'=>'Literature Review','desc'=>'Survey of existing research'],
        ['title'=>'Research Paper Draft','desc'=>'IEEE format paper preparation'],
        ['title'=>'Plagiarism Check','desc'=>'Originality verification']
    ],
    'presentation' => [
        ['title'=>'Seminar Presentation','desc'=>'Topic-based presentation'],
        ['title'=>'Technical PPT','desc'=>'Technology-focused slides'],
        ['title'=>'Project Demo','desc'=>'Live demonstration presentation']
    ]
];

$titles = [
    'general'=>'General Assignments',
    'lab'=>'Laboratory Assignments',
    'project'=>'Projects',
    'research'=>'Research Work',
    'presentation'=>'Presentations'
];

$list = $assignments[$type] ?? [];
$pageTitle = $titles[$type] ?? 'Assignments';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $pageTitle; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f1f5f9;
}
.container{
    max-width:1000px;
    margin:40px auto;
    padding:30px;
}
.header{
    background:#fff;
    padding:25px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    margin-bottom:20px;
    text-align:center;
}
.nav-links{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:12px;
    margin-bottom:30px;
}
.nav-links a{
    padding:10px 18px;
    text-decoration:none;
    border-radius:20px;
    font-weight:600;
    color:#fff;
    background:#2563eb;
    transition:0.3s;
}
.nav-links a:hover{
    background:#1d4ed8;
}
.assignment-list{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:25px;
}
.card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}
.card:hover{
    transform:translateY(-6px);
}
.card h3{
    color:#1e293b;
    margin-bottom:10px;
}
.card p{
    color:#475569;
    font-size:14px;
}
.card a{
    display:inline-block;
    margin-top:15px;
    padding:8px 18px;
    background:#2563eb;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:14px;
}
.back{
    display:inline-block;
    margin-top:30px;
    text-decoration:none;
    color:#2563eb;
    font-weight:600;
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <h2><?php echo $pageTitle; ?></h2>
        <p>Select an assignment to view details or submit</p>
    </div>

    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="undergraduate_assignment_list.php?type=general">View Assignments</a>
        <a href="undergraduate_assignment_list.php?type=lab">View Labs</a>
        <a href="undergraduate_assignment_list.php?type=project">View Projects</a>
        <a href="undergraduate_assignment_list.php?type=research">View Research</a>
        <a href="undergraduate_assignment_list.php?type=presentation">View Topics</a>
    </div>

    <!-- Assignment Cards -->
    <div class="assignment-list">
        <?php foreach($list as $a): ?>
        <div class="card">
            <h3><?php echo htmlspecialchars($a['title']); ?></h3>
            <p><?php echo htmlspecialchars($a['desc']); ?></p>
            <a href="#">View / Submit</a>
        </div>
        <?php endforeach; ?>
    </div>

    <a href="undergraduate_assignments.php" class="back">← Back to Assignments</a>

</div>

</body>
</html>