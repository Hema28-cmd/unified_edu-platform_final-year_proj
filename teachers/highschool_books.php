<?php
session_start();
require_once "../config/db.php";

$success = false;

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

/* ADD BOOK */
if(isset($_POST['add_book'])){

    $title = $_POST['title'];
    $category = $_POST['category'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $teacher_id = $_SESSION['user_id'];

    /* FILE UPLOAD */
    $pdf_name = $_FILES['pdf_file']['name'];
    $tmp_name = $_FILES['pdf_file']['tmp_name'];

    $upload_dir = "../uploads/books/";
    if(!is_dir($upload_dir)){
        mkdir($upload_dir, 0777, true);
    }

    $file_path = $upload_dir . time() . "_" . basename($pdf_name);
    move_uploaded_file($tmp_name, $file_path);

    /* INSERT INTO DB */
    $stmt = $conn->prepare("
        INSERT INTO books 
        (title,category,author,level,description,file_path,pdf_file,status,created_by,created_at)
        VALUES (?,?,?,?,?,?,?,?,?,NOW())
    ");

    $level = "highschool";
    $status = "pending";

    $stmt->bind_param("ssssssssi",
        $title,
        $category,
        $author,
        $level,
        $description,
        $file_path,
        $pdf_name,
        $status,
        $teacher_id
    );

    if($stmt->execute()){
        $success = true;
    }
}

/* ✅ FETCH BOOKS (MOVE HERE — OUTSIDE IF) */
$stmt = $conn->prepare("
    SELECT * FROM books 
    WHERE created_by=? AND level='highschool'
    ORDER BY created_at DESC
");

$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$teacher_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>High School Books | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Merriweather:wght@700&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Inter', sans-serif;
    background: linear-gradient(135deg,#f0fdfa,#fff7ed);
    color:#1e293b;
    padding:24px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(90deg,#0f766e,#115e59);
    padding:16px 28px;
    border-radius:16px;
    box-shadow:0 8px 28px rgba(0,0,0,0.2);
}
.navbar h2{
    font-family:'Merriweather', serif;
    color:#ecfeff;
    font-size:22px;
}
.navbar a{
    color:#ccfbf1;
    margin-left:18px;
    text-decoration:none;
    font-weight:500;
}
.navbar a:hover{color:#ffffff;}

/* INTRO */
.intro{
    margin:28px 0;
    background:#ffffff;
    padding:28px;
    border-radius:22px;
    box-shadow:0 10px 28px rgba(0,0,0,0.12);
}
.intro h1{
    font-family:'Merriweather', serif;
    font-size:28px;
    color:#0f766e;
}
.intro p{
    margin-top:10px;
    color:#475569;
    font-size:15px;
    line-height:1.7;
}

.book-cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:28px;
    margin-top:36px;
}

/* UNIQUE CARD STYLE */
.book-card{
    position:relative;
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(14px);
    border-radius:22px;
    padding:24px;
    overflow:hidden;
    box-shadow:0 12px 32px rgba(0,0,0,0.15);
    transition:0.35s;
}

/* Gradient top border */
.book-card::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background:linear-gradient(90deg,#0f766e,#14b8a6,#06b6d4);
}

/* Hover effect */
.book-card:hover{
    transform:translateY(-8px) scale(1.02);
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

/* Title */
.book-card h3{
    font-size:20px;
    color:#0f172a;
    margin-bottom:6px;
}

/* Category badge */
.category-badge{
    display:inline-block;
    background:#ecfeff;
    color:#0f766e;
    padding:4px 10px;
    border-radius:12px;
    font-size:12px;
    font-weight:600;
    margin-bottom:10px;
}

/* Author */
.book-author{
    font-size:13px;
    color:#64748b;
    margin-bottom:10px;
}

/* Description */
.book-desc{
    font-size:14px;
    color:#334155;
    margin-bottom:12px;
    line-height:1.5;
}

/* Footer */
.card-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:12px;
}

/* Button */
.view-btn{
    background:#0f766e;
    color:#fff;
    padding:6px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
}
.view-btn:hover{
    background:#14b8a6;
}

/* Ribbon STATUS */
.ribbon{
    position:absolute;
    top:12px;
    right:-8px;
    padding:6px 16px;
    font-size:11px;
    font-weight:bold;
    transform:rotate(45deg);
    color:#fff;
}

.ribbon.pending{background:#f59e0b;}
.ribbon.approved{background:#10b981;}
.ribbon.rejected{background:#ef4444;}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-top:36px;
    background:#0f766e;
    color:#ffffff;
    padding:12px 28px;
    border-radius:16px;
    text-decoration:none;
    font-weight:600;
}
.back-btn:hover{
    background:#14b8a6;
}
.modal-overlay{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
    justify-content:center;
    align-items:center;
}

.modal-form{
    background:#fff;
    padding:20px;
    border-radius:12px;
    width:100%;
    max-width:500px;
}

.form-group{margin-bottom:12px;}
.form-group input,
.form-group textarea{
    width:100%;
    padding:8px;
    border:1px solid #ccc;
    border-radius:8px;
}

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.action-btn{
    padding:10px 15px;
    background:#0f766e;
    color:#fff;
    border:none;
    border-radius:10px;
    cursor:pointer;
}
.status{
    display:inline-block;
    padding:5px 10px;
    border-radius:12px;
    font-size:12px;
    font-weight:600;
    margin-top:6px;
}

.status.pending{background:#fef3c7;color:#92400e;}
.status.approved{background:#dcfce7;color:#166534;}
.status.rejected{background:#fee2e2;color:#991b1b;}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>High School Books</h2>
    <div>
        <a href="highschool.php">Dashboard</a>
        <a href="highschool_lessons.php">Lessons</a>
        <a href="highschool_books.php">Books</a>
        <a href="highschool_quizzes.php">Quizzes</a>
        <a href="highschool_assignments.php">Assignments</a>
        <a href="highschool_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- INTRO -->
<div class="intro">
    <h1>Academic Books & References</h1>
    <p>Explore textbooks, reference materials, and supplementary resources designed to enhance conceptual understanding for high school students.</p>
</div>

<button class="back-btn" onclick="openBookForm()">➕ Add New Book</button>

<div class="book-cards">

<?php while($book = $result->fetch_assoc()): ?>

<div class="book-card">

    <h3>📘 <?php echo htmlspecialchars($book['title']); ?></h3><br>

    <span>
        📂 <?php echo htmlspecialchars($book['category']); ?> | ✍️ <?php echo htmlspecialchars($book['author']); ?>
        
    </span>

    <p><?php echo htmlspecialchars($book['description']); ?></p> <br>

    <!-- STATUS -->
    <span class="status <?php echo $book['status']; ?>">
        <?php echo ucfirst($book['status']); ?>
    </span>

    <!-- PDF LINK -->
    <?php if(!empty($book['file_path'])): ?>
        <p>
            <a href="<?php echo $book['file_path']; ?>" target="_blank"><br>
                📄 View PDF
            </a>
        </p>
    <?php endif; ?>

    <p style="font-size:12px;color:#64748b;">
        🗓 <?php echo date("d M Y", strtotime($book['created_at'])); ?>
    </p>

</div>

<?php endwhile; ?>

<?php if($result->num_rows == 0): ?>
<div style="text-align:center; padding:30px;">
    <h3>📭 No Books Added Yet</h3>
    <p style="color:#64748b;">Start by adding your first book.</p>
</div>
<?php endif; ?>

</div>
<br><br>
    <!-- LANGUAGE & LITERATURE -->
    <div class="book-card">
        <h3>📖 Literature & Language</h3><br>
        <span>English & Regional Languages</span><br>
        <p>Enhance comprehension, writing, and analytical reading skills.</p><br>
        <ul>
            <li>Grammar & composition</li><br>
            <li>Poetry & prose analysis</li><br>
            <li>Critical reading exercises</li><br>
        </ul>
    </div>

<br><br>
    <!-- SOCIAL STUDIES -->
    <div class="book-card">
        <h3>🌍 Social Studies</h3><br>
        <span>History, Civics, Geography</span><br>
        <p>Books focusing on global and national perspectives.</p><br>
        <ul>
            <li>Historical events & timelines</li><br>
            <li>Geographical studies</li><br>
            <li>Government & civic responsibilities</li><br>
        </ul>
    </div>

</div>

<a href="highschool.php" class="back-btn">⬅ Back to Dashboard</a>

<div id="bookModal" class="modal-overlay">
<form method="POST" enctype="multipart/form-data" class="modal-form">

<h2>📚 Add New Book</h2>

<div class="form-group">
<label>Title</label>
<input type="text" name="title" required>
</div>

<div class="form-group">
<label>Category</label>
<input type="text" name="category" placeholder="Math / Science..." required>
</div>

<div class="form-group">
<label>Author</label>
<input type="text" name="author" required>
</div>

<div class="form-group">
<label>Description</label>
<textarea name="description" required></textarea>
</div>

<div class="form-group">
<label>Upload PDF</label>
<input type="file" name="pdf_file" accept=".pdf" required>
</div>

<div class="form-actions">
<button type="submit" name="add_book" class="action-btn">Save Book</button>
<button type="button" onclick="closeBookForm()" class="action-btn">Cancel</button>
</div>

</form>
</div>

<script>
function openBookForm(){
    document.getElementById('bookModal').style.display='flex';
}

function closeBookForm(){
    document.getElementById('bookModal').style.display='none';
}
</script>

<?php if($success): ?>
<script>
alert("📚 New book created successfully and waiting for admin approval!");
window.location.href = window.location.href;
</script>
<?php endif; ?>

</body>
</html>
