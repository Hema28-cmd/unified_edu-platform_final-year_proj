<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

require_once "../config/db.php";

$teacher_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM books WHERE created_by = ? AND level='secondary' ORDER BY created_at DESC");
$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$result = $stmt->get_result();

$teacher_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Books | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Merriweather:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Poppins', sans-serif;
    background:linear-gradient(135deg,#faf5ff,#fff1f2);
    padding:22px;
    color:#1e293b;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(90deg,#6d28d9,#be185d);
    padding:16px 30px;
    border-radius:16px;
    box-shadow:0 12px 30px rgba(0,0,0,0.25);
}
.navbar h2{
    font-family:'Merriweather', serif;
    color:#fff;
}
.navbar a{
    color:#fdf4ff;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#fde68a;}

/* BACK */
.back{
    margin:22px 0;
}
.back a{
    padding:10px 24px;
    background:linear-gradient(90deg,#fb7185,#f43f5e);
    color:#fff;
    text-decoration:none;
    border-radius:30px;
    font-weight:500;
}

/* PAGE HEADER */
.header{
    background:#ffffff;
    border-radius:30px;
    padding:32px;
    box-shadow:0 14px 35px rgba(0,0,0,0.15);
    margin-bottom:35px;
}
.header h1{
    font-family:'Merriweather', serif;
    color:#6d28d9;
}
.header p{
    margin-top:10px;
    color:#475569;
    font-size:15px;
}

/* SUBJECT BLOCK */
.subject{
    margin-bottom:45px;
}
.subject-title{
    font-size:22px;
    font-weight:600;
    margin-bottom:18px;
    color:#be185d;
}

/* BOOK TIMELINE */
.book-timeline{
    display:flex;
    flex-direction:column;
    gap:20px;
}

/* BOOK ROW */
.book-row{
    display:grid;
    grid-template-columns:70px 1fr;
    gap:20px;
    background:#ffffff;
    border-radius:24px;
    padding:22px;
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
}
.icon{
    font-size:40px;
    display:flex;
    align-items:flex-start;
    justify-content:center;
}
.book-content h3{
    color:#6d28d9;
    margin-bottom:6px;
}
.book-content p{
    font-size:14px;
    color:#475569;
    margin-bottom:6px;
}
.book-content ul{
    padding-left:18px;
    font-size:14px;
    color:#334155;
}

/* EXTRA STRIP */
.strip{
    margin-top:40px;
    background:linear-gradient(135deg,#ede9fe,#fce7f3);
    padding:28px;
    border-radius:26px;
    box-shadow:0 12px 30px rgba(0,0,0,0.18);
}
.strip h3{
    color:#7c3aed;
    margin-bottom:10px;
}
.strip p{
    font-size:14px;
    line-height:1.6;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Secondary Books</h2>
    <div>
        <a href="secondary_lessons.php">Lessons</a>
        <a href="secondary_books.php">Books</a>
        <a href="secondary_quizzes.php">Quizzes</a>
        <a href="secondary_assignments.php">Assignments</a>
        <a href="secondary_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK -->
<div class="back">
    <a href="secondary.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Subject-wise Academic Books 📚</h1>
    <p>
        This section provides detailed information about prescribed textbooks,
        reference books, and supplementary learning materials used in secondary education.
        These resources support lesson delivery, assessments, and project work.
   </p>

<br>
<button id="openBookPopup" style="padding:10px 20px;border:none;border-radius:8px;background:#6d28d9;color:white;cursor:pointer;font-weight:500;">
➕ Add New Secondary Book
</button>

</div>

<!-- MATHEMATICS -->
<div class="subject">
<div class="subject-title">📐 Mathematics</div>
<div class="book-timeline">

<div class="book-row">
<div class="icon">📘</div>
<div class="book-content">
<h3>NCERT Mathematics (Class 8–10)</h3>
<p><b>Purpose:</b> Core curriculum coverage</p>
<p><b>Difficulty Level:</b> Moderate</p>
<ul>
<li>Algebraic expressions and equations</li>
<li>Geometry, mensuration, and constructions</li>
<li>Statistics and data interpretation</li>
</ul>
<p><b>Teaching Approach:</b> Concept explanation + guided practice</p>
</div>
</div>

<div class="book-row">
<div class="icon">📙</div>
<div class="book-content">
<h3>Advanced Problem Solving</h3>
<p><b>Purpose:</b> Skill enhancement & exam readiness</p>
<p><b>Difficulty Level:</b> High</p>
<ul>
<li>Application-based problems</li>
<li>Logical reasoning and shortcuts</li>
<li>Time-bound practice sets</li>
</ul>
<p><b>Best Used For:</b> Homework, remedial and advanced learners</p>
</div>
</div>

</div>
</div>

<!-- SCIENCE -->
<div class="subject">
<div class="subject-title">🔬 Science</div>
<div class="book-timeline">

<div class="book-row">
<div class="icon">⚙️</div>
<div class="book-content">
<h3>Physics Fundamentals</h3>
<p><b>Focus:</b> Conceptual clarity through examples</p>
<ul>
<li>Motion, force, and laws of physics</li>
<li>Energy, work, and power</li>
<li>Light, sound, and electricity</li>
</ul>
<p><b>Assessment Support:</b> Numerical and reasoning-based questions</p>
</div>
</div>

<div class="book-row">
<div class="icon">🌱</div>
<div class="book-content">
<h3>Biology Essentials</h3>
<p><b>Focus:</b> Understanding life processes</p>
<ul>
<li>Human body systems</li>
<li>Plant physiology</li>
<li>Environment and sustainability</li>
</ul>
<p><b>Learning Method:</b> Diagrams, case studies, activities</p>
</div>
</div>

</div>
</div>

<!-- EXTRA STRIP -->
<div class="strip">
<h3>🎓 Academic Implementation Notes</h3>
<p>
• Teachers can align chapters with lesson plans and weekly schedules.<br>
• Reference books help differentiate instruction for mixed-ability classrooms.<br>
• Books support quizzes, assignments, lab records, and project work.<br>
• Encourages self-study, critical thinking, and exam preparedness.
</p>
</div>

<!-- TEACHER ADDED BOOKS -->
<div class="subject">
<div class="subject-title">📚 Your Added Books</div>
<div class="book-timeline">

<?php while($row = $result->fetch_assoc()) { ?>

<div class="book-row">
<div class="icon">📖</div>

<div class="book-content">
<h3><?php echo htmlspecialchars($row['title']); ?></h3>

<p><b>Category:</b> <?php echo htmlspecialchars($row['category']); ?></p>

<p><b>Author:</b> <?php echo htmlspecialchars($row['author']); ?></p>

<p><b>Description:</b> <?php echo htmlspecialchars($row['description']); ?></p>

<p>
<b>Status:</b> 
<?php
$status = $row['status'];

if($status == 'pending'){
    echo "<span style='color:orange;font-weight:600;'>Pending Approval</span>";
}
elseif($status == 'approved'){
    echo "<span style='color:green;font-weight:600;'>Approved</span>";
}
else{
    echo "<span style='color:red;font-weight:600;'>Rejected</span>";
}
?>
</p>

<?php if(!empty($row['pdf_file'])) { ?>
<p>
<a href="<?php echo $row['pdf_file']; ?>" target="_blank" style="color:#6d28d9;font-weight:500;">
📄 View Book PDF
</a>
</p>
<?php } ?>

</div>
</div>

<?php } ?>

</div>
</div>

<!-- ADD BOOK POPUP -->
<div id="bookPopup" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;">

<div style="background:white;padding:25px;border-radius:12px;width:420px;">

<h3>Add Secondary Book</h3>

<form id="addBookForm" enctype="multipart/form-data">

<input type="text" name="title" placeholder="Book Title" required style="width:100%;margin-bottom:10px;padding:8px;"><br>

<input type="text" name="category" placeholder="Category (Mathematics, Science)" required style="width:100%;margin-bottom:10px;padding:8px;"><br>

<input type="text" name="author" placeholder="Author Name" required style="width:100%;margin-bottom:10px;padding:8px;"><br>

<textarea name="description" placeholder="Book Description" required style="width:100%;margin-bottom:10px;padding:8px;"></textarea>

<input type="file" name="pdf_file" accept="application/pdf" required style="width:100%;margin-bottom:10px;padding:8px;">

<button type="submit" style="padding:8px 16px;background:#6d28d9;color:white;border:none;border-radius:6px;">Save</button>

<button type="button" id="closeBookPopup" style="padding:8px 16px;background:#ccc;border:none;border-radius:6px;">Cancel</button>

</form>

</div>
</div>
<script>

const popup = document.getElementById("bookPopup");

document.getElementById("openBookPopup").onclick = () => {
    popup.style.display = "flex";
};

document.getElementById("closeBookPopup").onclick = () => {
    popup.style.display = "none";
};

document.getElementById("addBookForm").onsubmit = function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch("add_secondary_book.php",{
        method:"POST",
        body:formData
    })
    .then(res=>res.json())
.then(data=>{
    alert(data.message);
    popup.style.display="none";
    location.reload();
})
.catch(err=>{
    alert("Upload failed");
});
}

</script>
</body>
</html>
