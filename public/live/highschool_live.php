<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool'){
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Live Classes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Bootstrap CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
body {
    background: linear-gradient(135deg, #fef9ff, #ede9fe);
    font-family: 'Poppins', sans-serif;
    min-height: 100vh;
    color: #1e293b;
    margin: 0;
    padding: 0;
}

.page-title {
    text-align: center;
    font-weight: 700;
    margin-bottom: 50px;
    color: #7c3aed;
}

.classes-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    max-width: 1200px;
    margin: auto;
}

.class-card {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    display: flex;
    align-items: center;
    padding: 20px 30px;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s;
    color: #fff;
}

.class-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
}

.class-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -50%;
    width: 200%;
    height: 100%;
    transform: skewX(-20deg);
    z-index: 0;
    opacity: 0.85;
}

.class-card {
    position: relative;
    overflow: hidden;
    border-radius: 20px;
    display: flex;
    align-items: center;
    padding: 20px 30px;
    cursor: pointer;
    transition: transform 0.3s, box-shadow 0.3s, border 0.3s;
    color: #fff;
    border: 3px solid rgba(255, 255, 255, 0.4); /* Add border here */
}

.class-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
    border: 3px solid rgba(255, 255, 255, 0.8); /* Stronger border on hover */
}


/* Colors for subjects */
.math::before { background: #3b82f6; }
.physics::before { background: #f97316; }
.chemistry::before { background: #14b8a6; }
.biology::before { background: #facc15; }
.english::before { background: #f472b6; }
.history::before { background: #fbbf24; }
.cs::before { background: #8b5cf6; }
.economics::before { background: #06b6d4; }

.class-card-content {
    position: relative;
    display: flex;
    align-items: center;
    z-index: 1;
    width: 100%;
}

.class-card i {
    font-size: 60px;
    margin-right: 20px;
}

.class-card-info {
    flex: 1;
}

.class-card-info h5 {
    font-size: 20px;
    margin-bottom: 10px;
    font-weight: 700;
}

.class-card-info p {
    font-size: 14px;
    margin-bottom: 15px;
}

.btn-join {
    border-radius: 25px;
    padding: 8px 18px;
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

.btn-back {
    display:block;
    max-width:220px;
    margin:50px auto 0;
    text-align:center;
    padding:12px 30px;
    font-size:16px;
    border-radius:30px;
    color:#fff;
    background:#7c3aed;
    border:none;
    transition: 0.3s;
}
.btn-back:hover {
    background:#5b21b6;
    transform: scale(1.05);
}
</style>
</head>
<body>

<div class="container py-5">

    <h2 class="page-title">
        📚 High School Live Classes
    </h2>

    <div class="classes-container">

        <!-- Math Class -->
        <div class="class-card math">
            <div class="class-card-content">
                <i class="fa-solid fa-calculator"></i>
                <div class="class-card-info">
                    <h5>Mathematics</h5>
                    <p>Advanced concepts and problem-solving sessions.</p>
                    <a href="https://meet.google.com/abc-defg-hij" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- Physics Class -->
        <div class="class-card physics">
            <div class="class-card-content">
                <i class="fa-solid fa-atom"></i>
                <div class="class-card-info">
                    <h5>Physics</h5>
                    <p>Theories, experiments, and practical learning.</p>
                    <a href="https://meet.google.com/xyz-pqrs-tuv" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- Chemistry Class -->
        <div class="class-card chemistry">
            <div class="class-card-content">
                <i class="fa-solid fa-flask"></i>
                <div class="class-card-info">
                    <h5>Chemistry</h5>
                    <p>Explore chemical reactions and experiments.</p>
                    <a href="https://meet.google.com/lmn-opqr-stu" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- Biology Class -->
        <div class="class-card biology">
            <div class="class-card-content">
                <i class="fa-solid fa-dna"></i>
                <div class="class-card-info">
                    <h5>Biology</h5>
                    <p>Understand life sciences and practical studies.</p>
                    <a href="https://meet.google.com/qrs-tuvw-xyz" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- English Class -->
        <div class="class-card english">
            <div class="class-card-content">
                <i class="fa-solid fa-book-open"></i>
                <div class="class-card-info">
                    <h5>English</h5>
                    <p>Improve reading, writing, and communication skills.</p>
                    <a href="https://meet.google.com/eng-hijk-lmn" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- History Class -->
        <div class="class-card history">
            <div class="class-card-content">
                <i class="fa-solid fa-landmark"></i>
                <div class="class-card-info">
                    <h5>History</h5>
                    <p>Explore historical events and significant milestones.</p>
                    <a href="https://meet.google.com/his-opqr-stu" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- Computer Science Class -->
        <div class="class-card cs">
            <div class="class-card-content">
                <i class="fa-solid fa-laptop-code"></i>
                <div class="class-card-info">
                    <h5>Computer Science</h5>
                    <p>Programming, algorithms, and coding exercises.</p>
                    <a href="https://meet.google.com/cs-uvwx-yza" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

        <!-- Economics Class -->
        <div class="class-card economics">
            <div class="class-card-content">
                <i class="fa-solid fa-chart-line"></i>
                <div class="class-card-info">
                    <h5>Economics</h5>
                    <p>Learn economic theories and practical examples.</p>
                    <a href="https://meet.google.com/eco-bcde-fgh" target="_blank" class="btn btn-join">
                        <i class="fa-solid fa-video"></i> Join
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Back Button -->
    <a href="../highschool.php" class="btn btn-back">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>

</div>

</body>
</html>
