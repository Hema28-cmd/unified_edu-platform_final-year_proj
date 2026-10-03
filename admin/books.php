<?php
session_start();

/* Admin only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

/* DB Connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");
if ($conn->connect_error) {
    die("Database connection failed");
}

/* Handle Book Upload */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['book_file'])) {

    if ($_FILES['book_file']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = "../uploads/books/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES['book_file']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['book_file']['tmp_name'], $targetFile)) {

            $filePathDB = "uploads/books/" . $fileName;

            $stmt = $conn->prepare("
                INSERT INTO books 
                (title, author, level, file_path, status, created_by) 
                VALUES (?, ?, ?, ?, 'pending', ?)
            ");

            $stmt->bind_param(
                "ssssi",
                $_POST['title'],
                $_POST['author'],
                $_POST['level'],
                $filePathDB,
                $_SESSION['user_id']
            );

            $stmt->execute();
            $stmt->close();
        }
    }
}

/* BOOK STATS */
$stats = [
    'total' => 0,
    'pending' => 0,
    'approved' => 0,
    'rejected' => 0
];

$statQuery = $conn->query("
    SELECT status, COUNT(*) as count 
    FROM books 
    GROUP BY status
");

while ($s = $statQuery->fetch_assoc()) {
    $stats[$s['status']] = $s['count'];
}

$stats['total'] = array_sum($stats);

/* Approve / Reject */
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE books SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: books.php");
    exit;
}

/* DELETE BOOK */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    header("Location: books.php");
    exit;
}


/* UPDATE BOOK */
if(isset($_POST['update_book'])){

    $id = $_POST['book_id'];
    $title = $_POST['edit_title'];
    $author = $_POST['edit_author'];
    $level = $_POST['edit_level'];

    $stmt = $conn->prepare("
        UPDATE books
        SET title=?, author=?, level=?
        WHERE id=?
    ");

    $stmt->bind_param("sssi",$title,$author,$level,$id);
    $stmt->execute();
    $stmt->close();

    header("Location: books.php");
    exit;
}

/* Fetch Books */
$result = $conn->query("
    SELECT b.*, u.name AS admin_name 
    FROM books b
    LEFT JOIN users u ON b.created_by = u.id
    ORDER BY b.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | Books Library</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(120deg,#eef2ff,#ecfeff);
}

/* HEADER */
.header{
    background:linear-gradient(90deg,#6d28d9,#0891b2);
    color:#fff;
    padding:25px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.header h1{margin:0;font-size:26px;}
.header a{
    background:#f59e0b;
    padding:10px 18px;
    border-radius:20px;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
}

/* CONTAINER */
.container{
    max-width:1300px;
    margin:40px auto;
    padding:0 20px;
}

/* UPLOAD CARD */
.upload-card{
    background:#fff;
    border-radius:22px;
    padding:30px;
    box-shadow:0 20px 40px rgba(0,0,0,.12);
    margin-bottom:35px;
}
.upload-card h2{
    margin-top:0;
    color:#4338ca;
}
.upload-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
}
.upload-grid input,
.upload-grid select{
    padding:14px;
    border-radius:14px;
    border:1px solid #c7d2fe;
}
.upload-grid button{
    background:linear-gradient(90deg,#7c3aed,#06b6d4);
    color:#fff;
    border:none;
    border-radius:16px;
    padding:14px;
    font-weight:bold;
    cursor:pointer;
}

/* TABLE */
.table-box{
    background:#fff;
    border-radius:24px;
    padding:25px;
    box-shadow:0 18px 40px rgba(0,0,0,.15);
}
table{
    width:100%;
    border-collapse:collapse;
}
th,td{
    padding:14px;
}
th{
    background:#ede9fe;
    color:#4c1d95;
}
tr:nth-child(even){
    background:#f8fafc;
}

/* STATUS */
.status{
    padding:6px 14px;
    border-radius:16px;
    font-size:13px;
    font-weight:bold;
}
.pending{background:#fde68a;color:#92400e;}
.approved{background:#bbf7d0;color:#166534;}
.rejected{background:#fecaca;color:#7f1d1d;}

/* ACTIONS */
.actions a{
    text-decoration:none;
    padding:7px 14px;
    border-radius:14px;
    font-size:13px;
    font-weight:bold;
    margin-right:6px;
}
.view{background:#3b82f6;color:#fff;}
.approve{background:#22c55e;color:#fff;}
.reject{background:#ef4444;color:#fff;}

/* STATS BAR */
.stats-bar{
    max-width:1300px;
    margin:30px auto;
    padding:0 20px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
}

.stat-card{
    background:#ffffff;
    border-radius:20px;
    padding:22px;
    box-shadow:0 12px 25px rgba(0,0,0,0.08);
    text-align:center;
}

.stat-card h4{
    margin:0;
    font-size:15px;
    color:#64748b;
}

.stat-card p{
    margin:12px 0 0;
    font-size:28px;
    font-weight:bold;
}

/* LIGHT COLORS */
.stat-card.total{
    background:#f0f9ff;
    color:#0369a1;
}
.stat-card.pending{
    background:#fff7ed;
    color:#9a3412;
}
.stat-card.approved{
    background:#ecfdf5;
    color:#065f46;
}
.stat-card.rejected{
    background:#fef2f2;
    color:#991b1b;
}

/* HEADER – soften colors */
.header{
    background:linear-gradient(90deg,#c7d2fe,#bae6fd);
    color:#1e293b;
}
.header a{
    background:#38bdf8;
}

</style>
</head>

<body>

<div class="header">
    <h1>📚 Books Management</h1>
    <a href="../admin/admin.php"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
</div>

<!-- STATUS CARDS -->
<div class="stats-bar">
    <div class="stat-card total">
        <h4>Total Books</h4>
        <p><?= $stats['total'] ?></p>
    </div>
    <div class="stat-card pending">
        <h4>Pending</h4>
        <p><?= $stats['pending'] ?></p>
    </div>
    <div class="stat-card approved">
        <h4>Approved</h4>
        <p><?= $stats['approved'] ?></p>
    </div>
    <div class="stat-card rejected">
        <h4>Rejected</h4>
        <p><?= $stats['rejected'] ?></p>
    </div>
</div>

<div class="container">

<!-- UPLOAD -->
<div class="upload-card">
    <h2>➕ Upload New Book</h2>
    <form method="POST" enctype="multipart/form-data" class="upload-grid">
        <input type="text" name="title" placeholder="Book Title" required>
        <input type="text" name="author" placeholder="Author Name" required>
        <select name="level">
	    <option value="kindergarten">Kindergarten</option>
            <option value="primary">Primary</option>
            <option value="secondary">Secondary</option>
            <option value="higher">Higher</option>
	    <option value="undergraduate">UnderGraduate</option>
	    <option value="postgraduate">PostGraduate</option>
        </select>
        <input type="file" name="book_file" accept=".pdf,.doc,.docx" required>
        <button type="submit">Upload Book</button>
    </form>
</div>

<!-- TABLE -->
<div class="table-box">
<table>
<tr>
    <th>Title</th>
    <th>Author</th>
    <th>Level</th>
    <th>Uploaded By</th>
    <th>Status</th>
    <th>Date</th>
    <th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['title']) ?></td>
    <td><?= htmlspecialchars($row['author']) ?></td>
    <td><?= ucfirst($row['level']) ?></td>
    <td><?= htmlspecialchars($row['admin_name']) ?></td>
    <td>
        <span class="status <?= $row['status'] ?>">
            <?= ucfirst($row['status']) ?>
        </span>
    </td>
    <td><?= date("d M Y", strtotime($row['created_at'])) ?></td>
   <td class="actions">

<!--<a class="view" href="../<?= $row['file_path'] ?>" target="_blank">View</a>-->

<a class="approve"
onclick="openEdit(
'<?= $row['id'] ?>',
'<?= htmlspecialchars($row['title']) ?>',
'<?= htmlspecialchars($row['author']) ?>',
'<?= $row['level'] ?>'
)">
Edit
</a>

<a class="reject"
href="?delete=<?= $row['id'] ?>"
onclick="return confirm('Delete this book?')">
Delete
</a>

<?php if ($row['status'] === 'pending'): ?>
<a class="approve" href="?action=approve&id=<?= $row['id'] ?>">Approve</a>
<a class="reject" href="?action=reject&id=<?= $row['id'] ?>">Reject</a>
<?php endif; ?>

</td>

</tr>
<?php endwhile; ?>

</table>
</div>

</div>

<!-- EDIT BOOK MODAL -->
<div id="editModal" style="display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
align-items:center;
justify-content:center;">

<div style="background:white;
padding:30px;
border-radius:15px;
width:420px;">

<h2>Edit Book</h2>

<form method="POST">

<input type="hidden" name="book_id" id="edit_id">

<label>Title</label>
<input type="text" name="edit_title" id="edit_title" required style="width:100%;padding:10px;margin-bottom:10px;">

<label>Author</label>
<input type="text" name="edit_author" id="edit_author" required style="width:100%;padding:10px;margin-bottom:10px;">

<label>Level</label>
<select name="edit_level" id="edit_level" style="width:100%;padding:10px;margin-bottom:15px;">
<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="higher">Higher</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<button type="submit" name="update_book" style="padding:10px 20px;background:#2563eb;color:white;border:none;border-radius:8px;">Update</button>

<button type="button" onclick="closeEdit()" style="margin-left:10px;padding:10px 20px;">Cancel</button>

</form>

</div>
</div>

<script>

function openEdit(id,title,author,level){

document.getElementById("editModal").style.display="flex";

document.getElementById("edit_id").value=id;
document.getElementById("edit_title").value=title;
document.getElementById("edit_author").value=author;
document.getElementById("edit_level").value=level;

}

function closeEdit(){
document.getElementById("editModal").style.display="none";
}

</script>

</body>
</html>

<?php $conn->close(); ?>
