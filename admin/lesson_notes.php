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

$type = $_GET['type'] ?? 'lessons';

if($type == 'primary'){
    $table = "primary_lessons";
}else{
    $table = "lessons";
}

/* AUTO INSERT SAMPLE LESSON NOTES (RUN ONCE) */
$check = $conn->query("SELECT COUNT(*) c FROM lesson_notes");
$count = $check->fetch_assoc()['c'];

if ($count == 0) {

    $samples = [
        [
            'title' => 'Algebra Basics',
            'course_id' => 1,
            'level' => 'secondary',
            'file' => 'uploads/notes/maths_sample.pdf'
        ],
        [
            'title' => 'Introduction to Physics',
            'course_id' => 2,
            'level' => 'secondary',
            'file' => 'uploads/notes/physics_sample.docx'
        ]
    ];

    $stmt = $conn->prepare("
        INSERT INTO lesson_notes
        (title, course_id, level, file_path, status, created_by, created_by_role)
        VALUES (?, ?, ?, ?, 'approved', ?, 'admin')
    ");

    foreach ($samples as $s) {
        $adminId = $_SESSION['user_id'];
        $stmt->bind_param(
            "sisss",
            $s['title'],
            $s['course_id'],
            $s['level'],
            $s['file'],
            $adminId
        );
        $stmt->execute();
    }

    $stmt->close();
}

/* HANDLE NEW LESSON NOTE UPLOAD */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['note_file'])) {

    if ($_FILES['note_file']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = "../uploads/notes/";

        // Ensure directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['note_file']['name']);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['note_file']['tmp_name'], $targetFile)) {

            $filePathDB = "uploads/notes/" . $fileName;

            $stmt = $conn->prepare("
                INSERT INTO lesson_notes
                (title, course_id, level, file_path, status, created_by, created_by_role)
                VALUES (?, ?, ?, ?, 'pending', ?, 'admin')
            ");

            $stmt->bind_param(
                "sisss",
                $_POST['title'],
                $_POST['course_id'],
                $_POST['level'],
                $filePathDB,
                $_SESSION['user_id']
            );

            $stmt->execute();
            $stmt->close();
        }
    }
}

/* Approve / Reject action */
if (isset($_GET['action'], $_GET['id'])) {
    $id = (int)$_GET['id'];
    $status = $_GET['action'] === 'approve' ? 'approved' : 'rejected';

    $stmt = $conn->prepare("UPDATE lesson_notes SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: lesson_notes.php");
    exit;
}

/* DELETE LESSON NOTE */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM lesson_notes WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    header("Location: lesson_notes.php");
    exit;
}


/* UPDATE LESSON NOTE */
if(isset($_POST['update_note'])){

    $id = $_POST['note_id'];
    $title = $_POST['edit_title'];
    $course_id = $_POST['edit_course_id'];
    $level = $_POST['edit_level'];

    $stmt = $conn->prepare("
        UPDATE lesson_notes 
        SET title=?, course_id=?, level=? 
        WHERE id=?
    ");

    $stmt->bind_param("sisi",$title,$course_id,$level,$id);
    $stmt->execute();
    $stmt->close();

    header("Location: lesson_notes.php");
    exit;
}

/* Fetch lesson notes */
$query = "
SELECT ln.*, 
       c.title AS course_title, 
       u.name AS creator_name
FROM lesson_notes ln
LEFT JOIN courses c ON ln.course_id = c.id
LEFT JOIN users u ON ln.created_by = u.id
ORDER BY ln.created_at DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin | Lesson Notes</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
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

/* WRAPPER */
.wrapper{
    max-width:1300px;
    margin:30px auto;
    padding:0 20px;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}
.stat{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}
.stat h3{margin:0;color:#334155;}
.stat p{font-size:26px;margin:10px 0 0;color:#0f766e;font-weight:bold;}

/* TABLE */
.table-box{
    background:#fff;
    border-radius:20px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,0.1);
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
    background:#e0e7ff;
    color:#1e3a8a;
}
tr:nth-child(even){
    background:#f8fafc;
}
.status{
    padding:6px 12px;
    border-radius:14px;
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
.approve-btn{background:#22c55e;color:#fff;}
.reject-btn{background:#ef4444;color:#fff;}
.view-btn{background:#3b82f6;color:#fff;}

/* UPLOAD FORM */
.upload-form{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    align-items:end;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-weight:600;
    margin-bottom:6px;
    color:#334155;
}

.form-group input,
.form-group select{
    padding:12px;
    border-radius:12px;
    border:1px solid #cbd5f5;
    font-size:14px;
}

.form-group small{
    margin-top:4px;
    font-size:12px;
    color:#64748b;
}

.upload-btn{
    background:linear-gradient(90deg,#2563eb,#1e40af);
    color:#fff;
    border:none;
    padding:14px;
    border-radius:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.upload-btn:hover{
    opacity:0.9;
}

</style>
</head>

<body>

<div class="topbar">
    <h1>📘 Lesson Notes Management</h1>
    <a href="../admin/admin.php"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
</div>

<div class="wrapper">

<!-- STAT CARDS -->
<div class="stats">
    <div class="stat">
        <h3>Total Notes</h3>
        <p><?php echo $result->num_rows; ?></p>
    </div>
    <div class="stat">
        <h3>Pending</h3>
        <p>
            <?php
            $p = $conn->query("SELECT COUNT(*) c FROM lesson_notes WHERE status='pending'")->fetch_assoc();
            echo $p['c'];
            ?>
        </p>
    </div>
    <div class="stat">
        <h3>Approved</h3>
        <p>
            <?php
            $a = $conn->query("SELECT COUNT(*) c FROM lesson_notes WHERE status='approved'")->fetch_assoc();
            echo $a['c'];
            ?>
        </p>
    </div>
</div>

<div class="table-box" style="margin-bottom:30px;">
    <h2 style="margin-top:0;color:#1e3a8a;">➕ Upload New Lesson Note</h2>

    <form method="POST" enctype="multipart/form-data" class="upload-form">

        <div class="form-group">
            <label>Lesson Title</label>
            <input type="text" name="title" placeholder="Enter lesson title" required>
        </div>

        <div class="form-group">
            <label>Course ID</label>
            <input type="number" name="course_id" placeholder="Enter course ID" required>
        </div>

        <div class="form-group">
            <label>Education Level</label>
            <select name="level" required>
		<option value="kindergarten">Kindergarten</option>
                <option value="primary">Primary</option>
                <option value="secondary">Secondary</option>
                <option value="highschool">High School</option>
		<option value="undergraduate">UnderGraduate</option>
                <option value="postgraduate">PostGraduate</option>

            </select>
        </div>

        <div class="form-group">
            <label>Lesson File</label>
            <input type="file" name="note_file" required>
            <small>Accepted formats: PDF, DOCX</small>
        </div>

        <button type="submit" class="upload-btn">
            <i class="fa fa-upload"></i> Upload Lesson Note
        </button>

    </form>
</div>

<!-- TABLE -->
<div class="table-box">
<table>
<tr>
    <th>Title</th>
    <th>Course</th>
    <th>Level</th>
    <th>Uploaded By</th>
    <th>Role</th>
    <th>Status</th>
    <th>Date</th>
    <th>Actions</th>
</tr>

<?php if ($result->num_rows > 0): ?>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?php echo htmlspecialchars($row['title']); ?></td>
    <td><?php echo htmlspecialchars($row['course_title'] ?? '—'); ?></td>
    <td><?php echo ucfirst($row['level']); ?></td>
    <td><?php echo htmlspecialchars($row['creator_name']); ?></td>
    <td><?php echo ucfirst($row['created_by_role']); ?></td>
    <td>
        <span class="status <?php echo $row['status']; ?>">
            <?php echo ucfirst($row['status']); ?>
        </span>
    </td>
    <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
    <td class="actions">

<a class="view-btn" href="../<?php echo $row['file_path']; ?>" target="_blank">View</a>

<a class="approve-btn"
onclick="openEdit(
'<?php echo $row['id']; ?>',
'<?php echo htmlspecialchars($row['title']); ?>',
'<?php echo $row['course_id']; ?>',
'<?php echo $row['level']; ?>'
)">
Edit
</a>

<a class="reject-btn"
href="?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this lesson note?')">
Delete
</a>

<?php if ($row['status'] === 'pending'): ?>
<a class="approve-btn" href="?action=approve&id=<?php echo $row['id']; ?>">Approve</a>
<a class="reject-btn" href="?action=reject&id=<?php echo $row['id']; ?>">Reject</a>
<?php endif; ?>

</td>

</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="8">No lesson notes found.</td></tr>
<?php endif; ?>

</table>
</div>

</div>

<!-- EDIT POPUP -->
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
width:400px;">

<h2>Edit Lesson Note</h2>

<form method="POST">

<input type="hidden" name="note_id" id="edit_id">

<label>Title</label>
<input type="text" name="edit_title" id="edit_title" required style="width:100%;padding:10px;margin-bottom:10px;">

<label>Course ID</label>
<input type="number" name="edit_course_id" id="edit_course_id" required style="width:100%;padding:10px;margin-bottom:10px;">

<label>Level</label>
<select name="edit_level" id="edit_level" style="width:100%;padding:10px;margin-bottom:15px;">
<option value="kindergarten">Kindergarten</option>
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">High School</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<button type="submit" name="update_note" class="upload-btn">Update</button>
<button type="button" onclick="closeEdit()" style="margin-left:10px;">Cancel</button>

</form>

</div>
</div>

<script>

function openEdit(id,title,course,level){

document.getElementById("editModal").style.display="flex";

document.getElementById("edit_id").value=id;
document.getElementById("edit_title").value=title;
document.getElementById("edit_course_id").value=course;
document.getElementById("edit_level").value=level;

}

function closeEdit(){
document.getElementById("editModal").style.display="none";
}

</script>

</body>
</html>

<?php $conn->close(); ?>
