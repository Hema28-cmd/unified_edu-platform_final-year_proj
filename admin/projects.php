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

/* ===============================
   CREATE NEW PROJECT
=============================== */

if(isset($_POST['create_project'])){

$title = $_POST['title'];
$description = $_POST['description'];
$level = $_POST['level'];
$domain = $_POST['domain'];
$created_by = $_SESSION['user_id'];

$stmt = $conn->prepare("
INSERT INTO project_topics
(title,description,level,domain,created_by_role,created_by)
VALUES (?,?,?,?, 'admin',?)
");

$stmt->bind_param("ssssi",$title,$description,$level,$domain,$created_by);
$stmt->execute();
$stmt->close();

header("Location: projects.php");
exit;
}


/* ===============================
   APPROVE / REJECT
=============================== */

if(isset($_GET['action'],$_GET['id'])){

$id = (int)$_GET['id'];
$status = ($_GET['action']=="approve") ? "approved" : "rejected";

$stmt = $conn->prepare("UPDATE project_topics SET status=? WHERE id=?");
$stmt->bind_param("si",$status,$id);
$stmt->execute();
$stmt->close();

header("Location: projects.php");
exit;

}


/* ===============================
   DELETE PROJECT
=============================== */

if(isset($_GET['delete'])){

$id = (int)$_GET['delete'];

$stmt = $conn->prepare("DELETE FROM project_topics WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();

header("Location: projects.php");
exit;

}


/* ===============================
   UPDATE PROJECT
=============================== */

if(isset($_POST['update_project'])){

$id = (int)$_POST['edit_id'];
$title = $_POST['edit_title'];
$desc = $_POST['edit_desc'];
$level = $_POST['edit_level'];
$domain = $_POST['edit_domain'];

$stmt = $conn->prepare("
UPDATE project_topics 
SET title=?, description=?, level=?, domain=? 
WHERE id=?
");

$stmt->bind_param("ssssi",$title,$desc,$level,$domain,$id);
$stmt->execute();
$stmt->close();

header("Location: projects.php");
exit;
}

/* ===============================
   FETCH PROJECTS
=============================== */

$result = $conn->query("
SELECT p.*, u.name as creator
FROM project_topics p
LEFT JOIN users u ON p.created_by=u.id
ORDER BY p.created_at DESC
");


/* ===============================
   FETCH STATS
=============================== */

function count_data($conn,$status){
$res = $conn->query("SELECT COUNT(*) as c FROM project_topics WHERE status='$status'");
return $res->fetch_assoc()['c'];
}

$total = $conn->query("SELECT COUNT(*) as c FROM project_topics")->fetch_assoc()['c'];
$pending = count_data($conn,"pending");
$approved = count_data($conn,"approved");
$rejected = count_data($conn,"rejected");

?>

<!DOCTYPE html>
<html>
<head>

<title>Project Topics Management</title>

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(120deg,#eef2ff,#ecfeff);
}

.header{
background:linear-gradient(90deg,#c7d2fe,#bae6fd);
padding:25px 40px;
display:flex;
justify-content:space-between;
align-items:center;
}

.header h2{margin:0;color:#1e293b;}

.header a{
background:#38bdf8;
padding:10px 18px;
border-radius:20px;
color:white;
text-decoration:none;
font-weight:bold;
}

.stats{
max-width:1200px;
margin:30px auto;
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:20px;
}

.card{
padding:22px;
border-radius:20px;
text-align:center;
box-shadow:0 10px 25px rgba(0,0,0,0.08);
font-weight:bold;
}

.card:nth-child(1){background:#e0f2fe;color:#0369a1;}
.card:nth-child(2){background:#fff7ed;color:#9a3412;}
.card:nth-child(3){background:#ecfdf5;color:#065f46;}
.card:nth-child(4){background:#fef2f2;color:#991b1b;}

.container{
max-width:1300px;
margin:auto;
padding:20px;
}

.create-box{
background:white;
padding:30px;
border-radius:22px;
box-shadow:0 20px 40px rgba(0,0,0,.12);
margin-bottom:30px;
}

.create-box input,
.create-box select,
.create-box textarea{
width:100%;
padding:12px;
margin:8px 0;
border-radius:12px;
border:1px solid #c7d2fe;
}

button{
padding:12px 18px;
border:none;
border-radius:14px;
font-weight:bold;
cursor:pointer;
background:linear-gradient(90deg,#7c3aed,#06b6d4);
color:white;
}

table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:20px;
overflow:hidden;
box-shadow:0 18px 40px rgba(0,0,0,.15);
}

th{
background:#ede9fe;
color:#4c1d95;
padding:14px;
}

td{
padding:14px;
border-bottom:1px solid #f1f5f9;
}

tr:nth-child(even){
background:#f8fafc;
}

.status{
padding:6px 14px;
border-radius:16px;
font-size:13px;
font-weight:bold;
}

.pending{background:#fde68a;color:#92400e;}
.approved{background:#bbf7d0;color:#166534;}
.rejected{background:#fecaca;color:#7f1d1d;}

.actions a{
text-decoration:none;
padding:7px 14px;
border-radius:14px;
font-size:13px;
font-weight:bold;
margin-right:6px;
color:white;
}

.approve{background:#22c55e;}
.reject{background:#ef4444;}
.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
justify-content:center;
align-items:center;
}

.modal-box{
background:linear-gradient(135deg,#ffffff,#eef2ff);
padding:30px;
border-radius:20px;
width:400px;
box-shadow:0 20px 50px rgba(0,0,0,.3);
}

.viewBtn{
background:#3b82f6;
}

.editBtn{
background:#f59e0b;
}

.viewBtn, .editBtn{
padding:7px 14px;
border-radius:14px;
color:white;
text-decoration:none;
font-size:13px;
margin-right:6px;
display:inline-block;
}
</style>

</head>

<body>

<div class="header">
<h2>Project Topics Management</h2>
<a href="admin.php">Back</a>
</div>

<div class="stats">

<div class="card">
<h4>Total Projects</h4>
<h2><?= $total ?></h2>
</div>

<div class="card">
<h4>Pending</h4>
<h2><?= $pending ?></h2>
</div>

<div class="card">
<h4>Approved</h4>
<h2><?= $approved ?></h2>
</div>

<div class="card">
<h4>Rejected</h4>
<h2><?= $rejected ?></h2>
</div>

</div>

<div class="container">

<div class="create-box">

<h2>Add New Project Topic</h2>

<form method="POST">

<input type="text" name="title" placeholder="Project Title" required>

<textarea name="description" placeholder="Project Description" required></textarea>

<select name="level">
<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">Highschool</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<input type="text" name="domain" placeholder="Project Domain (AI, Web, IoT etc.)">

<button type="submit" name="create_project">Add Project</button>

</form>

</div>

<table>

<tr>
<th>Title</th>
<th>Level</th>
<th>Domain</th>
<th>Created By</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>
</tr>

<?php while($row = $result->fetch_assoc()): ?>

<tr>

<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= ucfirst($row['level']) ?></td>
<td><?= htmlspecialchars($row['domain']) ?></td>
<td><?= htmlspecialchars($row['creator']) ?></td>

<td>
<span class="status <?= $row['status'] ?>">
<?= ucfirst($row['status']) ?>
</span>
</td>

<td><?= date("d M Y",strtotime($row['created_at'])) ?></td>

<td class="actions">

<!-- VIEW -->
<a href="#" class="viewBtn" 
data-title="<?= htmlspecialchars($row['title']) ?>"
data-desc="<?= htmlspecialchars($row['description']) ?>"
data-level="<?= $row['level'] ?>"
data-domain="<?= htmlspecialchars($row['domain']) ?>"
>View</a>

<!-- EDIT -->
<a href="#" class="editBtn"
data-id="<?= $row['id'] ?>"
data-title="<?= htmlspecialchars($row['title']) ?>"
data-desc="<?= htmlspecialchars($row['description']) ?>"
data-level="<?= $row['level'] ?>"
data-domain="<?= htmlspecialchars($row['domain']) ?>"
>Edit</a>

<?php if($row['status']=="pending"): ?>
<a class="approve" href="?action=approve&id=<?= $row['id'] ?>">Approve</a>
<a class="reject" href="?action=reject&id=<?= $row['id'] ?>">Reject</a>
<?php endif; ?>

<a class="reject" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this project?')">Delete</a>

</td>

</tr>

<?php endwhile; ?>

</table>

<!-- VIEW MODAL -->
<div id="viewModal" class="modal">
  <div class="modal-box">
    <h2>Project Details</h2>
    <p><b>Title:</b> <span id="v_title"></span></p>
    <p><b>Description:</b> <span id="v_desc"></span></p>
    <p><b>Level:</b> <span id="v_level"></span></p>
    <p><b>Domain:</b> <span id="v_domain"></span></p>
    <button onclick="closeModal()">Close</button>
  </div>
</div>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
  <div class="modal-box">
    <h2>Edit Project</h2>

    <form method="POST">
      <input type="hidden" name="edit_id" id="e_id">

      <input type="text" name="edit_title" id="e_title" required>
      <textarea name="edit_desc" id="e_desc" required></textarea>

      <select name="edit_level" id="e_level">
        <option value="kindergarten">Kindergarten</option>
        <option value="primary">Primary</option>
        <option value="secondary">Secondary</option>
        <option value="highschool">Highschool</option>
        <option value="undergraduate">Undergraduate</option>
        <option value="postgraduate">Postgraduate</option>
      </select>

      <input type="text" name="edit_domain" id="e_domain">

      <button type="submit" name="update_project">Update</button>
      <button type="button" onclick="closeModal()">Cancel</button>
    </form>
  </div>
</div>

</div>

<script>

/* OPEN VIEW */
document.querySelectorAll('.viewBtn').forEach(btn=>{
btn.onclick = () => {
document.getElementById('viewModal').style.display='flex';

v_title.innerText = btn.dataset.title;
v_desc.innerText = btn.dataset.desc;
v_level.innerText = btn.dataset.level;
v_domain.innerText = btn.dataset.domain;
};
});

/* OPEN EDIT */
document.querySelectorAll('.editBtn').forEach(btn=>{
btn.onclick = () => {
document.getElementById('editModal').style.display='flex';

e_id.value = btn.dataset.id;
e_title.value = btn.dataset.title;
e_desc.value = btn.dataset.desc;
e_level.value = btn.dataset.level;
e_domain.value = btn.dataset.domain;
};
});

/* CLOSE */
function closeModal(){
document.getElementById('viewModal').style.display='none';
document.getElementById('editModal').style.display='none';
}

</script>

</body>
</html>

<?php $conn->close(); ?>