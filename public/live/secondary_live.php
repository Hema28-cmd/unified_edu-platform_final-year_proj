<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary'){
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Live Classes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg,#fff1f0,#e0f7fa);
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    color: #1e293b;
}

.page-title {
    text-align: center;
    font-weight: 700;
    margin-bottom: 50px;
    color: #f43f5e;
}

.classes-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: auto;
}

.class-card {
    border-radius: 20px;
    padding: 25px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
    color: #fff;
}

.class-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

/* Unique card colors */
.math { background: linear-gradient(135deg,#f472b6,#fb7185);}
.science { background: linear-gradient(135deg,#60a5fa,#3b82f6);}
.english { background: linear-gradient(135deg,#34d399,#10b981);}
.history { background: linear-gradient(135deg,#fbbf24,#f59e0b);}

/* Card Title */
.class-card h5 {
    font-size: 20px;
    margin-bottom: 15px;
    font-weight: 700;
}

/* Card Text */
.class-card p {
    font-size: 14px;
    margin-bottom: 20px;
}

/* Join Button */
.btn-join {
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: 500;
    color: #fff;
    background: rgba(255,255,255,0.2);
    border: none;
    transition: background 0.3s, transform 0.2s;
}

.btn-join:hover {
    background: rgba(255,255,255,0.4);
    transform: scale(1.05);
}

/* Back Button */
.btn-back {
    display:block;
    max-width:220px;
    margin:50px auto 0;
    text-align:center;
    padding:12px 30px;
    font-size:16px;
    border-radius:30px;
    color:#fff;
    background:#f43f5e;
    border:none;
    transition: 0.3s;
}
.btn-back:hover {
    background:#e11d48;
    transform: scale(1.05);
}
</style>
</head>
<body>

<div class="container py-5">

    <h2 class="page-title">
        📚 Secondary Level Live Classes
    </h2>

    <div class="classes-container">

        <!-- Math Class -->
        <div class="class-card math">
            <h5><i class="fa-solid fa-calculator"></i> Mathematics</h5>
            <p>Practice problem-solving and advanced concepts.</p>
            <a href="https://meet.google.com/abc-defg-hij" target="_blank" class="btn btn-join">
                <i class="fa-solid fa-video"></i> Join Live Class
            </a>
        </div>

        <!-- Science Class -->
        <div class="class-card science">
            <h5><i class="fa-solid fa-flask"></i> Science</h5>
            <p>Experiments, theories, and practical learning.</p>
            <a href="https://meet.google.com/xyz-pqrs-tuv" target="_blank" class="btn btn-join">
                <i class="fa-solid fa-video"></i> Join Live Class
            </a>
        </div>

        <!-- English Class -->
        <div class="class-card english">
            <h5><i class="fa-solid fa-book-open"></i> English</h5>
            <p>Improve reading, writing, and communication skills.</p>
            <a href="https://meet.google.com/abc-efgh-ijk" target="_blank" class="btn btn-join">
                <i class="fa-solid fa-video"></i> Join Live Class
            </a>
        </div>

        <!-- History Class -->
        <div class="class-card history">
            <h5><i class="fa-solid fa-landmark"></i> History</h5>
            <p>Explore historical events and significant milestones.</p>
            <a href="https://meet.google.com/lmn-opqr-stu" target="_blank" class="btn btn-join">
                <i class="fa-solid fa-video"></i> Join Live Class
            </a>
        </div>

    </div>

    <!-- Back Button -->
    <a href="../secondary.php" class="btn btn-back">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>

</div>

</body>
</html>
