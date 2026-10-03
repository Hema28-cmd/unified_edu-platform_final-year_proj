<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$resources = [

    [
        'title'=>'Study Planner',
        'description'=>'Plan daily, weekly, and monthly study schedules effectively.',
        'link'=>'study_planner.php',
        'icon'=>'fa-calendar',
        'color'=>'#facc15'
    ],

    [
        'title'=>'Exam Tips',
        'description'=>'Smart strategies, time management tips, and revision methods.',
        'link'=>'exam_tips.php',
        'icon'=>'fa-lightbulb',
        'color'=>'#22c55e'
    ],

    [
        'title'=>'Sample Assignments',
        'description'=>'Reference assignments to understand structure and expectations.',
        'link'=>'sample_assignments.php',
        'icon'=>'fa-file-lines',
        'color'=>'#6366f1'
    ],

    [
        'title'=>'Research Paper Guide',
        'description'=>'Learn how to write academic research papers and project reports effectively.',
        'link'=>'research_guide.php',
        'icon'=>'fa-book-open',
        'color'=>'#0ea5e9'
    ],

    [
        'title'=>'Programming Resources',
        'description'=>'Access coding tutorials, documentation, and practice problems.',
        'link'=>'programming_resources.php',
        'icon'=>'fa-code',
        'color'=>'#f97316'
    ],

    [
        'title'=>'Career Development',
        'description'=>'Interview preparation, resume tips, and career guidance resources.',
        'link'=>'career_resources.php',
        'icon'=>'fa-briefcase',
        'color'=>'#14b8a6'
    ]

];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Resources</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f8fafc;
}

.wrapper{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:260px;
    background:#1e293b;
    padding:30px 20px;
    color:#fff;
}

.sidebar h2{
    text-align:center;
    margin-bottom:40px;
    color:#f59e0b;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 16px;
    margin-bottom:12px;
    color:#e5e7eb;
    text-decoration:none;
    border-radius:10px;
}

.sidebar a.active{
    background:#334155;
    color:#f59e0b;
}

.sidebar a.logout{
    background:#dc2626;
}

.main{
    flex:1;
    padding:30px;
}

.header{
    background:#fff;
    padding:20px 30px;
    border-radius:14px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    margin-bottom:30px;
}

.resource-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.resource-card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.resource-card:hover{
    transform:translateY(-6px);
}

.resource-card i{
    font-size:40px;
    margin-bottom:15px;
}

.resource-card h3{
    margin-bottom:10px;
    color:#1e293b;
}

.resource-card p{
    font-size:14px;
    color:#475569;
    margin-bottom:15px;
}

.resource-card a{
    display:inline-block;
    padding:10px 18px;
    background:#1e40af;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:14px;
}

.resource-card a:hover{
    background:#4338ca;
}
/* MOVE TO NEXT LEVEL BUTTON */
.move-next-btn{
    background: transparent;         /* no background */
    color: #fff;                     /* white text */
    border: 2px solid #fff;          /* white border */
    font-weight:bold;
    justify-content:center;
    border-radius:10px;
    cursor:pointer;
    width:100%;
    text-align:center;
    padding:14px 16px;
    margin-bottom:12px;
    display:flex;
    align-items:center;
    gap:12px;
    font-size:15px;
    transition:0.3s;
}
.move-next-btn:hover{
    background: rgba(255,255,255,0.1);  /* subtle hover effect */
    transform:scale(1.03);
}

</style>
</head>
<body>

<div class="wrapper">

 <!-- SIDEBAR -->
    <div class="sidebar">
        <h2>🎓 Undergraduate</h2>

        <a href="../courses/undergraduate_courses.php"><i class="fa-solid fa-book"></i> Courses</a>
        <a href="../assignments/undergraduate_assignments.php"><i class="fa-solid fa-pen"></i> Assignments</a>
        <a href="../live/undergraduate_live.php"><i class="fa-solid fa-video"></i> Live Classes</a>
        <a href="../exams/undergraduate_exams.php"><i class="fa-solid fa-calendar-check"></i> Exams</a>
        <a class="active"><i class="fa-solid fa-folder-open"></i> Resources</a>
        <a href="../forums/undergraduate_forums.php"><i class="fa-solid fa-comments"></i> Forums</a>
        <a href="../certificate/undergraduate_certificate.php"><i class="fa-solid fa-certificate"></i> Certificates</a>

        <!-- Move to Next Level Button -->
<form method="post" action="../move_next_under.php">
    <button type="submit" class="move-next-btn">
        <i class="fa-solid fa-arrow-right"></i> Move to Next Level
    </button>
</form>

        <a href="../logout.php" class="logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </div>

    <div class="main">
        <div class="header">
            <h1>Undergraduate Resources</h1>
            <p>Access learning materials and academic support tools</p>
        </div>

        <div class="resource-grid">
            <?php foreach($resources as $res): ?>
            <div class="resource-card" style="border-top:4px solid <?php echo $res['color']; ?>">
                <i class="fa-solid <?php echo $res['icon']; ?>" style="color:<?php echo $res['color']; ?>"></i>
                <h3><?php echo $res['title']; ?></h3>
                <p><?php echo $res['description']; ?></p>
                <a href="<?php echo $res['link']; ?>">Access</a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

</body>
</html>
