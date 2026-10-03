<?php
session_start();
require_once "../config/db.php";

/* 🔐 Only teacher can submit */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

/* ✅ Check form submission */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $level = trim($_POST['level']);
    $category = "Primary";
    $status = "pending";
    $created_by = (int)$_SESSION['user_id'];

    if (!empty($title) && !empty($description) && !empty($level)) {

        $stmt = $conn->prepare("
            INSERT INTO lessons (title, description, level, category, status, created_by, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param("sssssi",
            $title,
            $description,
            $level,
            $category,
            $status,
            $created_by
        );

        if ($stmt->execute()) {
            header("Location: ../teacher/primary_lesson.php?success=1");
            exit;
        } else {
            echo "Database Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required.";
    }
}
?>