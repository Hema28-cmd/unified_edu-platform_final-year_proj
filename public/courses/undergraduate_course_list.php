<?php
session_start();
require_once "../../config/db.php";

/* 🔐 Allow only undergraduate users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

/* Get category */
$category = $_GET['category'] ?? 'computer_science';

/* Titles */
$titleMap = [
    'computer_science'=>'Computer Science Courses',
    'mechanical'=>'Mechanical Engineering Courses',
    'civil'=>'Civil Engineering Courses',
    'ece'=>'ECE Courses',
    'medical'=>'Medical & Health Sciences Courses',
    'management'=>'Management & Commerce Courses'
];

/* Colors */
$colorMap = [
    'computer_science'=>'#2563eb',
    'mechanical'=>'#ef4444',
    'civil'=>'#f59e0b',
    'ece'=>'#10b981',
    'medical'=>'#ec4899',
    'management'=>'#8b5cf6'
];

$pageTitle = $titleMap[$category] ?? 'Courses';
$accent = $colorMap[$category] ?? '#1e40af';

/* Fetch courses */
$stmt = $conn->prepare("SELECT title, description FROM courses WHERE category=? AND level='undergraduate' AND status='approved'");
$stmt->bind_param("s",$category);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $pageTitle; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

body{
margin:0;
font-family:'Poppins',sans-serif;
background:linear-gradient(135deg,#f8fafc,#e2e8f0);
}

/* NAVBAR */

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:18px 40px;
background:linear-gradient(90deg,<?php echo $accent; ?>,#0f172a);
color:white;
}

.navbar h2{
margin:0;
font-weight:600;
}

.navbar a{
color:white;
text-decoration:none;
margin-left:20px;
font-weight:500;
}

/* CONTAINER */

.container{
max-width:1200px;
margin:auto;
padding:40px 25px;
}

/* HEADER */

.header{
text-align:center;
margin-bottom:40px;
}

.header h1{
font-size:34px;
color:#1e293b;
margin-bottom:10px;
}

.header p{
color:#64748b;
font-size:16px;
}

/* GRID */

.course-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
gap:28px;
}

/* CARD */

.course-card{
background:white;
border-radius:20px;
padding:28px;
box-shadow:0 12px 30px rgba(0,0,0,0.08);
transition:0.35s;
position:relative;
overflow:hidden;
}

.course-card:hover{
transform:translateY(-8px);
box-shadow:0 18px 40px rgba(0,0,0,0.15);
}

/* TOP COLOR BAR */

.course-card::before{
content:'';
position:absolute;
top:0;
left:0;
width:100%;
height:6px;
background:linear-gradient(90deg,<?php echo $accent; ?>,#38bdf8);
}

/* ICON */

.icon{
font-size:32px;
color:<?php echo $accent; ?>;
margin-bottom:12px;
}

/* TITLE */

.course-card h3{
margin:5px 0 10px;
font-size:20px;
color:#1e293b;
}

/* DESCRIPTION */

.course-card p{
font-size:14px;
color:#475569;
margin-bottom:18px;
line-height:1.5;
}

/* META BADGES */

.meta{
display:flex;
gap:10px;
flex-wrap:wrap;
}

.badge{
background:#f1f5f9;
padding:6px 12px;
border-radius:15px;
font-size:12px;
color:#334155;
}

/* BUTTON */

.enroll{
margin-top:18px;
display:inline-block;
padding:10px 18px;
background:linear-gradient(90deg,<?php echo $accent; ?>,#22c55e);
color:white;
border-radius:20px;
font-size:13px;
text-decoration:none;
transition:0.3s;
}

.enroll:hover{
transform:scale(1.05);
}

/* BACK BUTTON */

.back{
display:inline-block;
margin-top:40px;
padding:12px 28px;
background:<?php echo $accent; ?>;
color:white;
border-radius:25px;
text-decoration:none;
}

.back:hover{
opacity:0.9;
}

.empty{
text-align:center;
color:#64748b;
font-size:18px;
}

.description{
background:#f8fafc;
border-left:4px solid <?php echo $accent; ?>;
padding:12px 14px;
border-radius:8px;
font-size:14px;
color:#475569;
margin-bottom:15px;
line-height:1.6;
}

</style>
</head>

<body>

<div class="navbar">
<h2>🎓 Undergraduate Portal</h2>

<div>
<a href="../undergraduate.php">Dashboard</a>
<a href="../logout.php">Logout</a>
</div>
</div>

<div class="container">

<div class="header">
<h1><?php echo $pageTitle; ?></h1>
<p>Explore specialized undergraduate courses designed to enhance your skills.</p>
</div>

<div class="course-grid">

<?php if($result->num_rows > 0): ?>
<?php while($course = $result->fetch_assoc()): ?>

<div class="course-card">

<div class="icon">
<i class="fa-solid fa-book-open"></i>
</div>

<h3><?php echo htmlspecialchars($course['title']); ?></h3>

<div class="description">
<?php echo htmlspecialchars($course['description']); ?>
</div>

<div class="meta">
<span class="badge">🎓 Undergraduate</span>
<span class="badge">📚 Course</span>
<span class="badge">⭐ Popular</span>
</div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p class="empty">No courses available in this category.</p>

<?php endif; ?>

</div>

<a href="undergraduate_courses.php" class="back">← Back to Categories</a>

</div>

</body>
</html>