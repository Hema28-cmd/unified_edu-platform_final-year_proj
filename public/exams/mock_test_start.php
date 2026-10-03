<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

// Total test time in minutes
$total_time = 60;
?>
<!DOCTYPE html>
<html>
<head>
<title>Mock Test Start</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI';background:#fef9f0;}
.header{background:#d97706;color:#fff;padding:50px;text-align:center;}
.header h1{margin:0;font-size:2.5em;}
.header p{margin-top:10px;font-size:1.1em;}
.container{max-width:950px;margin:40px auto;padding:20px;}
.card{background:#fff7ed;padding:30px;border-radius:20px;margin-bottom:25px;box-shadow:0 12px 28px rgba(0,0,0,0.08);}
.card h2{color:#b45309;margin-bottom:15px;}
.card p{color:#4b5563;line-height:1.6;}
.timer{font-size:1.3em;color:#b45309;font-weight:bold;text-align:right;margin-bottom:15px;}
.question{margin-bottom:25px;}
.question h3{color:#92400e;}
.question label{display:block;margin:6px 0;color:#374151;}
.actions{display:flex;justify-content:space-between;flex-wrap:wrap;margin-top:20px;}
.button{display:inline-block;padding:12px 28px;background:#d97706;color:#fff;text-decoration:none;border-radius:30px;transition:0.2s;margin-top:10px;}
.button:hover{background:#b45309;}
</style>
<script>
let totalTime = <?php echo $total_time * 60; ?>;
function startTimer() {
    const timerDisplay = document.getElementById('timer');
    const timer = setInterval(() => {
        let minutes = Math.floor(totalTime / 60);
        let seconds = totalTime % 60;
        timerDisplay.textContent = `Time Remaining: ${minutes}m ${seconds}s`;
        totalTime--;
        if(totalTime < 0) {
            clearInterval(timer);
            alert("Time is up! Submitting your test.");
            document.getElementById('mockTestForm').submit();
        }
    }, 1000);
}
window.onload = startTimer;
</script>
</head>
<body>

<div class="header">
<h1>Mock Test</h1>
<p>Attempt the test within the allotted time</p>
</div>

<div class="container">
<div class="timer" id="timer"></div>

<form id="mockTestForm" method="post" action="mock_test_submit.php">

<!-- Mathematics -->
<div class="card question">
<h2>Section 1: Mathematics</h2>
<h3>1. Derivative of x²?</h3>
<label><input type="radio" name="q1" value="2x"> 2x</label>
<label><input type="radio" name="q1" value="x"> x</label>
<label><input type="radio" name="q1" value="x²"> x²</label>
<label><input type="radio" name="q1" value="1"> 1</label>

<h3>2. ∫x dx = ?</h3>
<label><input type="radio" name="q2" value="x² + C"> x² + C</label>
<label><input type="radio" name="q2" value="(1/2)x² + C"> (1/2)x² + C</label>
<label><input type="radio" name="q2" value="ln(x) + C"> ln(x) + C</label>
<label><input type="radio" name="q2" value="1/x + C"> 1/x + C</label>
</div>

<!-- Physics -->
<div class="card question">
<h2>Section 2: Physics</h2>
<h3>3. SI unit of Force?</h3>
<label><input type="radio" name="q3" value="Joule"> Joule</label>
<label><input type="radio" name="q3" value="Newton"> Newton</label>
<label><input type="radio" name="q3" value="Watt"> Watt</label>
<label><input type="radio" name="q3" value="Pascal"> Pascal</label>

<h3>4. Speed of light in vacuum?</h3>
<label><input type="radio" name="q4" value="3 × 10⁸ m/s"> 3 × 10⁸ m/s</label>
<label><input type="radio" name="q4" value="3 × 10⁶ m/s"> 3 × 10⁶ m/s</label>
<label><input type="radio" name="q4" value="1.5 × 10⁸ m/s"> 1.5 × 10⁸ m/s</label>
<label><input type="radio" name="q4" value="3 × 10⁷ m/s"> 3 × 10⁷ m/s</label>
</div>

<!-- Chemistry -->
<div class="card question">
<h2>Section 3: Chemistry</h2>
<h3>5. Chemical formula of water?</h3>
<label><input type="radio" name="q5" value="H₂O"> H₂O</label>
<label><input type="radio" name="q5" value="CO₂"> CO₂</label>
<label><input type="radio" name="q5" value="O₂"> O₂</label>
<label><input type="radio" name="q5" value="H₂"> H₂</label>

<h3>6. pH of neutral solution?</h3>
<label><input type="radio" name="q6" value="7"> 7</label>
<label><input type="radio" name="q6" value="1"> 1</label>
<label><input type="radio" name="q6" value="14"> 14</label>
<label><input type="radio" name="q6" value="0"> 0</label>
</div>

<!-- Computer Science -->
<div class="card question">
<h2>Section 4: Computer Science</h2>
<h3>7. Language used for web development?</h3>
<label><input type="radio" name="q7" value="HTML"> HTML</label>
<label><input type="radio" name="q7" value="Python"> Python</label>
<label><input type="radio" name="q7" value="JavaScript"> JavaScript</label>
<label><input type="radio" name="q7" value="All of the above"> All of the above</label>

<h3>8. SQL stands for?</h3>
<label><input type="radio" name="q8" value="Structured Query Language"> Structured Query Language</label>
<label><input type="radio" name="q8" value="Simple Query Language"> Simple Query Language</label>
<label><input type="radio" name="q8" value="System Query Language"> System Query Language</label>
<label><input type="radio" name="q8" value="Sequential Query Logic"> Sequential Query Logic</label>
</div>

<div class="actions">
<button type="submit" class="button">Submit Test</button>
<a href="practice_exams.php" class="button">Back</a>
</div>

</form>
</div>

</body>
</html>
