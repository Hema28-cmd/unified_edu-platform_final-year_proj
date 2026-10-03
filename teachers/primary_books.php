<?php
session_start();
include "../config/db.php";

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_id = (int)$_SESSION['user_id'];
$teacher_name = $_SESSION['user_name'];

/* ✅ Fetch Primary Books from Database */
$books = $conn->query("
    SELECT * FROM books
    WHERE level='primary'
    AND (status='approved' OR created_by=$teacher_id)
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Books | Teacher Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Fredoka+One&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{background: linear-gradient(135deg,#fffaf0,#dbeafe);font-family:'Poppins', sans-serif;color:#1e293b;padding:20px;}
.navbar{display:flex;justify-content:space-between;align-items:center;background: linear-gradient(90deg,#ec4899,#f472b6);padding:12px 25px;border-radius:12px;box-shadow:0 8px 20px rgba(0,0,0,0.2);margin-bottom:15px;}
.navbar h2{font-family:'Fredoka One', cursive;font-size:20px;color:#fff;}
.navbar a{color:#fff;text-decoration:none;margin-left:18px;font-weight:500;}
.back-btn{display:inline-block;margin-bottom:20px;padding:12px 25px;background: linear-gradient(90deg,#3b82f6,#60a5fa);color:#fff;border-radius:25px;text-decoration:none;font-weight:500;}
.header{margin-bottom:20px;background:#fff0f6;padding:25px;border-radius:25px;box-shadow:0 10px 30px rgba(0,0,0,0.15);text-align:center;}
.header h1{font-family:'Fredoka One', cursive;font-size:26px;color:#d946ef;}
.books-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;}
.book-card{padding:20px;border-radius:20px;box-shadow:0 6px 20px rgba(0,0,0,0.15);background:#ffffff;transition:0.3s;}
.book-card:hover{transform:translateY(-5px);}
.uploaded-book{background:linear-gradient(135deg,#fef3c7,#fde68a);border:2px dashed #f59e0b;}
.book-icon{font-size:32px;margin-bottom:10px;}
.book-card h3{font-family:'Fredoka One', cursive;font-size:18px;margin-bottom:6px;}
.book-card p{font-size:13px;margin-bottom:6px;}
.book-card span{font-size:12px;color:#555;}
.actions{margin-top:25px;display:flex;flex-wrap:wrap;gap:15px;}
.action-btn{padding:10px 18px;border-radius:25px;background: linear-gradient(90deg,#f97316,#facc15);color:#fff;text-decoration:none;font-weight:500;border:none;cursor:pointer;}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);align-items:center;justify-content:center;}
.modal-form{background:#fff;padding:25px;border-radius:20px;width:100%;max-width:400px;}
.form-group{margin-bottom:14px;}
.form-group label{font-weight:600;}
.form-group input,.form-group textarea{width:100%;padding:10px;border-radius:10px;border:1px solid #ccc;}
.form-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:15px;}
/* 🎨 Different colors for books */
.color-1 { background:linear-gradient(135deg,#fef3c7,#fde68a); }
.color-2 { background:linear-gradient(135deg,#dbeafe,#bfdbfe); }
.color-3 { background:linear-gradient(135deg,#dcfce7,#bbf7d0); }
.color-4 { background:linear-gradient(135deg,#fce7f3,#fbcfe8); }
.color-5 { background:linear-gradient(135deg,#ede9fe,#ddd6fe); }
.color-6 { background:linear-gradient(135deg,#cffafe,#a5f3fc); }

</style>
</head>

<body>

<div class="navbar">
    <h2>Primary Books</h2>
    <div>
        <a href="primary_lesson.php">Lessons</a>
        <a href="primary_books.php">Books</a>
        <a href="primary_quizzes.php">Quizzes</a>
        <a href="primary_assignments.php">Assignments</a>
        <a href="primary_project.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<a href="primary.php" class="back-btn">⬅ Back to Dashboard</a>

<div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 📚</h1>
    <p>Manage and explore primary level books.</p>
</div>

<div style="text-align:center;margin-bottom:20px;">
    <button class="action-btn" onclick="openBookForm()">➕ Add New Book PDF</button>
</div>

<div class="books-grid">

<?php if($books->num_rows > 0): ?>

    <?php 
    $i = 1;
    while($book = $books->fetch_assoc()): 
    $colorClass = "color-" . (($i % 6) + 1);
    ?>

        <div class="book-card <?= $colorClass ?> <?php echo ($book['created_by']==$teacher_id ? 'uploaded-book' : ''); ?>">
            
            <div class="book-icon">📚</div>

            <h3><?php echo htmlspecialchars($book['title']); ?></h3>

            <?php if(!empty($book['author'])): ?>
                <span>Author: <?php echo htmlspecialchars($book['author']); ?></span><br>
            <?php endif; ?>

            <p><?php echo htmlspecialchars($book['description']); ?></p>

            <span>Status: <strong><?php echo ucfirst($book['status']); ?></strong></span><br><br>

            <?php if(!empty($book['pdf_file'])): ?>
                <a href="../uploads/books/<?php echo $book['pdf_file']; ?>" 
                   target="_blank" 
                   class="action-btn">📄 View PDF</a>
            <?php endif; ?>

        </div>

    <?php 
    $i++;
    endwhile; 
    ?>

<?php else: ?>
    <p>No books available.</p>
<?php endif; ?>

</div>

<div class="actions">
    <a href="primary_quizzes.php" class="action-btn">📝 View Quizzes</a>
    <a href="primary_assignments.php" class="action-btn">📂 Assignments</a>
    <a href="primary_project.php" class="action-btn">🚀 Projects</a>
    <a href="primary_lesson.php" class="action-btn">📘 View Lessons</a>
</div>

<!-- ADD BOOK MODAL -->
<div id="bookModal" class="modal-overlay">
<form id="bookForm" enctype="multipart/form-data" class="modal-form">
    <h2>➕ Add New Book PDF</h2>

    <div class="form-group">
        <label>Book Title</label>
        <input type="text" name="title" required>
    </div>

    <div class="form-group">
        <label>Description</label>
        <textarea name="description" rows="4" required></textarea>
    </div>

    <div class="form-group">
        <label>Upload PDF</label>
        <input type="file" name="pdf_file" accept="application/pdf" required>
    </div>

    <div class="form-actions">
        <button type="submit" class="action-btn">Submit</button>
        <button type="button" class="action-btn" onclick="closeBookForm()">Cancel</button>
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

document.getElementById('bookForm').addEventListener('submit', function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch('../admin/save_book.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        alert(data.message);
        if(data.success){
            closeBookForm();
            location.reload();
        }
    })
    .catch(err => alert("Upload failed"));
});
</script>

</body>
</html>