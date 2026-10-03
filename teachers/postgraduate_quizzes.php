<?php
session_start();
require_once "../config/db.php";

/* ADD QUIZ */
if(isset($_POST['submit_quiz'])){

    $title = $_POST['title'];
    $level = "postgraduate";
    $created_by = $_SESSION['user_id'];
    $status = "pending";

    /* INSERT QUIZ */
    $stmt = $conn->prepare("
        INSERT INTO quizzes1 (title, level, created_by, status)
        VALUES (?,?,?,?)
    ");

    $stmt->bind_param("ssis", $title, $level, $created_by, $status);
    $stmt->execute();

    $quiz_id = $stmt->insert_id;

    /* INSERT QUESTIONS */
    foreach($_POST['questions'] as $index => $q){

        $question = $q['question'];
        $o1 = $q['option1'];
        $o2 = $q['option2'];
        $o3 = $q['option3'];
        $o4 = $q['option4'];
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
            $o1,
            $o2,
            $o3,
            $o4,
            $correct
        );

        $stmt2->execute();
    }

    echo "<script>
        alert('✅ Quiz added successfully! Waiting for admin approval');
        window.location.href=window.location.href;
    </script>";
}

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Sample Quizzes | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#e0f2fe,#fdf2f8);
    color:#0f172a;
    padding:24px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#0f172a,#1e293b);
    padding:20px 36px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 32px rgba(0,0,0,0.45);
}
.navbar h2{
    font-family:'Playfair Display', serif;
    color:#f97316;
}
.navbar a{
    color:#e5e7eb;
    margin-left:18px;
    text-decoration:none;
}
.navbar a:hover{color:#f97316;}

/* BACK */
.back{
    margin:24px 0;
}
.back a{
    background:linear-gradient(90deg,#f97316,#fb7185);
    color:#020617;
    padding:11px 28px;
    border-radius:22px;
    text-decoration:none;
    font-weight:600;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:36px;
    border-radius:30px;
    box-shadow:0 16px 38px rgba(0,0,0,0.2);
    margin-bottom:40px;
}
.header h1{
    font-family:'Playfair Display', serif;
    font-size:30px;
}
.header p{
    margin-top:12px;
    font-size:15px;
    color:#475569;
}

/* GRID */
.quiz-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

/* QUIZ CARD */
.quiz{
    background:#ffffff;
    padding:28px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.18);
    border-top:6px solid #f97316;
}
.quiz h3{
    margin-bottom:8px;
    color:#0f172a;
}
.quiz span{
    font-size:13px;
    color:#ea580c;
    font-weight:600;
}
.quiz p{
    font-size:14px;
    margin:10px 0;
    color:#334155;
}
.quiz ol{
    padding-left:18px;
}
.quiz li{
    font-size:13px;
    margin-bottom:8px;
}

/* INFO */
.info{
    margin-top:46px;
    background:linear-gradient(135deg,#0f172a,#1e293b);
    padding:36px;
    border-radius:30px;
    color:#e5e7eb;
}
.info h2{
    color:#fb7185;
    margin-bottom:14px;
}
.info ul{
    padding-left:20px;
}
.info li{
    font-size:14px;
    margin-bottom:8px;
}
.add-btn{
    margin-top:20px;
    padding:12px 26px;
    border:none;
    border-radius:30px;
    background:linear-gradient(135deg,#f97316,#fb7185);
    color:#fff;
    font-weight:600;
    cursor:pointer;
}
.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
}

.modal-box{
    background:#fff;
    padding:20px;
    width:450px;
    border-radius:20px;
}

.question-block input,
.question-block select{
    width:100%;
    margin:6px 0;
    padding:8px;
}
/* MODAL BACKGROUND */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(15,23,42,0.65);
    backdrop-filter:blur(6px);

    /* 🔥 IMPORTANT FIX */
    overflow-y:auto;   /* allows scrolling */
    padding:20px;

    display:flex;
    justify-content:center;
    align-items:flex-start; /* move modal to top */
    z-index:999;
}

/* MODAL BOX */
.modal-box{
    background:#ffffff;
    padding:28px;
    width:480px;
    max-height:90vh;   /* 🔥 limit height */
    overflow-y:auto;   /* 🔥 internal scroll */
    border-radius:24px;
    box-shadow:0 20px 50px rgba(0,0,0,0.3);
    animation:fadeIn 0.3s ease;
    margin-top:20px;
}

/* TITLE */
.modal-box h2{
    text-align:center;
    margin-bottom:18px;
    color:#0f172a;
}

/* INPUT GROUP */
.input-group{
    margin-bottom:14px;
}
.input-group label{
    font-size:13px;
    font-weight:600;
    color:#334155;
}
.input-group input{
    width:100%;
    padding:10px;
    margin-top:6px;
    border-radius:10px;
    border:1px solid #cbd5f5;
}

/* QUESTION CARD */
.question-card{
    background:#f8fafc;
    padding:14px;
    border-radius:14px;
    margin-bottom:14px;
    border:1px solid #e2e8f0;
}

/* OPTIONS GRID */
.options{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
    margin-top:8px;
}

/* INPUT STYLE */
.question-card input,
.question-card select{
    width:100%;
    padding:9px;
    margin-top:6px;
    border-radius:10px;
    border:1px solid #cbd5e1;
}

/* ADD QUESTION BUTTON */
.add-q-btn{
    width:100%;
    margin-top:10px;
    padding:10px;
    border:none;
    border-radius:12px;
    background:#f1f5f9;
    font-weight:600;
    cursor:pointer;
}
.add-q-btn:hover{
    background:#e2e8f0;
}

/* ACTION BUTTONS */
.form-actions{
    display:flex;
    gap:10px;
    margin-top:16px;
}

.submit-btn{
    flex:1;
    padding:12px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#f97316,#fb7185);
    color:#fff;
    font-weight:600;
    cursor:pointer;
}

.cancel-btn{
    flex:1;
    padding:12px;
    border:none;
    border-radius:12px;
    background:#e2e8f0;
    cursor:pointer;
}

/* ANIMATION */
@keyframes fadeIn{
    from{opacity:0;transform:scale(0.9);}
    to{opacity:1;transform:scale(1);}
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Postgraduate Sample Quizzes</h2>
    <div>
        <a href="postgraduate_lessons.php">Lessons</a>
        <a href="postgraduate_books.php">Books</a>
        <a href="postgraduate_quizzes.php">Quizzes</a>
        <a href="postgraduate_assignments.php">Assignments</a>
        <a href="postgraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK -->
<div class="back">
    <a href="postgraduate.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Sample Postgraduate Quizzes</h1>
    <p>
        Below are sample quizzes designed to evaluate analytical thinking,
        research understanding, and advanced subject knowledge.
    </p>
<br>
<button class="add-btn" onclick="openModal()">➕ Add Quiz</button>
</div>

<!-- QUIZZES -->
<div class="quiz-grid">

    <!-- Research Methodology -->
    <div class="quiz">
        <h3>Research Methodology</h3>
        <span>Conceptual Assessment</span>
        <p>Sample Questions:</p>
        <ol>
            <li>Differentiate between qualitative and quantitative research.</li>
            <li>What is a research hypothesis? Explain its types.</li>
            <li>Why is research ethics important in academic studies?</li>
        </ol>
    </div>

    <!-- Advanced Subject Knowledge -->
    <div class="quiz">
        <h3>Advanced Subject Knowledge</h3>
        <span>Domain Expertise</span>
        <p>Sample Questions:</p>
        <ol>
            <li>Explain the core theory related to your specialization.</li>
            <li>Analyze a real-world application of this theory.</li>
            <li>Compare two major models used in your subject area.</li>
        </ol>
    </div>

    <!-- Data Analysis -->
    <div class="quiz">
        <h3>Data Analysis & Statistics</h3>
        <span>Analytical Skills</span>
        <p>Sample Questions:</p>
        <ol>
            <li>What is the significance of standard deviation?</li>
            <li>Interpret the given dataset using appropriate charts.</li>
            <li>Differentiate between correlation and regression.</li>
        </ol>
    </div>

    <!-- Literature Review -->
    <div class="quiz">
        <h3>Literature Review</h3>
        <span>Research Readiness</span>
        <p>Sample Questions:</p>
        <ol>
            <li>What is the purpose of a literature review?</li>
            <li>How do you identify research gaps?</li>
            <li>Explain the importance of peer-reviewed journals.</li>
        </ol>
    </div>

</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM quizzes1 WHERE level='postgraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$res = $stmt->get_result();

$quizData = [];

while($row = $res->fetch_assoc()){
    $quizData[$row['status']][] = $row;
}
?>

<h2 style="margin-top:40px;">📊 Quizzes from Database</h2>

<h3 style="color:green;">✅ Approved</h3>
<?php if(isset($quizData['approved'])): ?>
<?php foreach($quizData['approved'] as $q): ?>
<div class="quiz">
<h3><?php echo $q['title']; ?></h3>
<p>Status: Approved</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved quizzes</p>
<?php endif; ?>

<h3 style="color:orange;">⏳ Pending</h3>
<?php if(isset($quizData['pending'])): ?>
<?php foreach($quizData['pending'] as $q): ?>
<div class="quiz" style="border-top:6px solid orange;">
<h3><?php echo $q['title']; ?></h3>
<p>Status: Pending</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending quizzes</p>
<?php endif; ?>

<!-- INFO -->
<div class="info">
    <h2>📌 Evaluation Guidelines</h2>
    <ul>
        <li>Focus on analytical and explanatory answers</li>
        <li>Encourage real-world and research-based examples</li>
        <li>Use rubric-based evaluation</li>
        <li>Promote critical thinking over memorization</li>
    </ul>
</div>

<div id="quizModal" class="modal">

<form method="POST" class="modal-box">

<h2>📝 Create Quiz</h2>

<div class="input-group">
<label>Quiz Title</label>
<input type="text" name="title" placeholder="Enter quiz title..." required>
</div>

<div id="questions-area">

<div class="question-card">
<h4>Question 1</h4>

<input type="text" name="questions[0][question]" placeholder="Enter question..." required>

<div class="options">
<input type="text" name="questions[0][option1]" placeholder="Option 1" required>
<input type="text" name="questions[0][option2]" placeholder="Option 2" required>
<input type="text" name="questions[0][option3]" placeholder="Option 3" required>
<input type="text" name="questions[0][option4]" placeholder="Option 4" required>
</div>

<select name="questions[0][correct]" required>
<option value="">Select Correct Option</option>
<option value="1">Option 1</option>
<option value="2">Option 2</option>
<option value="3">Option 3</option>
<option value="4">Option 4</option>
</select>

</div>

</div>

<button type="button" class="add-q-btn" onclick="addQuestion()">➕ Add Question</button>

<div class="form-actions">
<button type="submit" name="submit_quiz" class="submit-btn">Submit Quiz</button>
<button type="button" onclick="closeModal()" class="cancel-btn">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("quizModal").style.display="flex";
    document.body.style.overflow = "hidden"; // stop background scroll
}

function closeModal(){
    document.getElementById("quizModal").style.display="none";
    document.body.style.overflow = "auto"; // restore scroll
}

let qIndex = 1;

function addQuestion(){

    let area = document.getElementById("questions-area");

    let html = `
    <div class="question-card">
    <h4>Question ${qIndex+1}</h4>

    <input type="text" name="questions[${qIndex}][question]" placeholder="Enter question..." required>

    <div class="options">
    <input type="text" name="questions[${qIndex}][option1]" placeholder="Option 1" required>
    <input type="text" name="questions[${qIndex}][option2]" placeholder="Option 2" required>
    <input type="text" name="questions[${qIndex}][option3]" placeholder="Option 3" required>
    <input type="text" name="questions[${qIndex}][option4]" placeholder="Option 4" required>
    </div>

    <select name="questions[${qIndex}][correct]" required>
    <option value="">Select Correct Option</option>
    <option value="1">Option 1</option>
    <option value="2">Option 2</option>
    <option value="3">Option 3</option>
    <option value="4">Option 4</option>
    </select>
    </div>
    `;

    area.insertAdjacentHTML("beforeend", html);
    qIndex++;
}
</script>

</body>
</html>
