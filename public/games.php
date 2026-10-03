<?php
session_start();

// Only kindergarten/primary students allowed
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_level'], ['kindergarten','primary'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Fun Games | Unified Edu</title>
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
    background: linear-gradient(135deg,#ffedd5,#e0f7fa,#dbeafe);
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

/* 🔙 BACK BUTTON */
.back-btn{
    display:inline-block;
    margin:20px 30px;
    padding:10px 22px;
    background:linear-gradient(90deg,#6366f1,#ec4899);
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

/* 🔷 GAMES GRID */
.games-grid{
    max-width:1200px;
    margin:0 auto 50px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* 🎴 CARD */
.card{
    border-radius:25px;
    padding:25px 20px;
    text-align:center;
    cursor:pointer;
    transition:0.3s;
    color:white;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
}
.card:hover{
    transform: scale(1.06);
}

/* Gradient backgrounds */
.card:nth-child(1){background:linear-gradient(135deg,#f87171,#fb7185);}
.card:nth-child(2){background:linear-gradient(135deg,#34d399,#3b82f6);}
.card:nth-child(3){background:linear-gradient(135deg,#a78bfa,#f472b6);}
.card:nth-child(4){background:linear-gradient(135deg,#facc15,#f97316);}
.card:nth-child(5){background:linear-gradient(135deg,#22c55e,#14b8a6);}
.card:nth-child(6){background:linear-gradient(135deg,#ec4899,#8b5cf6);}

.card i{
    margin-bottom:12px;
}

.card h3{
    font-size:24px;
    margin-bottom:10px;
}
.card p{
    font-size:16px;
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
        <a href="../logout.php">Logout</a>
    </div>
</div>

<!-- 🔙 BACK -->
<a href="kindergarten.php" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Back to Lessons
</a>

<!-- 🟡 HEADER -->
<div class="header">
    <h1>🎮 Fun Games</h1>
    <p>Play, learn, and grow smarter every day!</p>
</div>

<!-- 🔷 GAMES GRID -->
<div class="games-grid">

<?php
$games = [
    [
        'title'=>'Alphabet Puzzle',
        'description'=>'Drag and match letters to complete words.',
        'link'=>'alphabet_game.php',
        'icon'=>'fa-a'
    ],
    [
        'title'=>'Number Counting',
        'description'=>'Count objects and match numbers.',
        'link'=>'numbers_game.php',
        'icon'=>'fa-1'
    ],
    [
        'title'=>'Color Match',
        'description'=>'Match colors with fun challenges.',
        'link'=>'colors_game.php',
        'icon'=>'fa-palette'
    ],
    [
        'title'=>'Shape Builder',
        'description'=>'Build shapes and learn geometry basics.',
        'link'=>'shapes_game.php',
        'icon'=>'fa-square'
    ],
    [
        'title'=>'Memory Cards',
        'description'=>'Flip cards and boost your memory power.',
        'link'=>'memory_game.php',
        'icon'=>'fa-clone'
    ],
    [
        'title'=>'Drawing & Coloring Fun',
        'description'=>'Draw, color, and show your creativity.',
        'link'=>'drawing_game.php',
        'icon'=>'fa-paint-brush'
    ],
];

foreach($games as $g):
?>
<div class="card" onclick="window.location.href='<?php echo $g['link']; ?>';">
    <i class="fa-solid <?php echo $g['icon']; ?> fa-2x"></i>
    <h3><?php echo $g['title']; ?></h3>
    <p><?php echo $g['description']; ?></p>
</div>
<?php endforeach; ?>

</div>

<div class="footer">
    🌟 Keep learning & having fun with Unified Edu 🌟
</div>

</body>
</html>
