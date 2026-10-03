<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Advanced Networking | Postgraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Fonts & Icons -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:#f8fafc;
    color:#0f172a;
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#0f766e,#14b8a6);
    color:#fff;
    padding:50px 30px;
    text-align:center;
}
.header h1{
    font-size:38px;
    margin-bottom:8px;
}
.header p{
    opacity:0.9;
    font-size:18px;
}

/* LAYOUT */
.wrapper{
    display:grid;
    grid-template-columns:280px 1fr;
    max-width:1400px;
    margin:40px auto;
    gap:30px;
    padding:0 20px;
}

/* SIDEBAR */
.sidebar{
    background:#ffffff;
    border-radius:25px;
    padding:30px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
}
.sidebar h3{
    margin-top:0;
    color:#0f766e;
    font-size:22px;
}
.sidebar ul{
    list-style:none;
    padding:0;
}
.sidebar li{
    margin:15px 0;
    padding:12px 15px;
    background:#f1f5f9;
    border-radius:15px;
    cursor:pointer;
    transition:0.3s;
}
.sidebar li:hover{
    background:#ccfbf1;
    transform:translateX(6px);
}
.sidebar li i{
    color:#0f766e;
    margin-right:10px;
}

/* MAIN CONTENT */
.content{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:30px;
}

/* INFO CARD */
.card{
    background:#ffffff;
    border-radius:25px;
    padding:30px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
    position:relative;
    transition:0.3s;
}
.card:hover{
    transform:translateY(-8px);
}
.card::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    border-radius:25px 25px 0 0;
    background:linear-gradient(90deg,#14b8a6,#0f766e);
}
.card h2{
    margin-top:10px;
    font-size:22px;
    color:#0f766e;
}
.card p{
    font-size:15px;
    color:#475569;
    line-height:1.6;
}
.card ul{
    margin-top:10px;
}
.card ul li{
    margin:8px 0;
}

/* ACTION BUTTON */
.card a{
    display:inline-block;
    margin-top:15px;
    padding:10px 22px;
    background:#0f766e;
    color:#fff;
    text-decoration:none;
    border-radius:25px;
    font-size:14px;
}
.card a:hover{
    background:#115e59;
}

/* BACK BUTTON */
.back-btn{
    display:block;
    width:240px;
    margin:60px auto 80px;
    text-align:center;
    padding:14px;
    background:#14b8a6;
    color:#fff;
    border-radius:30px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{
    background:#0f766e;
}

/* MOBILE */
@media(max-width:900px){
    .wrapper{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>🌐 Advanced Networking</h1>
    <p>Postgraduate course on modern computer networks and security</p>
</div>

<!-- MAIN LAYOUT -->
<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Course Modules</h3>
        <ul>
            <li><i class="fa-solid fa-network-wired"></i> Network Architectures</li>
            <li><i class="fa-solid fa-router"></i> Routing & Switching</li>
            <li><i class="fa-solid fa-shield-halved"></i> Network Security</li>
            <li><i class="fa-solid fa-cloud"></i> Software Defined Networks</li>
            <li><i class="fa-solid fa-wifi"></i> Wireless & Mobile Networks</li>
            <li><i class="fa-solid fa-server"></i> Network Management</li>
        </ul>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="card">
            <h2>Course Overview</h2>
            <p>
                This course provides in-depth knowledge of modern computer networking
                concepts, focusing on design, implementation, and management of
                large-scale networks used in enterprises and cloud environments.
            </p>
            <ul>
                <li>OSI & TCP/IP Models</li>
                <li>IPv4 & IPv6 Addressing</li>
                <li>Network Virtualization</li>
            </ul>
        </div>

        <div class="card">
            <h2>Learning Outcomes</h2>
            <p>After completing this course, students will be able to:</p>
            <ul>
                <li>Design secure and scalable networks</li>
                <li>Configure routing and switching protocols</li>
                <li>Implement firewalls and intrusion detection systems</li>
                <li>Analyze network performance and traffic</li>
            </ul>
        </div>

        <div class="card">
            <h2>Practical Components</h2>
            <p>
                Hands-on laboratory sessions using simulation and real tools help
                students gain practical exposure.
            </p>
            <ul>
                <li>Cisco Packet Tracer Labs</li>
                <li>Wireshark Packet Analysis</li>
                <li>Firewall Configuration</li>
            </ul>
            <a href="../assignments/assignments.php?course=network">View Assignments</a>
        </div>

        <div class="card">
            <h2>Evaluation Scheme</h2>
            <p>
                Student performance is assessed through continuous evaluation and
                practical examinations.
            </p>
            <ul>
                <li>Assignments – 30%</li>
                <li>Laboratory Work – 30%</li>
                <li>End Semester Exam – 40%</li>
            </ul>
        </div>

    </div>
</div>

<!-- BACK BUTTON -->
<a href="../postgraduate.php?course=network" class="back-btn">
    ⬅ Back to Course Details
</a>

</body>
</html>
