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
<title>Fun Rhymes | Unified Edu</title>
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
    background: linear-gradient(135deg,#fef9c3,#fce7f3,#dbeafe);
}

/* 🌈 NAVBAR */
.navbar{
    background: linear-gradient(90deg,#f97316,#6366f1,#ec4899);
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

/* 🔷 RHYMES GRID */
.rhymes-grid{
    max-width:1200px;
    margin:0 auto 50px;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
    gap:25px;
}

/* CARD */
.card{
    border-radius:25px;
    padding:20px;
    text-align:center;
    cursor:pointer;
    transition:0.3s;
    color:white;
    box-shadow:0 15px 35px rgba(0,0,0,0.2);
}
.card:hover{
    transform: scale(1.05);
}

/* Different gradient backgrounds for cards */
.card:nth-child(1){background:linear-gradient(135deg,#f87171,#fbbf24);}
.card:nth-child(2){background:linear-gradient(135deg,#34d399,#3b82f6);}
.card:nth-child(3){background:linear-gradient(135deg,#a78bfa,#f472b6);}
.card:nth-child(4){background:linear-gradient(135deg,#facc15,#f97316);}
.card:nth-child(5){background:linear-gradient(135deg,#22c55e,#14b8a6);}
.card:nth-child(6){background:linear-gradient(135deg,#fb7185,#f43f5e);}
.card:nth-child(7){background:linear-gradient(135deg,#60a5fa,#2563eb);}
.card:nth-child(8){background:linear-gradient(135deg,#34d399,#059669);}

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
.emoji{
    font-size:50px;
    margin-bottom:10px;
    transition:0.3s;
}

/* Animations */
.twinkle{ animation: twinkle 1s infinite alternate; }
@keyframes twinkle{
    from{ transform:scale(1); opacity:0.6;}
    to{ transform:scale(1.3); opacity:1;}
}

.bounce{ animation: bounce 0.6s infinite alternate; }
@keyframes bounce{
    from{ transform:translateY(0);}
    to{ transform:translateY(-15px);}
}

.fall{ animation: fall 1s ease; }
@keyframes fall{
    from{ transform:translateY(-100px);}
    to{ transform:translateY(0);}
}

.walk{ animation: walk 1s infinite alternate; }
@keyframes walk{
    from{ transform:translateX(-5px);}
    to{ transform:translateX(5px);}
}

.shake{ animation: shake 0.5s infinite; }
@keyframes shake{
    0%{ transform:rotate(0);}
    25%{ transform:rotate(5deg);}
    50%{ transform:rotate(-5deg);}
    100%{ transform:rotate(0);}
}

.pop{ animation: pop 0.4s ease; }
@keyframes pop{
    from{ transform:scale(0);}
    to{ transform:scale(1);}
}

.rain{ animation: rain 1s infinite linear; }
@keyframes rain{
    from{ transform:translateY(-10px);}
    to{ transform:translateY(10px);}
}

.spin{ animation: spin 1s linear infinite; }
@keyframes spin{
    from{ transform:rotate(0);}
    to{ transform:rotate(360deg);}
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
    <h1>🎵 Fun Rhymes</h1>
    <p>Click on a rhyme to learn and sing along!</p>
</div>

<!-- 🔷 RHYMES GRID -->
<div class="rhymes-grid">

<?php
$rhymes = [
    ['title'=>'Twinkle Twinkle Little Star','description'=>'A shining star in the sky!','emoji'=>'⭐','animation'=>'twinkle'],
    ['title'=>'Baa Baa Black Sheep','description'=>'A fluffy sheep giving wool!','emoji'=>'🐑','animation'=>'bounce'],
    ['title'=>'Humpty Dumpty','description'=>'An egg sitting on a wall!','emoji'=>'🥚','animation'=>'fall'],
    ['title'=>'Mary Had a Little Lamb','description'=>'A cute lamb follows Mary!','emoji'=>'🐑','animation'=>'walk'],
    ['title'=>'Old MacDonald Had a Farm','description'=>'Animals making sounds!','emoji'=>'🐄','animation'=>'shake'],
    ['title'=>'Johny Johny Yes Papa','description'=>'Sweet and funny rhyme!','emoji'=>'🍬','animation'=>'pop'],
    ['title'=>'Rain Rain Go Away','description'=>'Rain drops falling!','emoji'=>'🌧️','animation'=>'rain'],
    ['title'=>'Wheels on the Bus','description'=>'Bus wheels go round and round!','emoji'=>'🚌','animation'=>'spin']
];

foreach($rhymes as $r):
?>
<div class="card" onclick="playAnimation('<?php echo $r['animation']; ?>')">
    <div class="emoji"><?php echo $r['emoji']; ?></div>
<h3><?php echo $r['title']; ?></h3>
<p><?php echo $r['description']; ?></p>
</div>
<?php endforeach; ?>

</div>

<div class="footer">
    🎶 Singing rhymes is fun with Unified Edu! 🎶
</div>

<script>
function playAnimation(type){
    let emoji = event.currentTarget.querySelector('.emoji');

    emoji.classList.remove(
        'twinkle','bounce','fall','walk','shake','pop','rain','spin'
    );

    void emoji.offsetWidth; // reset animation

    emoji.classList.add(type);
}
</script>

</body>
</html>