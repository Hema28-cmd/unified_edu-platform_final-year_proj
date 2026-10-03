<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: ../login.php"); exit; }

$conn=new mysqli("localhost","root","","unified_edu");
if($conn->connect_error) die("DB Error");

$level=$_GET['level']??'';

$sql="SELECT * FROM quizzes WHERE level='$level' ORDER BY subject";
$res=$conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
<title><?= ucfirst($level) ?> Quizzes</title>
<style>
body{font-family:Poppins;background:#eef2ff;margin:0}
.header{background:#6366f1;color:white;padding:20px;position:relative}
.back{position:absolute;left:20px;top:20px;color:white;text-decoration:none}
.quiz{background:white;margin:20px;padding:18px;border-radius:14px}
</style>
</head>
<body>

<div class="header">
<a href="quizzes.php" class="back">⬅ Back</a>
<h2><?= ucfirst($level) ?> Quizzes</h2>
</div>

<?php if($res): while($q=$res->fetch_assoc()): ?>
<div class="quiz">
<b><?= htmlspecialchars($q['title']) ?></b><br>
Subject: <?= $q['subject'] ?><br>
Questions: <?= $q['total_questions'] ?>
</div>
<?php endwhile; endif; ?>

</body>
</html>
<?php $conn->close(); ?>
