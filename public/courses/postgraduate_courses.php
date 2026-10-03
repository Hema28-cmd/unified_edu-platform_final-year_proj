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
<title>Postgraduate Courses</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body {
    margin: 0;
    font-family: 'Roboto', sans-serif;
    background: #f5f7fb;
}

/* HEADER */
.header {
    text-align: center;
    padding: 50px 20px 20px;
    background: linear-gradient(135deg,#4f46e5,#6366f1);
    color: #fff;
}
.header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    margin-bottom: 10px;
}
.header p {
    font-size: 18px;
    opacity: 0.9;
}

/* COURSES GRID */
.courses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px,1fr));
    gap: 25px;
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

/* COURSE CARD */
.course-card {
    border-radius: 20px;
    padding: 30px 20px;
    text-align: center;
    color: #fff;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
    position: relative;
}
.course-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
}

/* ICON */
.course-card i {
    font-size: 48px;
    margin-bottom: 15px;
    padding: 20px;
    border-radius: 50%;
    display: inline-block;
    background: rgba(255,255,255,0.2);
}

/* TEXT */
.course-card h3 {
    margin: 15px 0 8px;
    font-size: 22px;
}
.course-card p {
    font-size: 14px;
    color: #f3f4f6;
}

/* VIEW BUTTON */
.course-card a {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 25px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    text-decoration: none;
    border-radius: 25px;
    font-weight: 500;
    transition: background 0.3s, transform 0.2s;
}
.course-card a:hover {
    background: rgba(255,255,255,0.35);
    transform: scale(1.05);
}

/* CARD COLORS */
.card-ai { background: linear-gradient(135deg,#f472b6,#f43f5e); }
.card-ml { background: linear-gradient(135deg,#22c55e,#16a34a); }
.card-cyber { background: linear-gradient(135deg,#f59e0b,#fbbf24); }
.card-data { background: linear-gradient(135deg,#3b82f6,#60a5fa); }
.card-cloud { background: linear-gradient(135deg,#8b5cf6,#a78bfa); }
.card-network { background: linear-gradient(135deg,#14b8a6,#0d9488); }

/* FOOTER */
.footer {
    text-align: center;
    color: #64748b;
    padding: 30px 0;
}
.back-btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 28px;
    background:#ffffff;
    color:#4f46e5;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
    box-shadow:0 8px 18px rgba(0,0,0,0.15);
    transition:0.3s;
}
.back-btn i{
    margin-right:8px;
}
.back-btn:hover{
    background:#eef2ff;
    transform:translateY(-3px);
}

</style>
</head>
<body>

<div class="header">
    <h1>Postgraduate Courses</h1>
    <p>Choose your course to access study materials and assignments</p>

    <a href="http://localhost/unified_edu/public/postgraduate.php" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
</div>


<div class="courses-grid">
    <div class="course-card card-ai">
        <i class="fa-solid fa-robot"></i>
        <h3>Artificial Intelligence</h3>
        <p>Explore advanced AI concepts, neural networks, and intelligent systems.</p>
        <a href="course_detail.php?course=ai">View Course</a>
    </div>

    <div class="course-card card-ml">
        <i class="fa-solid fa-brain"></i>
        <h3>Machine Learning</h3>
        <p>Learn predictive modeling, supervised and unsupervised algorithms.</p>
        <a href="course_detail.php?course=ml">View Course</a>
    </div>

    <div class="course-card card-cyber">
        <i class="fa-solid fa-shield-alt"></i>
        <h3>Cyber Security</h3>
        <p>Understand security protocols, penetration testing, and ethical hacking.</p>
        <a href="course_detail.php?course=cyber">View Course</a>
    </div>

    <div class="course-card card-data">
        <i class="fa-solid fa-database"></i>
        <h3>Data Science</h3>
        <p>Analyze and visualize data using Python, R, and advanced techniques.</p>
        <a href="course_detail.php?course=data">View Course</a>
    </div>

    <div class="course-card card-cloud">
        <i class="fa-solid fa-cloud"></i>
        <h3>Cloud Computing</h3>
        <p>Learn about AWS, Azure, GCP, and scalable cloud architectures.</p>
        <a href="course_detail.php?course=cloud">View Course</a>
    </div>

    <div class="course-card card-network">
        <i class="fa-solid fa-network-wired"></i>
        <h3>Networking</h3>
        <p>Study advanced networking protocols, security, and administration.</p>
        <a href="course_detail.php?course=network">View Course</a>
    </div>
</div>

<div class="footer">
    © <?php echo date("Y"); ?> Smart Education Platform – Postgraduate
</div>

</body>
</html>
