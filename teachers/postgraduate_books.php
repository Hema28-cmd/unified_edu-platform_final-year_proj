<?php
session_start();

require_once "../config/db.php";

/* ADD BOOK */
if(isset($_POST['add_book'])){

    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $description = $_POST['description'];

    $level = "postgraduate";
    $status = "pending";
    $created_by = $_SESSION['user_id'];

    /* FILE UPLOAD */
    $pdf_name = $_FILES['pdf_file']['name'];
    $pdf_tmp = $_FILES['pdf_file']['tmp_name'];
    $upload_path = "../uploads/" . $pdf_name;

    move_uploaded_file($pdf_tmp, $upload_path);

    $stmt = $conn->prepare("
        INSERT INTO books
        (title, category, author, level, description, pdf_file, status, created_by, created_at)
        VALUES (?,?,?,?,?,?,?,?,NOW())
    ");

    $stmt->bind_param("sssssssi",
        $title,
        $category,
        $author,
        $level,
        $description,
        $pdf_name,
        $status,
        $created_by
    );

    $stmt->execute();

    echo "<script>
        alert('✅ Book added successfully! Waiting for admin approval');
        window.location.href=window.location.href;
    </script>";
}

/* 🔐 Teacher access check */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Books | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}

body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#ede9fe,#ccfbf1);
    color:#1e293b;
    padding:24px;
}

/* NAVBAR */
.navbar{
    background:linear-gradient(90deg,#3b0764,#134e4a);
    padding:18px 36px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 12px 30px rgba(0,0,0,0.35);
}
.navbar h2{
    font-family:'Merriweather', serif;
    color:#f0fdfa;
    font-size:22px;
}
.navbar a{
    color:#ccfbf1;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#5eead4;}

/* BACK BUTTON */
.back{
    margin:22px 0;
}
.back a{
    display:inline-block;
    background:linear-gradient(90deg,#5eead4,#2dd4bf);
    color:#042f2e;
    padding:10px 26px;
    border-radius:22px;
    font-weight:600;
    text-decoration:none;
    box-shadow:0 6px 18px rgba(0,0,0,0.2);
}

/* HEADER */
.header{
    background:#ffffff;
    padding:34px;
    border-radius:28px;
    box-shadow:0 14px 34px rgba(0,0,0,0.15);
    margin-bottom:36px;
}
.header h1{
    font-family:'Merriweather', serif;
    font-size:28px;
    color:#3b0764;
}
.header p{
    margin-top:10px;
    font-size:15px;
    color:#475569;
    line-height:1.7;
}

/* BOOK SECTIONS */
.section{
    margin-bottom:42px;
}
.section h2{
    color:#134e4a;
    font-size:22px;
    margin-bottom:18px;
}

/* BOOK GRID */
.book-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:26px;
}
.book{
    background:linear-gradient(135deg,#fdf4ff,#ecfeff);
    padding:24px;
    border-radius:24px;
    box-shadow:0 10px 28px rgba(0,0,0,0.15);
}
.book h3{
    color:#3b0764;
    margin-bottom:6px;
}
.book span{
    font-size:13px;
    color:#0f766e;
    font-weight:600;
}
.book p{
    font-size:14px;
    color:#334155;
    margin-top:10px;
}

/* DIGITAL RESOURCES */
.digital{
    background:linear-gradient(135deg,#134e4a,#042f2e);
    padding:36px;
    border-radius:28px;
    color:#f0fdfa;
    box-shadow:0 16px 42px rgba(0,0,0,0.4);
}
.digital h2{
    color:#5eead4;
    margin-bottom:14px;
}
.digital ul{
    padding-left:20px;
}
.digital li{
    font-size:14px;
    margin-bottom:8px;
}

/* TIPS */
.tips{
    margin-top:40px;
    background:linear-gradient(135deg,#ede9fe,#c7d2fe);
    padding:30px;
    border-radius:26px;
    box-shadow:0 12px 32px rgba(0,0,0,0.15);
}
.tips h3{
    color:#312e81;
    margin-bottom:12px;
}
.tips p{
    font-size:14px;
    line-height:1.6;
}
.add-book-btn{
    margin-top:18px;
    padding:12px 26px;
    border:none;
    border-radius:30px;
    font-weight:600;
    color:#fff;
    background:linear-gradient(135deg,#9333ea,#14b8a6);
    cursor:pointer;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
}
.add-book-btn:hover{
    transform:translateY(-2px);
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;left:0;
    width:100%;height:100%;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
}

.modal-box{
    background:#fff;
    padding:25px;
    border-radius:20px;
    width:420px;
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
    background:#14b8a6;
    color:#fff;
    padding:10px;
    border:none;
}

.btn-cancel{
    background:#ddd;
    padding:10px;
    border:none;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Postgraduate Academic Books</h2>
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
    <h1>Postgraduate Book & Reference Library 📚</h1>
    <p>
        This curated library supports advanced academic learning, research work,
        and professional development for postgraduate students across disciplines.
    </p>
<br>
<button class="add-book-btn" onclick="openModal()">➕ Add Book</button>
</div>

<?php
$stmt = $conn->prepare("
    SELECT * FROM books
    WHERE level='postgraduate'
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
            <h3>Advanced Research Methodology</h3>
            <span>Methodology</span>
            <p>Comprehensive guide on qualitative and quantitative research methods.</p>
        </div>

        <div class="book">
            <h3>Statistical Analysis for Researchers</h3>
            <span>Data Analysis</span>
            <p>Advanced statistical tools and real-world research applications.</p>
        </div>

        <div class="book">
            <h3>Advanced Subject Theory</h3>
            <span>Core Discipline</span>
            <p>In-depth theoretical coverage aligned with postgraduate curriculum.</p>
        </div>

    </div>
</div>

<!-- REFERENCE BOOKS -->
<div class="section">
    <h2>📗 Reference & Supplementary Books</h2>
    <div class="book-grid">

        <div class="book">
            <h3>International Case Studies</h3>
            <span>Global Perspective</span>
            <p>Industry and academic case studies from leading institutions.</p>
        </div>

        <div class="book">
            <h3>Professional Ethics & Standards</h3>
            <span>Ethics</span>
            <p>Ethical practices, plagiarism rules, and research integrity.</p>
        </div>

        <div class="book">
            <h3>Advanced Technical Documentation</h3>
            <span>Academic Writing</span>
            <p>Guidelines for thesis writing and technical publications.</p>
        </div>

    </div>
</div>

<div class="section">
<h2>📊 Books from Database</h2>

<!-- APPROVED -->
<h3 style="color:green;">✅ Approved Books</h3>
<div class="book-grid">

<?php if(isset($books['approved'])): ?>
<?php foreach($books['approved'] as $b): ?>
<div class="book" style="background:#dcfce7;">
    <h3><?php echo $b['title']; ?></h3>
    <span><?php echo $b['category']; ?></span>
    <p><?php echo $b['description']; ?></p>
    <small><b>Author:</b> <?php echo $b['author']; ?></small><br>
    <a href="../uploads/<?php echo $b['pdf_file']; ?>" target="_blank">📥 View PDF</a>
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
<div class="book" style="background:#ffedd5;">
    <h3><?php echo $b['title']; ?></h3>
    <span><?php echo $b['category']; ?></span>
    <p><?php echo $b['description']; ?></p>
    <small><b>Author:</b> <?php echo $b['author']; ?></small>
</div>
<?php endforeach; ?>
<?php else: ?>
<p>No pending books</p>
<?php endif; ?>

</div>
</div>

<!-- DIGITAL RESOURCES -->
<div class="digital">
    <h2>🌐 Digital Libraries & Journals</h2>
    <ul>
        <li>IEEE, Springer, Elsevier journals</li>
        <li>Google Scholar & ResearchGate</li>
        <li>Institutional e-library access</li>
        <li>Open-access research repositories</li>
        <li>Conference proceedings & whitepapers</li>
    </ul>
</div>

<!-- TIPS -->
<div class="tips">
    <h3>📌 Teaching & Study Tips</h3>
    <p>
        • Encourage students to use multiple reference sources.<br>
        • Promote journal reading habits.<br>
        • Use books to support dissertation topics.<br>
        • Integrate digital libraries with coursework.
    </p>
</div>

<!-- BOOK MODAL -->
<div id="bookModal" class="modal">

<form method="POST" enctype="multipart/form-data" class="modal-box">

<h2>📚 Add New Book</h2>

<div class="input-group">
<label>Title</label>
<input type="text" name="title" required>
</div>

<div class="input-group">
<label>Category</label>
<input type="text" name="category" required>
</div>

<div class="input-group">
<label>Author</label>
<input type="text" name="author" required>
</div>

<div class="input-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="input-group">
<label>Upload PDF</label>
<input type="file" name="pdf_file" required>
</div>

<div class="form-actions">
<button type="submit" name="add_book" class="btn-submit">Submit</button>
<button type="button" onclick="closeModal()" class="btn-cancel">Cancel</button>
</div>

</form>
</div>

<script>
function openModal(){
    document.getElementById("bookModal").style.display="flex";
}
function closeModal(){
    document.getElementById("bookModal").style.display="none";
}
window.onclick = function(e){
    let modal = document.getElementById("bookModal");
    if(e.target === modal){
        modal.style.display="none";
    }
}
</script>

</body>
</html>
