<?php
session_start();
require_once '../../config/db.php';

/* 🔐 Allow only highschool students */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* 📚 Fetch High School Courses */
$stmt = $conn->prepare("
    SELECT id, title, description
    FROM courses
    WHERE level = 'highschool'
    AND status = 'approved'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
$total_courses = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>High School Courses</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f3f4f6;
    color:#1f2937;
}

/* NAVBAR */
.navbar{
    background:#4c1d95;
    color:white;
    padding:18px 40px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.navbar .logo{
    font-size:22px;
    font-weight:700;
}

.navbar a{
    color:#ddd6fe;
    text-decoration:none;
    font-weight:600;
}
.navbar a:hover{
    color:white;
}

/* HEADER */
.header{
    text-align:center;
    padding:60px 20px 40px;
}

.header h1{
    font-size:40px;
    color:#4c1d95;
}

.header p{
    margin-top:10px;
    font-size:18px;
    color:#6b7280;
}

.count-box{
    margin-top:20px;
    display:inline-block;
    padding:10px 20px;
    background:#14b8a6;
    color:white;
    border-radius:25px;
    font-size:14px;
}

/* CONTAINER */
.container{
    max-width:1000px;
    margin:40px auto 80px;
    padding:0 20px;
}

/* COURSE CARD - Horizontal */
.course-card{
    display:flex;
    background:white;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    overflow:hidden;
    transition:0.3s;
}

.course-card:hover{
    transform:translateX(8px);
    box-shadow:0 12px 30px rgba(0,0,0,0.1);
}

/* Decorative Side Bar */
.course-accent{
    width:8px;
    background:linear-gradient(180deg,#14b8a6,#4c1d95);
}

/* Content */
.course-content{
    padding:30px;
    flex:1;
}

.course-content h3{
    font-size:22px;
    color:#111827;
    margin-bottom:12px;
}

.course-content p{
    font-size:15px;
    color:#4b5563;
    line-height:1.6;
}

/* EMPTY STATE */
.empty{
    text-align:center;
    padding:80px 20px;
}

.empty h2{
    font-size:24px;
    color:#6b7280;
}

/* FOOTER */
.footer{
    background:#4c1d95;
    color:#e9d5ff;
    text-align:center;
    padding:25px;
    font-size:14px;
}

@media(max-width:768px){
    .course-card{
        flex-direction:column;
    }
    .course-accent{
        width:100%;
        height:6px;
    }
}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <a href="../highschool.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>High School Courses</h1>
    <p>Structured academic content designed for advanced students.</p>
    <div class="count-box">
        <?php echo $total_courses; ?> Courses Available
    </div>
</div>

<div class="container">

<?php if($total_courses > 0): ?>

    <?php while($row = $result->fetch_assoc()): ?>
        <div class="course-card">
            <div class="course-accent"></div>

            <div class="course-content">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p>
                    <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                </p>
            </div>
        </div>
    <?php endwhile; ?>

<?php else: ?>
    <div class="empty">
        <h2>No High School Courses Available Yet</h2>
    </div>
<?php endif; ?>

</div>

<!-- FOOTER -->
<div class="footer">
    © <?php echo date("Y"); ?> Unified Edu | High School Learning
</div>

</body>
</html>