<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Programming Resources</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Segoe UI, sans-serif;
}

/* BODY */

body{
background:linear-gradient(135deg,#1f4037,#99f2c8);
min-height:100vh;
}

/* NAVBAR */

.navbar{
background:#111;
color:white;
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 40px;
}

.navbar h2{
font-weight:500;
}

.navbar a{
color:white;
text-decoration:none;
background:#ff6b6b;
padding:8px 15px;
border-radius:6px;
transition:0.3s;
}

.navbar a:hover{
background:#ff3b3b;
}

/* HERO SECTION */

.hero{
text-align:center;
padding:40px 20px;
color:white;
}

.hero h1{
font-size:38px;
margin-bottom:10px;
}

.hero p{
font-size:16px;
opacity:0.9;
}

/* CONTAINER */

.container{
width:90%;
margin:auto;
margin-top:20px;
}

/* SECTION TITLE */

.section-title{
margin:40px 0 20px;
font-size:26px;
color:white;
}

/* GRID */

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:25px;
}

/* CARD */

.card{
background:white;
border-radius:12px;
padding:25px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
transition:0.3s;
position:relative;
}

.card:hover{
transform:translateY(-10px) scale(1.03);
}

.card i{
font-size:34px;
margin-bottom:10px;
}

.card h3{
margin:10px 0;
}

.card p{
font-size:14px;
color:#555;
}

.card a{
display:inline-block;
margin-top:12px;
padding:8px 16px;
border-radius:6px;
text-decoration:none;
color:white;
font-size:14px;
}

/* COLOR THEMES */

.python{
border-left:6px solid #3776ab;
}
.python a{background:#3776ab;}

.cpp{
border-left:6px solid #00599c;
}
.cpp a{background:#00599c;}

.java{
border-left:6px solid #f89820;
}
.java a{background:#f89820;}

.web{
border-left:6px solid #e34c26;
}
.web a{background:#e34c26;}

.practice{
border-left:6px solid #28a745;
}
.practice a{background:#28a745;}

.tools{
border-left:6px solid #6f42c1;
}
.tools a{background:#6f42c1;}

.video{
border-left:6px solid #ff0000;
}
.video a{background:#ff0000;}

/* FEATURED SECTION */

.feature{
background:white;
padding:30px;
border-radius:12px;
margin-top:30px;
box-shadow:0 8px 20px rgba(0,0,0,0.2);
display:flex;
align-items:center;
justify-content:space-between;
flex-wrap:wrap;
}

.feature h2{
color:#333;
}

.feature a{
background:#007bff;
color:white;
padding:10px 18px;
border-radius:6px;
text-decoration:none;
}

/* FOOTER */

.footer{
text-align:center;
padding:25px;
margin-top:50px;
color:white;
font-size:14px;
}

</style>
</head>

<body>

<!-- NAVBAR -->

<div class="navbar">
<h2><i class="fa-solid fa-code"></i> Programming Resources</h2>
<a href="undergraduate_resources.php">
<i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<!-- HERO -->

<div class="hero">
<h1>Learn Programming Easily</h1>
<p>Explore tutorials, coding platforms and development tools.</p>
</div>

<div class="container">

<!-- FEATURED -->

<div class="feature">
<h2>Start Your Programming Journey Today 🚀</h2>
<a href="https://www.w3schools.com/" target="_blank">Start Learning</a>
</div>


<!-- LANGUAGES -->

<div class="section-title">Programming Languages</div>

<div class="grid">

<div class="card python">
<i class="fa-brands fa-python"></i>
<h3>Python Programming</h3>
<p>Learn Python basics, automation, data science and AI.</p>
<a href="https://www.w3schools.com/python/" target="_blank">Learn Python</a>
</div>

<div class="card cpp">
<i class="fa-solid fa-laptop-code"></i>
<h3>C / C++</h3>
<p>Understand memory management and system programming.</p>
<a href="https://www.programiz.com/cpp-programming" target="_blank">Learn C++</a>
</div>

<div class="card java">
<i class="fa-brands fa-java"></i>
<h3>Java Programming</h3>
<p>Learn object oriented programming and application development.</p>
<a href="https://www.programiz.com/java-programming" target="_blank">Learn Java</a>
</div>

<div class="card web">
<i class="fa-solid fa-globe"></i>
<h3>Web Development</h3>
<p>Build modern websites using HTML, CSS and JavaScript.</p>
<a href="https://www.w3schools.com/" target="_blank">Start Web Dev</a>
</div>

</div>


<!-- PRACTICE -->

<div class="section-title">Coding Practice</div>

<div class="grid">

<div class="card practice">
<i class="fa-solid fa-code"></i>
<h3>LeetCode</h3>
<p>Practice coding interview problems and algorithms.</p>
<a href="https://leetcode.com" target="_blank">Practice</a>
</div>

<div class="card practice">
<i class="fa-solid fa-terminal"></i>
<h3>HackerRank</h3>
<p>Improve problem solving with coding challenges.</p>
<a href="https://hackerrank.com" target="_blank">Solve</a>
</div>

<div class="card practice">
<i class="fa-solid fa-trophy"></i>
<h3>CodeChef</h3>
<p>Participate in global coding competitions.</p>
<a href="https://codechef.com" target="_blank">Compete</a>
</div>

</div>


<!-- TOOLS -->

<div class="section-title">Developer Tools</div>

<div class="grid">

<div class="card tools">
<i class="fa-brands fa-github"></i>
<h3>GitHub</h3>
<p>Host and collaborate on programming projects.</p>
<a href="https://github.com" target="_blank">Open GitHub</a>
</div>

<div class="card video">
<i class="fa-brands fa-youtube"></i>
<h3>Programming Videos</h3>
<p>Watch tutorials and coding project explanations.</p>
<a href="https://youtube.com" target="_blank">Watch</a>
</div>

<div class="card tools">
<i class="fa-solid fa-book"></i>
<h3>Programming Articles</h3>
<p>Read programming concepts and technical guides.</p>
<a href="https://www.geeksforgeeks.org/" target="_blank">Read</a>
</div>

</div>

</div>

<div class="footer">
Unified Education Platform © 2026 | Programming Resources
</div>

</body>
</html>