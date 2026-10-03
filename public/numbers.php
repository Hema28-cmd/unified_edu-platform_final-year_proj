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
<title>Number Fun | Unified Edu</title>
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
    background: linear-gradient(135deg,#fce7f3,#dbeafe);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#22c55e,#3b82f6,#a855f7);
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
    background:linear-gradient(90deg,#f97316,#ef4444);
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

/* 🔢 HEADER */
.header{
    text-align:center;
    padding:10px 20px 30px;
}
.header h1{
    font-size:42px;
    color:#1e3a8a;
}
.header p{
    font-size:18px;
    color:#475569;
    margin-top:10px;
}

/* 🔢 NUMBER GRID */
.number-grid{
    max-width:1200px;
    margin:0 auto 40px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(160px,1fr));
    gap:30px;
}

/* 🎲 NUMBER CARD */
.num-card{
    background:white;
    border-radius:30px;
    padding:25px 15px;
    text-align:center;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
    transition:0.3s;
    cursor:pointer;
}
.num-card:hover{
    transform:translateY(-8px) scale(1.05);
}

/* NUMBER CIRCLE */
.num-circle{
    width:90px;
    height:90px;
    margin:0 auto 15px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:44px;
    font-weight:bold;
    color:white;
}

/* COLOR VARIANTS */
.bg1{background:#22c55e;}
.bg2{background:#3b82f6;}
.bg3{background:#f97316;}
.bg4{background:#ec4899;}
.bg5{background:#8b5cf6;}
.bg6{background:#eab308; color:#1e293b;}

.num-card h3{
    font-size:22px;
    color:#1e293b;
}
.num-card p{
    font-size:15px;
    color:#64748b;
    margin-top:6px;
}

/* EMOJI COUNT */
.emoji{
    font-size:24px;
    margin-top:10px;
}

/* FOOTER */
.footer{
    text-align:center;
    margin-bottom:30px;
    font-size:14px;
    color:#475569;
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

<!-- 🔢 HEADER -->
<div class="header">
    <h1>🔢 Number Fun</h1>
    <p>Learn numbers by counting fun objects</p>
</div>

<!-- 🔢 NUMBERS -->
<div class="number-grid">

<?php
$numbers = [
    1 => "🍎",
    2 => "🐟",
    3 => "⭐",
    4 => "🍌",
    5 => "🚗",
    6 => "⚽",
    7 => "🦋",
    8 => "🍓",
    9 => "🐘",
    10 => "🎈"
];

$colors = ['bg1','bg2','bg3','bg4','bg5','bg6'];
$i = 0;

foreach($numbers as $num => $emoji):
    $color = $colors[$i % count($colors)];
?>
    <div class="num-card">
        <div class="num-circle <?php echo $color; ?>">
            <?php echo $num; ?>
        </div>
        <h3>Number <?php echo $num; ?></h3>
        <p>Count the objects</p>
        <div class="emoji">
            <?php echo str_repeat($emoji . " ", $num); ?>
        </div>
    </div>
<?php
$i++;
endforeach;
?>

</div>

<div class="footer">
    🌈 Counting is fun with Unified Edu 🌈
</div>

</body>
</html>
