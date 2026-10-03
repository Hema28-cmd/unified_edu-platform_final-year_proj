<?php
session_start();
require_once "../config/db.php";

if($_SESSION['user_role']!=='admin'){ exit; }

if(isset($_GET['id'],$_GET['action'])){
    $stmt=$conn->prepare("UPDATE books SET status=? WHERE id=?");
    $stmt->bind_param("si",$_GET['action'],$_GET['id']);
    $stmt->execute();
}

$books=$conn->query("SELECT * FROM books WHERE status='pending'");
?>
<h2>Pending Book Approvals</h2>
<?php while($b=$books->fetch_assoc()): ?>
    <p><b><?php echo $b['title']; ?></b></p>
    <a href="?action=approved&id=<?php echo $b['id']; ?>">Approve</a> |
    <a href="?action=rejected&id=<?php echo $b['id']; ?>">Reject</a>
    <hr>
<?php endwhile; ?>
