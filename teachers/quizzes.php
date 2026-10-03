<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

require_once "../config/db.php";

$teacher_id = $_SESSION['user_id'];

/* FETCH APPROVED QUIZZES */
$sql_available = "SELECT id, title, subject, class, total_questions, created_by_role 
                  FROM quizzes 
                  WHERE level='kindergarten'
                  ORDER BY id DESC";
$result_available = $conn->query($sql_available);

/* FETCH NEW QUIZZES */
$sql_new = "SELECT id, title, status 
            FROM quizzes1 
            WHERE level='kindergarten' 
            AND created_by=? 
            ORDER BY id DESC";
$stmt = $conn->prepare($sql_new);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result_new = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Kindergarten Quizzes</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#fdf2f8,#e0f7fa);
    padding:0;
    margin:0;
}

/* NAVBAR */
.navbar{
    background:#1e293b;
    padding:15px 30px;
    color:white;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.navbar a{
    color:white;
    text-decoration:none;
    margin-left:20px;
    font-weight:500;
}

/* HEADER */
.header{
    background:linear-gradient(90deg,#06b6d4,#3b82f6);
    color:white;
    padding:40px;
    text-align:center;
}

.container{
    padding:40px;
}

.section-title{
    margin-top:50px;
    font-size:24px;
    font-weight:600;
}

/* GRID */
.grid{
    margin-top:25px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.card{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.card h3{
    color:#0ea5e9;
}

/* BADGES */
.badge{
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
    margin-top:10px;
}

.pending{ background:#fef3c7; color:#92400e; }
.approved{ background:#dcfce7; color:#166534; }
.rejected{ background:#fee2e2; color:#991b1b; }

/* INFO BOX */
.info-box{
    margin-top:30px;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.info-box h3{
    margin-bottom:15px;
    color:#15803d;
}

.info-box ul{
    line-height:1.8;
}

/* BUTTON */
.btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:linear-gradient(90deg,#f97316,#f43f5e);
    color:white;
    text-decoration:none;
    border-radius:25px;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div><strong>Teacher Panel</strong></div>
    <div>
        <a href="kindergarten.php">Dashboard</a>
        <a href="add_quiz.php">Add Quiz</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<!-- HEADER -->
<div class="header">
    <h1>📝 Kindergarten Quiz Management</h1>
    <p>Create, monitor, and manage quizzes effectively</p>
</div>

<div class="container">

<!-- GENERAL INSTRUCTIONS -->
<div class="info-box">
    <h3>📘 General Instructions</h3>
    <ul>
        <li>Create quizzes suitable for kindergarten understanding level.</li>
        <li>Use simple language and colorful visual-based questions.</li>
        <li>Each quiz should focus on one topic (Colors, Numbers, Shapes, etc.).</li>
        <li>Keep question count small (5–10 questions recommended).</li>
        <li>Ensure content is child-friendly and easy to understand.</li>
    </ul>
</div>

<!-- TEACHING TIPS -->
<div class="info-box">
    <h3>💡 Teaching Tips & Tricks</h3>
    <ul>
        <li>Conduct quizzes as interactive games.</li>
        <li>Encourage every child to participate actively.</li>
        <li>Appreciate effort rather than focusing on marks.</li>
        <li>Use pictures, objects, and gestures while teaching.</li>
        <li>Repeat key concepts to improve retention.</li>
    </ul>
</div>

<!-- WORKFLOW INFO -->
<div class="info-box">
    <h3>🔄 Quiz Approval Workflow</h3>
    <ul>
        <li>Newly created quizzes are stored in <strong>quizzes1</strong> table.</li>
        <li>Status will be <strong>Pending</strong> until admin reviews.</li>
        <li>After approval, quiz is moved to <strong>quizzes</strong> table.</li>
        <li>Approved quizzes appear in the "Available Quizzes" section.</li>
        <li>Rejected quizzes can be edited and resubmitted.</li>
    </ul>
</div>

<!-- AVAILABLE QUIZZES -->
<div class="section-title">✅ Available Quizzes</div>
<div class="grid">
<?php if ($result_available->num_rows == 0): ?>
    <p>No approved quizzes available.</p>
<?php endif; ?>

<?php while($row = $result_available->fetch_assoc()): 

    // Fetch questions for this quiz
    $quiz_id = $row['id'];
    $q_stmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
    $q_stmt->bind_param("i", $quiz_id);
    $q_stmt->execute();
    $q_result = $q_stmt->get_result();

    $questions = [];
    while($q = $q_result->fetch_assoc()){
        $questions[] = $q;
    }

?>
<div class="card" onclick='openQuiz(<?php echo json_encode($questions); ?>)' style="cursor:pointer;">
    <h3><?= htmlspecialchars($row['title']) ?></h3>
    <p><strong>Subject:</strong> <?= htmlspecialchars($row['subject']) ?></p>
    <p><strong>Class:</strong> <?= htmlspecialchars($row['class']) ?></p>
    <p><strong>Total Questions:</strong> <?= $row['total_questions'] ?></p>
</div>
<?php endwhile; ?>
</div>

<!-- NEWLY CREATED QUIZZES -->
<div class="section-title">🆕 Your Newly Created Quizzes</div>
<div class="grid">
<?php if ($result_new->num_rows == 0): ?>
    <p>No new quizzes created yet.</p>
<?php endif; ?>

<?php while($row = $result_new->fetch_assoc()): ?>
<div class="card" onclick="loadQuiz(<?= $row['id'] ?>)" style="cursor:pointer;">
    <h3><?= htmlspecialchars($row['title']) ?></h3>

    <?php if ($row['status'] == 'pending'): ?>
        <span class="badge pending">⏳ Pending Approval</span>
    <?php elseif ($row['status'] == 'approved'): ?>
        <span class="badge approved">✅ Approved</span>
    <?php else: ?>
        <span class="badge rejected">❌ Rejected</span>
    <?php endif; ?>
</div>
<?php endwhile; ?>
</div>

<a href="kindergarten.php" class="btn">⬅ Back to Dashboard</a>

</div>

<!-- 📋 QUIZ MODAL -->
<div id="quizModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.6);">
    <div style="background:white; width:70%; max-height:80%; overflow:auto; margin:5% auto; padding:25px; border-radius:15px;">
        
        <h2>📝 Quiz Questions</h2>
        <div id="quizContent"></div>

        <button onclick="closeModal()" style="margin-top:20px;">Close</button>
    </div>
</div>

<script>
function openQuiz(questions){

    let html = "";

    if(questions.length === 0){
        html = "<p>No questions available</p>";
    } else {

        questions.forEach((q, index) => {
            html += `
                <div style="margin-bottom:15px;">
                    <strong>Q${index+1}. ${q.question}</strong><br>
                    A. ${q.option1}<br>
                    B. ${q.option2}<br>
                    C. ${q.option3}<br>
                    D. ${q.option4}<br>
                    <span style="color:green;">✔ Answer: ${q.correct_answer}</span>
                </div>
            `;
        });
    }

    document.getElementById("quizContent").innerHTML = html;
    document.getElementById("quizModal").style.display = "block";
}

function closeModal(){
    document.getElementById("quizModal").style.display = "none";
}
</script>

</body>
</html>