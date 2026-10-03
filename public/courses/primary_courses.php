<?php
session_start();

/* Allow only logged-in users */
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* DB connection */
$conn = new mysqli("localhost", "root", "", "unified_edu");
if ($conn->connect_error) {
    die("Database connection failed");
}

/* Fetch approved secondary courses */
$sql = "SELECT title, description, created_at 
        FROM courses 
        WHERE level = 'secondary' 
          AND status = 'approved'
        ORDER BY created_at DESC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Courses | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    min-height:100vh;
    background: radial-gradient(circle at top,#e0e7ff,#f8fafc);
}

/* NAVBAR */
.navbar{
    background: linear-gradient(90deg,#1e3a8a,#0f766e);
    color:#fff;
    padding:16px 32px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.navbar .logo{
    font-size:22px;
    font-weight:700;
}
.navbar a{
    color:#fff;
    text-decoration:none;
    font-weight:600;
}
.navbar a:hover{
    text-decoration:underline;
}

/* HEADER */
.header{
    text-align:center;
    padding:50px 20px 30px;
}
.header h1{
    font-size:38px;
    color:#1e293b;
}
.header p{
    margin-top:10px;
    font-size:18px;
    color:#475569;
}

/* COURSE TIMELINE */
.timeline{
    max-width:1100px;
    margin:40px auto;
    padding:0 20px;
    display:grid;
    grid-template-columns: repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

/* COURSE CARD */
.course{
    background: linear-gradient(145deg,#ffffff,#f1f5f9);
    border-radius:18px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,0.12);
    position:relative;
    overflow:hidden;
    transition:0.35s ease;
}
.course::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:6px;
    background: linear-gradient(90deg,#6366f1,#14b8a6,#f59e0b);
}
.course:hover{
    transform:translateY(-10px);
    box-shadow:0 25px 55px rgba(0,0,0,0.18);
}

/* ICON */
.course-icon{
    width:70px;
    height:70px;
    border-radius:50%;
    background: linear-gradient(135deg,#6366f1,#14b8a6);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:30px;
    color:#fff;
    margin-bottom:15px;
}

/* CONTENT */
.course h3{
    font-size:22px;
    color:#0f172a;
    margin-bottom:10px;
}
.course p{
    font-size:15px;
    color:#475569;
    line-height:1.6;
}

/* META */
.course .meta{
    margin-top:15px;
    font-size:13px;
    color:#64748b;
    display:flex;
    justify-content:space-between;
}

/* EMPTY STATE */
.empty{
    text-align:center;
    font-size:18px;
    color:#64748b;
    grid-column:1/-1;
}

/* FOOTER */
.footer{
    text-align:center;
    padding:30px 10px;
    font-size:14px;
    color:#64748b;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="logo">Unified Edu</div>
    <a href="../primary.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>📘 Secondary Level Courses</h1>
    <p>Build strong foundations in science, mathematics, and technology</p>
</div>

<!-- COURSES -->
<div class="timeline">

<?php if ($result && $result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="course">
            <div class="course-icon">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
            <h3><?php echo htmlspecialchars($row['title']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="meta">
                <span><i class="fa-solid fa-layer-group"></i> Secondary</span>
                <span><i class="fa-regular fa-calendar"></i>
                    <?php echo date("d M Y", strtotime($row['created_at'])); ?>
                </span>
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="empty">
        🚧 No secondary courses available yet.
    </div>
<?php endif; ?>

</div>

<div class="footer">
    Unified Education Management System ✨
</div>

</body>
</html>
