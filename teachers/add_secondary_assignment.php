<?php

session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){
echo json_encode(["message"=>"Unauthorized"]);
exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$subject = $_POST['subject'];
$teacher_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO assignments (title, description, subject, created_by, status) VALUES (?, ?, ?, ?, 'pending')");
$stmt->bind_param("sssi",$title,$description,$subject,$teacher_id);

if($stmt->execute()){
echo json_encode(["message"=>"Assignment submitted for approval"]);
}else{
echo json_encode(["message"=>"Failed to add assignment"]);
}

?>