<?php
session_start();
include "../config/db.php";

$book_id=(int)($_GET['book_id']??0);
$action=$_GET['action']??'';

if(!$book_id || !in_array($action,['approve','reject'])) die("Invalid request");

$res=$conn->query("SELECT * FROM books WHERE id=$book_id");
$book=$res->fetch_assoc();
if(!$book) die("Book not found");

$new_status=$action==='approve'?'approved':'rejected';
$conn->query("UPDATE books SET status='$new_status' WHERE id=$book_id");

// Notify teacher
$teacher_id=$book['created_by'];
$msg="Your book '{$book['title']}' has been $new_status by the admin.";
$notif_stmt=$conn->prepare("INSERT INTO notifications (user_id,book_id,type,message) VALUES (?,?, 'approval_result',?)");
$notif_stmt->bind_param("iis",$teacher_id,$book_id,$msg);
$notif_stmt->execute();
$notif_stmt->close();

header("Location: admin_dashboard.php");
?>
