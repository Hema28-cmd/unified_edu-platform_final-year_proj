<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level']!=='secondary'){
    header("Location: ../../dashboard.php");
    exit;
}

$score = 0;
$submitted = false;

// Math questions
$questions = [
    ['q'=>'2 + 2 = ?', 'options'=>['3','4','5'], 'answer'=>'4'],
    ['q'=>'3² = ?', 'options'=>['6','9','12'], 'answer'=>'9'],
    ['q'=>'4² = ?', 'options'=>['12','16','18'], 'answer'=>'16'],
    ['q'=>'10 ÷ 2 = ?', 'options'=>['2','5','8'], 'answer'=>'5']
];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $submitted = true;
    foreach($questions as $index=>$q){
        if(isset($_POST['q'.$index]) && $_POST['q'.$index]===$q['answer']){
            $score++;
        }
    }
    // ✅ Mark math quiz completed
    $_SESSION['quiz_completed']['math'] = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Math Quiz</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
    font-family:'Segoe UI', Tahoma, Geneva, Verdana,sans-serif;
    background: linear-gradient(135deg,#dbeafe,#93c5fd);
    margin:0;
    padding:0;
}
.container{
    max-width:900px;
    margin:30px auto;
    padding:20px;
}
h2{
    text-align:center;
    color:#1e3a8a;
    margin-bottom:30px;
    font-size:2.2em;
    text-shadow:1px 1px 2px #fff;
}
.card{
    background:#ffffff;
    border-left:8px solid #2563eb;
    padding:20px;
    margin-bottom:20px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover{
    transform: translateY(-8px);
    box-shadow:0 12px 30px rgba(0,0,0,0.2);
}
.card h3{
    margin-bottom:15px;
    color:#1e40af;
    font-size:1.2em;
}
.options label{
    display:block;
    background:#dbeafe;
    margin-bottom:10px;
    padding:12px 16px;
    border-radius:10px;
    cursor:pointer;
    transition:0.3s;
    font-weight:500;
}
.options label:hover{
    background:#bfdbfe;
}
button{
    display:block;
    margin:20px auto;
    padding:12px 25px;
    background:#2563eb;
    color:#fff;
    border:none;
    border-radius:12px;
    font-size:18px;
    cursor:pointer;
    transition:0.3s;
}
button:hover{
    background:#1e40af;
}
.score-container{
    text-align:center;
    margin-top:40px;
    padding:30px;
    background:#eff6ff;
    border:5px solid #60a5fa;
    border-radius:15px;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
    animation: fadeIn 1s ease-in-out;
}
.score-container h2{
    color:#1e3a8a;
    font-size:2em;
}
.score-container p{
    font-size:1.5em;
    margin:15px 0;
    color:#1e40af;
}
.back-link{
    text-align:center;
    margin-top:20px;
}
.back-link a{
    text-decoration:none;
    color:#1e40af;
    font-weight:bold;
    background:#bfdbfe;
    padding:10px 20px;
    border-radius:10px;
    transition:0.3s;
}
.back-link a:hover{
    background:#2563eb;
    color:#fff;
}
@keyframes fadeIn{
    0%{opacity:0;transform: translateY(-20px);}
    100%{opacity:1;transform: translateY(0);}
}
</style>
</head>

<body>
<div class="container">

<h2>➕ Math Quiz</h2>

<?php if(!$submitted): ?>
<form method="POST">
    <?php foreach($questions as $index=>$q): ?>
    <div class="card">
        <h3>Q<?php echo $index+1;?>. <?php echo $q['q'];?></h3>
        <div class="options">
            <?php foreach($q['options'] as $opt): ?>
            <label>
                <input type="radio" name="q<?php echo $index;?>" value="<?php echo $opt;?>" required>
                <?php echo $opt;?>
            </label>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>
    <button type="submit"><i class="fa-solid fa-paper-plane"></i> Submit Quiz</button>
</form>

<?php else: ?>
<div class="score-container">
    <h2>🎉 Quiz Completed!</h2>
    <p>Your score: <?php echo $score;?> / <?php echo count($questions);?></p>
    <p><?php echo ($score==count($questions)) ? "Outstanding! 🔢✨" : "Good try! Practice more 💪";?></p>
</div>
<div class="back-link">
    <a href="../secondary_quizzes.php"><i class="fa-solid fa-arrow-left"></i> Back to Quizzes</a>
</div>
<?php endif; ?>

</div>
</body>
</html>
