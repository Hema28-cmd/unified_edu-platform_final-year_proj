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
<title>Undergraduate Forums</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#eef2ff,#f8fafc);
}

/* LAYOUT */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    background:#1e1b4b;
    color:#e5e7eb;
    padding:30px 20px;
}

.sidebar h2{
    text-align:center;
    margin-bottom:40px;
    color:#a5b4fc;
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
    transition:0.3s;
}

.sidebar a:hover,
.sidebar a.active{
    background:#312e81;
    color:#c7d2fe;
}

.sidebar a.logout{
    background:#7f1d1d;
    color:#fff;
}

/* MAIN */
.main{
    flex:1;
    padding:35px;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:30px 35px;
    border-radius:22px;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    margin-bottom:35px;
}

.header h1{
    margin:0;
    font-size:28px;
    color:#1e1b4b;
}

.header p{
    margin-top:8px;
    color:#475569;
}

/* FORUM GRID */
.forum-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:30px;
}

/* DISCUSSION LIST */
.discussion-box{
    background:#ffffff;
    padding:28px;
    border-radius:22px;
    box-shadow:0 12px 28px rgba(0,0,0,0.08);
}

.discussion{
    display:flex;
    gap:18px;
    padding:18px 0;
    border-bottom:1px solid #e5e7eb;
}

.discussion:last-child{
    border-bottom:none;
}

.discussion i{
    font-size:26px;
    color:#6366f1;
}

.discussion h4{
    margin:0;
    color:#1e1b4b;
}

.discussion p{
    margin:6px 0;
    font-size:14px;
    color:#475569;
}

.discussion span{
    font-size:12px;
    color:#64748b;
}

/* SIDE PANEL */
.side-panel{
    display:flex;
    flex-direction:column;
    gap:25px;
}

.panel{
    background:#ffffff;
    padding:25px;
    border-radius:22px;
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
}

.panel h3{
    margin-bottom:14px;
    color:#1e1b4b;
}

.tag{
    display:inline-block;
    padding:8px 14px;
    background:#e0e7ff;
    color:#3730a3;
    border-radius:18px;
    font-size:13px;
    margin:6px;
}

/* BUTTON */
.new-post{
    margin-top:20px;
    padding:14px;
    border:none;
    width:100%;
    border-radius:14px;
    background:#6366f1;
    color:#fff;
    font-size:15px;
    cursor:pointer;
}

.new-post:hover{
    background:#4f46e5;
}

/* MOBILE */
@media(max-width:900px){
    .forum-grid{
        grid-template-columns:1fr;
    }
    .wrapper{
        flex-direction:column;
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
        <a class="active"><i class="fa-solid fa-comments"></i> UG Forums</a>
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
            <h1>Undergraduate Discussion Forums</h1>
            <p>Ask questions, share knowledge, and collaborate with peers</p>
        </div>

        <div class="forum-grid">

            <!-- DISCUSSIONS -->
            <div class="discussion-box">
                <h3>Recent Discussions</h3>

                <div class="discussion">
                    <i class="fa-solid fa-book"></i>
                    <div>
                        <h4>Best strategy to prepare for semester exams?</h4>
                        <p>Share your preparation methods, revision techniques, and time management tips.</p>
                        <span>Posted by Student • 12 replies</span>
                    </div>
                </div>

                <div class="discussion">
                    <i class="fa-solid fa-code"></i>
                    <div>
                        <h4>Project ideas for final year computer science</h4>
                        <p>Discuss innovative and feasible project ideas suitable for undergraduate students.</p>
                        <span>Posted by Student • 8 replies</span>
                    </div>
                </div>

                <div class="discussion">
                    <i class="fa-solid fa-flask"></i>
                    <div>
                        <h4>How to write effective lab records?</h4>
                        <p>Tips on formatting, observation writing, and viva preparation.</p>
                        <span>Posted by Student • 6 replies</span>
                    </div>
                </div>

                <div class="discussion">
                    <i class="fa-solid fa-graduation-cap"></i>
                    <div>
                        <h4>Internship vs Certification – which is better?</h4>
                        <p>Discuss the impact of internships and online certifications.</p>
                        <span>Posted by Student • 15 replies</span>
                    </div>
                </div>
            </div>

            <!-- SIDE PANEL -->
            <div class="side-panel">

                <div class="panel">
                    <h3>Popular Topics</h3>
                    <span class="tag">Exams</span>
                    <span class="tag">Projects</span>
                    <span class="tag">Internships</span>
                    <span class="tag">Assignments</span>
                    <span class="tag">Placements</span>
                </div>

                <div class="panel">
                    <h3>Forum Guidelines</h3>
                    <p style="font-size:14px;color:#475569;line-height:1.6;">
                        • Be respectful and professional<br>
                        • Avoid spam and irrelevant content<br>
                        • Share accurate academic information<br>
                        • Help peers with constructive responses
                    </p>
                </div>

                
            </div>

        </div>

    </div>
</div>

</body>
</html>
