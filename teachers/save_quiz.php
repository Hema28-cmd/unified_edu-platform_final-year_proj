<?php
session_start();
header('Content-Type: application/json');

/* Prevent PHP warnings from breaking JSON */
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

/* 🔐 Teacher-only access */
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher'){
    echo json_encode(['success'=>false,'message'=>'Unauthorized']);
    exit;
}

/* DB Connection */
$conn = new mysqli("localhost","root","","unified_edu");
if($conn->connect_error){
    echo json_encode(['success'=>false,'message'=>'DB connection failed']);
    exit;
}

/* Fetch POST data */
$title = trim($_POST['title'] ?? '');
$level = $_POST['level'] ?? 'primary';
$questions = $_POST['questions'] ?? [];

if(!$title || empty($questions)){
    echo json_encode(['success'=>false,'message'=>'All fields required']);
    exit;
}

/* Insert quiz into quizzes1 */
$stmt = $conn->prepare("INSERT INTO quizzes1 (title, level, created_by, status) VALUES (?, ?, ?, ?)");
$status = 'pending';
$created_by = (int)$_SESSION['user_id'];

if(!$stmt){
    echo json_encode(['success'=>false,'message'=>'Prepare failed: '.$conn->error]);
    exit;
}

$stmt->bind_param("ssis", $title, $level, $created_by, $status);

if(!$stmt->execute()){
    echo json_encode(['success'=>false,'message'=>'Failed to create quiz']);
    exit;
}

$quiz_id = $stmt->insert_id;
$stmt->close();

/* Insert questions into quiz_questions table if provided */
if(!empty($questions)){
    $q_stmt = $conn->prepare("INSERT INTO quiz_questions (quiz_id, question, option1, option2, option3, option4, correct_option) VALUES (?,?,?,?,?,?,?)");
    if(!$q_stmt){
        echo json_encode(['success'=>false,'message'=>'Prepare failed (quiz_questions): '.$conn->error]);
        exit;
    }

    foreach($questions as $q){
        $q_text = $q['text'] ?? '';
        $opt1 = $q['option1'] ?? '';
        $opt2 = $q['option2'] ?? '';
        $opt3 = $q['option3'] ?? '';
        $opt4 = $q['option4'] ?? '';
        $correct = (int)($q['correct'] ?? 1);

        $q_stmt->bind_param("isssssi", $quiz_id, $q_text, $opt1, $opt2, $opt3, $opt4, $correct);
        $q_stmt->execute();
    }
    $q_stmt->close();
}

/* Return JSON success */
echo json_encode(['success'=>true,'message'=>'Quiz created successfully!']);
exit;