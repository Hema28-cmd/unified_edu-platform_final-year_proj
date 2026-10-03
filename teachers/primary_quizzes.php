<?php
session_start();

/* 🔐 Teacher-only access */
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher'){
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];

/* DB Connection */
$conn = new mysqli("localhost","root","","unified_edu");
if($conn->connect_error){
    die("DB connection failed: ".$conn->connect_error);
}

/* Fetch quizzes from both tables */
$quizzes = [];
$sql = "
    SELECT id, title, 'approved' as status, created_at FROM quizzes WHERE level='primary'
    UNION ALL
    SELECT id, title, status, created_at FROM quizzes1 WHERE level='primary'
    ORDER BY created_at DESC
";

$res = $conn->query($sql);
if($res){
    while($row = $res->fetch_assoc()){
        $quiz_id = $row['id'];

        // Fetch questions for this quiz
        $questions = [];
        $q_sql = "SELECT question, option1, option2, option3, option4, correct_option FROM quiz_questions WHERE quiz_id = $quiz_id";
        $q_res = $conn->query($q_sql);
        if($q_res){
            while($q_row = $q_res->fetch_assoc()){
                $questions[] = $q_row;
            }
        }

        // If no questions, add sample placeholder questions
        if(empty($questions)){
            $questions = [
                ['question' => 'Sample Question 1: What is 2 + 2?', 'option1'=>'1','option2'=>'2','option3'=>'3','option4'=>'4','correct_option'=>4],
                ['question' => 'Sample Question 2: What color is the sky?', 'option1'=>'Red','option2'=>'Blue','option3'=>'Green','option4'=>'Yellow','correct_option'=>2],
                ['question' => 'Sample Question 3: Name a primary color.', 'option1'=>'Pink','option2'=>'Purple','option3'=>'Red','option4'=>'Brown','correct_option'=>3],
            ];
        }

        $row['questions'] = $questions; // attach questions to the quiz
        $quizzes[] = $row;
    }
}

// Function to generate random pastel color
function randomPastelColor(){
    $r = rand(150, 255);
    $g = rand(150, 255);
    $b = rand(150, 255);
    return "rgb($r,$g,$b)";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Quizzes | Teacher Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Fredoka+One&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Poppins',sans-serif;padding:20px;background:#f3f4f6;}
.navbar{display:flex;justify-content:space-between;padding:12px 25px;background:linear-gradient(90deg,#ec4899,#f472b6);color:#fff;border-radius:12px;margin-bottom:20px;}
.navbar a{color:#fff;text-decoration:none;margin-left:15px;font-weight:500;}
.back-btn{padding:10px 20px;background:#3b82f6;color:#fff;border-radius:25px;text-decoration:none;margin-bottom:20px;display:inline-block;}
.quizzes-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:15px;}
.quiz-card{padding:15px;border-radius:15px;box-shadow:0 5px 15px rgba(0,0,0,0.1);transition: transform 0.2s;}
.quiz-card:hover{transform: translateY(-5px);}
.quiz-card h3{margin-bottom:5px;}
.quiz-card span{font-size:12px;display:block;margin-bottom:3px;}
.status-approved{color: #16a34a; font-weight:600;} /* green */
.status-pending{color: #f59e0b; font-weight:600;} /* orange */
.questions-list{margin-top:10px;padding-left:15px;}
.questions-list li{margin-bottom:5px;}
.action-btn{padding:10px 15px;background:linear-gradient(90deg,#f97316,#facc15);color:#fff;border:none;border-radius:25px;cursor:pointer;}
.remove-question{background:#ef4444;margin-top:5px;}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);align-items:center;justify-content:center;z-index:100;}
.modal-form{background:#fff;padding:20px;border-radius:12px;width:100%;max-width:600px;max-height:90vh;overflow-y:auto;}
.form-group{margin-bottom:10px;}
.form-group input, .form-group select, .form-group textarea{width:100%;padding:8px;border:1px solid #ccc;border-radius:8px;}
.form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:10px;}
.question-block{border:1px solid #ccc;padding:10px;margin:10px 0;border-radius:10px;}
</style>
</head>
<body>

<div class="navbar">
    <h2>Primary Quizzes</h2>
    <div>
        <a href="primary_lesson.php">Lessons</a>
        <a href="primary_books.php">Books</a>
        <a href="primary_quizzes.php">Quizzes</a>
        <a href="primary_assignments.php">Assignments</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<a href="primary.php" class="back-btn">⬅ Back to Dashboard</a>
<h2>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 📚</h2>

<!-- Add Quiz Button -->
<div style="margin:15px 0;">
    <button class="action-btn" onclick="openQuizForm()">➕ Add New Quiz</button>
</div>

<!-- Quizzes Grid -->
<div class="quizzes-grid" id="quizzesGrid">
<?php if(count($quizzes) > 0): foreach($quizzes as $quiz): 
    $status_class = $quiz['status'] === 'approved' ? 'status-approved' : 'status-pending';
    $bg_color = randomPastelColor(); // unique color for each card
?>
<div class="quiz-card" style="background: <?php echo $bg_color; ?>;">
    <h3>📝 <?php echo htmlspecialchars($quiz['title']); ?></h3>
    <span class="<?php echo $status_class; ?>">Status: <?php echo htmlspecialchars($quiz['status']); ?></span>
    <span>Created At: <?php echo $quiz['created_at']; ?></span>

    <?php if(!empty($quiz['questions'])): ?>
        <ul class="questions-list">
        <?php foreach($quiz['questions'] as $idx => $q): ?>
            <li>
                <strong>Q<?php echo $idx+1; ?>:</strong> <?php echo htmlspecialchars($q['question']); ?>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
<?php endforeach; else: ?>
<p>No quizzes found.</p>
<?php endif; ?>
</div>

<!-- Modal for Add Quiz -->
<div id="quizModal" class="modal-overlay">
<form id="quizForm" class="modal-form">
    <h2>📝 Create Quiz</h2>
    <div class="form-group">
        <label>Quiz Title</label>
        <input type="text" name="title" required>
    </div>

    <div id="questionsContainer"></div>
    <button type="button" class="action-btn" onclick="addQuestion()">➕ Add Question</button>

    <div class="form-actions">
        <button type="submit" class="action-btn">Submit Quiz</button>
        <button type="button" class="action-btn" onclick="closeQuizForm()">Cancel</button>
    </div>
</form>
</div>

<script>
let questionCount = 0;

function openQuizForm(){
    document.getElementById('quizModal').style.display='flex';
    if(questionCount===0) addQuestion();
}

function closeQuizForm(){
    document.getElementById('quizModal').style.display='none';
    document.getElementById('questionsContainer').innerHTML='';
    questionCount=0;
}

function addQuestion(){
    questionCount++;
    const container = document.getElementById('questionsContainer');
    const div = document.createElement('div');
    div.classList.add('question-block');
    div.dataset.qid = questionCount;
    div.innerHTML = `
        <div class="form-group"><label>Question ${questionCount}</label><input type="text" name="questions[${questionCount}][text]" required></div>
        <div class="form-group"><label>Option 1</label><input type="text" name="questions[${questionCount}][option1]" required></div>
        <div class="form-group"><label>Option 2</label><input type="text" name="questions[${questionCount}][option2]" required></div>
        <div class="form-group"><label>Option 3</label><input type="text" name="questions[${questionCount}][option3]" required></div>
        <div class="form-group"><label>Option 4</label><input type="text" name="questions[${questionCount}][option4]" required></div>
        <div class="form-group"><label>Correct Option (1-4)</label><input type="number" min="1" max="4" name="questions[${questionCount}][correct]" required></div>
        <button type="button" class="action-btn remove-question" onclick="removeQuestion(this)">Remove</button>
    `;
    container.appendChild(div);
}

function removeQuestion(btn){
    btn.closest('.question-block').remove();
}
</script>
</body>
</html>