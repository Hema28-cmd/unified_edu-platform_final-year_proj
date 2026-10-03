<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Learning Hub</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background: linear-gradient(135deg,#f3f4f6,#e0f2fe);
}

/* TOP BAR */
.topbar{
    background: linear-gradient(90deg,#4f46e5,#6366f1);
    color:#fff;
    padding:20px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 10px rgba(0,0,0,0.1);
}

.topbar h2{margin:0;}
.topbar a{
    color:#fff;
    text-decoration:none;
    font-weight:600;
}

/* WRAPPER */
.wrapper{
    max-width:1100px;
    margin:40px auto;
    padding:0 20px;
}

/* SECTION */
.section{
    background:#ffffff;
    border-left:8px solid #4f46e5;
    border-radius:16px;
    padding:30px;
    margin-bottom:35px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
}
.section:hover{
    transform: translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

.section h3{
    margin-top:0;
    color:#1e293b;
    font-size:22px;
}

.section p{
    color:#475569;
    font-size:15px;
    line-height:1.6;
}

/* ACTION BAR */
.actions{
    margin-top:20px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.actions a{
    padding:12px 22px;
    border-radius:22px;
    text-decoration:none;
    font-size:15px;
    font-weight:500;
    color:#fff;
    transition:0.3s;
}

/* BUTTON COLORS */
.btn-courses{background:#6366f1;}
.btn-research{background:#16a34a;}
.btn-assignments{background:#f59e0b;}
.btn-projects{background:#db2777;}
.btn-seminars{background:#dc2626;}
.btn-publications{background:#0d9488;}
.btn-networking{background:#f97316;}
.btn-certificate{background:#14b8a6;}

.actions a:hover{opacity:0.9}

/* FOOTER */
.footer{
    text-align:center;
    color:#64748b;
    padding:25px 0;
    border-top:1px solid #e2e8f0;
}

/* ICONS */
.section i{
    font-size:28px;
    margin-right:10px;
    color: inherit;
}
</style>
</head>

<body>

<div class="topbar">
    <h2>🎓 Postgraduate Portal</h2>
    <a href="logout.php">Logout</a>
</div>

<div class="wrapper">

    <div class="section">
        <h3><i class="fa-solid fa-book-open"></i> Courses</h3>
        <p>Access detailed postgraduate courses including advanced topics, electives, and supplementary learning materials. Stay on top of your curriculum and track progress efficiently.</p>
        <div class="actions">
            <a href="courses/postgraduate_courses.php" class="btn-courses">View Courses</a>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-microscope"></i> Research</h3>
        <p>Explore ongoing research projects, journals, and publications. Collaborate with faculty and peers, and stay updated on the latest findings in your field.</p>
        <div class="actions">
            <a href="research/research.php" class="btn-research">View Research</a>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-pencil"></i> Assignments</h3>
        <p>Download, complete, and submit your assignments online. Track deadlines and check grading to stay organized throughout the semester.</p>
        <div class="actions">
            <a href="assignments/postgraduate_assignments.php" class="btn-assignments">View Assignments</a>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-diagram-project"></i> Projects</h3>
        <p>Manage individual and group projects. Upload your deliverables, get feedback, and monitor project milestones for successful completion.</p>
        <div class="actions">
            <a href="project/projects.php" class="btn-projects">View Projects</a>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-newspaper"></i> Publications</h3>
        <p>Access published papers, articles, and thesis materials. Submit your own publications and contribute to the academic repository.</p>
        <div class="actions">
            <a href="publications/publications.php" class="btn-publications">View Publications</a>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-users"></i> Networking</h3>
        <p>Connect with your peers, faculty, and alumni. Join discussion forums, groups, and professional networks to enhance collaboration.</p>
        <div class="actions">
            <a href="network/networking.php" class="btn-networking">Explore Networking</a>
        </div>
    </div>

    <div class="section">
        <h3><i class="fa-solid fa-trophy"></i> Certificate</h3>
        <p>Download your postgraduate completion certificates, awards, and recognitions earned during your academic journey.</p>
        <div class="actions">
            <a href="certificate/certificate.php" class="btn-certificate">View Certificate</a>
        </div>
    </div>

</div>

<div class="footer">
    © <?php echo date("Y"); ?> Smart Education Platform – Postgraduate
</div>

</body>
</html>
