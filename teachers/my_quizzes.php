<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_id = $_SESSION['user_id'];

/* Fetch quizzes */
$sql = "SELECT id, title, status, created_at
        FROM quizzes1
        WHERE created_by = ?
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Quizzes</title>
<style>
body{
    font-family:Segoe UI, sans-serif;
    background:linear-gradient(135deg,#eef2ff,#f0fdf4);
    padding:40px;
}
.container{
    max-width:900px;
    margin:auto;
}
h1{
    text-align:center;
    margin-bottom:30px;
}
.quiz-card{
    background:#fff;
    padding:20px;
    border-radius:18px;
    margin-bottom:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.1);
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.status{
    padding:6px 14px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
}
.pending{background:#fef3c7;color:#92400e;}
.approved{background:#dcfce7;color:#166534;}
.rejected{background:#fee2e2;color:#991b1b;}
.actions a{
    text-decoration:none;
    margin-left:10px;
    font-size:14px;
    font-weight:600;
}
.view{color:#2563eb;}
.edit{color:#16a34a;}
</style>
</head>

<body>
<div class="container">
<h1>📋 My Quizzes</h1>

<?php if ($result->num_rows == 0): ?>
    <p style="text-align:center;">No quizzes created yet.</p>
<?php endif; ?>

<?php while ($row = $result->fetch_assoc()): ?>
<div class="quiz-card">
    <div>
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <small>Created on <?= date("d M Y", strtotime($row['created_at'])) ?></small>
    </div>

    <div>
        <span class="status <?= $row['status'] ?>">
            <?= ucfirst($row['status']) ?>
        </span>

        <span class="actions">
            <a class="view" href="view_quiz.php?id=<?= $row['id'] ?>">View</a>

            <?php if ($row['status'] !== 'approved'): ?>
                <a class="edit" href="edit_quiz.php?id=<?= $row['id'] ?>">Edit</a>
            <?php endif; ?>
        </span>
    </div>
</div>
<?php endwhile; ?>

</div>
</body>
</html>
