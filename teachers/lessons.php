<?php
session_start();
require_once "../config/db.php";

/* 🔐 Allow only teachers */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

/* ➕ ADD LESSON */
if(isset($_POST['add_lesson'])){

    $teacher_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    $stmt = $conn->prepare(
        "INSERT INTO lessons 
        (title, description, category, level, created_by, status) 
        VALUES (?, ?, ?, 'kindergarten', ?, 'pending')"
    );

    $stmt->bind_param("sssi", $title, $description, $category, $teacher_id);
    $stmt->execute();
    $stmt->close();

    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

/* FETCH LESSONS */
$stmt = $conn->prepare(
    "SELECT * FROM lessons 
     WHERE level = 'kindergarten'
     ORDER BY created_at DESC"
);

$stmt->execute();
$result = $stmt->get_result();

$pendingLessons = [];
$approvedLessons = [];

while($row = $result->fetch_assoc()){
    if($row['status'] == 'pending'){
        $pendingLessons[] = $row;
    }
    elseif($row['status'] == 'approved'){
        $approvedLessons[] = $row;
    }
}

$totalLessons = count($pendingLessons) + count($approvedLessons);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Kindergarten Lessons</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Segoe UI;}

body{
    background:linear-gradient(135deg,#f0f9ff,#fdf4ff);
}

/* ================= NAVBAR ================= */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px 40px;
    background:linear-gradient(90deg,#2563eb,#7c3aed);
    color:white;
}

.navbar h2{
    font-weight:600;
}

.back-btn{
    background:white;
    color:#2563eb;
    padding:8px 18px;
    border-radius:25px;
    text-decoration:none;
    font-size:14px;
    font-weight:600;
}

/* MAIN CONTAINER */
.container{
    padding:40px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.add-btn{
    padding:12px 30px;
    background:linear-gradient(45deg,#2563eb,#7c3aed);
    border:none;
    border-radius:30px;
    color:white;
    cursor:pointer;
}

/* INSTRUCTIONS SECTION */
.instructions{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-bottom:40px;
}

.instructions h3{
    margin-bottom:15px;
    color:#1e293b;
}

.instructions ul{
    padding-left:20px;
    line-height:1.8;
}

/* STATS */
.stats{
    display:flex;
    gap:20px;
    margin-bottom:40px;
}

.stat-card{
    flex:1;
    background:white;
    padding:20px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    text-align:center;
}

.stat-card h3{
    font-size:26px;
}

/* SECTION TITLE */
.section-title{
    font-size:22px;
    margin-bottom:20px;
}

/* PENDING */
.pending-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:20px;
    margin-bottom:50px;
}

.pending-card{
    background:white;
    padding:20px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.pending-badge{
    display:inline-block;
    margin-top:10px;
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    background:#fde68a;
    color:#92400e;
}

/* APPROVED */
.approved-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:20px;
}

.approved-card{
    background:linear-gradient(135deg,#dcfce7,#f0fdf4);
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.approved-badge{
    display:inline-block;
    margin-top:12px;
    padding:8px 18px;
    border-radius:30px;
    background:#16a34a;
    color:white;
    font-size:12px;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
}

.modal-box{
    background:white;
    width:420px;
    margin:8% auto;
    padding:30px;
    border-radius:25px;
}

.modal-box input,
.modal-box select,
.modal-box textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:12px;
    border:1px solid #ddd;
}

.save-btn{
    padding:10px 20px;
    border:none;
    border-radius:20px;
    background:#2563eb;
    color:white;
}

.cancel-btn{
    background:#9ca3af;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>🎓 Teacher Panel - Kindergarten</h2>
    <a href="../teachers/kindergarten.php" class="back-btn">⬅ Back to Dashboard</a>
</div>

<div class="container">

<div class="header">
    <h1>📘 Kindergarten Lessons</h1>
    <button class="add-btn" onclick="openModal()">➕ Add Lesson</button>
</div>

<!-- GENERAL INSTRUCTIONS -->
<div class="instructions">
    <h3>📌 General Teaching Instructions</h3>
    <ul>
        <li>Use colorful visuals and interactive activities to keep children engaged.</li>
        <li>Break lessons into small segments (10–15 minutes each).</li>
        <li>Encourage participation through songs, storytelling, and games.</li>
        <li>Use real-life examples and objects for better understanding.</li>
        <li>Always repeat key concepts in simple language.</li>
        <li>Appreciate students frequently to boost confidence.</li>
        <li>Use hands-on learning like drawing, coloring, and matching exercises.</li>
    </ul>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat-card">
        <h3><?php echo $totalLessons; ?></h3>
        <p>Total Lessons</p>
    </div>
    <div class="stat-card">
        <h3><?php echo count($pendingLessons); ?></h3>
        <p>Pending</p>
    </div>
    <div class="stat-card">
        <h3><?php echo count($approvedLessons); ?></h3>
        <p>Approved</p>
    </div>
</div>

<!-- PENDING -->
<h2 class="section-title">🟡 Pending Lessons</h2>
<?php if(count($pendingLessons)>0): ?>
<div class="pending-grid">
<?php foreach($pendingLessons as $row): ?>
<div class="pending-card">
<h3><?php echo htmlspecialchars($row['title']); ?></h3>
<p><?php echo htmlspecialchars($row['description']); ?></p>
<p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
<small>Created: <?php echo date("d M Y", strtotime($row['created_at'])); ?></small>
<span class="pending-badge">Pending</span>
</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<p>No pending lessons found.</p>
<?php endif; ?>

<!-- APPROVED -->
<h2 class="section-title">🟢 Approved Lessons</h2>
<?php if(count($approvedLessons)>0): ?>
<div class="approved-container">
<?php foreach($approvedLessons as $row): ?>
<div class="approved-card">
<h3><?php echo htmlspecialchars($row['title']); ?></h3>
<p><?php echo htmlspecialchars($row['description']); ?></p>
<p><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></p>
<small>Approved On: <?php echo date("d M Y", strtotime($row['created_at'])); ?></small>
<span class="approved-badge">Approved</span>
</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<p>No approved lessons found.</p>
<?php endif; ?>

</div>

<!-- MODAL -->
<div class="modal" id="modal">
<div class="modal-box">
<h3>Add New Lesson</h3>
<form method="POST">
<input type="text" name="title" placeholder="Lesson Title" required>
<select name="category" required>
<option value="">Select Category</option>
<option>Language</option>
<option>Numeracy</option>
<option>Shapes & Colors</option>
<option>Life Skills</option>
</select>
<textarea name="description" placeholder="Lesson Description" required></textarea>
<button type="submit" name="add_lesson" class="save-btn">Save</button>
<button type="button" onclick="closeModal()" class="save-btn cancel-btn">Cancel</button>
</form>
</div>
</div>

<script>
function openModal(){
    document.getElementById("modal").style.display="block";
}
function closeModal(){
    document.getElementById("modal").style.display="none";
}
</script>

</body>
</html>