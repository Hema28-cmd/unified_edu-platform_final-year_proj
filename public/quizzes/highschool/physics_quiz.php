<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

$questions = [
    "Unit of Force?" => ["Newton", "Joule", "Watt", "Pascal"],
    "Speed formula?" => ["distance/time", "mass*acceleration", "force*time", "velocity*time"],
    "Acceleration due to gravity?" => ["9.8 m/s²", "10 m/s²", "9 m/s²", "8 m/s²"],
    "Ohm's Law?" => ["V = IR", "F = ma", "E = mc²", "P = VI"],
    "Energy formula?" => ["mgh", "mv²", "1/2mv²", "F*d"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Physics Quiz</title>
<style>
body { font-family: Arial; background:#d6eaf8; padding:20px; }
.container { max-width:600px; margin:auto; background:#fff; padding:25px; border-radius:15px; box-shadow:0 6px 20px rgba(0,0,0,0.1);}
h1 { text-align:center; color:#2980b9; }
.question { margin:15px 0; padding:15px; background:#aed6f1; border-left:5px solid #2980b9; border-radius:5px; }
.options label { display:block; margin:5px 0; }
button { display:block; margin:20px auto; padding:10px 20px; background:#2980b9; color:#fff; border:none; border-radius:8px; cursor:pointer; }
button:hover { background:#21618c; }
</style>
</head>
<body>
<div class="container">
<h1>Physics Quiz</h1>
<form action="submit_quiz.php" method="post">
<?php $i=1; foreach($questions as $q => $opts): ?>
<div class="question">
<strong>Q<?php echo $i; ?>. <?php echo $q; ?></strong>
<div class="options">
<?php foreach($opts as $opt): ?>
<label><input type="radio" name="q<?php echo $i; ?>" value="<?php echo $opt; ?>"> <?php echo $opt; ?></label>
<?php endforeach; ?>
</div>
</div>
<?php $i++; endforeach; ?>
<button type="submit" name="quiz" value="physics">Submit Quiz</button>
</form>
</div>
</body>
</html>
