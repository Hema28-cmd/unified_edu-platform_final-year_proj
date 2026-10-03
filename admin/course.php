<?php
session_start();

/* Admin Only */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

/* DB */
$conn = new mysqli("localhost","root","","unified_edu");
if ($conn->connect_error) {
    die("Database connection failed");
}

/* UPDATE COURSE */
if(isset($_POST['update_course'])){

$stmt=$conn->prepare("
UPDATE courses 
SET title=?, description=?, level=? 
WHERE id=?
");

$stmt->bind_param(
"sssi",
$_POST['title'],
$_POST['description'],
$_POST['level'],
$_POST['course_id']
);

$stmt->execute();
$stmt->close();

header("Location: course.php");
exit;
}

/* ADD COURSE */
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['title'])){

$stmt=$conn->prepare("
INSERT INTO courses(title,description,level,created_by,status)
VALUES(?,?,?,?, 'pending')
");

$stmt->bind_param(
"sssi",
$_POST['title'],
$_POST['description'],
$_POST['level'],
$_SESSION['user_id']
);

$stmt->execute();
$stmt->close();

header("Location: course.php");
exit;
}

/* APPROVE / REJECT */
if(isset($_GET['action'],$_GET['id'])){

$id=(int)$_GET['id'];
$status=$_GET['action']=="approve" ? "approved":"rejected";

$stmt=$conn->prepare("UPDATE courses SET status=? WHERE id=?");
$stmt->bind_param("si",$status,$id);
$stmt->execute();
$stmt->close();

header("Location: course.php");
exit;
}

/* DELETE COURSE */
if(isset($_GET['delete'])){
$id=(int)$_GET['delete'];

$stmt=$conn->prepare("DELETE FROM courses WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();

header("Location: course.php");
exit;
}

/* STATS */
$stats=[
'total'=>0,
'pending'=>0,
'approved'=>0,
'rejected'=>0
];

$q=$conn->query("
SELECT status,COUNT(*) c FROM courses GROUP BY status
");

while($s=$q->fetch_assoc()){
$stats[$s['status']]=$s['c'];
}

$stats['total']=array_sum($stats);

/* FETCH COURSES */

$result=$conn->query("
SELECT c.*,u.name admin_name
FROM courses c
LEFT JOIN users u ON c.created_by=u.id
ORDER BY c.created_at DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Courses Management</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(120deg,#eef2ff,#ecfeff);
}

/* HEADER */

.header{
background:linear-gradient(90deg,#c7d2fe,#bae6fd);
padding:25px 40px;
display:flex;
justify-content:space-between;
align-items:center;
}

.header h1{
margin:0;
}

.header a{
background:#38bdf8;
padding:10px 18px;
border-radius:20px;
text-decoration:none;
color:white;
font-weight:bold;
}

/* STATS */

.stats-bar{
max-width:1300px;
margin:30px auto;
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:20px;
padding:0 20px;
}

.stat-card{
background:white;
padding:22px;
border-radius:20px;
box-shadow:0 10px 25px rgba(0,0,0,.08);
text-align:center;
}

.stat-card h4{
margin:0;
color:#64748b;
}

.stat-card p{
font-size:28px;
font-weight:bold;
margin-top:10px;
}

.total{background:#f0f9ff;color:#0369a1;}
.pending{background:#fff7ed;color:#9a3412;}
.approved{background:#ecfdf5;color:#065f46;}
.rejected{background:#fef2f2;color:#991b1b;}

/* CONTAINER */

.container{
max-width:1300px;
margin:auto;
padding:20px;
}

/* ADD CARD */

.upload-card{
background:white;
border-radius:22px;
padding:30px;
box-shadow:0 20px 40px rgba(0,0,0,.12);
margin-bottom:30px;
}

.upload-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:15px;
}

.upload-grid input,
.upload-grid textarea,
.upload-grid select{
padding:12px;
border-radius:10px;
border:1px solid #ccc;
}

.upload-grid button{
background:linear-gradient(90deg,#7c3aed,#06b6d4);
color:white;
border:none;
padding:12px;
border-radius:14px;
cursor:pointer;
}

/* TABLE */

.table-box{
background:white;
padding:25px;
border-radius:22px;
box-shadow:0 15px 30px rgba(0,0,0,.1);
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
padding:14px;
text-align:left;
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
border-radius:14px;
font-size:13px;
font-weight:bold;
}

.pending{background:#fde68a;color:#92400e;}
.approved{background:#bbf7d0;color:#166534;}
.rejected{background:#fecaca;color:#7f1d1d;}

/* ACTIONS */

.actions a{
padding:7px 12px;
border-radius:12px;
font-size:13px;
text-decoration:none;
color:white;
margin-right:5px;
}

.view{background:#3b82f6;}
.approve{background:#22c55e;}
.reject{background:#ef4444;}

.edit{
background:#f59e0b;
}

.delete{
background:#ef4444;
}

/* MODAL */

.modal{
display:none;
position:fixed;
z-index:1000;
left:0;
top:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
}

.modal-content{
background:white;
padding:30px;
width:420px;
margin:120px auto;
border-radius:18px;
position:relative;
}

.modal-content input,
.modal-content textarea,
.modal-content select{
width:100%;
padding:10px;
margin-top:6px;
margin-bottom:12px;
border-radius:8px;
border:1px solid #ccc;
}

.modal-content button{
background:linear-gradient(90deg,#7c3aed,#06b6d4);
color:white;
border:none;
padding:10px;
border-radius:10px;
cursor:pointer;
}

.close{
position:absolute;
right:15px;
top:10px;
font-size:22px;
cursor:pointer;
}

/* LEVEL COLORS */

.level{
padding:6px 14px;
border-radius:14px;
font-size:13px;
font-weight:bold;
display:inline-block;
}

/* Light colors */

.level-primary{
background:#e0f2fe;
color:#0369a1;
}

.level-secondary{
background:#fef9c3;
color:#854d0e;
}

.level-highschool{
background:#dcfce7;
color:#166534;
}

.level-undergraduate{
background:#ede9fe;
color:#4c1d95;
}

.level-postgraduate{
background:#ffe4e6;
color:#9f1239;
}

</style>

</head>

<body>

<div class="header">
<h1>📚 Courses Management</h1>
<a href="admin.php"><i class="fa fa-arrow-left"></i> Dashboard</a>
</div>

<!-- STATS -->

<div class="stats-bar">

<div class="stat-card total">
<h4>Total Courses</h4>
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

<!-- ADD COURSE -->

<div class="upload-card">

<h2>➕ Add New Course</h2>

<form method="POST" class="upload-grid">

<input type="text" name="title"
value="<?= $editData['title'] ?? '' ?>"
placeholder="Course Title" required>

<textarea name="description"><?= $editData['description'] ?? '' ?></textarea>

<select name="level">
<option value="primary"
<?= isset($editData) && $editData['level']=="primary" ? "selected":"" ?>>
Primary
</option>
<option value="kindergarten">Kindergarten</option>
<option value="secondary">Secondary</option>
<option value="highschool">High School</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>

</select>

<input type="hidden" name="course_id"
value="<?= $editData['id'] ?? '' ?>">

<button type="submit">Create Course</button>

</form>

</div>

<!-- TABLE -->

<div class="table-box">

<table>

<tr>
<th>Title</th>
<th>Description</th>
<th>Level</th>
<th>Created By</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>
</tr>

<?php while($row=$result->fetch_assoc()): ?>

<tr>

<td><?= htmlspecialchars($row['title']) ?></td>

<td><?= htmlspecialchars($row['description']) ?></td>

<td>
<span class="level level-<?= $row['level'] ?>">
<?= ucfirst($row['level']) ?>
</span>
</td>

<td><?= htmlspecialchars($row['admin_name']) ?></td>

<td>
<span class="status <?= $row['status'] ?>">
<?= ucfirst($row['status']) ?>
</span>
</td>

<td><?= date("d M Y",strtotime($row['created_at'])) ?></td>

<td class="actions">

<button class="edit editBtn"
data-id="<?= $row['id'] ?>"
data-title="<?= htmlspecialchars($row['title']) ?>"
data-description="<?= htmlspecialchars($row['description']) ?>"
data-level="<?= $row['level'] ?>">
Edit
</button>

<a class="delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this course?')">Delete</a>

<?php if($row['status']=="pending"): ?>

<a class="approve" href="?action=approve&id=<?= $row['id'] ?>">Approve</a>

<a class="reject" href="?action=reject&id=<?= $row['id'] ?>">Reject</a>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

<!-- EDIT COURSE MODAL -->

<div id="editModal" class="modal">

<div class="modal-content">

<span class="close">&times;</span>

<h2>Edit Course</h2>

<form method="POST">

<input type="hidden" name="course_id" id="course_id">

<label>Title</label>
<input type="text" name="title" id="title" required>

<label>Description</label>
<textarea name="description" id="description"></textarea>

<label>Level</label>
<select name="level" id="level">

<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">High School</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>

</select>

<button type="submit" name="update_course">
Update Course
</button>

</form>

</div>

</div>

<script>

const modal = document.getElementById("editModal");
const closeBtn = document.querySelector(".close");

document.querySelectorAll(".editBtn").forEach(button => {

button.onclick = function(){

document.getElementById("course_id").value = this.dataset.id;
document.getElementById("title").value = this.dataset.title;
document.getElementById("description").value = this.dataset.description;
document.getElementById("level").value = this.dataset.level;

modal.style.display = "block";

}

});

closeBtn.onclick = function(){
modal.style.display="none";
}

window.onclick = function(e){
if(e.target==modal){
modal.style.display="none";
}
}

</script>

</body>
</html>

<?php $conn->close(); ?>