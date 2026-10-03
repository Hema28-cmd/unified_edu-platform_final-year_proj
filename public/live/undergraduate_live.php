<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}
$user_name = $_SESSION['user_name'] ?? 'Student';

/* SAMPLE LIVE MEETING LINKS */
$live_links = [
    'lecture'  => 'https://meet.google.com/abc-defg-hij',
    'lab'      => 'https://zoom.us/j/9876543210',
    'workshop' => 'https://meet.google.com/work-shop-123',
    'seminar'  => 'https://zoom.us/j/1234567890',
    'doubt'    => 'https://meet.google.com/doubt-clear-456'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Live Classes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#eef2ff;
}
.container{
    max-width:1200px;
    margin:40px auto;
    padding:20px;
}
.header{
    background:linear-gradient(135deg,#4f46e5,#6366f1);
    color:#fff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}
.header h1{margin:0;font-size:32px;}
.header p{margin-top:8px;opacity:0.9;}

.live-grid{
    margin-top:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.live-card{
    background:#fff;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}
.live-card:hover{transform:translateY(-8px);}
.live-card i{font-size:42px;margin-bottom:15px;}
.live-card h3{margin-bottom:10px;color:#1e293b;}
.live-card p{font-size:14px;color:#475569;margin-bottom:18px;}

.live-card a{
    display:inline-block;
    padding:12px 26px;
    border-radius:20px;
    text-decoration:none;
    color:#fff;
    font-weight:600;
}

.lecture i{color:#2563eb;}
.lab i{color:#16a34a;}
.workshop i{color:#f59e0b;}
.seminar i{color:#ec4899;}
.doubt i{color:#8b5cf6;}

.lecture a{background:#2563eb;}
.lab a{background:#16a34a;}
.workshop a{background:#f59e0b;}
.seminar a{background:#ec4899;}
.doubt a{background:#8b5cf6;}

.back{
    display:inline-block;
    margin-top:35px;
    padding:12px 20px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:14px;
    font-weight:600;
}
.back:hover{background:#dc2626;}
</style>
</head>
<body>

<div class="container">

    <div class="header">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?> 🎥</h1>
        <p>Click below to join live classes instantly</p>
    </div>

    <div class="live-grid">

        <div class="live-card lecture">
            <i class="fa-solid fa-chalkboard"></i>
            <h3>Live Lecture</h3>
            <p>Join the ongoing live lecture session.</p>
            <a href="<?php echo $live_links['lecture']; ?>" target="_blank">▶ Join Now</a>
        </div>

        <div class="live-card lab">
            <i class="fa-solid fa-flask"></i>
            <h3>Live Lab Session</h3>
            <p>Join the live practical laboratory class.</p>
            <a href="<?php echo $live_links['lab']; ?>" target="_blank">▶ Join Now</a>
        </div>

        <div class="live-card workshop">
            <i class="fa-solid fa-laptop-code"></i>
            <h3>Workshop</h3>
            <p>Join the hands-on technical workshop.</p>
            <a href="<?php echo $live_links['workshop']; ?>" target="_blank">▶ Join Now</a>
        </div>

        <div class="live-card seminar">
            <i class="fa-solid fa-microphone"></i>
            <h3>Seminar / Guest Talk</h3>
            <p>Join the seminar or guest lecture.</p>
            <a href="<?php echo $live_links['seminar']; ?>" target="_blank">▶ Join Now</a>
        </div>

        <div class="live-card doubt">
            <i class="fa-solid fa-circle-question"></i>
            <h3>Doubt Clearing</h3>
            <p>Join the doubt clearing live session.</p>
            <a href="<?php echo $live_links['doubt']; ?>" target="_blank">▶ Join Now</a>
        </div>

    </div>

    <a href="../undergraduate.php" class="back">← Back to Dashboard</a>

</div>

</body>
</html>
