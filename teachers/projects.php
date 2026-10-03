<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

include "../config/db.php";

/* =========================
   ADD PROJECT
========================= */
if(isset($_POST['add_project'])){

    $stmt = $conn->prepare("
        INSERT INTO project_topics
        (title, description, level, domain, created_by_role, created_by, status)
        VALUES (?,?,?,?,?,?, 'pending')
    ");

    $level = 'kindergarten';
    $role = 'teacher';
    $teacher_id = $_SESSION['user_id'];

    $stmt->bind_param(
        "sssssi",
        $_POST['title'],
        $_POST['description'],
        $level,
        $_POST['domain'],
        $role,
        $teacher_id
    );

    if($stmt->execute()){
        $success = "Project submitted successfully! Waiting for admin approval.";
    }
}

/* =========================
   FETCH PROJECTS
========================= */

// Approved
$approved = $conn->query("
    SELECT * FROM project_topics 
    WHERE level='kindergarten' 
    AND status='approved'
    ORDER BY created_at DESC
");

// Pending (only teacher's own)
$pending = $conn->query("
    SELECT * FROM project_topics 
    WHERE level='kindergarten' 
    AND status='pending'
    AND created_by=".$_SESSION['user_id']."
    ORDER BY created_at DESC
");

// Rejected (only teacher's own)
$rejected = $conn->query("
    SELECT * FROM project_topics 
    WHERE level='kindergarten' 
    AND status='rejected'
    AND created_by=".$_SESSION['user_id']."
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Kindergarten Projects</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:'Segoe UI';
    background:linear-gradient(135deg,#fff7ed,#e0f2fe);
    padding:40px;
}
.header{
    background:linear-gradient(90deg,#ea580c,#facc15);
    padding:25px;
    border-radius:20px;
    color:white;
}
.grid{
    margin-top:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}
.card{
    background:white;
    padding:20px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.badge{
    padding:5px 12px;
    border-radius:20px;
    color:white;
    font-size:12px;
}
.approved{ background:green; }
.pending{ background:orange; }
.rejected{ background:red; }

.section{
    margin-top:50px;
}
.add-btn{
    padding:10px 20px;
    background:green;
    color:white;
    border:none;
    border-radius:20px;
    cursor:pointer;
}
.back-btn{
    display:inline-block;
    margin-top:30px;
    padding:10px 20px;
    background:purple;
    color:white;
    text-decoration:none;
    border-radius:20px;
}
.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
}
.modal form{
    background:white;
    padding:30px;
    width:400px;
    border-radius:20px;
}
input,textarea{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}
.approved-card{
    border-left:6px solid #16a34a;
    transition:0.3s ease;
}
.approved-card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:10px;
}

.card-header h3{
    font-size:18px;
    color:#065f46;
}

.card-body .desc{
    font-size:14px;
    line-height:1.6;
    color:#374151;
    margin-bottom:15px;
}

.card-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    font-size:13px;
}

.domain{
    background:#dcfce7;
    color:#166534;
    padding:5px 12px;
    border-radius:20px;
    font-weight:600;
}

.date{
    color:#6b7280;
    font-style:italic;
}
/* Different colors for approved cards */
.color-1 { border-left:6px solid #22c55e; background:#f0fdf4; }
.color-2 { border-left:6px solid #3b82f6; background:#eff6ff; }
.color-3 { border-left:6px solid #f59e0b; background:#fffbeb; }
.color-4 { border-left:6px solid #ef4444; background:#fef2f2; }
.color-5 { border-left:6px solid #8b5cf6; background:#f5f3ff; }
.color-6 { border-left:6px solid #14b8a6; background:#f0fdfa; }

</style>
</head>
<body>

<div class="header">
<h1>🎨 Kindergarten Project Topics</h1>
<p>Creative hands-on learning activities</p>

<button onclick="openModal()" class="add-btn">➕ Add Project</button>

<?php if(isset($success)) echo "<p style='margin-top:10px;'>$success</p>"; ?>
</div>


<!-- =========================
     APPROVED PROJECTS
========================= -->
<div class="section">
<h2 style="margin-bottom:20px;">🟢 Approved Projects</h2>

<?php if($approved->num_rows > 0): ?>

<div class="grid">
<?php 
$i = 1;
while($row = $approved->fetch_assoc()): 
$colorClass = "color-" . (($i % 6) + 1);
?>

<div class="card approved-card <?= $colorClass ?>">

    <div class="card-header">
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <span class="badge approved">Approved</span>
    </div>

    <div class="card-body">
        <p class="desc"><?= nl2br(htmlspecialchars($row['description'])) ?></p>
    </div>

    <div class="card-footer">
        <span class="domain"><?= htmlspecialchars($row['domain']) ?></span>
        <span class="date">
            <?= date("d M Y", strtotime($row['created_at'])) ?>
        </span>
    </div>

</div>

<?php 
$i++;
endwhile; 
?>
</div>

<?php else: ?>
<p style="color:gray;">No approved projects available yet.</p>
<?php endif; ?>

</div>

<!-- =========================
     PENDING PROJECTS
========================= -->
<div class="section">
<h2>🟡 My Pending Projects</h2>
<div class="grid">
<?php while($row = $pending->fetch_assoc()): ?>
<div class="card">
<h3><?= $row['title'] ?></h3>
<p><?= $row['description'] ?></p>
<p><strong>Domain:</strong> <?= $row['domain'] ?></p>
<span class="badge pending">Pending</span>
</div>
<?php endwhile; ?>
</div>
</div>


<!-- =========================
     REJECTED PROJECTS
========================= -->
<div class="section">
<h2>🔴 My Rejected Projects</h2>
<div class="grid">
<?php while($row = $rejected->fetch_assoc()): ?>
<div class="card">
<h3><?= $row['title'] ?></h3>
<p><?= $row['description'] ?></p>
<p><strong>Domain:</strong> <?= $row['domain'] ?></p>
<span class="badge rejected">Rejected</span>
</div>
<?php endwhile; ?>
</div>
</div>


<!-- =========================
     GUIDELINES SECTION
========================= -->
<div class="section">
<h2>📚 Project Guidelines</h2>
<p>• Keep projects simple and age appropriate</p>
<p>• Encourage creativity</p>
<p>• Do not allow parents to complete project</p>
<p>• Appreciate every child’s effort</p>
</div>


<a href="kindergarten.php" class="back-btn">⬅ Back to Dashboard</a>


<!-- =========================
     MODAL FORM
========================= -->
<div class="modal" id="projectModal">
<form method="POST">
<h3>Add Project Topic</h3>

<input type="text" name="title" placeholder="Project Title" required>
<textarea name="description" placeholder="Project Description" required></textarea>
<input type="text" name="domain" placeholder="Domain (Art, Math, etc)" required>

<button type="submit" name="add_project" class="add-btn">Submit</button>
<button type="button" onclick="closeModal()">Cancel</button>
</form>
</div>

<script>
function openModal(){
    document.getElementById('projectModal').style.display='flex';
}
function closeModal(){
    document.getElementById('projectModal').style.display='none';
}
</script>

</body>
</html>