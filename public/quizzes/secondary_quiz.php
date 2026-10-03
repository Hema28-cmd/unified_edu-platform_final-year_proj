<?php
session_start();
require_once '../../config/db.php';

/* =============================
   AUTH CHECK
============================= */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['quiz_id'])) {
    die("Invalid quiz.");
}

$quiz_id = intval($_GET['quiz_id']);

/* =============================
   FETCH QUIZ DETAILS
============================= */
$stmt = $conn->prepare("
    SELECT * FROM quizzes 
    WHERE id = ? 
    AND level = 'secondary'
");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();

if (!$quiz) {
    die("Secondary quiz not found.");
}

/* =============================
   FETCH QUESTIONS
============================= */
$qstmt = $conn->prepare("
    SELECT * FROM quiz_questions 
    WHERE quiz_id = ?
");
$qstmt->bind_param("i", $quiz_id);
$qstmt->execute();
$questions = $qstmt->get_result();

if ($questions->num_rows == 0) {
    die("No questions available.");
}

/* =============================
   CHECK IF ALREADY ATTEMPTED
============================= */
$checkAttempt = $conn->prepare("
    SELECT * FROM quiz_attempts
    WHERE user_id = ? AND quiz_id = ?
    ORDER BY completed_at DESC
    LIMIT 1
");
$checkAttempt->bind_param("ii", $user_id, $quiz_id);
$checkAttempt->execute();
$attemptResult = $checkAttempt->get_result();

if ($attemptResult->num_rows > 0 && $_SERVER["REQUEST_METHOD"] != "POST") {

    $attemptData = $attemptResult->fetch_assoc();
    $previous_score = $attemptData['score'];
    $total = $questions->num_rows;
    $pass_mark = ceil($total * 0.5);
?>
<!DOCTYPE html>
<html>
<head>
<title>Quiz Result</title>
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#14b8a6,#f97316);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}
.result-card{
    background:white;
    width:700px;
    padding:40px;
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,0.2);
}
.pass{color:#16a34a;}
.fail{color:#dc2626;}
.question-review{
    margin-bottom:15px;
    padding:10px;
    border-left:4px solid #f97316;
    background:#f9fafb;
}
button{
    margin-top:20px;
    padding:12px 35px;
    border:none;
    border-radius:30px;
    background:#14b8a6;
    color:white;
    cursor:pointer;
}
a{text-decoration:none;}
</style>
</head>
<body>

<div class="result-card">
<h2>🎓 Quiz Already Completed</h2>

<h3>Score: <?php echo $previous_score; ?> / <?php echo $total; ?></h3>

<?php if($previous_score >= $pass_mark): ?>
    <p class="pass">✅ PASSED</p>
<?php else: ?>
    <p class="fail">❌ FAILED</p>
<?php endif; ?>

<hr><br>

<?php
$questions->data_seek(0);
$qno = 1;
while ($row = $questions->fetch_assoc()):
?>
<div class="question-review">
<strong>Q<?php echo $qno++; ?>. <?php echo $row['question']; ?></strong><br>
Correct Answer: <?php echo $row["option".$row['correct_option']]; ?>
</div>
<?php endwhile; ?>

<a href="secondary_quizzes.php">
<button>⬅ Back to Quizzes</button>
</a>

</div>
</body>
</html>
<?php
exit;
}

/* =============================
   HANDLE SUBMISSION
============================= */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $total = 0;
    $score = 0;
    $questions->data_seek(0);

    while ($row = $questions->fetch_assoc()) {
        $total++;
        $qid = $row['id'];

        if (isset($_POST['answer'][$qid]) &&
            $_POST['answer'][$qid] == $row['correct_option']) {
            $score++;
        }
    }

    $pass_mark = ceil($total * 0.5);

    $insert = $conn->prepare("
        INSERT INTO quiz_attempts 
        (user_id, quiz_id, score, completed_at)
        VALUES (?, ?, ?, NOW())
    ");
    $insert->bind_param("iii", $user_id, $quiz_id, $score);
    $insert->execute();
    $insert->close();

/* =============================
   UPDATE USER PROGRESS
============================= */

// Total quizzes in secondary
$totalQuizStmt = $conn->prepare("
SELECT COUNT(*) as total 
FROM quizzes 
WHERE level='secondary'
");
$totalQuizStmt->execute();
$totalQuiz = $totalQuizStmt->get_result()->fetch_assoc()['total'];


// Count passed quizzes
$passedStmt = $conn->prepare("
SELECT COUNT(DISTINCT qa.quiz_id) as passed
FROM quiz_attempts qa
WHERE qa.user_id = ?
AND qa.score >= (
    SELECT CEIL(COUNT(*) * 0.5)
    FROM quiz_questions
    WHERE quiz_id = qa.quiz_id
)
");
$passedStmt->bind_param("i", $user_id);
$passedStmt->execute();
$passedQuiz = $passedStmt->get_result()->fetch_assoc()['passed'];


// Check if progress row exists
$check = $conn->prepare("
SELECT id FROM user_progress
WHERE user_id=? AND level='secondary'
");
$check->bind_param("i",$user_id);
$check->execute();
$res = $check->get_result();

if($res->num_rows > 0){

    // Update progress
    $unlock = ($passedQuiz >= $totalQuiz) ? 1 : 0;

    $update = $conn->prepare("
    UPDATE user_progress
    SET quizzes_completed=?, certificate_unlocked=?
    WHERE user_id=? AND level='secondary'
    ");
    $update->bind_param("iii",$passedQuiz,$unlock,$user_id);
    $update->execute();

}else{

    // Insert progress row
    $unlock = ($passedQuiz >= $totalQuiz) ? 1 : 0;

    $insertProgress = $conn->prepare("
    INSERT INTO user_progress
    (user_id, level, quizzes_completed, certificate_unlocked)
    VALUES (?, 'secondary', ?, ?)
    ");
    $insertProgress->bind_param("iii",$user_id,$passedQuiz,$unlock);
    $insertProgress->execute();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Quiz Result</title>
<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#14b8a6,#f97316);
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.result-card{
    background:white;
    width:450px;
    padding:40px;
    border-radius:20px;
    text-align:center;
}
.pass{color:#16a34a;}
.fail{color:#dc2626;}
button{
    margin-top:20px;
    padding:12px 35px;
    border:none;
    border-radius:30px;
    background:#14b8a6;
    color:white;
    cursor:pointer;
}
a{text-decoration:none;}
</style>
</head>
<body>

<div class="result-card">
<h2>🎓 Quiz Result</h2>
<h3>Score: <?php echo $score; ?> / <?php echo $total; ?></h3>

<?php if ($score >= $pass_mark): ?>
    <p class="pass">✅ PASSED</p>
<?php else: ?>
    <p class="fail">❌ FAILED</p>
<?php endif; ?>

<a href="secondary_quizzes.php">
<button>⬅ Back to Quizzes</button>
</a>

</div>
</body>
</html>
<?php
exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo htmlspecialchars($quiz['title']); ?></title>
<style>
body{font-family:'Segoe UI',sans-serif;background:#f0fdfa;}
.container{max-width:900px;margin:40px auto;}
.question-card{
    background:white;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}
.option{display:block;margin:10px 0;}
.submit-btn{
    display:block;
    margin:30px auto;
    padding:12px 40px;
    border:none;
    border-radius:30px;
    background:#f97316;
    color:white;
    cursor:pointer;
}
</style>
</head>
<body>

<div class="container">
<h2><?php echo htmlspecialchars($quiz['title']); ?></h2>
<p>Total Questions: <?php echo $questions->num_rows; ?></p>

<form method="POST">

<?php
$questions->data_seek(0);
$qno = 1;
while ($row = $questions->fetch_assoc()):
?>
<div class="question-card">
<strong>Q<?php echo $qno++; ?>. <?php echo $row['question']; ?></strong>

<?php for($i=1;$i<=4;$i++): ?>
<label class="option">
<input type="radio"
name="answer[<?php echo $row['id']; ?>]"
value="<?php echo $i; ?>" required>
<?php echo $row["option".$i]; ?>
</label>
<?php endfor; ?>

</div>
<?php endwhile; ?>

<button type="submit" class="submit-btn">Submit Quiz</button>
</form>
</div>

</body>
</html>