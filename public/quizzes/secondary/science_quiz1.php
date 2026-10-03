<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level']!=='secondary'){
    header("Location: ../../dashboard.php");
    exit;
}

$score = 0;
$submitted = false;

// Science questions
$questions = [
    ['q'=>'Water boils at ___ degrees Celsius.', 'options'=>['90','100','120'], 'answer'=>'100'],
    ['q'=>'Which planet is known as the Red Planet?', 'options'=>['Mars','Venus','Jupiter'], 'answer'=>'Mars'],
    ['q'=>'The process of plants making food is called?', 'options'=>['Respiration','Photosynthesis','Digestion'], 'answer'=>'Photosynthesis'],
    ['q'=>'Which gas do humans inhale?', 'options'=>['Oxygen','Carbon Dioxide','Nitrogen'], 'answer'=>'Oxygen']
];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $submitted = true;
    foreach($questions as $index=>$q){
        if(isset($_POST['q'.$index]) && $_POST['q'.$index]===$q['answer']){
            $score++;
        }
    }
}
$_SESSION['quiz_completed']['science'] = true;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Science Quiz</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:'Segoe UI', Tahoma, Geneva, Verdana,sans-serif; background: linear-gradient(135deg,#d1fae5,#6ee7b7); margin:0; padding:0;}
.container{max-width:900px;margin:30px auto;padding:20px;}
h2{text-align:center;color:#047857;margin-bottom:30px;font-size:2.2em;text-shadow:1px 1px 2px #fff;}
.card{background:#ffffff; border-left:8px solid #10b981; padding:20px; margin-bottom:20px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.15); transition: transform 0.3s ease, box-shadow 0.3s ease;}
.card:hover{transform: translateY(-8px); box-shadow:0 12px 30px rgba(0,0,0,0.2);}
.card h3{margin-bottom:15px;color:#065f46;font-size:1.2em;}
.options label{display:block;background:#a7f3d0;margin-bottom:10px;padding:12px 16px;border-radius:10px;cursor:pointer;transition:0.3s;font-weight:500;}
.options label:hover{background:#6ee7b7;}
button{display:block;margin:20px auto;padding:12px 25px;background:#10b981;color:#fff;border:none;border-radius:12px;font-size:18px; cursor:pointer; transition:0.3s;}
button:hover{background:#047857;}
.score-container{text-align:center;margin-top:40px;padding:30px;background:#d1fae5;border:5px solid #10b981;border-radius:15px;box-shadow:0 8px 25px rgba(0,0,0,0.15); animation: fadeIn 1s ease-in-out;}
.score-container h2{color:#065f46;font-size:2em;}
.score-container p{font-size:1.5em; margin:15px 0; color:#065f46;}
.back-link{text-align:center;margin-top:20px;}
.back-link a{text-decoration:none; color:#047857;font-weight:bold;background:#a7f3d0;padding:10px 20px;border-radius:10px; transition:0.3s;}
.back-link a:hover{background:#10b981;color:#fff;}
@keyframes fadeIn{0%{opacity:0;transform: translateY(-20px);}100%{opacity:1;transform: translateY(0);}}
</style>
</head>
<body>
<div class="container">
<h2>🧪 Science Quiz</h2>

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
