<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];

require_once "../config/db.php";

/* ADD QUIZ */
if(isset($_POST['create_quiz'])){

    $title = $_POST['quiz_title'];
    $teacher_id = $_SESSION['user_id'];
    $level = "undergraduate";

    // Insert quiz
    $stmt = $conn->prepare("
        INSERT INTO quizzes1 (title, level, created_by)
        VALUES (?,?,?)
    ");
    $stmt->bind_param("ssi", $title, $level, $teacher_id);
    $stmt->execute();

    $quiz_id = $conn->insert_id;

    // Insert questions
    foreach($_POST['question'] as $index => $q){

        $question = $_POST['question'][$index];
        $op1 = $_POST['option1'][$index];
        $op2 = $_POST['option2'][$index];
        $op3 = $_POST['option3'][$index];
        $op4 = $_POST['option4'][$index];
        $correct = $_POST['correct'][$index];

        $stmt2 = $conn->prepare("
            INSERT INTO quiz_questions
            (quiz_id, level, question, option1, option2, option3, option4, correct_option)
            VALUES (?,?,?,?,?,?,?,?)
        ");

        $stmt2->bind_param("issssssi",
            $quiz_id,
            $level,
            $question,
            $op1,
            $op2,
            $op3,
            $op4,
            $correct
        );

        $stmt2->execute();
    }

    echo "<script>alert('✅ Quiz added successfully! Waiting for admin approval'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Quizzes | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

/* BASE */
body{
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#f0f9ff,#ecfeff);
    color:#0f172a;
    padding:26px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#0f766e,#134e4a);
    padding:22px 36px;
    border-radius:24px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 34px rgba(0,0,0,0.3);
}
.navbar h2{
    font-family:'Poppins',sans-serif;
    color:#ecfeff;
    font-size:26px;
}
.navbar a{
    color:#ccfbf1;
    margin-left:22px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff}

/* INTRO */
.intro{
    margin-top:34px;
    background:#ffffff;
    padding:36px;
    border-radius:30px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.intro h1{
    font-family:'Poppins',sans-serif;
    color:#0f766e;
    font-size:30px;
}
.intro p{
    margin-top:12px;
    font-size:16px;
    line-height:1.7;
    color:#334155;
}

/* QUIZ SECTION */
.section{
    margin-top:46px;
}
.section h2{
    font-size:22px;
    margin-bottom:20px;
    color:#115e59;
}

/* QUIZ GRID */
.quiz-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:28px;
}

/* QUIZ CARD */
.quiz{
    background:linear-gradient(135deg,#ecfeff,#ccfbf1);
    padding:26px;
    border-radius:24px;
    box-shadow:0 10px 26px rgba(0,0,0,0.15);
}
.quiz h3{
    color:#0f766e;
    font-size:18px;
    margin-bottom:8px;
}
.quiz p{
    font-size:14px;
    margin-bottom:6px;
    color:#334155;
}
.quiz ul{
    margin-top:10px;
    padding-left:18px;
}
.quiz li{
    font-size:14px;
    margin-bottom:6px;
}

/* SAMPLE QUESTION */
.sample{
    margin-top:14px;
    background:#f0fdfa;
    padding:14px;
    border-radius:14px;
    font-size:13px;
    color:#134e4a;
}

/* ASSESSMENT STRATEGY */
.strategy{
    margin-top:50px;
    background:linear-gradient(135deg,#020617,#020617);
    padding:38px;
    border-radius:30px;
    color:#e5e7eb;
}
.strategy h2{
    color:#5eead4;
    margin-bottom:14px;
}
.strategy li{
    margin-bottom:10px;
    font-size:14px;
}

/* FOOTER ACTIONS */
.actions{
    margin-top:50px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#0f766e;
    color:#ecfeff;
    padding:14px 32px;
    border-radius:18px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#115e59}
.note{
    font-size:13px;
    color:#475569;
}
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-box{
    background:#fff;
    padding:25px;
    border-radius:15px;
    width:500px;
    max-height:90vh;
    overflow:auto;
}

.question-block{
    margin-top:15px;
    padding:10px;
    border:1px solid #ddd;
}

textarea, input, select{
    width:100%;
    margin-top:8px;
    padding:8px;
}

.form-actions{
    margin-top:15px;
    display:flex;
    justify-content:space-between;
}

.btn-submit{
    background:#0f766e;
    color:#fff;
    padding:10px;
    border:none;
}

.btn-cancel{
    background:#ccc;
    padding:10px;
    border:none;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Undergraduate Quizzes</h2>
    <div>
        <a href="undergraduate_lessons.php">Lessons</a>
        <a href="undergraduate_books.php">Books</a>
        <a href="undergraduate_quizzes.php">Quizzes</a>
        <a href="undergraduate_assignments.php">Assignments</a>
        <a href="undergraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- INTRO -->
<div class="intro">
    <h1>Concept-Based & Skill-Oriented Quizzes</h1>
    <p>
        This section contains formative and summative quizzes designed
        for undergraduate students to assess conceptual understanding,
        analytical ability, and application skills across disciplines.
    </p><br>
<button class="back-btn" onclick="openModal()">➕ Create Quiz</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM quizzes1
    WHERE level='undergraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$quizList = [];

while($row = $result->fetch_assoc()){
    $quizList[$row['status']][] = $row;
}
?>

<!-- CORE QUIZZES -->
<div class="section">
    <h2>📝 Core Subject Quizzes</h2>
    <div class="quiz-grid">

        <div class="quiz">
            <h3>Programming Fundamentals</h3>
            <p><b>Type:</b> MCQs + Code Output</p>
            <p><b>Focus:</b> Logic, syntax, debugging</p>
            <ul>
                <li>Variables & data types</li>
                <li>Loops & functions</li>
                <li>Basic algorithms</li>
            </ul>
            <div class="sample">
                <b>Sample:</b> What will be the output of a loop with nested conditions?
            </div>
        </div>

        <div class="quiz">
            <h3>Database Management Systems</h3>
            <p><b>Type:</b> SQL-based Questions</p>
            <p><b>Focus:</b> Query writing & optimization</p>
            <ul>
                <li>Normalization</li>
                <li>Joins & subqueries</li>
                <li>Transactions</li>
            </ul>
            <div class="sample">
                <b>Sample:</b> Write an SQL query to find the second highest salary.
            </div>
        </div>

        <div class="quiz">
            <h3>Operating Systems</h3>
            <p><b>Type:</b> Conceptual + Numerical</p>
            <p><b>Focus:</b> System efficiency</p>
            <ul>
                <li>CPU scheduling</li>
                <li>Deadlocks</li>
                <li>Memory management</li>
            </ul>
            <div class="sample">
                <b>Sample:</b> Calculate average waiting time using FCFS scheduling.
            </div>
        </div>

        <div class="quiz">
            <h3>Software Engineering</h3>
            <p><b>Type:</b> Case-study based</p>
            <p><b>Focus:</b> Design & analysis</p>
            <ul>
                <li>SDLC models</li>
                <li>Agile methodology</li>
                <li>UML diagrams</li>
            </ul>
            <div class="sample">
                <b>Sample:</b> Identify the best SDLC model for a banking application.
            </div>
        </div>

    </div>
</div>

<div class="section">
<h2>📊 Created Quizzes</h2>

<h3 style="color:green;">✅ Approved</h3>
<div class="quiz-grid">

<?php if(isset($quizList['approved'])): ?>
<?php foreach($quizList['approved'] as $q): ?>
<div class="quiz" style="background:#dcfce7;">
<h3><?php echo $q['title']; ?></h3>
<p>Status: Approved</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved quizzes</p>
<?php endif; ?>

</div>

<h3 style="color:orange;margin-top:20px;">⏳ Pending</h3>
<div class="quiz-grid">

<?php if(isset($quizList['pending'])): ?>
<?php foreach($quizList['pending'] as $q): ?>
<div class="quiz" style="background:#fef9c3;">
<h3><?php echo $q['title']; ?></h3>
<p>Status: Pending Approval</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending quizzes</p>
<?php endif; ?>

</div>
</div>

<!-- STRATEGY -->
<div class="strategy">
    <h2>🎯 Quiz & Assessment Strategy</h2>
    <ul>
        <li>Conduct short quizzes after every major unit</li>
        <li>Mix MCQs, numerical, and application-based questions</li>
        <li>Encourage open-book quizzes for analytical thinking</li>
        <li>Use quizzes as preparation for competitive exams</li>
        <li>Provide feedback and discussion after assessments</li>
    </ul>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="undergraduate.php" class="back-btn">⬅ Back to Undergraduate</a>
    <div class="note">
        Undergraduate Assessment Module • Skill-Oriented Learning
    </div>
</div>

<!-- QUIZ MODAL -->
<div id="quizModal" class="modal">

<form method="POST" class="modal-box">

<h2>📝 Create Quiz</h2>

<label>Quiz Title</label>
<input type="text" name="quiz_title" required>

<div id="questionsArea">

<div class="question-block">
<h4>Question 1</h4>

<textarea name="question[]" placeholder="Enter question" required></textarea>

<input type="text" name="option1[]" placeholder="Option 1" required>
<input type="text" name="option2[]" placeholder="Option 2" required>
<input type="text" name="option3[]" placeholder="Option 3" required>
<input type="text" name="option4[]" placeholder="Option 4" required>

<select name="correct[]" required>
<option value="">Correct Option</option>
<option value="1">Option 1</option>
<option value="2">Option 2</option>
<option value="3">Option 3</option>
<option value="4">Option 4</option>
</select>

</div>

</div>

<button type="button" onclick="addQuestion()">➕ Add Question</button>

<div class="form-actions">
<button type="submit" name="create_quiz" class="btn-submit">Submit Quiz</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("quizModal").style.display="flex";
}

function closeModal(){
    document.getElementById("quizModal").style.display="none";
}

let count = 1;

function addQuestion(){
    count++;

    let html = `
    <div class="question-block">
    <h4>Question ${count}</h4>

    <textarea name="question[]" placeholder="Enter question" required></textarea>

    <input type="text" name="option1[]" placeholder="Option 1" required>
    <input type="text" name="option2[]" placeholder="Option 2" required>
    <input type="text" name="option3[]" placeholder="Option 3" required>
    <input type="text" name="option4[]" placeholder="Option 4" required>

    <select name="correct[]" required>
    <option value="">Correct Option</option>
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
    <option value="4">Option 4</option>
    </select>
    </div>
    `;

    document.getElementById("questionsArea").insertAdjacentHTML("beforeend", html);
}

window.onclick = function(e){
    let modal = document.getElementById("quizModal");
    if(e.target === modal){
        modal.style.display = "none";
    }
}
</script>
  
</body>
</html>
