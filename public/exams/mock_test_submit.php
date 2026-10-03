<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

// Correct answers
$answers = [
    'q1'=>'2x','q2'=>'(1/2)x² + C','q3'=>'Newton','q4'=>'3 × 10⁸ m/s',
    'q5'=>'H₂O','q6'=>'7','q7'=>'All of the above','q8'=>'Structured Query Language'
];

$user_answers = $_POST ?? [];
$score = 0;
foreach($answers as $q=>$ans){
    if(isset($user_answers[$q]) && $user_answers[$q] === $ans){
        $score++;
    }
}
$total_questions = count($answers);
$percentage = ($score/$total_questions)*100;
?>
<!DOCTYPE html>
<html>
<head>
<title>Mock Test Results</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#fef2f2;}
.header{background:#b91c1c;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:950px;margin:40px auto;padding:20px;}
.card{background:#fee2e2;padding:30px;border-radius:20px;margin-bottom:25px;box-shadow:0 12px 28px rgba(0,0,0,0.08);}
.card h2{color:#991b1b;margin-bottom:15px;}
.card p{color:#7f1d1d;line-height:1.6;}
.card .section-title{color:#7f1d1d;margin-top:15px;font-weight:bold;}
.correct{color:#059669;font-weight:bold;}
.wrong{color:#b91c1c;font-weight:bold;}
.actions{display:flex;justify-content:space-between;flex-wrap:wrap;margin-top:20px;}
.button{display:inline-block;padding:12px 28px;background:#b91c1c;color:#fff;text-decoration:none;border-radius:30px;transition:0.2s;margin-top:10px;}
.button:hover{background:#991b1b;}
</style>
</head>
<body>

<div class="header">
<h1>Mock Test Results</h1>
<p>Here’s your performance summary</p>
</div>

<div class="container">

<div class="card">
<h2>Overall Score</h2>
<p>You scored: <strong><?php echo $score; ?>/<?php echo $total_questions; ?></strong> (<?php echo round($percentage,2); ?>%)</p>
<p>
<?php
if($percentage>=80) echo "Excellent performance!";
elseif($percentage>=50) echo "Good effort!";
else echo "Needs improvement.";
?>
</p>
</div>

<div class="card">
<h2>Section-wise Review</h2>
<?php
foreach(['Mathematics'=>['q1','q2'],
         'Physics'=>['q3','q4'],
         'Chemistry'=>['q5','q6'],
         'Computer Science'=>['q7','q8']] as $section=>$qs){
    echo "<p class='section-title'>$section</p>";
    foreach($qs as $q){
        $ua = $user_answers[$q] ?? 'Not Answered';
        $status = ($ua === $answers[$q]) ? 'Correct' : 'Incorrect';
        $class = ($ua === $answers[$q]) ? 'correct' : 'wrong';
        echo "<p>$q: $ua - <span class='$class'>$status</span></p>";
    }
}
?>
</div>

<div class="card">
<h2>Tips for Improvement</h2>
<ul>
<li>Review incorrect answers and understand mistakes.</li>
<li>Practice weak sections more.</li>
<li>Time management is important.</li>
<li>Take multiple mock tests for improvement.</li>
</ul>
</div>

<div class="actions">
<a href="practice_exams.php" class="button">Back to Dashboard</a>
<a href="mock_test.php" class="button">Retake Mock Test</a>
</div>

</div>
</body>
</html>
