<?php
session_start();

/* Allow only primary level users */
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary'){
    header("Location: ../dashboard.php");
    exit;
}

/* DB CONNECTION */
require_once "../../config/db.php";

/* FETCH PRIMARY LESSONS */
$stmt = $conn->prepare("
    SELECT id, title, file_path 
    FROM lesson_notes
    WHERE level = 'primary' AND status = 'approved'
    ORDER BY title ASC
");

$stmt->execute();
$result = $stmt->get_result();

/* GROUP LESSONS BY CLASS */
$grouped_lessons = [];

while($row = $result->fetch_assoc()){

    /* Detect Class 1–5 from title */
    if(preg_match('/Class\s*(1|2|3|4|5)/i', $row['title'], $matches)){
        $class_name = "Class ".$matches[1];
    }else{
        $class_name = "Other Lessons";
    }

    $grouped_lessons[$class_name][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Primary School Lessons</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(120deg,#e0f7fa,#fff3e0);
}

/* NAVBAR */
.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 30px;
background:linear-gradient(90deg,#0077b6,#00b4d8);
color:white;
box-shadow:0 4px 12px rgba(0,0,0,0.2);
}

.navbar h1{
margin:0;
font-size:22px;
}

.navbar a{
text-decoration:none;
color:white;
background:rgba(255,255,255,0.25);
padding:8px 15px;
border-radius:20px;
transition:0.3s;
}

.navbar a:hover{
background:white;
color:#0077b6;
}

/* CONTENT */
.content{
padding:40px;
max-width:1200px;
margin:auto;
}

.page-title{
text-align:center;
font-size:30px;
color:#023e8a;
margin-bottom:40px;
}

/* CLASS SECTION */
.class-section{
margin-bottom:50px;
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.class-title{
font-size:24px;
margin-bottom:20px;
color:#ff6f00;
border-left:6px solid #ffb703;
padding-left:10px;
}

/* LESSON GRID */
.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
gap:25px;
}

/* LESSON CARD */
.card{
background:linear-gradient(145deg,#ffffff,#f1f1f1);
border-radius:18px;
padding:25px;
text-align:center;
cursor:pointer;
transition:0.4s;
position:relative;
overflow:hidden;
border-bottom:5px solid #00b4d8;
}

.card:hover{
transform:translateY(-8px) scale(1.03);
box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

.card h3{
color:#03045e;
margin-bottom:12px;
font-size:18px;
}

.card p{
font-size:14px;
color:#555;
}

/* Decorative bubble */
.card::before{
content:"";
position:absolute;
top:-35px;
right:-35px;
width:110px;
height:110px;
background:rgba(0,180,216,0.15);
border-radius:50%;
}

/* FOOTER */
.footer{
text-align:center;
padding:15px;
background:#0077b6;
color:white;
margin-top:60px;
font-size:14px;
}

</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
<h1>📘 Primary School Lessons</h1>
<a href="../primary.php">⬅ Back to Dashboard</a>
</div>

<div class="content">

<div class="page-title">
Choose Your Learning Notes
</div>

<?php if(!empty($grouped_lessons)): ?>

<?php foreach($grouped_lessons as $class => $lessons): ?>

<div class="class-section">

<div class="class-title">
<?= htmlspecialchars($class) ?>
</div>

<div class="cards">

<?php foreach($lessons as $lesson): ?>

<div class="card"
onclick="window.open('../../<?= htmlspecialchars($lesson['file_path']) ?>','_blank')">

<h3><?= htmlspecialchars($lesson['title']) ?></h3>

<p>📄 Click to open lesson notes</p>

</div>

<?php endforeach; ?>

</div>
</div>

<?php endforeach; ?>

<?php else: ?>

<p style="text-align:center;font-size:18px;color:#555;">
🚫 No primary lessons available yet.
</p>

<?php endif; ?>

</div>

<div class="footer">
© <?php echo date("Y"); ?> Primary Learning Portal | Learn • Grow • Shine 🌟
</div>

</body>
</html>