<?php
session_start();

// Only allow secondary level users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../dashboard.php");
    exit;
}

// Directory containing PDFs
$booksDir = __DIR__ . DIRECTORY_SEPARATOR . "secondary" . DIRECTORY_SEPARATOR;
$groupedBooks = [];

if (is_dir($booksDir)) {
    $allFiles = scandir($booksDir);

    foreach ($allFiles as $file) {

        if (is_file($booksDir . $file) && strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'pdf') {

            // Detect Class from filename
            if (preg_match('/Class\s*(\d+)/i', $file, $matches)) {

                $classNum = $matches[1];

                // Only allow Class 6 to 9
                if ($classNum >= 6 && $classNum <= 9) {

                    $className = "Class " . $classNum;

                    $groupedBooks[$className][] = $file;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Level Books</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
/* BODY & HEADER */
body { 
    margin:0; 
    padding:40px; 
    font-family: 'Roboto', sans-serif; 
    background: linear-gradient(135deg, #f5f7fa, #c3cfe2); 
}
.header { text-align:center; margin-bottom:50px; }
.header h1 { font-family: 'Playfair Display', serif; font-size:48px; color:#1e293b; margin-bottom:10px; }
.header p { color:#334155; font-size:20px; }

/* BOOK CARDS GRID */
.books-container { 
    display:grid; 
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
    gap:30px; 
    max-width:1200px; 
    margin:auto; 
}

/* INDIVIDUAL CARD */
.book-card { 
    background: linear-gradient(145deg, #ffffff, #e0f7fa); 
    border-radius:20px; 
    padding:25px; 
    text-align:center; 
    box-shadow: 0 8px 25px rgba(0,0,0,0.1); 
    transition: transform 0.3s, box-shadow 0.3s; 
}
.book-card:hover { 
    transform: translateY(-8px); 
    box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
}
.book-card h3 { 
    font-family: 'Playfair Display', serif; 
    font-size:20px; 
    margin-bottom:20px; 
    color:#0f172a; 
}

/* VIEW BUTTON */
.book-card a { 
    text-decoration:none; 
    padding:12px 25px; 
    border-radius:30px; 
    color:#fff; 
    background: linear-gradient(135deg, #06b6d4, #3b82f6); 
    font-weight:500; 
    transition: background 0.3s, transform 0.2s; 
    display:inline-block; 
}
.book-card a:hover { 
    background: linear-gradient(135deg, #0284c7, #0ea5e9); 
    transform: scale(1.05);
}

/* BACK BUTTON */
.back-btn { 
    display:block; 
    max-width:220px; 
    margin:50px auto 0; 
    text-align:center; 
    padding:14px 30px; 
    font-size:16px; 
    color:#fff; 
    background: linear-gradient(135deg, #f43f5e, #e11d48); 
    border:none; 
    border-radius:35px; 
    cursor:pointer; 
    text-decoration:none; 
    transition: background 0.3s, transform 0.2s; 
}
.back-btn:hover { 
    background: linear-gradient(135deg, #be123c, #9f1239); 
    transform: scale(1.05);
}

/* NO BOOKS MESSAGE */
.no-books { 
    text-align:center; 
    font-size:22px; 
    color:#334155; 
    margin-top:50px; 
}
.class-section{
    max-width:1200px;
    margin:40px auto;
}

.class-title{
    font-size:26px;
    margin-bottom:20px;
    color:#1e293b;
    border-left:6px solid #3b82f6;
    padding-left:10px;
    font-family:'Playfair Display', serif;
}
</style>
</head>
<body>

<div class="header">
    <h1>Secondary Level Books</h1>
    <p>Click to view your academic books</p>
</div>

<?php 
$classes = ['Class 6','Class 7','Class 8','Class 9'];

foreach($classes as $class): 
    $books = $groupedBooks[$class] ?? [];
?>

<div class="class-section">

    <h2 class="class-title"><?php echo $class; ?></h2>

    <div class="books-container">

        <?php if(!empty($books)): ?>

            <?php foreach($books as $book): 
                $bookName = pathinfo($book, PATHINFO_FILENAME);
                $bookPath = "secondary/" . urlencode($book); 
            ?>

                <div class="book-card">
                    <h3><?php echo htmlspecialchars(str_replace('_', ' ', $bookName)); ?></h3>
                    <a href="<?php echo $bookPath; ?>" target="_blank">📖 View</a>
                </div>

            <?php endforeach; ?>

        <?php else: ?>
            <div class="no-books">No books available for this class.</div>
        <?php endif; ?>

    </div>

</div>

<?php endforeach; ?>
<a href="../secondary.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
