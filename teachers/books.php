<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

require_once "../config/db.php";

$teacher_id = $_SESSION['user_id'];

/* ================= ADD BOOK ================= */
if (isset($_POST['add_book'])) {

    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $author = "Kindergarten Team";
    $level = "kindergarten";
    $status = "pending";
    $created_at = date("Y-m-d H:i:s");

    if ($title === "" || $description === "") {
        die("Title and description required");
    }

    $pdf_name = "";

    if (!empty($_FILES['pdf']['name'])) {

        $ext = strtolower(pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION));

        if ($ext !== "pdf") {
            die("Only PDF files allowed");
        }

        $pdf_name = time() . "_" . basename($_FILES['pdf']['name']);
        move_uploaded_file($_FILES['pdf']['tmp_name'], "../uploads/books/" . $pdf_name);
    }

    $stmt = $conn->prepare(
        "INSERT INTO books 
        (title, category, author, level, description, pdf_file, status, created_by, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "sssssssis",
        $title,
        $category,
        $author,
        $level,
        $description,
        $pdf_name,
        $status,
        $teacher_id,
        $created_at
    );

    $stmt->execute();
    $stmt->close();

    header("Location: books.php");
    exit;
}

/* ================= FETCH BOOKS ================= */
/* Show:
   - All approved kindergarten books
   - PLUS this teacher's own books (any status)
*/

$stmt = $conn->prepare(
    "SELECT * FROM books 
     WHERE level='kindergarten'
     AND (status='approved' OR created_by=?)
     ORDER BY category, created_at DESC"
);

$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

/* GROUP BY CATEGORY */
$booksByCategory = [];

while ($row = $result->fetch_assoc()) {
    $booksByCategory[$row['category']][] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
<title>Kindergarten Books</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

/* 🌈 Background */
body{
    background:linear-gradient(135deg,#f0f9ff,#fef3c7);
    padding:30px;
    color:#1e293b;
}

/* 🔝 Navbar */
.navbar{
    background:linear-gradient(90deg,#6366f1,#0ea5e9);
    padding:18px 25px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
    box-shadow:0 8px 25px rgba(0,0,0,0.2);
}

.navbar h2{
    font-size:22px;
}

.navbar a{
    background:white;
    color:#0ea5e9;
    padding:8px 14px;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
}

/* ➕ Add Button */
.add-btn{
    background:linear-gradient(90deg,#22c55e,#16a34a);
    padding:10px 18px;
    border:none;
    border-radius:10px;
    color:white;
    cursor:pointer;
    font-weight:600;
}

.add-btn:hover{
    transform:translateY(-2px);
}

/* 📚 Section */
.section{
    margin-top:40px;
}

.section h3{
    margin-bottom:15px;
    color:#7c3aed;
}

/* 📦 Cards Layout */
.container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:20px;
}

/* 📘 Card */
.card{
    background:white;
    padding:20px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
}

.card h4{
    color:#2563eb;
    margin-bottom:10px;
}

.card p{
    font-size:14px;
    margin-bottom:10px;
    line-height:1.5;
}

/* 🏷 Badge */
.badge{
    padding:5px 12px;
    border-radius:20px;
    font-size:12px;
    color:white;
}

.approved{ background:#16a34a; }
.pending{ background:#f59e0b; }
.rejected{ background:#dc2626; }

/* 📄 PDF Link */
.card a{
    display:inline-block;
    margin-bottom:8px;
    color:#0ea5e9;
    font-weight:600;
    text-decoration:none;
}

/* 📘 Teaching Tips */
.tips{
    margin-top:50px;
    background:white;
    padding:25px;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
}

.tips h3{
    color:#ea580c;
    margin-bottom:12px;
}

.tips ul{
    padding-left:20px;
}

.tips li{
    margin-bottom:8px;
    font-size:14px;
}

/* 📋 Modal */
#modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.6);
}

.modal-content{
    background:white;
    padding:25px;
    max-width:450px;
    margin:8% auto;
    border-radius:18px;
}

.modal-content input,
.modal-content select,
.modal-content textarea{
    width:100%;
    padding:8px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #ddd;
}

.modal-content button{
    padding:8px 14px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:600;
}

.save-btn{
    background:#22c55e;
    color:white;
}

.cancel-btn{
    background:#9ca3af;
    color:white;
}
</style>
</head>

<body>

<!-- 🔝 Navbar -->
<div class="navbar">
    <h2>📚 Kindergarten Learning Library</h2>
    <div>
        <button onclick="document.getElementById('modal').style.display='block'" class="add-btn">
            ➕ Add Book
        </button>
        <a href="kindergarten.php">⬅ Dashboard</a>
    </div>
</div>

<!-- 🔍 Search -->
<div style="margin-top:25px; text-align:center;">
    <input 
        type="text" 
        placeholder="🔍 Search books by title..." 
        onkeyup="searchBooks(this.value)"
        style="padding:10px; width:60%; border-radius:10px; border:1px solid #ccc;"
    >
</div>

<!-- 📚 DISPLAY BOOKS -->
<?php if(!empty($booksByCategory)): ?>

    <?php foreach($booksByCategory as $category => $books): ?>

        <div class="section">
            <h3>📂 <?php echo htmlspecialchars($category); ?></h3>

            <div class="container">

                <?php foreach($books as $b): ?>

                    <div class="card">
                        <h4><?php echo htmlspecialchars($b['title']); ?></h4>

                        <p><?php echo htmlspecialchars($b['description']); ?></p>

                        <?php if(!empty($b['pdf_file'])): ?>
                            <a href="../uploads/books/<?php echo $b['pdf_file']; ?>" target="_blank">
                                📄 View PDF
                            </a>
                        <?php endif; ?>

                        <span class="badge <?php echo $b['status']; ?>">
                            <?php echo ucfirst($b['status']); ?>
                        </span>

                    </div>

                <?php endforeach; ?>

            </div>
        </div>

    <?php endforeach; ?>

<?php else: ?>

    <div class="section">
        <p>No Kindergarten books available.</p>
    </div>

<?php endif; ?>

<div class="tips">
    <h3>👩‍🏫 Teacher Guidelines</h3>
    <ul>
        <li>Select books based on student understanding level.</li>
        <li>Use storytelling along with visual aids.</li>
        <li>Encourage interactive reading sessions.</li>
        <li>Assign small reading activities after each book.</li>
        <li>Track student engagement and participation.</li>
    </ul>
</div>

<!-- 📘 Teaching Tips Section -->
<div class="tips">
    <h3>📘 Teaching Tips & Tricks</h3>
    <ul>
        <li>Encourage children to describe pictures in their own words.</li>
        <li>Use expressive voice while reading stories aloud.</li>
        <li>Ask simple open-ended questions.</li>
        <li>Allow students to act out short story scenes.</li>
        <li>Use colorful flashcards alongside books.</li>
        <li>Promote group storytelling sessions.</li>
    </ul>
</div>

<!-- 📋 ADD BOOK MODAL -->
<div id="modal">
    <div class="modal-content">
        <h3>Add Book</h3>

        <form method="POST" enctype="multipart/form-data">

            <input type="text" name="title" placeholder="Book Title" required>

            <select name="category" required>
                <option>Story Books</option>
                <option>Rhymes & Phonics</option>
                <option>Activity Workbooks</option>
                <option>Creative Books</option>
            </select>

            <textarea name="description" placeholder="Description" required></textarea>

            <input type="file" name="pdf" accept="application/pdf">

            <button name="add_book" class="save-btn">Save</button>
            <button type="button" onclick="document.getElementById('modal').style.display='none'" class="cancel-btn">Cancel</button>

        </form>
    </div>
</div>

<script>
function searchBooks(value) {
    let cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        let text = card.innerText.toLowerCase();
        if (text.includes(value.toLowerCase())) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}
</script>

</body>
</html>