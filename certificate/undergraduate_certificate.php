<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Course Certificate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#f0fdfa,#f1f5f9);
}

.wrapper{
display:flex;
min-height:100vh;
}

/* SIDEBAR */

.sidebar{
width:260px;
background:#0f766e;
color:#ecfeff;
padding:30px 20px;
}

.sidebar h2{
text-align:center;
margin-bottom:40px;
color:#99f6e4;
}

.sidebar a{
display:flex;
align-items:center;
gap:12px;
padding:14px 16px;
margin-bottom:12px;
color:#ecfeff;
text-decoration:none;
border-radius:10px;
transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
background:#134e4a;
}

.sidebar a.logout{
background:#7f1d1d;
}

/* MAIN */

.main{
flex:1;
padding:35px;
}

/* HEADER */

.header{
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
margin-bottom:30px;
}

.header h1{
margin:0;
color:#0f766e;
}

.header p{
color:#475569;
margin-top:8px;
}

/* CARD */

.certificate-box{
display:flex;
justify-content:center;
}

.certificate-card{
background:white;
width:450px;
padding:30px;
border-radius:25px;
box-shadow:0 15px 35px rgba(0,0,0,0.1);
text-align:center;
transition:0.3s;
}

.certificate-card:hover{
transform:translateY(-6px);
}

.certificate-card i{
font-size:60px;
color:#14b8a6;
margin-bottom:15px;
}

.certificate-card h3{
margin-bottom:10px;
color:#134e4a;
}

.certificate-card p{
font-size:14px;
color:#475569;
line-height:1.6;
}

/* BUTTON */

.btn{
    display:inline-flex;          /* better alignment */
    align-items:center;
    justify-content:center;
    gap:8px;

    margin-top:15px;
    padding:8px 16px;             /* 🔽 reduced size */
    
    background:#14b8a6;
    color:white;
    text-decoration:none;
    border-radius:18px;           /* slightly smaller */
    
    font-size:13px;               /* 🔽 smaller text */
    font-weight:500;
    
    width:auto;                   /* 🔥 prevents full width */
    max-width:160px;              /* optional limit */
}

.btn:hover{
    background:#0f766e;
}

/* INFO SECTION */

.info-section{
margin-top:40px;
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:25px;
}

.info-card{
background:white;
padding:25px;
border-radius:18px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.info-card h3{
color:#0f766e;
margin-bottom:10px;
}

.info-card ul{
padding-left:18px;
color:#475569;
font-size:14px;
}

/* MOBILE */

@media(max-width:768px){

.wrapper{
flex-direction:column;
}

.sidebar{
width:100%;
}

.certificate-card{
width:100%;
}

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
        <a href="../resources/undergraduate_resources.php"><i class="fa-solid fa-folder-open"></i> Resources</a>
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

<!-- MAIN -->

<div class="main">

<div class="header">
<h1>Undergraduate Course Completion Certificate</h1>
<p>
Students who successfully complete all required academic activities
are eligible to receive a digital course completion certificate.
</p>
</div>

<div class="certificate-box">

<div class="certificate-card">

<i class="fa-solid fa-award"></i>

<h3>Download Your Certificate</h3>

<p>
This certificate confirms that the student has completed the
undergraduate learning modules including lessons, quizzes,
and academic assessments provided in the platform.
</p>

<a href="view_undergraduate_certificate.php" class="btn">
<i class="fa-solid fa-eye"></i> View Certificate
</a>

</div>

</div>

<!-- INFORMATION SECTIONS -->

<div class="info-section">

<div class="info-card">
<h3>Certificate Eligibility</h3>
<ul>
<li>Complete all course lessons</li>
<li>Pass quizzes and assessments</li>
<li>Submit required academic activities</li>
<li>Maintain minimum required score</li>
</ul>
</div>

<div class="info-card">
<h3>Benefits of Certificate</h3>
<ul>
<li>Proof of course completion</li>
<li>Enhances academic profile</li>
<li>Supports internship applications</li>
<li>Useful for higher studies</li>
</ul>
</div>

<div class="info-card">
<h3>Certificate Features</h3>
<ul>
<li>Digital downloadable certificate</li>
<li>Includes student name</li>
<li>Contains issue date</li>
<li>Official verification details</li>
</ul>
</div>

</div>

</div>

</div>

</body>
</html>