<?php
session_start();

// Only kindergarten students allowed
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fun Colors | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Comic Sans MS','Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background: linear-gradient(135deg,#fef9c3,#dbeafe,#fce7f3);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#6366f1,#ec4899,#f97316);
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

/* 🔙 BACK BUTTON */
.back-btn{
    display:inline-block;
    margin:20px 30px;
    padding:10px 22px;
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    color:white;
    text-decoration:none;
    border-radius:25px;
    font-weight:bold;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    transition:0.3s;
}
.back-btn:hover{
    transform:translateX(-5px);
}

/* 🟡 HEADER */
.header{
    text-align:center;
    padding:10px 20px 30px;
}
.header h1{
    font-size:42px;
    color:#7c2d12;
}
.header p{
    font-size:18px;
    color:#475569;
    margin-top:10px;
}

/* 🔷 COLORS GRID */
.color-grid{
    max-width:1200px;
    margin:0 auto 50px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
    gap:30px;
}

/* COLOR CARD */
.color-card{
    border-radius:25px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
    text-align:center;
    padding:25px;
    cursor:pointer;
    transition:0.3s;
}
.color-card:hover{
    transform:scale(1.05) rotate(-2deg);
}
.color-box{
    width:100px;
    height:100px;
    margin:0 auto 15px;
    border-radius:20px;
    box-shadow:0 10px 20px rgba(0,0,0,0.2);
}
.color-card h3{
    font-size:24px;
    margin-bottom:8px;
    color:#1e293b;
}
.color-card p{
    font-size:16px;
    color:#475569;
}

/* FOOTER */
.footer{
    text-align:center;
    font-size:14px;
    color:#475569;
    margin-bottom:30px;
}
</style>
</head>

<body>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <div>
        <a href="kindergarten.php">Home</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- 🔙 BACK -->
<a href="lesson.php" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Back to Lessons
</a>

<!-- 🟡 HEADER -->
<div class="header">
    <h1>🎨 Explore Colors</h1>
    <p>Click on colors to learn fun examples</p>
</div>

<!-- 🔷 COLORS GRID -->
<div class="color-grid">

<?php
$colors = [
    ['name'=>'Red','code'=>'#ef4444','examples'=>'🍎 🍓 ❤️'],
    ['name'=>'Orange','code'=>'#f97316','examples'=>'🍊 🦊 🎃'],
    ['name'=>'Yellow','code'=>'#facc15','examples'=>'🌕 🍌 🌻'],
    ['name'=>'Green','code'=>'#22c55e','examples'=>'🌳 🥦 🐸'],
    ['name'=>'Blue','code'=>'#3b82f6','examples'=>'🌊 🟦 🦋'],
    ['name'=>'Purple','code'=>'#8b5cf6','examples'=>'🍆 👑 🪁'],
    ['name'=>'Pink','code'=>'#ec4899','examples'=>'🌸 🩷 🍬'],
    ['name'=>'Brown','code'=>'#a0522d','examples'=>'🍫 🐻 🪵'],
    ['name'=>'Black','code'=>'#000000','examples'=>'🖤 🐧 🎩'],
    ['name'=>'White','code'=>'#ffffff','examples'=>'❄️ 🐇 🕊️'],
];

foreach($colors as $c):
?>
<div class="color-card" onclick="alert('Examples: <?php echo $c['examples']; ?>');">
    <div class="color-box" style="background:<?php echo $c['code']; ?>"></div>
    <h3><?php echo $c['name']; ?></h3>
    <p>Examples: <?php echo $c['examples']; ?></p>
</div>
<?php endforeach; ?>

</div>

<div class="footer">
    🌈 Learning colors is fun with Unified Edu 🌈
</div>

</body>
</html>
