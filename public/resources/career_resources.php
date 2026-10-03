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
<title>Career Resources</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Segoe UI, sans-serif;
}

body{
background:linear-gradient(135deg,#667eea,#764ba2);
min-height:100vh;
}

/* NAVBAR */

.navbar{
display:flex;
justify-content:space-between;
align-items:center;
background:#111;
color:white;
padding:15px 40px;
}

.navbar h2{
font-weight:500;
}

.navbar a{
text-decoration:none;
color:white;
background:#ff6b6b;
padding:8px 15px;
border-radius:6px;
transition:0.3s;
}

.navbar a:hover{
background:#ff3b3b;
}

/* HERO */

.hero{
text-align:center;
padding:50px 20px;
color:white;
}

.hero h1{
font-size:40px;
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
}

/* SECTION TITLE */

.section-title{
font-size:26px;
color:white;
margin:40px 0 20px;
}

/* GRID */

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:25px;
}

/* CARD */

.card{
background:white;
border-radius:12px;
padding:25px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
transition:0.3s;
}

.card:hover{
transform:translateY(-10px);
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
margin-top:10px;
padding:8px 16px;
border-radius:6px;
text-decoration:none;
color:white;
font-size:14px;
}

/* COLORS */

.resume{
border-left:6px solid #28a745;
}
.resume a{background:#28a745;}

.jobs{
border-left:6px solid #007bff;
}
.jobs a{background:#007bff;}

.skills{
border-left:6px solid #f39c12;
}
.skills a{background:#f39c12;}

.interview{
border-left:6px solid #e74c3c;
}
.interview a{background:#e74c3c;}

.network{
border-left:6px solid #6f42c1;
}
.network a{background:#6f42c1;}

.learning{
border-left:6px solid #20c997;
}
.learning a{background:#20c997;}

/* FEATURE */

.feature{
background:white;
padding:30px;
border-radius:12px;
margin-top:20px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
display:flex;
justify-content:space-between;
align-items:center;
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
<h2><i class="fa-solid fa-briefcase"></i> Career Resources</h2>
<a href="undergraduate_resources.php">
<i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<!-- HERO -->

<div class="hero">
<h1>Build Your Career 🚀</h1>
<p>Explore job platforms, skill development and career guidance.</p>
</div>

<div class="container">

<!-- FEATURE -->

<div class="feature">
<h2>Find Your Dream Career Today</h2>
<a href="https://www.linkedin.com" target="_blank">Explore Careers</a>
</div>

<!-- JOB PLATFORMS -->

<div class="section-title">Job Platforms</div>

<div class="grid">

<div class="card jobs">
<i class="fa-brands fa-linkedin"></i>
<h3>LinkedIn</h3>
<p>Build professional profile and find job opportunities.</p>
<a href="https://linkedin.com" target="_blank">Visit</a>
</div>

<div class="card jobs">
<i class="fa-solid fa-briefcase"></i>
<h3>Indeed</h3>
<p>Search thousands of job listings across industries.</p>
<a href="https://indeed.com" target="_blank">Find Jobs</a>
</div>

<div class="card jobs">
<i class="fa-solid fa-building"></i>
<h3>Naukri</h3>
<p>Popular job portal for freshers and professionals.</p>
<a href="https://naukri.com" target="_blank">Search Jobs</a>
</div>

</div>

<!-- SKILL DEVELOPMENT -->

<div class="section-title">Skill Development</div>

<div class="grid">

<div class="card skills">
<i class="fa-solid fa-laptop"></i>
<h3>Online Courses</h3>
<p>Learn new skills with online courses and certifications.</p>
<a href="https://coursera.org" target="_blank">Learn</a>
</div>

<div class="card skills">
<i class="fa-solid fa-code"></i>
<h3>Technical Skills</h3>
<p>Develop coding and technology skills.</p>
<a href="https://www.w3schools.com" target="_blank">Start Learning</a>
</div>

<div class="card learning">
<i class="fa-solid fa-book"></i>
<h3>Career Articles</h3>
<p>Read career advice and industry insights.</p>
<a href="https://www.geeksforgeeks.org" target="_blank">Read</a>
</div>

</div>

<!-- CAREER PREPARATION -->

<div class="section-title">Career Preparation</div>

<div class="grid">

<div class="card resume">
<i class="fa-solid fa-file"></i>
<h3>Resume Builder</h3>
<p>Create professional resumes for job applications.</p>
<a href="https://www.canva.com/resumes/" target="_blank">Create Resume</a>
</div>

<div class="card interview">
<i class="fa-solid fa-user-tie"></i>
<h3>Interview Preparation</h3>
<p>Prepare for job interviews and aptitude tests.</p>
<a href="https://www.interviewbit.com/" target="_blank">Prepare</a>
</div>

<div class="card network">
<i class="fa-solid fa-users"></i>
<h3>Professional Networking</h3>
<p>Connect with professionals and mentors.</p>
<a href="https://linkedin.com" target="_blank">Connect</a>
</div>

</div>

</div>

<div class="footer">
Unified Education Platform © 2026 | Career Resources
</div>

</body>
</html>
