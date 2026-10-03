<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

$conn = new mysqli("localhost","root","","unified_edu");

if ($conn->connect_error) {
    die("Database connection failed");
}

if(!isset($_GET['id'])){
    echo "Quiz not found";
    exit;
}

$quiz_id = (int)$_GET['id'];

/* GET QUIZ INFO FROM BOTH TABLES */

$stmt = $conn->prepare("
SELECT id,title,level FROM quizzes WHERE id=?
UNION
SELECT id,title,level FROM quizzes1 WHERE id=?
");

$stmt->bind_param("ii",$quiz_id,$quiz_id);
$stmt->execute();

$result = $stmt->get_result();
$quiz = $result->fetch_assoc();
$stmt->close();

if(!$quiz){
    echo "Quiz not found";
    exit;
}

/* GET QUESTIONS */

$stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
$stmt->bind_param("i",$quiz_id);
$stmt->execute();
$questions = $stmt->get_result();

$total_questions = $questions->num_rows;

?>

<!DOCTYPE html>
<html>
<head>

<title>View Quiz</title>

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(120deg,#eef2ff,#ecfeff);
}

/* HEADER */

.header{
background:linear-gradient(90deg,#6366f1,#06b6d4);
padding:30px;
color:white;
display:flex;
justify-content:space-between;
align-items:center;
}

.header h1{
margin:0;
font-size:28px;
}

.back{
background:white;
color:#4f46e5;
padding:10px 16px;
border-radius:20px;
text-decoration:none;
font-weight:bold;
}

/* CONTAINER */

.container{
max-width:1000px;
margin:auto;
padding:30px;
}

/* QUIZ INFO CARD */

.quiz-info{
background:white;
padding:25px;
border-radius:18px;
box-shadow:0 15px 35px rgba(0,0,0,0.12);
margin-bottom:25px;
}

.quiz-title{
font-size:26px;
font-weight:bold;
color:#4338ca;
margin-bottom:8px;
}

.meta{
display:flex;
gap:25px;
margin-top:10px;
color:#475569;
font-weight:500;
}

/* QUESTIONS */

.question-card{
background:white;
border-radius:16px;
padding:22px;
margin-bottom:20px;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
transition:0.3s;
}

.question-card:hover{
transform:translateY(-3px);
}

.question-title{
font-size:18px;
font-weight:600;
margin-bottom:12px;
color:#1e293b;
}

/* OPTIONS */

.option{
padding:10px 12px;
border-radius:10px;
margin:6px 0;
background:#f8fafc;
border:1px solid #e2e8f0;
}

.correct{
background:#dcfce7;
border:1px solid #22c55e;
color:#166534;
font-weight:bold;
}

/* QUESTION NUMBER */

.q-number{
background:#6366f1;
color:white;
padding:4px 10px;
border-radius:8px;
margin-right:8px;
font-size:13px;
}

</style>

</head>

<body>

<div class="header">

<h1>Quiz Details</h1>

<a class="back" href="quizzes.php">← Back to Quizzes</a>

</div>

<div class="container">

<div class="quiz-info">

<div class="quiz-title">
<?= htmlspecialchars($quiz['title'] ?? '') ?>
</div>

<div class="meta">
<div><b>Level:</b> <?= ucfirst($quiz['level'] ?? '') ?></div>
<div><b>Total Questions:</b> <?= $total_questions ?></div>
</div>

</div>

<?php
$no = 1;
$questions->data_seek(0);

while($q = $questions->fetch_assoc()):
?>

<div class="question-card">

<div class="question-title">
<span class="q-number">Q<?= $no++ ?></span>
<?= htmlspecialchars($q['question']) ?>
</div>

<div class="option <?= $q['correct_option']==1 ? 'correct' : '' ?>">
1. <?= htmlspecialchars($q['option1']) ?>
</div>

<div class="option <?= $q['correct_option']==2 ? 'correct' : '' ?>">
2. <?= htmlspecialchars($q['option2']) ?>
</div>

<div class="option <?= $q['correct_option']==3 ? 'correct' : '' ?>">
3. <?= htmlspecialchars($q['option3']) ?>
</div>

<div class="option <?= $q['correct_option']==4 ? 'correct' : '' ?>">
4. <?= htmlspecialchars($q['option4']) ?>
</div>

</div>

<?php endwhile; ?>

</div>

</body>
</html>