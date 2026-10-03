<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level']!=='secondary'){
    header("Location: ../../dashboard.php");
    exit;
}

$score = 0;
$submitted = false;

// Social questions
$questions = [
    ['q'=>'Who was the first President of the USA?', 'options'=>['George Washington','Abraham Lincoln','Thomas Jefferson'], 'answer'=>'George Washington'],
    ['q'=>'Which continent is Egypt in?', 'options'=>['Africa','Asia','Europe'], 'answer'=>'Africa'],
    ['q'=>'The Great Wall is located in which country?', 'options'=>['China','India','Russia'], 'answer'=>'China'],
    ['q'=>'Which is a fundamental right?', 'options'=>['Freedom of Speech','Pay Taxes','Drive Car'], 'answer'=>'Freedom of Speech']
];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $submitted = true;
    foreach($questions as $index=>$q){
        if(isset($_POST['q'.$index]) && $_POST['q'.$index]===$q['answer']){
            $score++;
        }
    }
}
$_SESSION['quiz_completed']['social'] = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Social Quiz</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:'Segoe UI', Tahoma, Geneva, Verdana,sans-serif; background: linear-gradient(135deg,#fce7f3,#fda4af); margin:0; padding:0;}
.container{max-width:900px;margin:30px auto;padding:20px;}
h2{text-align:center;color:#be185d;margin-bottom:30px;font-size:2.2em;text-shadow:1px 1px 2px #fff;}
.card{background:#ffffff; border-left:8px solid #ec4899; padding:20px; margin-bottom:20px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.15); transition: transform 0.3s ease, box-shadow 0.3s ease;}
.card:hover{transform: translateY(-8px); box-shadow:0 12px 30px rgba(0,0,0,0.2);}
.card h3{margin-bottom:15px;color:#be185d;font-size:1.2em;}
.options label{display:block;background:#fda4af;margin-bottom:10px;padding:12px 16px;border-radius:10px;cursor:pointer;transition:0.3s;font-weight:500;}
.options label:hover{background:#f472b6;}
button{display:block;margin:20px auto;padding:12px 25px;background:#ec4899;color:#fff;border:none;border-radius:12px;font-size:18px; cursor:pointer; transition:0.3s;}
button:hover{background:#be185d;}
.score-container{text-align:center;margin-top:40px;padding:30px;background:#fce7f3;border:5px solid #ec4899;border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.15); animation: fadeIn 1s ease-in-out;}
.score-container h2{color:#be185d;font-size:2em;}
.score-container p{font-size:1.5em; margin:15px 0; color:#831843;}
.back-link{text-align:center;margin-top:20px;}
.back-link a{text-decoration:none; color:#be185d;font-weight:bold;background:#fda4af;padding:10px 20px;border-radius:10px; transition:0.3s;}
.back-link a:hover{background:#ec4899;color:#fff;}
@keyframes fadeIn{0%{opacity:0;transform: translateY(-20px);}100%{opacity:1;transform: translateY(0);}}
</style>
</head>
<body>
<div class="container">
<h2>🌏 Social Quiz</h2>

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
    <p><?php echo ($score==count($questions)) ? "Excellent! 🌟" : "Good effort! Keep practicing!";?></p>
</div>
<div class="back-link">
    <a href="../secondary_quizzes.php"><i class="fa-solid fa-arrow-left"></i> Back to Quizzes</a>
</div>
<?php endif; ?>
</div>
</body>
</html>
