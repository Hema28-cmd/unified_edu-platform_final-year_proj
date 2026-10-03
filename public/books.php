<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    header("Location: dashboard.php");
    exit;
}

/* 📁 Physical path to books */
$baseDir = __DIR__ . '/books/kindergarten';

/* 📄 Read book files */
$files = [];
if (is_dir($baseDir)) {
    $files = array_diff(scandir($baseDir), ['.', '..']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Kindergarten Books | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@600;700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}
body{
    font-family:'Poppins',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#fefce8);
    min-height:100vh;
}

/* 🌈 NAVBAR */
.navbar{
    background:linear-gradient(90deg,#38bdf8,#a78bfa);
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    color:white;
}
.navbar .logo{
    font-size:22px;
    font-weight:700;
}
.navbar a{
    color:white;
    text-decoration:none;
    margin-left:15px;
    background:rgba(255,255,255,0.25);
    padding:8px 16px;
    border-radius:20px;
    font-size:14px;
}
.navbar a:hover{background:rgba(255,255,255,0.4);}

/* 🧩 LAYOUT */
.wrapper{
    display:flex;
    max-width:1300px;
    margin:30px auto;
    gap:25px;
    padding:0 20px;
}

/* 📌 SIDEBAR */
.sidebar{
    width:260px;
    background:white;
    border-radius:25px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}
.sidebar h3{
    font-family:'Baloo 2',cursive;
    font-size:24px;
    margin-bottom:15px;
    color:#1e293b;
}
.sidebar ul{
    list-style:none;
}
.sidebar li{
    padding:12px 10px;
    border-radius:12px;
    margin-bottom:10px;
    background:#f1f5f9;
    color:#334155;
    font-size:15px;
}
.sidebar li i{
    margin-right:10px;
    color:#6366f1;
}

/* 📚 MAIN CONTENT */
.main{
    flex:1;
}
.main h2{
    font-family:'Baloo 2',cursive;
    font-size:34px;
    color:#1e293b;
}
.main p{
    margin-top:8px;
    color:#475569;
    font-size:16px;
}

/* 📘 BOOK GRID */
.books{
    margin-top:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:25px;
}

/* 📖 BOOK CARD */
.book{
    background:white;
    border-radius:25px;
    padding:25px 20px;
    text-align:center;
    box-shadow:0 15px 35px rgba(0,0,0,0.12);
    cursor:pointer;
    transition:0.3s;
    position:relative;
}
.book:hover{
    transform:translateY(-8px) scale(1.03);
}

/* ICON */
.book i{
    font-size:45px;
    color:#f97316;
    margin-bottom:12px;
}
.book h4{
    font-size:18px;
    color:#1e293b;
    margin-bottom:6px;
}
.book span{
    font-size:13px;
    color:#64748b;
}

/* BADGE */
.badge{
    position:absolute;
    top:15px;
    right:15px;
    background:#22c55e;
    color:white;
    font-size:11px;
    padding:5px 10px;
    border-radius:20px;
}

/* FOOTER */
.footer{
    text-align:center;
    padding:30px;
    font-size:14px;
    color:#475569;
}
</style>
</head>

<body>

<!-- 🌈 NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <div>
        <a href="kindergarten.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- 🧩 MAIN LAYOUT -->
<div class="wrapper">

    <!-- 📌 SIDEBAR -->
    <div class="sidebar">
        <h3>📘 Book Categories</h3>
        <ul>
            <li><i class="fa-solid fa-a"></i> Alphabet Books</li>
            <li><i class="fa-solid fa-1"></i> Number Books</li>
            <li><i class="fa-solid fa-palette"></i> Coloring Books</li>
            <li><i class="fa-solid fa-book-open"></i> Story Books</li>
            <li><i class="fa-solid fa-music"></i> Rhymes Books</li>
        </ul>
    </div>

    <!-- 📚 CONTENT -->
    <div class="main">
        <h2>📚 Kindergarten Digital Books</h2>
        <p>Click any book to read and enjoy learning with pictures and fun stories.</p>

        <?php if (empty($files)): ?>
            <p style="margin-top:20px;color:red;">No books available.</p>
        <?php else: ?>
            <div class="books">
                <?php foreach ($files as $file):
                    $title = ucwords(str_replace(['_', '-', '.pdf'], [' ', ' ', ''], $file));
                ?>
                <div class="book"
                     onclick="window.open('/unified_edu/public/books/kindergarten/<?php echo urlencode($file); ?>','_blank')">
                    <div class="badge">PDF</div>
                    <i class="fa-solid fa-book"></i>
                    <h4><?php echo htmlspecialchars($title); ?></h4>
                    <span>Tap to open</span>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</div>

<div class="footer">
    🌟 Unified Education Management System – Kindergarten Module
</div>

</body>
</html>
