<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten'){
    header("Location: dashboard.php");
    exit;
}

// Example live classes (title, time, link)
$live_classes = [
    ['title'=>'Alphabet Fun','time'=>'10:00 AM - 10:30 AM','link'=>'https://meet.google.com/abc-defg-hij','icon'=>'fa-font'],
    ['title'=>'Numbers & Counting','time'=>'11:00 AM - 11:30 AM','link'=>'https://meet.google.com/klm-nopq-rst','icon'=>'fa-1'],
    ['title'=>'Colors & Drawing','time'=>'2:00 PM - 2:30 PM','link'=>'https://meet.google.com/uvw-xyza-bcd','icon'=>'fa-palette'],
    ['title'=>'Shapes & Objects','time'=>'3:00 PM - 3:30 PM','link'=>'https://meet.google.com/efg-hijk-lmn','icon'=>'fa-square'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kindergarten Live Classes | Unified Edu</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Comic Sans MS','Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg,#fef08a,#dbeafe);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#34d399,#3b82f6,#8b5cf6);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}
.navbar .logo{
    font-size:22px;
    font-weight:bold;
}
.navbar a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:600;
}
.navbar a:hover{
    text-decoration:underline;
}

/* 🟡 HEADER */
.header{
    text-align:center;
    padding:20px 20px 30px;
}
.header h1{
    font-size:40px;
    color:#7c2d12;
}
.header p{
    font-size:18px;
    color:#475569;
    margin-top:8px;
}

/* 📚 CLASSES GRID */
.classes-grid{
    max-width:1200px;
    margin:0 auto 50px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* 🔹 CLASS CARD */
.card{
    background:white;
    border-radius:25px;
    padding:25px 20px;
    text-align:center;
    cursor:pointer;
    transition:0.3s;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.card:hover{
    transform:scale(1.05);
    box-shadow:0 25px 50px rgba(0,0,0,0.2);
}
.card .icon{
    width:60px;
    height:60px;
    margin:0 auto 15px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
    color:white;
}
.card h3{
    font-size:22px;
    margin-bottom:8px;
    color:#1e293b;
}
.card p{
    font-size:15px;
    color:#64748b;
}

/* Gradient backgrounds for icons */
.icon-1{background:#f87171;}
.icon-2{background:#34d399;}
.icon-3{background:#6366f1;}
.icon-4{background:#facc15; color:#1e293b;}

/* JOIN BUTTON */
.join-btn{
    display:inline-block;
    margin-top:12px;
    background:linear-gradient(90deg,#3b82f6,#6366f1);
    color:white;
    text-decoration:none;
    padding:10px 22px;
    border-radius:20px;
    font-weight:bold;
    transition:0.3s;
}
.join-btn:hover{
    transform:scale(1.05);
    background:linear-gradient(90deg,#6366f1,#3b82f6);
}

/* RESPONSIVE */
@media(max-width:600px){
    .card{padding:20px;}
    .header h1{font-size:32px;}
}
</style>
</head>
<body>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <div>
        <a href="kindergarten.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- 🟡 HEADER -->
<div class="header">
    <h1>🎥 Live Classes</h1>
    <p>Join interactive sessions and learn with fun!</p>
</div>

<!-- 📚 CLASSES GRID -->
<div class="classes-grid">
    <?php foreach($live_classes as $index=>$cls): ?>
        <div class="card">
            <div class="icon icon-<?php echo $index+1; ?>"><i class="fa-solid <?php echo $cls['icon']; ?>"></i></div>
            <h3><?php echo $cls['title']; ?></h3>
            <p><?php echo $cls['time']; ?></p>
            <a href="<?php echo $cls['link']; ?>" target="_blank" class="join-btn">Join Class</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
