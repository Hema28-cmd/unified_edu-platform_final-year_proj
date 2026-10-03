<?php
session_start();

/* 🔐 Admin only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

/* 🛢 DB Connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");
if ($conn->connect_error) {
    die("Database connection failed");
}

/* HANDLE NEW ASSIGNMENT */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {

    $stmt = $conn->prepare("
        INSERT INTO assignments
        (title, description, subject, level, status, created_by_role)
        VALUES (?, ?, ?, ?, 'pending', 'admin')
    ");

    $stmt->bind_param(
        "ssss",
        $_POST['title'],
        $_POST['description'],
        $_POST['subject'],
        $_POST['level']
    );

    $stmt->execute();
    $stmt->close();

    header("Location: assignments.php");
    exit;
}

/* Approve / Reject */
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE assignments SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: assignments.php");
    exit;
}

/* DELETE ASSIGNMENT */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM assignments WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    header("Location: assignments.php");
    exit;
}


/* UPDATE ASSIGNMENT */
if(isset($_POST['update_assignment'])){

    $id = $_POST['assignment_id'];
    $title = $_POST['edit_title'];
    $subject = $_POST['edit_subject'];
    $level = $_POST['edit_level'];
    $description = $_POST['edit_description'];

    $stmt = $conn->prepare("
        UPDATE assignments
        SET title=?, subject=?, level=?, description=?
        WHERE id=?
    ");

    $stmt->bind_param("ssssi",$title,$subject,$level,$description,$id);
    $stmt->execute();
    $stmt->close();

    header("Location: assignments.php");
    exit;
}

/* Fetch assignments */
$result = $conn->query("
    SELECT *
    FROM assignments
    ORDER BY created_at DESC
");

/* Stats */
$total = $conn->query("SELECT COUNT(*) c FROM assignments")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) c FROM assignments WHERE status='pending'")->fetch_assoc()['c'];
$approved = $conn->query("SELECT COUNT(*) c FROM assignments WHERE status='approved'")->fetch_assoc()['c'];
$rejected = $conn->query("SELECT COUNT(*) c FROM assignments WHERE status='rejected'")->fetch_assoc()['c'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Assignments Management</title>

<style>
*{ box-sizing:border-box; }

body{
    margin:0;
    font-family:Segoe UI;
    background:#f1f5f9;
}

/* TOP BAR */
.topbar{
    background:linear-gradient(90deg,#065f46,#1e40af);
    color:#fff;
    padding:20px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.topbar h1{margin:0;font-size:24px;}
.topbar a{
    color:#fff;
    text-decoration:none;
    background:#f59e0b;
    padding:10px 18px;
    border-radius:20px;
    font-weight:bold;
}

.wrapper{
    max-width:1300px;
    margin:30px auto;
    padding:0 20px;
}

.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat{
    background:#fff;
    padding:20px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.stat p{
    font-size:26px;
    font-weight:bold;
}

/* ADD ASSIGNMENT CARD */
.add-assignment-card{
    background:#fff;
    border-radius:16px;
    padding:20px;
    margin-bottom:30px;
    box-shadow:0 10px 28px rgba(0,0,0,.08);
}

.add-assignment-header h2{
    margin:0 0 14px;
    font-size:20px;
    color:#1e293b;
}

.assignment-form{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:14px 16px;
}

.assignment-form .full{
    grid-column:1 / -1;
}

.assignment-form label{
    font-size:13px;
    font-weight:600;
    color:#475569;
}

.assignment-form input,
.assignment-form select,
.assignment-form textarea{
    width:100%;
    padding:8px 12px;
    height:38px;
    border-radius:10px;
    border:1px solid #cbd5e1;
}

.assignment-form textarea{
    height:70px;
    resize:none;
}

.assignment-actions{
    grid-column:1 / -1;
    display:flex;
    justify-content:flex-end;
}

.assignment-actions button{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:10px 26px;
    border-radius:12px;
    cursor:pointer;
}

/* TABLE */
.table-box{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 15px 35px rgba(0,0,0,.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:14px;
}

th{
    background:#e0e7ff;
}

.status{
    padding:6px 12px;
    border-radius:14px;
    font-size:13px;
    font-weight:bold;
}

.pending{background:#fde68a}
.approved{background:#bbf7d0}
.rejected{background:#fecaca}

.actions a{
    padding:6px 14px;
    border-radius:14px;
    color:#fff;
    text-decoration:none;
    font-size:13px;
}

.approve{background:#22c55e}
.reject{background:#ef4444}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.55);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:#fff;
    width:420px;
    padding:22px;
    border-radius:16px;
    position:relative;
    animation:zoom .25s ease;
}

@keyframes zoom{
    from{transform:scale(0.8);opacity:0}
    to{transform:scale(1);opacity:1}
}

.modal-content h2{
    margin-top:0;
    color:#1e293b;
}

.modal-content p{
    font-size:14px;
    color:#334155;
}

.close{
    position:absolute;
    top:12px;
    right:16px;
    font-size:22px;
    cursor:pointer;
}
.view{
    background:#3b82f6;
    color:#fff;
    padding:6px 14px;
    border-radius:14px;
    text-decoration:none;
    font-size:13px;
    margin-right:6px;
}

</style>
</head>

<body>

<div class="topbar">
<h1>📝 Assignments Management</h1>
<a href="../admin/admin.php"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
</div>

<div class="wrapper">

<div class="stats">
<div class="stat"><h3>Total</h3><p><?= $total ?></p></div>
<div class="stat"><h3>Pending</h3><p><?= $pending ?></p></div>
<div class="stat"><h3>Approved</h3><p><?= $approved ?></p></div>
<div class="stat"><h3>Rejected</h3><p><?= $rejected ?></p></div>
</div>

<div class="add-assignment-card">
<h2>➕ Add New Assignment</h2>

<form method="POST" class="assignment-form">

<div>
<label>Title</label>
<input type="text" name="title" placeholder="Enter assignment title" required>
</div>

<div>
<label>Subject</label>
<input type="text" name="subject" placeholder="Eg: Mathematics, Physics" required>
</div>

<div>
<label>Level</label>
<select name="level" required>
    <option value="">Select Level</option>
    <option value="kindergarten">🧸 Kindergarten</option>
    <option value="primary">Primary</option>
    <option value="secondary">Secondary</option>
    <option value="highschool">High School</option>
    <option value="undergraduate">Undergraduate</option>
    <option value="postgraduate">Postgraduate</option>
</select>
</div>

<div class="full">
<label>Description</label>
<textarea name="description" placeholder="Brief description of the assignment"></textarea>
</div>

<div class="assignment-actions">
<button>Create Assignment</button>
</div>

</form>
</div>

<div class="table-box">
<table>
<tr>
    <th>Title</th>
    <th>Subject</th>
    <th>Level</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars($row['subject']) ?></td>
        <td><?= ucfirst($row['level']) ?></td>
        <td>
            <span class="status <?= $row['status'] ?>">
                <?= ucfirst($row['status']) ?>
            </span>
        </td>

       <td class="actions">

<!-- VIEW -->
<a href="javascript:void(0)"
class="view"
onclick="openModal(
'<?= htmlspecialchars(addslashes($row['title'])) ?>',
'<?= htmlspecialchars(addslashes($row['subject'])) ?>',
'<?= htmlspecialchars(addslashes($row['level'])) ?>',
'<?= htmlspecialchars(addslashes($row['description'])) ?>',
'<?= ucfirst($row['status']) ?>'
)">View</a>

<!-- EDIT -->
<a class="approve"
onclick="openEdit(
'<?= $row['id'] ?>',
'<?= htmlspecialchars($row['title']) ?>',
'<?= htmlspecialchars($row['subject']) ?>',
'<?= $row['level'] ?>',
'<?= htmlspecialchars($row['description']) ?>'
)">Edit</a>

<!-- DELETE -->
<a class="reject"
href="?delete=<?= $row['id'] ?>"
onclick="return confirm('Delete this assignment?')">
Delete
</a>

<?php if ($row['status'] == 'pending'): ?>
<a class="approve" href="?action=approve&id=<?= $row['id'] ?>">Approve</a>
<a class="reject" href="?action=reject&id=<?= $row['id'] ?>">Reject</a>
<?php endif; ?>

</td>


    </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr>
        <td colspan="5" style="text-align:center;">No assignments found</td>
    </tr>
<?php endif; ?>

</table>
</div>


<!-- VIEW ASSIGNMENT MODAL -->
<div id="assignmentModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">×</span>

        <h2 id="m_title"></h2>

        <p><strong>Subject:</strong> <span id="m_subject"></span></p>
        <p><strong>Level:</strong> <span id="m_level"></span></p>
        <p><strong>Status:</strong> <span id="m_status"></span></p>

        <hr>

        <p><strong>Description:</strong></p>
        <p id="m_description"></p>
    </div>
</div>

</div>

<script>
function openModal(title, subject, level, description, status){
    document.getElementById("m_title").innerText = title;
    document.getElementById("m_subject").innerText = subject;
    document.getElementById("m_level").innerText = level;
    document.getElementById("m_description").innerText = description || "No description";
    document.getElementById("m_status").innerText = status;

    document.getElementById("assignmentModal").style.display = "flex";
}

function closeModal(){
    document.getElementById("assignmentModal").style.display = "none";
}
</script>

<!-- EDIT ASSIGNMENT MODAL -->
<div id="editModal" class="modal">
<div class="modal-content">

<span class="close" onclick="closeEdit()">×</span>

<h2>Edit Assignment</h2>

<form method="POST">

<input type="hidden" name="assignment_id" id="edit_id">

<label>Title</label>
<input type="text" name="edit_title" id="edit_title" required>

<label>Subject</label>
<input type="text" name="edit_subject" id="edit_subject" required>

<label>Level</label>
<select name="edit_level" id="edit_level">
<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">High School</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<label>Description</label>
<textarea name="edit_description" id="edit_description"></textarea>

<br><br>

<button type="submit" name="update_assignment"
style="background:#2563eb;color:#fff;border:none;padding:10px 20px;border-radius:10px;">
Update
</button>

<button type="button" onclick="closeEdit()">Cancel</button>

</form>

</div>
</div>

<script>

function openEdit(id,title,subject,level,description){

document.getElementById("editModal").style.display="flex";

document.getElementById("edit_id").value=id;
document.getElementById("edit_title").value=title;
document.getElementById("edit_subject").value=subject;
document.getElementById("edit_level").value=level;
document.getElementById("edit_description").value=description;

}

function closeEdit(){
document.getElementById("editModal").style.display="none";
}

</script>

</body>
</html>

<?php $conn->close(); ?>
