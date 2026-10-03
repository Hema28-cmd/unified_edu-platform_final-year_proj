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
   CREATE NEW QUIZ
=============================== */

if(isset($_POST['create_quiz'])){

$title = $_POST['quiz_title'];
$level = $_POST['quiz_level'];
$created_by = $_SESSION['user_id'];

/* Insert Quiz */
$stmt = $conn->prepare("
INSERT INTO quizzes1 (title, level, created_by)
VALUES (?, ?, ?)
");

$stmt->bind_param("ssi",$title,$level,$created_by);
$stmt->execute();

$quiz_id = $stmt->insert_id;
$stmt->close();

/* Insert Questions */

$questions = $_POST['question'];

for($i=0; $i<count($questions); $i++){

$question = $_POST['question'][$i];
$opt1 = $_POST['option1'][$i];
$opt2 = $_POST['option2'][$i];
$opt3 = $_POST['option3'][$i];
$opt4 = $_POST['option4'][$i];
$correct = $_POST['correct'][$i];

$stmt2 = $conn->prepare("
INSERT INTO quiz_questions
(quiz_id, level, question, option1, option2, option3, option4, correct_option)
VALUES (?,?,?,?,?,?,?,?)
");

$stmt2->bind_param(
"issssssi",
$quiz_id,
$level,
$question,
$opt1,
$opt2,
$opt3,
$opt4,
$correct
);

$stmt2->execute();
$stmt2->close();

}

header("Location: quizzes.php");
exit;
}

/* ===============================
   Approve / Reject Quiz
=============================== */
if (isset($_GET['action'], $_GET['id'])) {

    $id = (int)$_GET['id'];
    $status = ($_GET['action'] == 'approve') ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE quizzes1 SET status=? WHERE id=?");
    $stmt->bind_param("si",$status,$id);
    $stmt->execute();
    $stmt->close();

    header("Location: quizzes.php");
    exit;
}

/* ===============================
   DELETE QUIZ
=============================== */
if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];

    $conn->query("DELETE FROM quizzes WHERE id=$id");
    $conn->query("DELETE FROM quizzes1 WHERE id=$id");

    header("Location: quizzes.php");
    exit;
}

/* ===============================
   UPDATE QUIZ
=============================== */
if(isset($_POST['update_quiz'])){

$id = $_POST['quiz_id'];
$title = $_POST['edit_title'];
$level = $_POST['edit_level'];

/* Update quiz */
$conn->query("UPDATE quizzes SET title='$title', level='$level' WHERE id=$id");
$conn->query("UPDATE quizzes1 SET title='$title', level='$level' WHERE id=$id");

/* Update questions */
$q_ids = $_POST['q_id'];
$questions = $_POST['question'];
$opt1 = $_POST['option1'];
$opt2 = $_POST['option2'];
$opt3 = $_POST['option3'];
$opt4 = $_POST['option4'];
$correct = $_POST['correct'];

for($i=0; $i<count($questions); $i++){

if($q_ids[$i] == "new"){

$conn->query("INSERT INTO quiz_questions 
(quiz_id, level, question, option1, option2, option3, option4, correct_option)
VALUES (
$id,
'$level',
'{$questions[$i]}',
'{$opt1[$i]}',
'{$opt2[$i]}',
'{$opt3[$i]}',
'{$opt4[$i]}',
'{$correct[$i]}'
)");

}else{

$conn->query("UPDATE quiz_questions SET
question='{$questions[$i]}',
option1='{$opt1[$i]}',
option2='{$opt2[$i]}',
option3='{$opt3[$i]}',
option4='{$opt4[$i]}',
correct_option='{$correct[$i]}'
WHERE id='{$q_ids[$i]}'");

}

}

header("Location: quizzes.php");
exit;
}

/* ===============================
   FETCH QUIZZES FROM BOTH TABLES
=============================== */

$quizzes = [];

/* quizzes table (already approved quizzes) */
$q1 = $conn->query("SELECT *, 'approved' AS status FROM quizzes");

while($row = $q1->fetch_assoc()){
    $quizzes[$row['level']][] = $row;
}

/* quizzes1 table (pending / rejected / approved requests) */
$q2 = $conn->query("SELECT id,title,level,'' AS subject,status,created_at FROM quizzes1");

while($row = $q2->fetch_assoc()){
    $quizzes[$row['level']][] = $row;
}

/* ===============================
   FETCH STATS
=============================== */

function fetch_count($conn,$sql){
    $res = $conn->query($sql);
    return $res->fetch_assoc()['c'];
}

$stats = [
'total' => fetch_count($conn,"SELECT COUNT(*) c FROM quizzes") +
           fetch_count($conn,"SELECT COUNT(*) c FROM quizzes1"),

'pending' => fetch_count($conn,"SELECT COUNT(*) c FROM quizzes1 WHERE status='pending'"),

'approved' => fetch_count($conn,"SELECT COUNT(*) c FROM quizzes1 WHERE status='approved'") +
              fetch_count($conn,"SELECT COUNT(*) c FROM quizzes"),

'rejected' => fetch_count($conn,"SELECT COUNT(*) c FROM quizzes1 WHERE status='rejected'")
];

?>

<!DOCTYPE html>
<html>
<head>

<title>Quiz Management</title>

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

.header h2{
margin:0;
color:#1e293b;
}

.header a{
background:#38bdf8;
padding:10px 18px;
border-radius:20px;
color:white;
text-decoration:none;
font-weight:bold;
}

/* STATS */

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

.card h4{
margin:0;
font-size:15px;
color:#64748b;
}

.card h2{
margin-top:10px;
font-size:28px;
}

/* LIGHT COLORS */

.card:nth-child(1){
background:#e0f2fe;
color:#0369a1;
}

.card:nth-child(2){
background:#fff7ed;
color:#9a3412;
}

.card:nth-child(3){
background:#ecfdf5;
color:#065f46;
}

.card:nth-child(4){
background:#fef2f2;
color:#991b1b;
}

/* CONTAINER */

.container{
max-width:1300px;
margin:auto;
padding:20px;
}

/* CREATE QUIZ BOX */

.create-box{
background:white;
padding:30px;
border-radius:22px;
box-shadow:0 20px 40px rgba(0,0,0,.12);
margin-bottom:30px;
}

.create-box h2{
margin-top:0;
color:#4338ca;
}

.create-box input,
.create-box select{
width:100%;
padding:12px;
margin:8px 0;
border-radius:12px;
border:1px solid #c7d2fe;
}

/* QUESTION BOX */

.question-box{
background:#f8fafc;
padding:18px;
border-radius:14px;
margin-bottom:15px;
border:1px solid #e2e8f0;
}

/* BUTTONS */

button{
padding:12px 18px;
border:none;
border-radius:14px;
font-weight:bold;
cursor:pointer;
}

button[type="submit"]{
background:linear-gradient(90deg,#7c3aed,#06b6d4);
color:white;
}

button[type="button"]{
background:#e2e8f0;
margin-right:10px;
}

/* TABLE */

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
text-align:left;
padding:14px;
}

td{
padding:14px;
border-bottom:1px solid #f1f5f9;
}

tr:nth-child(even){
background:#f8fafc;
}

/* STATUS BADGES */

.status{
padding:6px 14px;
border-radius:16px;
font-size:13px;
font-weight:bold;
}

.pending{
background:#fde68a;
color:#92400e;
}

.approved{
background:#bbf7d0;
color:#166534;
}

.rejected{
background:#fecaca;
color:#7f1d1d;
}

/* ACTION BUTTONS */

.actions a{
text-decoration:none;
padding:7px 14px;
border-radius:14px;
font-size:13px;
font-weight:bold;
margin-right:6px;
color:white;
}

.view{
background:#3b82f6;
}

.approve{
background:#22c55e;
}

.reject{
background:#ef4444;
}
.edit{
background:#f59e0b;
}

/* MODAL */

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
z-index:999;
}

.modal-content{
background:white;
padding:30px;
border-radius:20px;
width:400px;
box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

.modal-content h3{
margin-top:0;
color:#7c3aed;
}

.modal-content input,
.modal-content select{
width:100%;
padding:10px;
margin:8px 0;
border-radius:10px;
border:1px solid #cbd5f5;
}


</style>

</head>

<body>

<div class="header">
<h2>Quiz Management</h2>
<a href="admin.php">Back</a>
</div>

<div class="stats">

<div class="card">
<h4>Total</h4>
<h2><?= $stats['total'] ?></h2>
</div>

<div class="card">
<h4>Pending</h4>
<h2><?= $stats['pending'] ?></h2>
</div>

<div class="card">
<h4>Approved</h4>
<h2><?= $stats['approved'] ?></h2>
</div>

<div class="card">
<h4>Rejected</h4>
<h2><?= $stats['rejected'] ?></h2>
</div>

</div>

<div class="container">

<div class="create-box">

<h2>Create New Quiz</h2>

<form method="POST">

<input type="text" name="quiz_title" placeholder="Quiz Title" required>

<select name="quiz_level">
<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">High School</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<div id="questions_container">

<div class="question-box">

<input type="text" name="question[]" placeholder="Question">

<input type="text" name="option1[]" placeholder="Option 1">
<input type="text" name="option2[]" placeholder="Option 2">
<input type="text" name="option3[]" placeholder="Option 3">
<input type="text" name="option4[]" placeholder="Option 4">

<select name="correct[]">
<option value="1">Correct Option 1</option>
<option value="2">Correct Option 2</option>
<option value="3">Correct Option 3</option>
<option value="4">Correct Option 4</option>
</select>

</div>

</div>

<button type="button" onclick="addQuestion()">Add Question</button>

<button type="submit" name="create_quiz">Create Quiz</button>

</form>

</div>

<table>

<tr>
<th>Title</th>
<th>Level</th>
<th>Subject</th>
<th>Status</th>
<th>Date</th>
<th>Actions</th>
</tr>

<?php foreach($quizzes as $level): ?>
<?php foreach($level as $q): ?>

<tr>

<td><?= htmlspecialchars($q['title']) ?></td>

<td><?= ucfirst($q['level']) ?></td>

<td><?= htmlspecialchars($q['subject']) ?></td>

<td>
<span class="status <?= $q['status'] ?>">
<?= ucfirst($q['status']) ?>
</span>
</td>

<td><?= date("d M Y",strtotime($q['created_at'])) ?></td>

<td class="actions">

<a class="view" href="view_quiz.php?id=<?= $q['id'] ?>">View</a>

<a class="edit"
   href="#"
   onclick="openEditModal(<?= $q['id'] ?>)"
   )">Edit</a>

<?php if($q['status']=="pending"): ?>
<a class="approve" href="?action=approve&id=<?= $q['id'] ?>">Approve</a>
<a class="reject" href="?action=reject&id=<?= $q['id'] ?>">Reject</a>
<?php endif; ?>

<a class="reject" href="?delete=<?= $q['id'] ?>">Delete</a>

</td>

</tr>

<?php endforeach; ?>
<?php endforeach; ?>

</table>

</div>

<script>

function addQuestion(){

let container = document.getElementById("questions_container");

let html = `
<div class="question-box">

<input type="text" name="question[]" placeholder="Question">

<input type="text" name="option1[]" placeholder="Option 1">
<input type="text" name="option2[]" placeholder="Option 2">
<input type="text" name="option3[]" placeholder="Option 3">
<input type="text" name="option4[]" placeholder="Option 4">

<select name="correct[]">
<option value="1">Correct Option 1</option>
<option value="2">Correct Option 2</option>
<option value="3">Correct Option 3</option>
<option value="4">Correct Option 4</option>
</select>

</div>
`;

container.insertAdjacentHTML("beforeend",html);

}

function openEditModal(id){

fetch("fetch_quiz.php?id="+id)
.then(res => res.json())
.then(data => {

document.getElementById("editModal").style.display = "flex";

document.getElementById("edit_id").value = data.quiz.id;
document.getElementById("edit_title").value = data.quiz.title;
document.getElementById("edit_level").value = data.quiz.level;

let container = document.getElementById("edit_questions_container");
container.innerHTML = "";

/* Load questions */
data.questions.forEach(q => {

let html = `
<div class="question-box">

<input type="hidden" name="q_id[]" value="${q.id}">

<input type="text" name="question[]" value="${q.question}" placeholder="Question">

<input type="text" name="option1[]" value="${q.option1}">
<input type="text" name="option2[]" value="${q.option2}">
<input type="text" name="option3[]" value="${q.option3}">
<input type="text" name="option4[]" value="${q.option4}">

<select name="correct[]">
<option value="1" ${q.correct_option==1?'selected':''}>Option 1</option>
<option value="2" ${q.correct_option==2?'selected':''}>Option 2</option>
<option value="3" ${q.correct_option==3?'selected':''}>Option 3</option>
<option value="4" ${q.correct_option==4?'selected':''}>Option 4</option>
</select>

</div>
`;

container.insertAdjacentHTML("beforeend", html);

});

});
}

function closeModal(){
document.getElementById("editModal").style.display = "none";
}

/* Close when clicking outside */
window.onclick = function(e){
let modal = document.getElementById("editModal");
if(e.target === modal){
modal.style.display = "none";
}
}

function addEditQuestion(){

let container = document.getElementById("edit_questions_container");

let html = `
<div class="question-box">

<input type="hidden" name="q_id[]" value="new">

<input type="text" name="question[]" placeholder="Question">

<input type="text" name="option1[]" placeholder="Option 1">
<input type="text" name="option2[]" placeholder="Option 2">
<input type="text" name="option3[]" placeholder="Option 3">
<input type="text" name="option4[]" placeholder="Option 4">

<select name="correct[]">
<option value="1">Option 1</option>
<option value="2">Option 2</option>
<option value="3">Option 3</option>
<option value="4">Option 4</option>
</select>

</div>
`;

container.insertAdjacentHTML("beforeend", html);
}

</script>

<!-- EDIT MODAL -->
<div id="editModal" class="modal">
<div class="modal-content" style="width:650px; max-height:90vh; overflow:auto;">

<h3>Edit Quiz + Questions</h3>

<form method="POST">

<input type="hidden" name="quiz_id" id="edit_id">

<input type="text" name="edit_title" id="edit_title" placeholder="Quiz Title">

<select name="edit_level" id="edit_level">
<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">High School</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<hr>

<div id="edit_questions_container"></div>

<button type="button" onclick="addEditQuestion()">➕ Add Question</button>

<br><br>

<button type="submit" name="update_quiz">Update</button>
<button type="button" onclick="closeModal()">Cancel</button>

</form>

</div>
</div>

</body>
</html>

<?php $conn->close(); ?>