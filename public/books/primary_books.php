<?php
session_start();

// Only allow primary level users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary') {
    header("Location: ../dashboard.php");
    exit;
}

/* 📁 Physical path to primary books folder */
$baseDir = __DIR__ . '/primary';

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
<title>Primary School Books</title>

<!-- CSS -->
<link rel="stylesheet" href="../assets/css/primary_student.css">

<!-- Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(to right, #f0f9ff, #e0f2fe);
    margin: 0;
    padding: 0;
}

.navbar {
    display: flex;
    justify-content: space-between;
    background: #0ea5e9;
    padding: 15px 30px;
    color: #fff;
    box-shadow: 0 3px 6px rgba(0,0,0,0.1);
}

.navbar a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    margin-left: 20px;
}

.content {
    padding: 40px 30px;
    max-width: 1200px;
    margin: auto;
}

h2 {
    text-align: center;
    color: #0284c7;
    font-size: 32px;
    margin-bottom: 50px;
}

/* Card layout */
.cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
}

.card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    text-align: center;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
}

.card-header {
    background: #0284c7;
    color: #fff;
    padding: 25px 10px;
    font-size: 20px;
    font-weight: bold;
}

.card-body {
    padding: 20px 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-body i {
    font-size: 50px;
    color: #0284c7;
    margin-bottom: 15px;
}

.card-body p {
    font-size: 14px;
    color: #334155;
}
</style>
</head>
<body>

<div class="navbar">
    <div class="logo">Primary School Books 📘</div>
    <div>
        <a href="../primary.php">Dashboard</a>
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="content">
    <h2>📚 Explore Primary School Books</h2>

    <?php if (empty($files)): ?>
        <p style="text-align:center; font-size:18px; color:#334155;">No books available.</p>
    <?php else: ?>
        <div class="cards">
            <?php foreach ($files as $file):
                $title = ucwords(str_replace(['_', '-', '.pdf'], [' ', ' ', ''], $file));
            ?>
                <div class="card" onclick="window.open('/unified_edu/public/books/primary/<?php echo urlencode($file); ?>','_blank')">
                    <div class="card-header"><?php echo htmlspecialchars($title); ?></div>
                    <div class="card-body">
                        <i class="fa-solid fa-book-open"></i>
                        <p>Click to open book</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
