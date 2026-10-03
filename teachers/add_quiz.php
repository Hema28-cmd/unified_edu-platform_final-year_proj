<?php
session_start();
require_once "../config/db.php";

/* Auth check */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

if (isset($_POST['save_quiz'])) {

    $title      = trim($_POST['title']);
    $teacher_id = $_SESSION['user_id'];
    $level      = 'kindergarten';

    /* Insert quiz */
    $quiz_sql = "INSERT INTO quizzes1 (title, level, created_by, status)
                 VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($quiz_sql);
    if (!$stmt) {
        die("Quiz Prepare Failed: " . $conn->error);
    }

    $stmt->bind_param("ssi", $title, $level, $teacher_id);
    $stmt->execute();
    $quiz_id = $stmt->insert_id;
    $stmt->close();

    /* Insert questions (MULTIPLE) */
    $question_sql = "INSERT INTO quiz_questions
        (quiz_id, question, option1, option2, option3, option4, correct_option)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($question_sql);
    if (!$stmt) {
        die("Question Prepare Failed: " . $conn->error);
    }

    foreach ($_POST['questions'] as $q) {
        $stmt->bind_param(
            "isssssi",
            $quiz_id,
            $q['question'],
            $q['opt1'],
            $q['opt2'],
            $q['opt3'],
            $q['opt4'],
            $q['correct']
        );
        $stmt->execute();
    }
    $stmt->close();

    /* Notify admin */
    $msg  = "New Kindergarten Quiz Added: $title (Pending Approval)";
    $link = "approve_quizzes.php";

    $notify_sql = "INSERT INTO admin_notifications (message, link)
                   VALUES (?, ?)";
    $stmt = $conn->prepare($notify_sql);
    if ($stmt) {
        $stmt->bind_param("ss", $msg, $link);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>alert('Quiz submitted for admin approval!');
          window.location.href='quizzes.php';</script>";
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Add Quiz</title>
<style>
body{font-family:Segoe UI;background:#f1f5f9;padding:40px;}
.box{max-width:800px;margin:auto;background:#fff;padding:30px;border-radius:20px;}
.question-box{border:1px dashed #ccc;padding:20px;border-radius:15px;margin-bottom:20px;}
input,textarea,select{width:100%;padding:10px;margin-bottom:10px;}
button{padding:12px 24px;border:none;border-radius:25px;}
.add-btn{background:#3b82f6;color:#fff;}
.remove-btn{background:#ef4444;color:#fff;margin-top:10px;}
.submit-btn{background:#22c55e;color:#fff;width:100%;margin-top:20px;}
</style>

<script>
function addQuestion(){
    const container = document.getElementById("questions");
    const index = container.children.length;

    const html = `
    <div class="question-box">
        <h4>Question ${index + 1}</h4>

        <textarea name="questions[${index}][question]" required></textarea>

        <input name="questions[${index}][opt1]" placeholder="Option 1" required>
        <input name="questions[${index}][opt2]" placeholder="Option 2" required>
        <input name="questions[${index}][opt3]" placeholder="Option 3" required>
        <input name="questions[${index}][opt4]" placeholder="Option 4" required>

        <select name="questions[${index}][correct]" required>
            <option value="">Correct Option</option>
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
            <option value="4">Option 4</option>
        </select>

        <button type="button" class="remove-btn" onclick="this.parentElement.remove()">Remove</button>
    </div>`;
    container.insertAdjacentHTML("beforeend", html);
}
</script>
</head>

<body>
<div class="box">
<h2>📝 Create Quiz</h2>

<form method="POST">
    <input name="title" placeholder="Quiz Title" required>

    <div id="questions"></div>

    <button type="button" class="add-btn" onclick="addQuestion()">➕ Add Question</button>

    <button name="save_quiz" class="submit-btn">Submit Quiz</button>
</form>
</div>

<script>addQuestion();</script>
</body>
</html>
