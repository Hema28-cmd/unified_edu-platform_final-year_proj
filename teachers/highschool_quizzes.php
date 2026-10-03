<?php
session_start();

require_once "../config/db.php";  // <-- ADD THIS

/* Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
/* ADD QUIZ */
if(isset($_POST['create_quiz'])){

    $quiz_title = $_POST['quiz_title'];
    $teacher_id = $_SESSION['user_id'];
    $level = "highschool";

    /* INSERT QUIZ */
    $stmt = $conn->prepare("INSERT INTO quizzes1 (title, level, created_by) VALUES (?,?,?)");
    $stmt->bind_param("ssi", $quiz_title, $level, $teacher_id);
    $stmt->execute();

    $quiz_id = $stmt->insert_id;

    /* INSERT QUESTIONS */
    foreach($_POST['questions'] as $q){

        $question = $q['question'];
        $opt1 = $q['opt1'];
        $opt2 = $q['opt2'];
        $opt3 = $q['opt3'];
        $opt4 = $q['opt4'];
        $correct = $q['correct'];

        $stmt2 = $conn->prepare("
            INSERT INTO quiz_questions 
            (quiz_id, level, question, option1, option2, option3, option4, correct_option)
            VALUES (?,?,?,?,?,?,?,?)
        ");

        $stmt2->bind_param("issssssi",
            $quiz_id,
            $level,
            $question,
            $opt1,
            $opt2,
            $opt3,
            $opt4,
            $correct
        );

        $stmt2->execute();
    }

    echo "<script>alert('✅ Quiz created and waiting for admin approval!'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Quizzes | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#ecfeff,#fdf4ff);
    padding:24px;
    color:#1f2937;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#0f766e,#4c1d95);
    padding:18px 30px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 28px rgba(0,0,0,0.25);
}
.navbar h2{
    font-family:'Playfair Display', serif;
    color:#ecfeff;
}
.navbar a{
    color:#d1fae5;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff;}

/* PAGE INTRO */
.intro{
    margin:32px 0;
    background:#ffffff;
    padding:30px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.intro h1{
    font-family:'Playfair Display', serif;
    font-size:30px;
    color:#115e59;
}
.intro p{
    margin-top:12px;
    font-size:15px;
    color:#475569;
    line-height:1.7;
}

/* QUIZ SECTIONS */
.section{
    margin-top:42px;
}
.section h2{
    font-size:22px;
    color:#4c1d95;
    margin-bottom:20px;
}

/* QUIZ GRID */
.quiz-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:24px;
}

/* QUIZ CARD */
.quiz-card{
    background:linear-gradient(135deg,#ccfbf1,#ede9fe);
    border-radius:22px;
    padding:24px;
    box-shadow:0 10px 26px rgba(0,0,0,0.15);
    transition:0.3s;
}
.quiz-card:hover{
    transform:translateY(-6px);
    box-shadow:0 14px 34px rgba(0,0,0,0.2);
}
.quiz-card h3{
    font-size:19px;
    color:#134e4a;
    margin-bottom:6px;
}
.quiz-card span{
    display:block;
    font-size:13px;
    color:#6b7280;
    margin-bottom:10px;
}
.quiz-card p{
    font-size:14px;
    color:#374151;
    margin-bottom:10px;
}
.quiz-card ul{
    padding-left:18px;
}
.quiz-card ul li{
    font-size:14px;
    margin-bottom:6px;
    color:#1f2937;
}

/* ASSESSMENT NOTE */
.note-box{
    margin-top:48px;
    background:linear-gradient(135deg,#fde68a,#fbcfe8);
    padding:26px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.18);
}
.note-box h3{
    font-size:20px;
    color:#7c2d12;
}
.note-box p{
    margin-top:10px;
    font-size:14px;
    line-height:1.7;
    color:#3f1d0b;
}

/* BACK BUTTON (SAME STYLE AS BEFORE) */
.actions{
    margin-top:40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#4c1d95;
    color:#ffffff;
    padding:12px 28px;
    border-radius:16px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{
    background:#6d28d9;
}
.footer-note{
    font-size:13px;
    color:#6b7280;
}
.question-block{
    margin-bottom:15px;
}
.question-block input,
.question-block select{
    width:100%;
    padding:8px;
    margin-top:6px;
    border:1px solid #ccc;
    border-radius:8px;
}
/* ✅ MODAL FIX */
.modal-overlay{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    display:none; /* IMPORTANT */
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-form{
    background:#ffffff;
    padding:25px;
    border-radius:20px;
    width:500px;
    max-height:90vh;
    overflow-y:auto;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}

.form-group{
    margin-bottom:15px;
}

.form-group input{
    width:100%;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
}

.form-actions{
    display:flex;
    justify-content:space-between;
}

.action-btn{
    background:#4c1d95;
    color:#fff;
    padding:10px 20px;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

.action-btn:hover{
    background:#6d28d9;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>High School Quizzes</h2>
    <div>
        <a href="highschool.php">Dashboard</a>
        <a href="highschool_lessons.php">Lessons</a>
        <a href="highschool_books.php">Books</a>
        <a href="highschool_quizzes.php">Quizzes</a>
        <a href="highschool_assignments.php">Assignments</a>
        <a href="highschool_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- INTRO -->
<div class="intro">

    <h1>Academic Quizzes & Evaluations</h1>
    <p>
        These quizzes are structured to assess knowledge retention, conceptual clarity,
        analytical ability, and exam readiness for high school students (Grades 9–12).
    </p><br>
<button type="button" class="back-btn" onclick="openQuizModal()">📝 Create Quiz</button>
</div>

<?php
$stmt = $conn->prepare("SELECT * FROM quizzes1 WHERE created_by=? ORDER BY created_at DESC LIMIT 1");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$latest = $stmt->get_result()->fetch_assoc();

if($latest):
?>

<div class="section">
<h2>🆕 Recently Added Quiz</h2>

<div class="quiz-card">
<h3><?php echo $latest['title']; ?></h3>
<span>Status: <?php echo $latest['status']; ?></span>

<?php
$qid = $latest['id'];
$qres = $conn->query("SELECT * FROM quiz_questions WHERE quiz_id=$qid");

while($q = $qres->fetch_assoc()):
?>

<p><b>Q:</b> <?php echo $q['question']; ?></p>
<ul>
<li><?php echo $q['option1']; ?></li>
<li><?php echo $q['option2']; ?></li>
<li><?php echo $q['option3']; ?></li>
<li><?php echo $q['option4']; ?></li>
</ul>

<?php endwhile; ?>

</div>
</div>

<?php endif; ?>

<!-- MATHEMATICS -->
<div class="section">
    <h2>Mathematics Quizzes</h2>
    <div class="quiz-grid">
        <div class="quiz-card">
            <h3>Algebra & Equations</h3>
            <span>MCQs + Problem Solving</span>
            <p>Focus on expressions, equations, and real-life applications.</p>
            <ul>
                <li>Linear & quadratic equations</li>
                <li>Word problems</li>
                <li>Formula application</li>
            </ul>
        </div>
        <div class="quiz-card">
            <h3>Geometry & Trigonometry</h3>
            <span>Diagram-based Quiz</span>
            <p>Enhances spatial reasoning and logical thinking.</p>
            <ul>
                <li>Triangles & circles</li>
                <li>Angles & constructions</li>
                <li>Trigonometric ratios</li>
            </ul>
        </div>
    </div>
</div>

<!-- SCIENCE -->
<div class="section">
    <h2>Science Quizzes</h2>
    <div class="quiz-grid">
        <div class="quiz-card">
            <h3>Physics – Motion & Energy</h3>
            <span>Numerical + Conceptual</span>
            <p>Tests understanding of laws of motion and energy.</p>
            <ul>
                <li>Speed, velocity & acceleration</li>
                <li>Work & power</li>
                <li>Numerical problems</li>
            </ul>
        </div>
        <div class="quiz-card">
            <h3>Chemistry – Reactions</h3>
            <span>MCQs + Balancing</span>
            <p>Evaluates chemical knowledge and calculations.</p>
            <ul>
                <li>Chemical equations</li>
                <li>Reaction types</li>
                <li>Stoichiometry basics</li>
            </ul>
        </div>
        <div class="quiz-card">
            <h3>Biology – Life Processes</h3>
            <span>MCQs + Diagrams</span>
            <p>Checks understanding of biological systems.</p>
            <ul>
                <li>Nutrition & respiration</li>
                <li>Human systems</li>
                <li>Environment & ecology</li>
            </ul>
        </div>
    </div>
</div>

<!-- SOCIAL & LANGUAGE -->
<div class="section">
    <h2>Social Studies & Language</h2>
    <div class="quiz-grid">
        <div class="quiz-card">
            <h3>History & Civics</h3>
            <span>Assertion–Reason</span>
            <p>Builds historical awareness and civic understanding.</p>
            <ul>
                <li>Freedom movement</li>
                <li>Constitution basics</li>
                <li>World history</li>
            </ul>
        </div>
        <div class="quiz-card">
            <h3>English Language</h3>
            <span>Grammar + Writing</span>
            <p>Improves language proficiency and expression.</p>
            <ul>
                <li>Grammar & vocabulary</li>
                <li>Reading comprehension</li>
                <li>Essay & letter writing</li>
            </ul>
        </div>
    </div>
</div>

<!-- NOTE -->
<div class="note-box">
    <h3>Assessment Guidelines</h3>
    <p>
        • Conduct weekly formative quizzes<br>
        • Use quizzes for concept reinforcement<br>
        • Combine objective and descriptive questions<br>
        • Analyze results to plan remedial sessions
    </p>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="highschool.php" class="back-btn">⬅ Back</a>
    <div class="footer-note">
        Designed for High School • Grades 9 – 12
    </div>
</div>

<!-- QUIZ MODAL -->
<div id="quizModal" class="modal-overlay" style="display:none;">
<form method="POST" class="modal-form">

<h2>📝 Create Quiz</h2>

<div class="form-group">
<label>Quiz Title</label>
<input type="text" name="quiz_title" required>
</div>

<div id="questionsContainer">

<div class="question-block">

<p><b>Question 1</b></p>

<input type="text" name="questions[0][question]" placeholder="Enter question" required>

<input type="text" name="questions[0][opt1]" placeholder="Option 1" required>
<input type="text" name="questions[0][opt2]" placeholder="Option 2" required>
<input type="text" name="questions[0][opt3]" placeholder="Option 3" required>
<input type="text" name="questions[0][opt4]" placeholder="Option 4" required>

<select name="questions[0][correct]" required>
<option value="">Correct Option</option>
<option value="1">Option 1</option>
<option value="2">Option 2</option>
<option value="3">Option 3</option>
<option value="4">Option 4</option>
</select>

</div>

</div>

<br>

<button type="button" onclick="addQuestion()">➕ Add Question</button>

<br><br>

<div class="form-actions">
<button type="submit" name="create_quiz" class="action-btn">Submit Quiz</button>
<button type="button" onclick="closeQuizModal()" class="action-btn">Cancel</button>
</div>

</form>
</div>

<script>
let qIndex = 1;

function openQuizModal(){
    document.getElementById('quizModal').style.display='flex';
}

function closeQuizModal(){
    document.getElementById('quizModal').style.display='none';
}

function addQuestion(){

    let container = document.getElementById('questionsContainer');

    let html = `
    <div class="question-block">
    <hr>
    <p><b>Question ${qIndex+1}</b></p>

    <input type="text" name="questions[${qIndex}][question]" placeholder="Enter question" required>

    <input type="text" name="questions[${qIndex}][opt1]" placeholder="Option 1" required>
    <input type="text" name="questions[${qIndex}][opt2]" placeholder="Option 2" required>
    <input type="text" name="questions[${qIndex}][opt3]" placeholder="Option 3" required>
    <input type="text" name="questions[${qIndex}][opt4]" placeholder="Option 4" required>

    <select name="questions[${qIndex}][correct]" required>
        <option value="">Correct Option</option>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>

    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    qIndex++;
}
</script>

</body>
</html>
