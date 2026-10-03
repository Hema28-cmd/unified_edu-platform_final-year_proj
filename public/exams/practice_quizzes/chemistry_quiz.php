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
<title>Chemistry Important Questions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#f0fdf4;}
.header{background:#16a34a;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:950px;margin:40px auto;}
.card{background:#ffffff;padding:30px;border-radius:20px;margin-bottom:25px;box-shadow:0 12px 28px rgba(0,0,0,0.08);transition:0.3s;}
.card:hover{transform:translateY(-5px);box-shadow:0 18px 35px rgba(0,0,0,0.12);}
.card h3{color:#047857;margin-bottom:12px;}
.card p{color:#374151;line-height:1.6;}
.back{display:inline-block;margin-top:20px;padding:12px 28px;background:#16a34a;color:#fff;border-radius:30px;text-decoration:none;transition:0.2s;}
.back:hover{background:#15803d;}
</style>
</head>
<body>

<div class="header">
<h1>Chemistry Important Questions</h1>
<p>Focus on key concepts, reactions, and equations</p>
</div>

<div class="container">

<div class="card">
<h3>1. Chemical formula of water?</h3>
<p>Answer: H₂O</p>
</div>

<div class="card">
<h3>2. pH value of neutral solution?</h3>
<p>Answer: 7</p>
</div>

<div class="card">
<h3>3. Atomic number of Oxygen?</h3>
<p>Answer: 8</p>
</div>

<div class="card">
<h3>4. Chemical formula of Carbon Dioxide?</h3>
<p>Answer: CO₂</p>
</div>

<div class="card">
<h3>5. Reaction type: HCl + NaOH → NaCl + H₂O?</h3>
<p>Answer: Neutralization</p>
</div>

<div class="card">
<h3>6. Electron configuration of Sodium (Na)?</h3>
<p>Answer: 1s² 2s² 2p⁶ 3s¹</p>
</div>

<div class="card">
<h3>7. Common name of NaHCO₃?</h3>
<p>Answer: Baking Soda</p>
</div>

<a href="../practice_subjects.php" class="back">Back</a>

</div>

</body>
</html>
