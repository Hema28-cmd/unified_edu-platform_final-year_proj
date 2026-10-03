<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Physics Important Questions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#fdf6f0;}
.header{background:#f97316;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:950px;margin:40px auto;}
.card{background:#fff4e6;padding:30px;border-radius:20px;margin-bottom:30px;box-shadow:0 15px 30px rgba(0,0,0,0.08);transition:0.3s;}
.card:hover{transform:translateY(-5px);box-shadow:0 20px 35px rgba(0,0,0,0.12);}
.card h3{color:#b45309;margin-bottom:15px;}
.card p{color:#374151;line-height:1.6;}
.back{display:inline-block;margin-top:20px;padding:12px 28px;background:#f97316;color:#fff;border-radius:30px;text-decoration:none;transition:0.2s;}
.back:hover{background:#ea580c;}
</style>
</head>
<body>

<div class="header">
<h1>Physics Important Questions</h1>
<p>Focus on essential conceptual and numerical questions</p>
</div>

<div class="container">

<div class="card">
<h3>1. SI unit of Force?</h3>
<p>Answer: Newton</p>
</div>

<div class="card">
<h3>2. Speed of light in vacuum?</h3>
<p>Answer: 3 × 10⁸ m/s</p>
</div>

<div class="card">
<h3>3. Newton’s second law of motion?</h3>
<p>Answer: F = ma (Force equals mass × acceleration)</p>
</div>

<div class="card">
<h3>4. Formula for gravitational potential energy?</h3>
<p>Answer: U = mgh</p>
</div>

<div class="card">
<h3>5. What is the value of acceleration due to gravity on Earth?</h3>
<p>Answer: g ≈ 9.8 m/s²</p>
</div>

<div class="card">
<h3>6. What is Ohm’s law?</h3>
<p>Answer: V = IR (Voltage = Current × Resistance)</p>
</div>

<div class="card">
<h3>7. Unit of electric charge?</h3>
<p>Answer: Coulomb (C)</p>
</div>

<a href="../practice_subjects.php" class="back">Back</a>

</div>

</body>
</html>
