<?php
session_start();
require_once "../config/db.php";

if($_SESSION['user_role'] !== 'admin'){
    header("Location: ../public/login.php");
    exit;
}

if(isset($_GET['id'],$_GET['action'])){
    $stmt = $conn->prepare(
        "UPDATE quizzes SET status=? WHERE id=?"
    );
    $stmt->bind_param("si", $_GET['action'], $_GET['id']);
    $stmt->execute();
}

$result = $conn->query(
    "SELECT quizzes.*, users.name 
     FROM quizzes JOIN users ON quizzes.created_by=users.id
     WHERE status='pending'"
);
?>
<!DOCTYPE html>
<html>
<head>
<title>Approve Quizzes</title>
<style>
body{font-family:Segoe UI;padding:40px;background:#f8fafc;}
.card{background:#fff;padding:20px;margin-bottom:20px;border-radius:16px;}
a{padding:8px 16px;border-radius:20px;color:#fff;text-decoration:none;}
.ap{background:#16a34a;}
.re{background:#dc2626;}
</style>
</head>
<body>

<h1>🧠 Quiz Approvals</h1>

<?php while($q=$result->fetch_assoc()): ?>
<div class="card">
<h3><?php echo $q['title']; ?></h3>
<p>Created by: <?php echo $q['name']; ?></p>
<a class="ap" href="?id=<?php echo $q['id']; ?>&action=approved">Approve</a>
<a class="re" href="?id=<?php echo $q['id']; ?>&action=rejected">Reject</a>
</div>
<?php endwhile; ?>

</body>
</html>
