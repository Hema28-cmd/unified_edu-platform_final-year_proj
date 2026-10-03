<?php
session_start();

require_once "../config/db.php";

/* ADD ASSIGNMENT */
if(isset($_POST['submit_assignment'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $subject = $_POST['subject'];
    $level = "postgraduate";
    $created_by = $_SESSION['user_id'];
    $role = "teacher";
    $status = "pending";

    $stmt = $conn->prepare("
        INSERT INTO assignments 
        (title, description, level, subject, created_by_role, status, created_by)
        VALUES (?,?,?,?,?,?,?)
    ");

    $stmt->bind_param("ssssssi",
        $title,
        $description,
        $level,
        $subject,
        $role,
        $status,
        $created_by
    );

    $stmt->execute();

    echo "<script>
        alert('✅ Assignment added successfully! Waiting for admin approval');
        window.location.href=window.location.href;
    </script>";
}

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Assignments | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#f1f5f9,#ecfeff);
    color:#0f172a;
    padding:24px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#020617,#0f766e);
    padding:20px 36px;
    border-radius:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 34px rgba(0,0,0,0.4);
}
.navbar h2{
    font-family:'Libre Baskerville', serif;
    color:#5eead4;
}
.navbar a{
    color:#e5e7eb;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#5eead4;}

/* BACK */
.back{
    margin:26px 0;
}
.back a{
    background:linear-gradient(90deg,#14b8a6,#67e8f9);
    color:#020617;
    padding:12px 30px;
    border-radius:26px;
    text-decoration:none;
    font-weight:600;
}

/* HEADER */
.header{
    background:#ffffff;
    padding:36px;
    border-radius:32px;
    box-shadow:0 18px 40px rgba(0,0,0,0.18);
    margin-bottom:42px;
}
.header h1{
    font-family:'Libre Baskerville', serif;
    font-size:30px;
    color:#0f766e;
}
.header p{
    margin-top:12px;
    font-size:15px;
    color:#475569;
    line-height:1.7;
}

/* GRID */
.assignments{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:32px;
}

/* CARD */
.card{
    background:#ffffff;
    padding:28px;
    border-radius:26px;
    box-shadow:0 14px 32px rgba(0,0,0,0.16);
    border-left:6px solid #14b8a6;
}
.card h3{
    color:#020617;
    margin-bottom:6px;
}
.card span{
    font-size:13px;
    color:#0f766e;
    font-weight:600;
}
.card p{
    font-size:14px;
    margin:10px 0;
    color:#334155;
}
.card ul{
    padding-left:18px;
}
.card li{
    font-size:13px;
    margin-bottom:6px;
}

/* GUIDELINES */
.guidelines{
    margin-top:50px;
    background:linear-gradient(135deg,#020617,#134e4a);
    padding:40px;
    border-radius:34px;
    color:#e5e7eb;
}
.guidelines h2{
    font-family:'Libre Baskerville', serif;
    color:#5eead4;
    margin-bottom:16px;
}
.guidelines ul{
    padding-left:22px;
}
.guidelines li{
    font-size:14px;
    margin-bottom:10px;
}
.add-btn{
    margin-top:16px;
    padding:12px 26px;
    border:none;
    border-radius:26px;
    background:linear-gradient(135deg,#14b8a6,#67e8f9);
    color:#020617;
    font-weight:600;
    cursor:pointer;
}
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-box{
    background:#fff;
    padding:24px;
    width:400px;
    border-radius:20px;
    display:flex;
    flex-direction:column;
    gap:10px;
}

.modal-box input,
.modal-box textarea{
    padding:10px;
    border-radius:10px;
    border:1px solid #ccc;
}

.form-actions{
    display:flex;
    gap:10px;
}

.submit-btn{
    flex:1;
    background:#14b8a6;
    border:none;
    padding:10px;
    border-radius:10px;
    color:#fff;
    cursor:pointer;
}

.cancel-btn{
    flex:1;
    background:#e2e8f0;
    border:none;
    padding:10px;
    border-radius:10px;
}

</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Postgraduate Assignments</h2>
    <div>
        <a href="postgraduate_lessons.php">Lessons</a>
        <a href="postgraduate_books.php">Books</a>
        <a href="postgraduate_quizzes.php">Quizzes</a>
        <a href="postgraduate_assignments.php">Assignments</a>
        <a href="postgraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK -->
<div class="back">
    <a href="postgraduate.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Advanced Academic Assignments</h1>
    <p>
        These postgraduate-level assignments are designed to strengthen
        research capability, analytical depth, academic writing, and
        subject mastery required for higher education and research careers.
    </p>
<br>
<button class="add-btn" onclick="openModal()">➕ Add Assignment</button>

</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM assignments 
    WHERE level='postgraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while($row = $res->fetch_assoc()){
    $data[$row['status']][] = $row;
}
?>

<!-- ASSIGNMENTS -->
<div class="assignments">

    <div class="card">
        <h3>Research Review Assignment</h3>
        <span>Literature & Analysis</span>
        <p>Students critically analyze recent research papers.</p>
        <ul>
            <li>Select 5 peer-reviewed journals</li>
            <li>Identify research gaps</li>
            <li>Summarize methodologies</li>
        </ul>
    </div>

    <div class="card">
        <h3>Conceptual Essay</h3>
        <span>Theoretical Understanding</span>
        <p>In-depth explanation of advanced theoretical concepts.</p>
        <ul>
            <li>3000–4000 words</li>
            <li>Include academic references</li>
            <li>Use proper citation style</li>
        </ul>
    </div>

    <div class="card">
        <h3>Case Study Analysis</h3>
        <span>Practical Application</span>
        <p>Apply subject knowledge to real-world scenarios.</p>
        <ul>
            <li>Industry or research-based case</li>
            <li>Problem identification</li>
            <li>Solution justification</li>
        </ul>
    </div>

    <div class="card">
        <h3>Data Interpretation Assignment</h3>
        <span>Analytical Skills</span>
        <p>Evaluate datasets using statistical or analytical tools.</p>
        <ul>
            <li>Use charts and graphs</li>
            <li>Interpret results</li>
            <li>Provide conclusions</li>
        </ul>
    </div>

    <div class="card">
        <h3>Critical Reflection Report</h3>
        <span>Independent Thinking</span>
        <p>Reflect on learning outcomes and academic growth.</p>
        <ul>
            <li>Personal insights</li>
            <li>Challenges faced</li>
            <li>Future learning goals</li>
        </ul>
    </div>

</div>

<h2 style="margin-top:40px;">📊 Assignments from Database</h2><br>

<h3 style="color:green;">✅ Approved</h3><br>
<?php if(isset($data['approved'])): ?>
<?php foreach($data['approved'] as $a): ?>
<div class="card">
<h3><?php echo $a['title']; ?></h3>
<span><?php echo $a['subject']; ?></span>
<p><?php echo $a['description']; ?></p>
<p>Status: Approved</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved assignments</p>
<?php endif; ?>
<br>
<h3 style="color:orange;">⏳ Pending</h3><br>
<?php if(isset($data['pending'])): ?>
<?php foreach($data['pending'] as $a): ?>
<div class="card" style="border-left:6px solid orange;">
<h3><?php echo $a['title']; ?></h3>
<span><?php echo $a['subject']; ?></span>
<p><?php echo $a['description']; ?></p>
<p>Status: Pending</p>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending assignments</p>
<?php endif; ?>


<!-- GUIDELINES -->
<div class="guidelines">
    <h2>📌 Assignment Evaluation Guidelines</h2>
    <ul>
        <li>Originality and plagiarism-free submissions</li>
        <li>Logical structure and clarity</li>
        <li>Strong academic references</li>
        <li>Critical analysis over descriptive writing</li>
        <li>Professional formatting and presentation</li>
    </ul>
</div>

<div id="assignmentModal" class="modal">

<form method="POST" class="modal-box">

<h2>📘 Create Assignment</h2>

<input type="text" name="title" placeholder="Assignment Title" required>

<textarea name="description" placeholder="Description" required></textarea>

<input type="text" name="subject" placeholder="Subject" required>

<div class="form-actions">
<button type="submit" name="submit_assignment" class="submit-btn">Submit</button>
<button type="button" onclick="closeModal()" class="cancel-btn">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("assignmentModal").style.display="flex";
}

function closeModal(){
    document.getElementById("assignmentModal").style.display="none";
}
</script>

</body>
</html>
