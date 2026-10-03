<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "../../config/db.php";

/* SECURITY CHECK */
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_level'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['user_level'] != 'highschool') {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$level   = $_SESSION['user_level'];

if (!isset($_GET['quiz_id'])) {
    die("Quiz not found.");
}

$quiz_id = intval($_GET['quiz_id']);

/* CHECK QUIZ */
$quizStmt = $conn->prepare("SELECT * FROM quizzes WHERE id=? AND level=?");
$quizStmt->bind_param("is", $quiz_id, $level);
$quizStmt->execute();
$quizResult = $quizStmt->get_result();

if ($quizResult->num_rows == 0) {
    die("Invalid quiz.");
}

$quiz = $quizResult->fetch_assoc();

/* CHECK ATTEMPT */
$checkAttempt = $conn->prepare("SELECT id FROM quiz_attempts WHERE user_id=? AND quiz_id=?");
$checkAttempt->bind_param("ii", $user_id, $quiz_id);
$checkAttempt->execute();
$alreadyAttempted = $checkAttempt->get_result()->num_rows > 0;

/* HANDLE SUBMIT */
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$alreadyAttempted) {

    $score = 0;

    $questionStmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
    $questionStmt->bind_param("i", $quiz_id);
    $questionStmt->execute();
    $questions = $questionStmt->get_result();

    while ($question = $questions->fetch_assoc()) {

        $q_id = $question['id'];
        $correct = $question['correct_option'];
        $selected = $_POST['answer_'.$q_id] ?? 0;

        if ($selected == $correct) {
            $score++;
        }
    }

    $insert = $conn->prepare("INSERT INTO quiz_attempts (user_id, quiz_id, score) VALUES (?, ?, ?)");
    $insert->bind_param("iii", $user_id, $quiz_id, $score);
    $insert->execute();

    header("Location: take_quiz.php?quiz_id=".$quiz_id);
    exit;
}

/* LOAD QUESTIONS */
$questionStmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=?");
$questionStmt->bind_param("i", $quiz_id);
$questionStmt->execute();
$questions = $questionStmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $quiz['title']; ?></title>
<style>
/* ----------------- BODY ----------------- */
body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    padding: 20px;
    background: linear-gradient(135deg,#f0f4f8,#e0f7fa,#fff8e1);
}

/* ----------------- CONTAINER ----------------- */
.container {
    max-width: 900px;
    margin: auto;
    background: #ffffffdd;
    border-radius: 15px;
    padding: 40px 30px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
}

/* ----------------- HEADER ----------------- */
h2 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 40px;
    background: linear-gradient(90deg,#4f46e5,#3b82f6,#22c55e);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ----------------- QUIZ CARD ----------------- */
.question-card {
    background: #fdfdfd;
    border-left: 6px solid #3b82f6;
    margin-bottom: 25px;
    padding: 20px 25px;
    border-radius: 12px;
    transition: 0.3s;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
}
.question-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.12);
}

.question-card p strong {
    font-size: 18px;
    color: #1e293b;
}

/* ----------------- OPTIONS ----------------- */
.options label {
    display: block;
    margin: 8px 0;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: 0.2s;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
}
.options input[type="radio"] {
    margin-right: 10px;
}
.options label:hover {
    background: #e0f2fe;
}

/* ----------------- BUTTONS ----------------- */
button {
    padding: 12px 28px;
    background: linear-gradient(90deg,#22c55e,#3b82f6,#f97316);
    border:none;
    color:white;
    font-size:16px;
    font-weight:bold;
    border-radius:12px;
    cursor:pointer;
    transition: 0.3s;
    display:block;
    margin: 30px auto 0;
}
button:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

/* ----------------- SCORE DISPLAY ----------------- */
.result {
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-weight: bold;
    text-align: center;
    font-size: 18px;
    background: linear-gradient(135deg,#d1fae5,#bfdbfe);
    color: #065f46;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

/* Correct & wrong options for review */
.correct {
    color: #16a34a;
    font-weight: bold;
}
.wrong {
    color: #dc2626;
    font-weight: bold;
}

/* ----------------- BACK LINK ----------------- */
a.back-link {
    display:inline-block;
    margin-top:30px;
    text-decoration:none;
    font-weight:600;
    color:#1e3a8a;
    transition:0.2s;
}
a.back-link:hover { color:#2563eb; }
</style>
</head>
<body>

<div class="container">
<h2><?php echo $quiz['title']; ?></h2>

<?php if($alreadyAttempted): ?>

<?php
$scoreQuery = $conn->prepare("SELECT score FROM quiz_attempts WHERE user_id=? AND quiz_id=?");
$scoreQuery->bind_param("ii", $user_id, $quiz_id);
$scoreQuery->execute();
$scoreData = $scoreQuery->get_result()->fetch_assoc();
?>

<div class="result">
✅ Your Score: <?php echo $scoreData['score']; ?> / <?php echo $questions->num_rows; ?>
</div>

<?php
$questions->data_seek(0);
while($question = $questions->fetch_assoc()):
?>
<div class="question-card">
<p><strong><?php echo $question['question']; ?></strong></p>

<?php
$correct = $question['correct_option'];
$options = [
1 => $question['option1'],
2 => $question['option2'],
3 => $question['option3'],
4 => $question['option4']
];
foreach($options as $key => $text):
?>
<p class="<?php echo ($key == $correct) ? 'correct' : ''; ?>">
<?php echo $text; ?><?php if($key == $correct) echo " ✔"; ?>
</p>
<?php endforeach; ?>
</div>
<?php endwhile; ?>

<?php else: ?>

<form method="POST">
<?php while($question = $questions->fetch_assoc()): ?>
<div class="question-card">
<p><strong><?php echo $question['question']; ?></strong></p>
<div class="options">
<label><input type="radio" name="answer_<?php echo $question['id']; ?>" value="1"> <?php echo $question['option1']; ?></label>
<label><input type="radio" name="answer_<?php echo $question['id']; ?>" value="2"> <?php echo $question['option2']; ?></label>
<label><input type="radio" name="answer_<?php echo $question['id']; ?>" value="3"> <?php echo $question['option3']; ?></label>
<label><input type="radio" name="answer_<?php echo $question['id']; ?>" value="4"> <?php echo $question['option4']; ?></label>
</div>
</div>
<?php endwhile; ?>
<button type="submit">Submit Quiz</button>
</form>

<?php endif; ?>

<a href="../quizzes/highschool_quizzes.php" class="back-link">⬅ Back to Quizzes</a>
</div>
</body>
</html>