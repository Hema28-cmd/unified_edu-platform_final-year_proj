<?php
session_start();
include "../config/db.php";

if($_SESSION['user_role']!=='teacher') exit;

$stmt=$conn->prepare("
INSERT INTO primary_lessons
(title,description,icon,color,created_by)
VALUES(?,?,?,?,?)
");

$stmt->bind_param(
"ssssi",
$_POST['title'],
$_POST['description'],
$_POST['icon'],
$_POST['color'],
$_SESSION['user_id']
);
$stmt->execute();

/* Notify admin */
$conn->query("
INSERT INTO admin_notifications(message,link)
VALUES('New Primary Lesson Submitted','admin/lesson_approval.php')
");

header("Location: ../teachers/primary_lesson.php");
