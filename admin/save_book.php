<?php
session_start();
include "../config/db.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    echo json_encode([
        "success" => false,
        "message" => "Unauthorized access"
    ]);
    exit;
}

$teacher_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $level = "primary"; // ✅ dynamically set
    $status = "pending"; // default status

    if (empty($title) || empty($description)) {
        echo json_encode([
            "success" => false,
            "message" => "All fields are required"
        ]);
        exit;
    }

    if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] != 0) {
        echo json_encode([
            "success" => false,
            "message" => "PDF upload failed"
        ]);
        exit;
    }

    $fileName = time() . "_" . basename($_FILES["pdf_file"]["name"]);
    $targetDir = "../uploads/books/";
    $targetFile = $targetDir . $fileName;

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (move_uploaded_file($_FILES["pdf_file"]["tmp_name"], $targetFile)) {

        $stmt = $conn->prepare("
            INSERT INTO books (title, description, pdf_file, level, status, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param(
            "sssssi",
            $title,
            $description,
            $fileName,
            $level,
            $status,
            $teacher_id
        );

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Book uploaded successfully!"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Database insert failed"
            ]);
        }

        $stmt->close();

    } else {
        echo json_encode([
            "success" => false,
            "message" => "File move failed"
        ]);
    }
}
?>