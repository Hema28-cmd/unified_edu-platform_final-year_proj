<?php
session_start();
require_once "../config/db.php";

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];

/* FETCH TEACHER QUIZZES */
$stmt = $conn->prepare("SELECT * FROM quizzes1 WHERE created_by=? ORDER BY created_at DESC");
$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$quiz_result = $stmt->get_result();

$teacher_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Quizzes | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#eef2ff,#f8fafc);
    color:#1e293b;
    padding:24px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 32px;
    background:linear-gradient(90deg,#312e81,#0f172a);
    border-radius:14px;
    box-shadow:0 10px 30px rgba(0,0,0,0.25);
}
.navbar h2{
    font-family:'Libre Baskerville', serif;
    font-size:22px;
    color:#e0e7ff;
}
.navbar a{
    color:#c7d2fe;
    text-decoration:none;
    margin-left:20px;
    font-size:14px;
}
.navbar a:hover{color:#ffffff;}

/* BACK BUTTON */
.back{
    margin:20px 0 30px;
}
.back a{
    display:inline-block;
    padding:10px 24px;
    background:#475569;
    color:#fff;
    border-radius:24px;
    text-decoration:none;
    font-size:14px;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:32px;
    border-radius:24px;
    box-shadow:0 12px 28px rgba(0,0,0,0.12);
    margin-bottom:40px;
}
.header h1{
    font-family:'Libre Baskerville', serif;
    font-size:28px;
    color:#312e81;
    font-weight:700;
}
.header p{
    margin-top:10px;
    font-size:15px;
    color:#475569;
    line-height:1.6;
}

/* QUIZ FLOW */
.quiz-flow{
    display:grid;
    grid-template-columns:1fr;
    gap:40px;
}

/* SUBJECT BLOCK */
.subject{
    display:grid;
    grid-template-columns:260px 1fr;
    gap:30px;
    background:#ffffff;
    border-radius:26px;
    padding:28px;
    box-shadow:0 12px 30px rgba(0,0,0,0.12);
}

/* LEFT INFO */
.subject-info{
    border-right:2px dashed #e5e7eb;
    padding-right:20px;
}
.subject-info h2{
    font-size:22px;
    font-weight:600;
    color:#0f172a;
}
.subject-info p{
    margin-top:10px;
    font-size:14px;
    color:#64748b;
}

/* RIGHT QUIZ */
.quiz-content h3{
    font-size:18px;
    font-weight:500;
    color:#1e40af;
    margin-bottom:8px;
}
.quiz-content ul{
    padding-left:18px;
    font-size:14px;
    color:#334155;
    margin-bottom:12px;
}

/* SAMPLE QUESTIONS */
.sample{
    background:#f1f5f9;
    padding:16px;
    border-radius:16px;
}
.sample strong{
    color:#1e40af;
    font-size:14px;
}
.sample li{
    font-size:13px;
    margin-top:6px;
}

/* TIPS */
.tips{
    margin-top:40px;
    background:linear-gradient(135deg,#e0f2fe,#bae6fd);
    padding:28px;
    border-radius:26px;
    box-shadow:0 12px 28px rgba(0,0,0,0.15);
}
.tips h3{
    font-size:20px;
    font-weight:600;
    color:#075985;
}
.tips p{
    margin-top:10px;
    font-size:14px;
    line-height:1.7;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Secondary Quizzes</h2>
    <div>
        <a href="secondary_lessons.php">Lessons</a>
        <a href="secondary_books.php">Books</a>
        <a href="secondary_quizzes.php">Quizzes</a>
        <a href="secondary_assignments.php">Assignments</a>
        <a href="secondary_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK -->
<div class="back">
    <a href="secondary.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Quiz Framework</h1>
    <p>
        This module provides structured quizzes aligned with the secondary syllabus.
        Each quiz focuses on conceptual clarity, application-based learning, and
        analytical thinking to prepare students for examinations.
    </p>
<br><br>

<button id="openQuizPopup" style="padding:10px 20px;border:none;border-radius:8px;background:#312e81;color:white;cursor:pointer;font-weight:500;">
➕ Add New Quiz
</button>
</div>

<!-- QUIZ FLOW -->
<div class="quiz-flow">

<!-- MATH -->
<div class="subject">
    <div class="subject-info">
        <h2>📐 Mathematics</h2>
        <p>Tests numerical ability, logical reasoning, and problem-solving skills.</p>
    </div>
    <div class="quiz-content">
        <h3>Core Areas</h3>
        <ul>
            <li>Algebra & Linear Equations</li>
            <li>Geometry & Mensuration</li>
            <li>Statistics & Probability</li>
        </ul>
        <div class="sample">
            <strong>Sample Questions:</strong>
            <ul>
                <li>Solve: 3x − 7 = 11</li>
                <li>Find the area of a circle with radius 7 cm</li>
                <li>What is the mean of 2, 4, 6, 8?</li>
            </ul>
        </div>
    </div>
</div>

<!-- SCIENCE -->
<div class="subject">
    <div class="subject-info">
        <h2>🔬 Science</h2>
        <p>Evaluates scientific understanding and real-life application.</p>
    </div>
    <div class="quiz-content">
        <h3>Core Areas</h3>
        <ul>
            <li>Physics: Motion, Energy</li>
            <li>Chemistry: Reactions, Matter</li>
            <li>Biology: Life Processes</li>
        </ul>
        <div class="sample">
            <strong>Sample Questions:</strong>
            <ul>
                <li>Define velocity</li>
                <li>Name the products of photosynthesis</li>
                <li>What is an acid?</li>
            </ul>
        </div>
    </div>
</div>

<!-- SOCIAL -->
<div class="subject">
    <div class="subject-info">
        <h2>🌍 Social Studies</h2>
        <p>Focuses on civic awareness and historical understanding.</p>
    </div>
    <div class="quiz-content">
        <h3>Core Areas</h3>
        <ul>
            <li>History & Freedom Movement</li>
            <li>Geography & Resources</li>
            <li>Civics & Constitution</li>
        </ul>
        <div class="sample">
            <strong>Sample Questions:</strong>
            <ul>
                <li>What is democracy?</li>
                <li>Name one fundamental right</li>
                <li>What is meant by latitude?</li>
            </ul>
        </div>
    </div>
</div>

</div>

<!-- TEACHER CREATED QUIZZES -->
<div class="subject">
<div class="subject-info">
<h2>📝 Your Quizzes</h2>
<p>Quizzes created by you and their approval status.</p>
</div>

<div class="quiz-content">

<?php if($quiz_result->num_rows > 0){ ?>

<?php while($quiz = $quiz_result->fetch_assoc()) { ?>

<h3><?php echo htmlspecialchars($quiz['title']); ?></h3>

<p>
<b>Level:</b> <?php echo htmlspecialchars($quiz['level']); ?>
</p>

<p>
<b>Status:</b>
<?php
if($quiz['status']=="pending"){
echo "<span style='color:orange;font-weight:600;'>Pending Approval</span>";
}
elseif($quiz['status']=="approved"){
echo "<span style='color:green;font-weight:600;'>Approved</span>";
}
else{
echo "<span style='color:red;font-weight:600;'>Rejected</span>";
}
?>
</p>

<hr style="margin:10px 0">

<?php } ?>

<?php } else { ?>

<p style="color:#64748b;font-size:14px;">
No quizzes created yet. Click <b>➕ Add New Quiz</b> to create one.
</p>

<?php } ?>

</div>
</div>

<!-- TIPS -->
<div class="tips">
    <h3>🎯 Best Practices</h3>
    <p>
        • Conduct regular formative quizzes to monitor progress<br>
        • Balance factual and application-based questions<br>
        • Encourage self-evaluation after quizzes<br>
        • Use quiz analysis to plan remedial classes
    </p>
</div>

<!-- CREATE QUIZ POPUP -->

<div id="quizPopup" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;">

<div style="background:white;padding:25px;border-radius:12px;width:450px;max-height:80vh;overflow:auto;">

<h3>📝 Create Quiz</h3>

<form id="addQuizForm">

<input type="text" name="title" placeholder="Quiz Title" required
style="width:100%;margin-bottom:12px;padding:8px;">

<select name="level" required
style="width:100%;margin-bottom:12px;padding:8px;">
<option value="">Select Level</option>
<option value="Secondary">Secondary</option>
<option value="Higher Secondary">Higher Secondary</option>
</select>
<div id="questionsContainer">

<!-- QUESTION TEMPLATE -->
<div class="question-block" style="border:1px solid #ddd;padding:10px;margin-bottom:12px;border-radius:6px;">

<label><b>Question 1</b></label>
<input type="text" name="question[]" placeholder="Question"
style="width:100%;margin-bottom:6px;padding:6px;" required>

<input type="text" name="option1[]" placeholder="Option 1"
style="width:100%;margin-bottom:6px;padding:6px;" required>

<input type="text" name="option2[]" placeholder="Option 2"
style="width:100%;margin-bottom:6px;padding:6px;" required>

<input type="text" name="option3[]" placeholder="Option 3"
style="width:100%;margin-bottom:6px;padding:6px;" required>

<input type="text" name="option4[]" placeholder="Option 4"
style="width:100%;margin-bottom:6px;padding:6px;" required>

<input type="number" name="correct_option[]" min="1" max="4"
placeholder="Correct Option (1-4)"
style="width:100%;margin-bottom:6px;padding:6px;" required>

<button type="button" class="removeQuestion"
style="background:#ef4444;color:white;border:none;padding:5px 10px;border-radius:4px;">
Remove
</button>

</div>

</div>

<button type="button" id="addQuestion"
style="background:#10b981;color:white;border:none;padding:8px 12px;border-radius:6px;margin-bottom:10px;">
➕ Add Question
</button>

<br>

<button type="submit"
style="padding:8px 16px;background:#312e81;color:white;border:none;border-radius:6px;">
Submit Quiz
</button>

<button type="button" id="closeQuizPopup"
style="padding:8px 16px;background:#ccc;border:none;border-radius:6px;">
Cancel
</button>

</form>

</div>
</div>

<script>

const popup = document.getElementById("quizPopup");

document.getElementById("openQuizPopup").onclick = () =>{
popup.style.display="flex";
}

document.getElementById("closeQuizPopup").onclick = () =>{
popup.style.display="none";
}

let questionCount = 1;

document.getElementById("addQuestion").onclick = function(){

questionCount++;

const container = document.getElementById("questionsContainer");

const block = document.createElement("div");

block.classList.add("question-block");

block.style = "border:1px solid #ddd;padding:10px;margin-bottom:12px;border-radius:6px;";

block.innerHTML = `
<label style="font-weight:600;">Question ${questionCount}</label>

<textarea name="question[]" placeholder="Enter question"
style="width:100%;margin-bottom:6px;padding:6px;border:1px solid #ccc;border-radius:4px;" required></textarea>

<input type="text" name="option1[]" placeholder="Option 1"
style="width:100%;margin-bottom:6px;padding:6px;border:1px solid #ccc;border-radius:4px;" required>

<input type="text" name="option2[]" placeholder="Option 2"
style="width:100%;margin-bottom:6px;padding:6px;border:1px solid #ccc;border-radius:4px;" required>

<input type="text" name="option3[]" placeholder="Option 3"
style="width:100%;margin-bottom:6px;padding:6px;border:1px solid #ccc;border-radius:4px;" required>

<input type="text" name="option4[]" placeholder="Option 4"
style="width:100%;margin-bottom:6px;padding:6px;border:1px solid #ccc;border-radius:4px;" required>

<label>Correct Option</label>
<select name="correct_option[]"
style="width:100%;margin-bottom:6px;padding:6px;border:1px solid #ccc;border-radius:4px;">
<option value="1">Option 1</option>
<option value="2">Option 2</option>
<option value="3">Option 3</option>
<option value="4">Option 4</option>
</select>

<button type="button" class="removeQuestion"
style="background:#ef4444;color:white;border:none;padding:5px 10px;border-radius:4px;">
Remove Question
</button>
`;

container.appendChild(block);

};

document.addEventListener("click",function(e){

if(e.target.classList.contains("removeQuestion")){
e.target.parentElement.remove();
}

});

document.getElementById("addQuizForm").onsubmit = function(e){

e.preventDefault();

const formData = new FormData(this);

fetch("add_secondary_quiz.php",{
method:"POST",
body:formData
})
.then(res=>res.json())
.then(data=>{
alert(data.message);

if(data.message === "Quiz submitted for approval"){
popup.style.display="none";
window.location.reload();
}
});

};

</script>
</body>
</html>
