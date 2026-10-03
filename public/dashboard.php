<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_name  = $_SESSION['user_name'];
$user_role  = $_SESSION['user_role'];   // admin / student / teacher
$user_level = $_SESSION['user_level'];  // kindergarten, primary, etc.

/* 🎓 Education-based message */
switch ($user_level) {
    case 'kindergarten':
        $level_message = 'Let’s start learning with fun activities, colors, and stories 🌈';
        break;
    case 'primary':
        $level_message = 'Build strong basics and explore new ideas step by step 📘';
        break;
    case 'secondary':
        $level_message = 'Strengthen concepts with structured and guided learning ✏️';
        break;
    case 'highschool':
        $level_message = 'Focus on academic excellence and future preparation 🎯';
        break;
    case 'undergraduate':
        $level_message = 'Enhance professional skills and practical knowledge 🎓';
        break;
    case 'postgraduate':
        $level_message = 'Advance your expertise through research and innovation 🔬';
        break;
    default:
        $level_message = 'Welcome to your personalized dashboard 🚀';
}

/* 🔀 FINAL ROLE + LEVEL REDIRECT LOGIC */
if ($user_role === 'admin') {

    // ✅ ADMIN → admin panel
    $redirect_page = "../admin/admin.php";

} elseif ($user_role === 'teacher') {

    // 👩‍🏫 TEACHER dashboards → /teachers/
    $redirect_page = "../teachers/" . $user_level . ".php";

} else {

    // 🎓 STUDENT dashboards → /public/
    $redirect_page = $user_level . ".php";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}
body{
    height:100vh;
    background: linear-gradient(135deg,#1e3a8a,#312e81);
    overflow:hidden;
    color:white;
}

/* 🌈 RAINBOW SHOWER */
.rainbow span{
    position:absolute;
    top:-50px;
    width:14px;
    height:14px;
    border-radius:50%;
    animation: fall linear infinite;
}
@keyframes fall{
    to{
        transform: translateY(110vh);
        opacity:0;
    }
}

/* ⬆ MOVE UP */
@keyframes moveUp {
    to {
        transform: translateY(-120vh);
        opacity: 0;
    }
}

/* 💎 DASHBOARD */
.dashboard-container{
    position:relative;
    z-index:10;
    max-width:520px;
    margin:110px auto;
    background:rgba(255,255,255,0.12);
    backdrop-filter: blur(14px);
    padding:42px;
    border-radius:28px;
    text-align:center;
    box-shadow:0 30px 60px rgba(0,0,0,0.35);
}
.move-up{
    animation: moveUp 1.1s ease forwards;
}
.dashboard-container h2{
    font-size:32px;
    margin-bottom:12px;
}
.dashboard-container p{
    font-size:16px;
    margin:8px 0;
    opacity:0.9;
}
.badge{
    display:inline-block;
    margin-top:8px;
    padding:7px 18px;
    border-radius:22px;
    background:linear-gradient(90deg,#f97316,#ec4899,#8b5cf6);
    font-weight:600;
    font-size:14px;
}
.level-text{
    margin-top:14px;
    font-size:15px;
    line-height:1.5;
    opacity:0.88;
}
.footer-text{
    margin-top:24px;
    font-size:14px;
    opacity:0.75;
}
</style>

<script>
    // Move up animation
    setTimeout(function(){
        document.querySelector('.dashboard-container')
            .classList.add('move-up');
    }, 4500);

    // 🔀 FINAL REDIRECT
    setTimeout(function(){
        window.location.href = "<?php echo $redirect_page; ?>";
    }, 5600);
</script>

</head>
<body>

<!-- 🌈 RAINBOW SHOWER -->
<div class="rainbow">
<?php
$colors = ['#ef4444','#f97316','#facc15','#22c55e','#38bdf8','#6366f1','#ec4899'];
for($i=0;$i<90;$i++){
    $color = $colors[array_rand($colors)];
    $left = rand(0,100);
    $delay = rand(0,8);
    $duration = rand(4,9);
    echo "<span style='left:$left%;background:$color;
          animation-duration:{$duration}s;
          animation-delay:{$delay}s'></span>";
}
?>
</div>

<!-- 🎓 DASHBOARD CARD -->
<div class="dashboard-container">
    <h2>Welcome, <?php echo htmlspecialchars($user_name); ?> 👋</h2>

    <p>Your Role</p>
    <div class="badge"><?php echo ucfirst(htmlspecialchars($user_role)); ?></div>

    <p style="margin-top:16px;">Education Level</p>
    <div class="badge"><?php echo ucfirst(htmlspecialchars($user_level)); ?></div>

    <p class="level-text"><?php echo $level_message; ?></p>

    <div class="footer-text">
        Preparing your personalized dashboard…
    </div>
</div>

</body>
</html>
