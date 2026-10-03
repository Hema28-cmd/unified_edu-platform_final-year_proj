<?php

session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){
echo json_encode(["message"=>"Unauthorized"]);
exit;
}

$title = $_POST['title'];
$level = $_POST['level'];
$teacher_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO quizzes1 (title, level, created_by, status) VALUES (?, ?, ?, 'pending')");
$stmt->bind_param("ssi",$title,$level,$teacher_id);

if($stmt->execute()){
echo json_encode(["message"=>"Quiz submitted for approval"]);
}else{
echo json_encode(["message"=>"Failed to add quiz"]);
}

?>