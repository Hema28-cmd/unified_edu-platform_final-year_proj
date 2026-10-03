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
<title>Alphabet World | Unified Edu</title>
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
    background: linear-gradient(135deg,#fde68a,#bfdbfe);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#f97316,#ec4899,#6366f1);
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
    background:linear-gradient(90deg,#22c55e,#16a34a);
    color:white;
    text-decoration:none;
    border-radius:25px;
    font-weight:bold;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    transition:0.3s;
}
.back-btn i{
    margin-right:8px;
}
.back-btn:hover{
    transform:translateX(-5px);
    background:linear-gradient(90deg,#16a34a,#15803d);
}

/* 📘 HEADER */
.header{
    text-align:center;
    padding:20px 20px 40px;
}
.header h1{
    font-size:40px;
    color:#1e3a8a;
}
.header p{
    font-size:18px;
    color:#475569;
    margin-top:10px;
}

/* 🔤 ALPHABET GRID */
.alphabet-container{
    max-width:1200px;
    margin:0 auto 50px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(140px,1fr));
    gap:25px;
}

/* 🧸 CARD */
.card{
    background:white;
    border-radius:25px;
    padding:25px 15px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
    transition:0.3s;
    cursor:pointer;
}
.card:hover{
    transform: translateY(-6px) scale(1.05);
}

/* LETTER CIRCLE */
.letter{
    width:80px;
    height:80px;
    margin:0 auto 10px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:42px;
    font-weight:bold;
    color:white;
}

/* COLORS */
.c1{ background:#f97316; }
.c2{ background:#22c55e; }
.c3{ background:#6366f1; }
.c4{ background:#ec4899; }
.c5{ background:#0ea5e9; }
.c6{ background:#facc15; color:#1e293b; }

.card h3{
    font-size:20px;
    color:#1e293b;
}
.card p{
    font-size:14px;
    color:#64748b;
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

<!-- 🔙 BACK BUTTON -->
<a href="lesson.php" class="back-btn">
    <i class="fa-solid fa-arrow-left"></i> Back to Lessons
</a>

<!-- 📘 HEADER -->
<div class="header">
    <h1>🔤 Alphabet World</h1>
    <p>Tap a letter and learn with fun examples</p>
</div>

<!-- 🔤 ALPHABET CARDS -->
<div class="alphabet-container">

<?php
$letters = range('A','Z');
$examples = [
    'A'=>'Apple','B'=>'Ball','C'=>'Cat','D'=>'Dog','E'=>'Elephant',
    'F'=>'Fish','G'=>'Grapes','H'=>'Hat','I'=>'Ice Cream','J'=>'Jug',
    'K'=>'Kite','L'=>'Lion','M'=>'Monkey','N'=>'Nest','O'=>'Orange',
    'P'=>'Parrot','Q'=>'Queen','R'=>'Rabbit','S'=>'Sun','T'=>'Tiger',
    'U'=>'Umbrella','V'=>'Van','W'=>'Watch','X'=>'Xylophone',
    'Y'=>'Yak','Z'=>'Zebra'
];

$colors = ['c1','c2','c3','c4','c5','c6'];
$i = 0;

foreach($letters as $letter):
    $color = $colors[$i % count($colors)];
?>
    <div class="card">
        <div class="letter <?php echo $color; ?>">
            <?php echo $letter; ?>
        </div>
        <h3><?php echo $letter; ?> for</h3>
        <p><?php echo $examples[$letter]; ?></p>
    </div>
<?php
$i++;
endforeach;
?>

</div>

<div class="footer">
    🌟 Learn • Play • Grow with Unified Edu 🌟
</div>

</body>
</html>
