<?php
session_start();
require_once "../config/db.php";

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){
echo json_encode(["message"=>"Unauthorized"]);
exit;
}

$title=$_POST['title'] ?? '';
$description=$_POST['description'] ?? '';
$domain=$_POST['domain'] ?? '';
$level="secondary";

$teacher_id=$_SESSION['user_id'];

$stmt=$conn->prepare("
INSERT INTO project_topics
(title,description,level,domain,created_by_role,created_by)
VALUES (?,?,?,?, 'teacher',?)
");

$stmt->bind_param("ssssi",$title,$description,$level,$domain,$teacher_id);

if($stmt->execute()){
echo json_encode(["message"=>"Project submitted for admin approval"]);
}else{
echo json_encode(["message"=>"Error creating project"]);
}