<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];

require_once "../config/db.php";

/* ADD BOOK */
if(isset($_POST['add_book'])){

    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $teacher_id = $_SESSION['user_id'];

    $level = "undergraduate";
    $status = "pending";

    $stmt = $conn->prepare("
        INSERT INTO books
        (title, category, author, level, description, pdf_file, status, created_by, created_at)
        VALUES (?,?,?,?,?,?,?, ?, NOW())
    ");

    $empty_pdf = ""; // you can update later for file upload

    $stmt->bind_param("sssssssi",
        $title,
        $category,
        $author,
        $level,
        $description,
        $empty_pdf,
        $status,
        $teacher_id
    );

    $stmt->execute();

    echo "<script>alert('✅ Book added successfully! Waiting for admin approval'); window.location.href=window.location.href;</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Undergraduate Books | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Libre+Baskerville:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box}

/* BASE */
body{
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#fff7ed,#fefce8);
    color:#1f2937;
    padding:26px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(135deg,#92400e,#451a03);
    padding:22px 38px;
    border-radius:22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 14px 34px rgba(0,0,0,0.35);
}
.navbar h2{
    font-family:'Libre Baskerville',serif;
    color:#fffbeb;
    font-size:26px;
}
.navbar a{
    color:#fde68a;
    margin-left:22px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff}

/* INTRO */
.intro{
    margin-top:32px;
    background:#ffffff;
    padding:34px;
    border-radius:28px;
    box-shadow:0 12px 30px rgba(0,0,0,0.15);
}
.intro h1{
    font-family:'Libre Baskerville',serif;
    color:#92400e;
    font-size:30px;
}
.intro p{
    margin-top:12px;
    font-size:16px;
    line-height:1.7;
    color:#374151;
}

/* CATEGORY */
.section{
    margin-top:44px;
}
.section h2{
    font-size:22px;
    margin-bottom:18px;
    color:#78350f;
}

/* BOOK GRID */
.book-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:26px;
}
.book{
    background:linear-gradient(135deg,#fff7ed,#fef3c7);
    padding:26px;
    border-radius:22px;
    box-shadow:0 10px 26px rgba(0,0,0,0.15);
}
.book h3{
    color:#92400e;
    font-size:18px;
    margin-bottom:8px;
}
.book p{
    font-size:14px;
    margin-bottom:6px;
}
.book span{
    font-size:13px;
    color:#57534e;
}

/* DIGITAL RESOURCES */
.digital{
    margin-top:48px;
    background:linear-gradient(135deg,#ecfeff,#f0fdfa);
    padding:36px;
    border-radius:30px;
}
.digital h2{
    color:#0f766e;
    font-size:24px;
}
.digital ul{
    margin-top:14px;
    padding-left:20px;
}
.digital li{
    margin-bottom:10px;
    font-size:14px;
}

/* USAGE TIPS */
.tips{
    margin-top:48px;
    background:#020617;
    padding:36px;
    border-radius:30px;
    color:#e5e7eb;
}
.tips h2{
    color:#fde68a;
    margin-bottom:14px;
}
.tips li{
    margin-bottom:10px;
    font-size:14px;
}

/* FOOTER ACTIONS */
.actions{
    margin-top:48px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.back-btn{
    background:#92400e;
    color:#fffbeb;
    padding:14px 30px;
    border-radius:18px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{background:#78350f}
.note{
    font-size:13px;
    color:#78716c;
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
    padding:25px;
    border-radius:15px;
    width:400px;
}

.input-group{
    margin-bottom:12px;
}

.input-group input,
.input-group textarea{
    width:100%;
    padding:10px;
    margin-top:5px;
}

.form-actions{
    display:flex;
    justify-content:space-between;
}

.btn-submit{
    background:#92400e;
    color:#fff;
    padding:10px 15px;
    border:none;
    border-radius:8px;
}

.btn-cancel{
    background:#e5e7eb;
    padding:10px 15px;
    border:none;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Undergraduate Books</h2>
    <div>
        <a href="undergraduate_lessons.php">Lessons</a>
        <a href="undergraduate_books.php">Books</a>
        <a href="undergraduate_quizzes.php">Quizzes</a>
        <a href="undergraduate_assignments.php">Assignments</a>
        <a href="undergraduate_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- INTRO -->
<div class="intro">
    <h1>Recommended Academic Resources</h1>
    <p>
        This section lists core textbooks, reference materials, and digital resources
        essential for undergraduate students to build strong fundamentals
        and prepare for exams, internships, and higher studies.
    </p><br>
<button class="back-btn" onclick="openModal()">➕ Add Book</button>

</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM books
    WHERE level='undergraduate'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();

$books = [];

while($row = $result->fetch_assoc()){
    $books[$row['status']][] = $row;
}
?>

<!-- CORE TEXTBOOKS -->
<div class="section">
    <h2>📘 Core Textbooks</h2>
    <div class="book-grid">
        <div class="book">
            <h3>Engineering Mathematics</h3>
            <p>Advanced calculus, linear algebra, probability</p>
            <span>Author: B.S. Grewal</span>
        </div>
        <div class="book">
            <h3>Programming in C / Java</h3>
            <p>Foundational programming concepts</p>
            <span>Author: E. Balagurusamy</span>
        </div>
        <div class="book">
            <h3>Database Management Systems</h3>
            <p>Relational models, SQL, normalization</p>
            <span>Author: Korth & Silberschatz</span>
        </div>
        <div class="book">
            <h3>Operating Systems</h3>
            <p>Processes, memory, scheduling</p>
            <span>Author: Galvin</span>
        </div>
    </div>
</div>

<div class="section">
<h2>📚 Added Books</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Books</h3>
<div class="book-grid">

<?php if(isset($books['approved'])): ?>
<?php foreach($books['approved'] as $b): ?>
<div class="book" style="background:#dcfce7;">
    <h3><?php echo $b['title']; ?></h3>
    <p><?php echo $b['description']; ?></p>
    <span>Author: <?php echo $b['author']; ?></span>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No approved books</p>
<?php endif; ?>

</div>

<!-- PENDING -->
<h3 style="color:orange;margin-top:20px;">⏳ Pending Books</h3>
<div class="book-grid">

<?php if(isset($books['pending'])): ?>
<?php foreach($books['pending'] as $b): ?>
<div class="book" style="background:#fef3c7;">
    <h3><?php echo $b['title']; ?></h3>
    <p><?php echo $b['description']; ?></p>
    <span>Author: <?php echo $b['author']; ?></span>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending books</p>
<?php endif; ?>

</div>
</div>

<!-- REFERENCE BOOKS -->
<div class="section">
    <h2>📚 Reference & Advanced Reading</h2>
    <div class="book-grid">
        <div class="book">
            <h3>Artificial Intelligence</h3>
            <p>Search, reasoning, machine learning basics</p>
            <span>Stuart Russell</span>
        </div>
        <div class="book">
            <h3>Computer Networks</h3>
            <p>Protocols, architectures, security</p>
            <span>Tanenbaum</span>
        </div>
        <div class="book">
            <h3>Software Engineering</h3>
            <p>SDLC, UML, agile methods</p>
            <span>Pressman</span>
        </div>
    </div>
</div>

<!-- DIGITAL -->
<div class="digital">
    <h2>🌐 Digital Learning Resources</h2>
    <ul>
        <li>NPTEL & SWAYAM video lectures</li>
        <li>IEEE research papers & journals</li>
        <li>Open-source textbooks (OpenStax)</li>
        <li>Online coding platforms & documentation</li>
    </ul>
</div>

<!-- TIPS -->
<div class="tips">
    <h2>📌 Book Usage Tips for Students</h2>
    <ul>
        <li>Combine textbooks with lecture notes</li>
        <li>Refer reference books for deeper understanding</li>
        <li>Practice problems after every topic</li>
        <li>Use digital resources for recent trends</li>
    </ul>
</div>

<!-- ACTIONS -->
<div class="actions">
    <a href="undergraduate.php" class="back-btn">⬅ Back to Undergraduate</a>
    <div class="note">
        Undergraduate Resources • Curriculum Aligned
    </div>
</div>

<!-- ADD BOOK MODAL -->
<div id="bookModal" class="modal">
<form method="POST" class="modal-box">

<h2>📚 Add New Book</h2>

<div class="input-group">
<label>Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Author</label>
<input type="text" name="author" required>
</div>

<div class="input-group">
<label>Category</label>
<input type="text" name="category" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="form-actions">
<button type="submit" name="add_book" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("bookModal").style.display = "flex";
}

function closeModal(){
    document.getElementById("bookModal").style.display = "none";
}

window.onclick = function(e){
    let modal = document.getElementById("bookModal");
    if(e.target === modal){
        modal.style.display = "none";
    }
}
</script>

</body>
</html>
