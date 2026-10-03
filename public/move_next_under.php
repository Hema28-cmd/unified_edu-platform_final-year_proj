<?php
session_start();

// Only allow undergraduate users
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate'){
    header("Location: dashboard.php");
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'Student';
$next_level = "Graduate Level";
$date_of_issue = date("d M Y");
$certificate_id = "UG-" . date("Ymd") . "-" . rand(1000,9999);

// Update session for next level
$_SESSION['user_level'] = 'postgraduate';
$_SESSION['postgraduate_quiz_completed'] = false;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Level Up - PostGraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{
    min-height:100vh;
    background: linear-gradient(160deg,#fdfbfb,#ebedee);
    display:flex;
    flex-direction:column;
    align-items:center;
    padding:20px;
}

/* HEADER BANNER */
.header-banner{
    width:100%;
    max-width:1000px;
    text-align:center;
    padding:50px 20px;
    background: linear-gradient(135deg,#ff9a9e,#fad0c4);
    border-radius:20px;
    box-shadow:0 8px 30px rgba(0,0,0,0.15);
    color:#fff;
}
.header-banner h1{
    font-size:38px;
    margin-bottom:10px;
}
.header-banner h2{
    font-size:26px;
    font-weight:400;
}

/* MAIN CONTENT CARDS */
.main-content{
    max-width:1000px;
    width:100%;
    display:flex;
    flex-direction:column;
    gap:25px;
    margin:40px 0;
}

/* INDIVIDUAL PANELS */
.panel{
    background:white;
    border-radius:20px;
    padding:30px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    transition:0.3s;
}
.panel:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.panel h3{
    margin-bottom:15px;
    color:#6a1b9a;
}
.panel p{
    font-size:15px;
    color:#424242;
    margin-bottom:8px;
}

/* CERTIFICATE INFO SPECIAL */
.certificate-info{
    border-left:6px solid #ff5722;
    background:#fff3e0;
}

/* BUTTONS */
.btn{
    display:inline-block;
    padding:14px 28px;
    font-size:16px;
    font-weight:bold;
    border-radius:25px;
    text-decoration:none;
    cursor:pointer;
    transition:0.3s;
    margin:10px 10px 0 10px;
}
.btn-primary{
    background:#8e24aa;
    color:white;
    border:none;
}
.btn-primary:hover{
    transform:scale(1.05);
    box-shadow:0 10px 25px rgba(0,0,0,0.2);
}
.btn-secondary{
    background:white;
    color:#8e24aa;
    border:2px solid #8e24aa;
}
.btn-secondary:hover{
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}

/* RESPONSIVE */
@media(max-width:768px){
    .main-content{
        flex-direction:column;
    }
}
</style>
</head>
<body>

<div class="header-banner">
    <h1>🎉 Congratulations, <?php echo htmlspecialchars($user_name); ?>!</h1>
    <h2>You are now promoted to <?php echo $next_level; ?></h2>
</div>

<div class="main-content">

    <div class="panel certificate-info">
        <h3>Certificate of Completion</h3>
        <p><strong>ID:</strong> <?php echo $certificate_id; ?></p>
        <p><strong>Date of Issue:</strong> <?php echo $date_of_issue; ?></p>
        <p><strong>Level Completed:</strong> Undergraduate</p>
    </div>

    <div class="panel">
        <h3>Next Steps</h3>
        <p>1️⃣ Explore Graduate Courses tailored for advanced learning.</p>
        <p>2️⃣ Join live sessions and Q&A for expert guidance.</p>
        <p>3️⃣ Complete assignments and track your performance.</p>
        <p>4️⃣ Earn certificates and achievements at the Graduate Level.</p>
    </div>

    <div class="panel">
        <h3>Resources & Tips</h3>
        <p>📘 Make use of the provided study materials.</p>
        <p>⏰ Manage time effectively for assignments.</p>
        <p>💬 Participate in forums for collaborative learning.</p>
        <p>🎯 Set milestones to track your progress efficiently.</p>
    </div>

</div>

<div style="text-align:center; margin-bottom:50px;">
    <a href="postgraduate.php" class="btn btn-primary">🎯 Go to Graduate Dashboard</a>
   
</div>

</body>
</html>
