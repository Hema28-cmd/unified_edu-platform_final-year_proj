<?php
session_start();
include "../config/db.php";

if($_SESSION['user_role']!=='admin') exit;

if(isset($_GET['action'],$_GET['id'])){
    $id=(int)$_GET['id'];
    $status=$_GET['action']=='approve'?'approved':'rejected';
    $conn->query("UPDATE primary_lessons SET status='$status' WHERE id=$id");
}

$lessons=$conn->query("SELECT * FROM primary_lessons WHERE status='pending'");
?>

<h2>📌 Pending Lessons</h2>
<?php while($l=$lessons->fetch_assoc()): ?>
<div style="background:#fff;padding:15px;margin:10px;border-radius:10px">
<strong><?php echo $l['title']; ?></strong>
<p><?php echo $l['description']; ?></p>
<a href="?action=approve&id=<?php echo $l['id']; ?>">✅ Approve</a>
<a href="?action=reject&id=<?php echo $l['id']; ?>">❌ Reject</a>
</div>
<?php endwhile; ?>
