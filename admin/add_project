<?php
session_start();

/* Allow only admin */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

include "../config/db.php";

/* Handle approve / reject */
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int) $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'approve') {
        $stmt = $conn->prepare("UPDATE project_topics SET status='approved' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    if ($action === 'reject') {
        $stmt = $conn->prepare("UPDATE project_topics SET status='rejected' WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    header("Location: add_project.php");
    exit;
}

/* Fetch pending projects */
$projects = $conn->query("
    SELECT p.id, p.title, p.description, p.domain, p.level, u.name AS teacher
    FROM project_topics p
    LEFT JOIN users u ON p.created_by = u.id
    WHERE p.status = 'pending'
    ORDER BY p.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Approve Project Topics</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:Segoe UI, sans-serif;
    background:#f1f5f9;
    padding:40px;
}
h1{
    margin-bottom:25px;
}
.table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.table th, .table td{
    padding:14px;
    border-bottom:1px solid #e5e7eb;
    text-align:left;
}
.table th{
    background:#0f172a;
    color:#fff;
}
.badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}
.approve{
    background:#22c55e;
    color:#fff;
    text-decoration:none;
    padding:8px 16px;
    border-radius:20px;
    margin-right:6px;
}
.reject{
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    padding:8px 16px;
    border-radius:20px;
}
.back{
    display:inline-block;
    margin-top:30px;
    padding:12px 24px;
    background:#6366f1;
    color:#fff;
    text-decoration:none;
    border-radius:25px;
}
</style>
</head>

<body>

<h1>📌 Pending Project Topics</h1>

<table class="table">
<tr>
    <th>Title</th>
    <th>Description</th>
    <th>Domain</th>
    <th>Level</th>
    <th>Teacher</th>
    <th>Action</th>
</tr>

<?php if ($projects->num_rows > 0): ?>
    <?php while($row = $projects->fetch_assoc()): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><?php echo htmlspecialchars($row['domain']); ?></td>
        <td><?php echo ucfirst($row['level']); ?></td>
        <td><?php echo $row['teacher'] ?? 'Unknown'; ?></td>
        <td>
            <a class="approve" href="?action=approve&id=<?php echo $row['id']; ?>">Approve</a>
            <a class="reject" href="?action=reject&id=<?php echo $row['id']; ?>">Reject</a>
        </td>
    </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="6">No pending project topics 🎉</td>
</tr>
<?php endif; ?>

</table>

<a href="dashboard.php" class="back">⬅ Back to Admin Dashboard</a>

</body>
</html>
