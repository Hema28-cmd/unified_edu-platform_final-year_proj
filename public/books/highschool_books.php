<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

$baseDir = __DIR__ . '/highschool';

$groupedBooks = [];

if (is_dir($baseDir)) {
    $allFiles = array_diff(scandir($baseDir), ['.', '..']);

    foreach ($allFiles as $file) {

        if (is_file($baseDir . '/' . $file) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'pdf') {

            if (preg_match('/Class\s*(\d+)/i', $file, $matches)) {

                $classNum = $matches[1];

               if ($classNum >= 10 && $classNum <= 12) {

                    $className = "Class " . $classNum;

                    $groupedBooks[$className][] = $file;
                }
            }
        }
    }
}

/* Count total books */
$totalBooks = 0;
foreach ($groupedBooks as $books) {
    $totalBooks += count($books);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Books</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

/* BODY */

body{
background:linear-gradient(120deg,#fdf2f8,#eef2ff);
color:#1f2937;
}

/* NAVBAR */

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:18px 50px;
background:linear-gradient(90deg,#7c3aed,#ec4899);
color:white;
}

.logo{
font-size:22px;
font-weight:bold;
}

.nav-links a{
color:white;
text-decoration:none;
margin-left:25px;
font-weight:600;
}

.nav-links a:hover{
text-decoration:underline;
}

/* HERO */

.hero{
padding:60px 30px;
text-align:center;
background:linear-gradient(135deg,#6366f1,#f472b6);
color:white;
}

.hero h1{
font-size:42px;
margin-bottom:10px;
}

.hero p{
font-size:18px;
opacity:0.9;
}

/* STATS */

.stats{
display:flex;
justify-content:center;
gap:30px;
margin-top:-40px;
}

.stat{
background:white;
padding:20px 40px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
text-align:center;
}

.stat h2{
color:#7c3aed;
}

/* CONTENT */

.content{
max-width:1200px;
margin:auto;
padding:50px 30px;
}

/* SEARCH */

.search-box{
text-align:center;
margin-bottom:40px;
}

.search-box input{
width:350px;
padding:12px;
border-radius:25px;
border:1px solid #ccc;
outline:none;
}

/* BOOK GRID */

.book-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:25px;
}

/* BOOK CARD */

.book-card{
background:white;
border-radius:18px;
padding:25px;
cursor:pointer;
transition:0.3s;
box-shadow:0 8px 20px rgba(0,0,0,0.08);
position:relative;
overflow:hidden;
}

.book-card:hover{
transform:translateY(-8px);
box-shadow:0 15px 30px rgba(0,0,0,0.15);
}

/* COLOR STRIPS */

.book-card::before{
content:"";
position:absolute;
top:0;
left:0;
width:100%;
height:6px;
background:linear-gradient(90deg,#6366f1,#ec4899);
}

.book-icon{
font-size:40px;
margin-bottom:10px;
color:#f59e0b;
}

.book-title{
font-weight:600;
margin-bottom:10px;
}

/* BADGE */

.badge{
display:inline-block;
padding:4px 10px;
font-size:12px;
border-radius:15px;
background:#e0e7ff;
color:#4338ca;
margin-bottom:10px;
}

/* FOOTER */

.footer{
margin-top:60px;
text-align:center;
padding:25px;
background:#1f2937;
color:white;
}

</style>
</head>

<body>

<!-- NAVBAR -->

<div class="navbar">
<div class="logo">📘 Unified Education</div>

<div class="nav-links">
<a href="../highschool.php">Dashboard</a>
<a href="../logout.php">Logout</a>
</div>
</div>

<!-- HERO -->

<div class="hero">
<h1>High School Learning Library</h1>
<p>Explore books to strengthen your knowledge and academic success</p>
</div>

<!-- STATS -->

<div class="stats">
<div class="stat">
<h2><?php echo $totalBooks ?></h2>
<p>Total Books</p>
</div>

<div class="stat">
<h2>10+</h2>
<p>Subjects</p>
</div>

<div class="stat">
<h2>100%</h2>
<p>Free Learning</p>
</div>
</div>

<!-- CONTENT -->

<div class="content">

<div class="search-box">
<input type="text" id="search" placeholder="Search books...">
</div>

<?php 
$classes = ['Class 10','Class 11','Class 12'];
?>

<?php foreach($classes as $class): 
    $books = $groupedBooks[$class] ?? [];
?>

<h2 style="margin:30px 0 15px 10px;"><?php echo $class; ?></h2>

<?php if (!empty($books)): ?>

<div class="book-grid" id="bookGrid">

<?php foreach ($books as $file):

$title = ucwords(str_replace(['_','-','.pdf'],[' ',' ',''],$file));
?>

<div class="book-card"
onclick="window.open('/unified_edu/public/books/highschool/<?php echo urlencode($file); ?>','_blank')">

<div class="book-icon">
<i class="fa-solid fa-book"></i>
</div>

<div class="badge">High School</div>

<div class="book-title">
<?php echo htmlspecialchars($title); ?>
</div>

<p style="font-size:14px;color:#64748b">
Click to read the book
</p>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<p style="margin-left:10px;color:#64748b;">No books available for this class.</p>

<?php endif; ?>

<?php endforeach; ?>
</div>

<!-- FOOTER -->

<div class="footer">
© <?php echo date("Y"); ?> Unified Education Platform
</div>

<script>

/* SEARCH BOOKS */

document.getElementById("search").addEventListener("keyup",function(){

let value = this.value.toLowerCase();

let cards = document.querySelectorAll(".book-card");

cards.forEach(card=>{

let text = card.innerText.toLowerCase();

card.style.display = text.includes(value) ? "block" : "none";

});

});

</script>

</body>
</html>
