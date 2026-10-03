<?php
session_start();
include "../config/db.php";

$res=$conn->query("SELECT b.*, u.user_name AS teacher_name FROM books b JOIN users u ON u.id=b.created_by WHERE status='pending' ORDER BY created_at DESC");
?>

<h1>Pending Books</h1>
<table border="1" cellpadding="10">
<tr><th>Title</th><th>Teacher</th><th>Description</th><th>PDF</th><th>Action</th></tr>
<?php while($b=$res->fetch_assoc()): ?>
<tr>
<td><?= $b['title'] ?></td>
<td><?= $b['teacher_name'] ?></td>
<td><?= $b['description'] ?></td>
<td><a href="../uploads/books/<?= $b['pdf_file'] ?>" target="_blank">View PDF</a></td>
<td>
<a href="admin_approve.php?book_id=<?= $b['id'] ?>&action=approve">✅ Approve</a>
<a href="admin_approve.php?book_id=<?= $b['id'] ?>&action=reject">❌ Reject</a>
</td>
</tr>
<?php endwhile; ?>
</table>
