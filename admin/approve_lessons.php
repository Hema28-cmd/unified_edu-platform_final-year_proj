<?php
session_start();
require_once "../config/db.php";

// Only admin
if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin'){
    header("Location: ../public/login.php");
    exit;
}

// Approve / Reject action
if(isset($_GET['action'], $_GET['id'])){
    $id = (int)$_GET['id'];
    $action = $_GET['action'];

    if(in_array($action, ['approved','rejected'])){
        $stmt = $conn->prepare("UPDATE lessons SET status=? WHERE id=?");
        $stmt->bind_param("si", $action, $id);
        $stmt->execute();
    }
}

// Fetch all pending lessons
$result = $conn->query(
    "SELECT lessons.*, users.name 
     FROM lessons 
     JOIN users ON lessons.created_by = users.id
     WHERE lessons.status='pending'
     ORDER BY lessons.created_at DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin | Lesson Approval</title>
<style>
body{font-family:Segoe UI; background:#f3f4f6; padding:30px;}
.card{background:#fff; padding:20px; border-radius:16px; margin-bottom:20px;}
.btn{padding:8px 16px; text-decoration:none; border-radius:20px; color:#fff;}
.approve{background:#16a34a;}
.reject{background:#dc2626;}
</style>
</head>

<body>
<h1>📚 Pending Lesson Approvals</h1>

<?php if($result->num_rows === 0): ?>
    <p>No pending lessons 🎉</p>
<?php endif; ?>

<?php while($row = $result->fetch_assoc()): ?>
<div class="card">
    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
    <p><?php echo htmlspecialchars($row['description']); ?></p>
    <p><strong>Teacher:</strong> <?php echo htmlspecialchars($row['name']); ?></p>

    <a class="btn approve" href="?action=approved&id=<?php echo $row['id']; ?>">Approve</a>
    <a class="btn reject" href="?action=rejected&id=<?php echo $row['id']; ?>">Reject</a>
</div>
<?php endwhile; ?>

</body>
</html>
