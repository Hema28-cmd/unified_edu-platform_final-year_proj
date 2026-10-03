<?php
session_start();

$conn = new mysqli("localhost","root","","unified_edu");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM courses WHERE id=$id");
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Course</title>

<style>

body{
font-family:Arial;
background:#f1f5f9;
padding:40px;
}

.card{
background:white;
padding:30px;
max-width:500px;
margin:auto;
border-radius:10px;
box-shadow:0 10px 25px rgba(0,0,0,.1);
}

input,textarea,select{
width:100%;
padding:10px;
margin-bottom:15px;
border-radius:6px;
border:1px solid #ccc;
}

button{
background:#6366f1;
color:white;
border:none;
padding:10px;
border-radius:6px;
cursor:pointer;
}

</style>
</head>

<body>

<div class="card">

<h2>Edit Course</h2>

<form method="POST" action="courses.php">

<input type="hidden" name="course_id" value="<?= $row['id'] ?>">

<input type="text" name="title" value="<?= $row['title'] ?>" required>

<textarea name="description"><?= $row['description'] ?></textarea>

<select name="level">

<option value="kindergarten" <?= $row['level']=="kindergarten"?'selected':'' ?>>Kindergarten</option>
<option value="primary" <?= $row['level']=="primary"?'selected':'' ?>>Primary</option>
<option value="secondary" <?= $row['level']=="secondary"?'selected':'' ?>>Secondary</option>
<option value="highschool" <?= $row['level']=="highschool"?'selected':'' ?>>High School</option>
<option value="undergraduate" <?= $row['level']=="undergraduate"?'selected':'' ?>>Undergraduate</option>
<option value="postgraduate" <?= $row['level']=="postgraduate"?'selected':'' ?>>Postgraduate</option>

</select>

<button name="update_course">Update Course</button>

</form>

</div>

</body>
</html>