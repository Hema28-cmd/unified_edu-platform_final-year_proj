<?php
session_start();
require_once "../config/db.php";

header('Content-Type: application/json');

if(!isset($_SESSION['user_id'])){
    echo json_encode(["status"=>"error","message"=>"Login required"]);
    exit;
}

$title = $_POST['title'];
$category = $_POST['category'];
$author = $_POST['author'];
$description = $_POST['description'];

$level = "secondary";
$status = "pending"; // ✅ now pending
$created_by = $_SESSION['user_id'];

$pdf_name = $_FILES['pdf_file']['name'];
$pdf_tmp = $_FILES['pdf_file']['tmp_name'];

$upload_folder = "../uploads/books/";
if(!is_dir($upload_folder)){
    mkdir($upload_folder,0777,true);
}

$pdf_path = $upload_folder . time() . "_" . $pdf_name;

move_uploaded_file($pdf_tmp,$pdf_path);

$stmt = $conn->prepare("INSERT INTO books 
(title, category, author, level, description, pdf_file, status, created_by, created_at)
VALUES (?,?,?,?,?,?,?,?,NOW())");

$stmt->bind_param(
"ssssssss",
$title,
$category,
$author,
$level,
$description,
$pdf_path,
$status,
$created_by
);

if($stmt->execute()){
    echo json_encode([
        "status"=>"success",
        "message"=>"Book submitted for approval (Pending)"
    ]);
}else{
    echo json_encode([
        "status"=>"error",
        "message"=>"Database error"
    ]);
}
?>