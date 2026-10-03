<?php
session_start();
require_once "../config/db.php";

/* 🔐 Only Kindergarten users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: quizzes.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$quiz_id = intval($_POST['quiz_id']);
$answers = $_POST['answer'] ?? [];

$score = 0;

/* 1️⃣ Calculate Score */
$stmt = $conn->prepare("SELECT id, correct_option FROM quiz_questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $question_id = $row['id'];
    $correct_option = $row['correct_option'];

    if (isset($answers[$question_id]) && $answers[$question_id] == $correct_option) {
        $score++;
    }
}

/* 2️⃣ Check if already attempted */
$check_stmt = $conn->prepare("SELECT id FROM quiz_attempts WHERE user_id = ? AND quiz_id = ?");
$check_stmt->bind_param("ii", $user_id, $quiz_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows == 0) {

    /* 3️⃣ Insert attempt */
    $insert_stmt = $conn->prepare("
        INSERT INTO quiz_attempts (user_id, quiz_id, score)
        VALUES (?, ?, ?)
    ");
    $insert_stmt->bind_param("iii", $user_id, $quiz_id, $score);
    $insert_stmt->execute();

    /* 4️⃣ Count total kindergarten quizzes */
    $totalQuizStmt = $conn->prepare("
        SELECT COUNT(*) as total_quiz 
        FROM quizzes 
        WHERE level = 'kindergarten'
    ");
    $totalQuizStmt->execute();
    $totalQuiz = $totalQuizStmt->get_result()->fetch_assoc()['total_quiz'];

    /* 5️⃣ Count quizzes completed by user */
    $completedStmt = $conn->prepare("
        SELECT COUNT(*) as completed 
        FROM quiz_attempts 
        WHERE user_id = ?
    ");
    $completedStmt->bind_param("i", $user_id);
    $completedStmt->execute();
    $completed = $completedStmt->get_result()->fetch_assoc()['completed'];

    /* 6️⃣ Check certificate unlock */
    $certificateUnlocked = 0;
    if ($completed == $totalQuiz && $totalQuiz > 0) {
        $certificateUnlocked = 1;
    }

    /* 7️⃣ Update or Insert into user_progress */
    $progressCheck = $conn->prepare("SELECT id FROM user_progress WHERE user_id = ? AND level = 'kindergarten'");
    $progressCheck->bind_param("i", $user_id);
    $progressCheck->execute();
    $progressResult = $progressCheck->get_result();

    if ($progressResult->num_rows == 0) {
        /* Insert new progress row */
        $insertProgress = $conn->prepare("
            INSERT INTO user_progress (user_id, level, quizzes_completed, certificate_unlocked)
            VALUES (?, 'kindergarten', ?, ?)
        ");
        $insertProgress->bind_param("iii", $user_id, $completed, $certificateUnlocked);
        $insertProgress->execute();
    } else {
        /* Update existing row */
        $updateProgress = $conn->prepare("
            UPDATE user_progress 
            SET quizzes_completed = ?, certificate_unlocked = ?
            WHERE user_id = ? AND level = 'kindergarten'
        ");
        $updateProgress->bind_param("iii", $completed, $certificateUnlocked, $user_id);
        $updateProgress->execute();
    }
}

/* 8️⃣ Redirect with success message */
header("Location: quizzes.php?completed=1&score=$score");
exit;