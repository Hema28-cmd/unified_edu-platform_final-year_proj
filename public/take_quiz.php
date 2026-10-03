<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once "../config/db.php";

/* 🔐 Student login required */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* 🔎 Get quiz id */
if (!isset($_GET['quiz_id']) || !is_numeric($_GET['quiz_id'])) {
    die("Invalid Quiz");
}
$quiz_id = (int)$_GET['quiz_id'];

/* 🚫 Prevent re-attempt */
$check = $conn->prepare(
    "SELECT id FROM quiz_attempts WHERE user_id = ? AND quiz_id = ?"
);
$check->bind_param("ii", $user_id, $quiz_id);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    echo "<h2 style='text-align:center;color:red;'>⚠ You already attempted this quiz.</h2>";
    exit;
}

/* 📘 Fetch quiz details */
$quizStmt = $conn->prepare(
    "SELECT title, subject FROM quizzes WHERE id = ?"
);
$quizStmt->bind_param("i", $quiz_id);
$quizStmt->execute();
$quiz = $quizStmt->get_result()->fetch_assoc();

if (!$quiz) {
    die("Quiz not found");
}

/* ❓ Fetch questions */
$qStmt = $conn->prepare(
    "SELECT * FROM quiz_questions WHERE quiz_id = ?"
);
$qStmt->bind_param("i", $quiz_id);
$qStmt->execute();
$questions = $qStmt->get_result();

/* 📝 Submit quiz */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $score = 0;
    $total = $questions->num_rows;

    foreach ($questions as $q) {
        $qid = $q['id'];
        $correct = $q['correct_option'];
        $answer = $_POST['q'][$qid] ?? 0;

        if ($answer == $correct) {
            $score++;
        }
    }

    $percentage = round(($score / $total) * 100);

    /* 💾 Save attempt */
    $save = $conn->prepare(
        "INSERT INTO quiz_attempts (user_id, quiz_id, score, percentage)
         VALUES (?, ?, ?, ?)"
    );
    $save->bind_param("iiii", $user_id, $quiz_id, $score, $percentage);
    $save->execute();

    /* 🎓 Update progress */
    if ($percentage >= 50) {

    // 1️⃣ Increment completed quizzes
    $conn->query(
        "UPDATE user_progress 
         SET quizzes_completed = quizzes_completed + 1 
         WHERE user_id = $user_id AND level = '{$_SESSION['user_level']}'"
    );

    // 2️⃣ Count total approved quizzes for this level
    $totalQuizStmt = $conn->prepare(
        "SELECT COUNT(*) AS total 
         FROM quizzes q
         JOIN admin_quizzes aq ON aq.id = q.admin_quiz_id
         WHERE q.level = ? AND aq.status = 'approved'"
    );
    $totalQuizStmt->bind_param("s", $_SESSION['user_level']);
    $totalQuizStmt->execute();
    $totalQuizzes = $totalQuizStmt->get_result()->fetch_assoc()['total'];

    // 3️⃣ Get completed quizzes
    $progressStmt = $conn->prepare(
        "SELECT quizzes_completed 
         FROM user_progress 
         WHERE user_id = ? AND level = ?"
    );
    $progressStmt->bind_param("is", $user_id, $_SESSION['user_level']);
    $progressStmt->execute();
    $completed = $progressStmt->get_result()->fetch_assoc()['quizzes_completed'];

    // 4️⃣ Unlock certificate if all quizzes completed
    if ($completed >= $totalQuizzes) {
        $conn->query(
            "UPDATE user_progress 
             SET certificate_unlocked = 1 
             WHERE user_id = $user_id AND level = '{$_SESSION['user_level']}'"
        );
    }
}


    echo "
    <div style='text-align:center;padding:60px;font-family:Arial;'>
        <h1>🎉 Quiz Completed!</h1>
        <h2>Score: $score / $total</h2>
        <h3>Percentage: $percentage%</h3>
        <a href='kindergarten.php'>
            <button style='padding:12px 25px;
            background:#22c55e;color:white;
            border:none;border-radius:30px;
            font-size:16px;'>⬅ Back to Dashboard</button>
        </a>
    </div>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= htmlspecialchars($quiz['title']) ?></title>

<style>
body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:linear-gradient(135deg,#fdf2f8,#ecfeff);
}

.container{
    max-width:900px;
    margin:40px auto;
    background:white;
    border-radius:20px;
    padding:30px;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

.header{
    text-align:center;
    background:linear-gradient(90deg,#6366f1,#22c55e);
    color:white;
    padding:20px;
    border-radius:15px;
}

.question{
    background:#f0fdf4;
    padding:20px;
    border-radius:15px;
    margin:20px 0;
}

.question h3{
    margin-bottom:15px;
}

.options label{
    display:block;
    background:#e0f2fe;
    padding:12px;
    border-radius:10px;
    margin-bottom:10px;
    cursor:pointer;
}

.options input{
    margin-right:10px;
}

.submit-btn{
    display:block;
    margin:30px auto 0;
    padding:15px 40px;
    background:#6366f1;
    color:white;
    border:none;
    border-radius:35px;
    font-size:18px;
    cursor:pointer;
}

.submit-btn:hover{
    background:#4f46e5;
}
</style>
</head>

<body>

<div class="container">

<div class="header">
    <h1><?= htmlspecialchars($quiz['title']) ?></h1>
    <p>📚 Subject: <?= htmlspecialchars($quiz['subject']) ?></p>
</div>

<form method="POST">

<?php foreach ($questions as $index => $q): ?>
<div class="question">
    <h3>Q<?= $index+1 ?>. <?= htmlspecialchars($q['question']) ?></h3>

    <div class="options">
        <?php for ($i=1; $i<=4; $i++): ?>
        <label>
            <input type="radio" name="q[<?= $q['id'] ?>]" value="<?= $i ?>" required>
            <?= htmlspecialchars($q["option$i"]) ?>
        </label>
        <?php endfor; ?>
    </div>
</div>
<?php endforeach; ?>

<button type="submit" class="submit-btn">✅ Submit Quiz</button>

</form>
</div>

</body>
</html>
