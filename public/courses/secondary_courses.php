<?php
session_start();

/* Allow only secondary students */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../dashboard.php");
    exit;
}

/* DB CONNECTION */
$conn = new mysqli("localhost", "root", "", "unified_edu");
if ($conn->connect_error) {
    die("Database Connection Failed");
}

/* Fetch approved secondary courses */
$stmt = $conn->prepare("
    SELECT title, description, created_at
    FROM courses
    WHERE level = 'secondary' AND status = 'approved'
    ORDER BY created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Courses</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #eef2ff, #ecfeff);
}

/* HEADER */
.header {
    background: linear-gradient(90deg, #4338ca, #06b6d4);
    color: #fff;
    padding: 25px 40px;
}

.header h1 {
    margin: 0;
    font-size: 28px;
}

.header p {
    margin-top: 6px;
    opacity: 0.9;
}

/* CONTAINER */
.container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
}

/* COURSE LIST */
.course {
    display: flex;
    gap: 20px;
    background: #ffffff;
    border-radius: 16px;
    padding: 22px;
    margin-bottom: 25px;
    box-shadow: 0 10px 28px rgba(0,0,0,0.08);
    transition: 0.3s;
    border-left: 6px solid #6366f1;
}

.course:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}

/* ICON */
.course-icon {
    min-width: 70px;
    height: 70px;
    background: linear-gradient(135deg, #6366f1, #22d3ee);
    color: #fff;
    border-radius: 16px;
    font-size: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* DETAILS */
.course-details h3 {
    margin: 0;
    color: #0f172a;
}

.course-details p {
    margin: 10px 0;
    color: #475569;
    font-size: 15px;
}

.course-details span {
    font-size: 13px;
    color: #64748b;
}

/* BUTTON */
.course-actions {
    margin-left: auto;
    display: flex;
    align-items: center;
}

.course-actions a {
    text-decoration: none;
    background: linear-gradient(90deg, #6366f1, #22d3ee);
    color: #fff;
    padding: 10px 18px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    transition: 0.3s;
}

.course-actions a:hover {
    opacity: 0.9;
}

/* EMPTY STATE */
.empty {
    text-align: center;
    padding: 60px;
    color: #64748b;
}

/* FOOTER */
.footer {
    text-align: center;
    margin: 40px 0 20px;
    color: #64748b;
}

.course-meta {
    margin-left: auto;
    display: flex;
    flex-direction: column;
    gap: 8px;
    font-size: 13px;
    color: #334155;
    background: #f8fafc;
    padding: 12px 14px;
    border-radius: 12px;
    min-width: 180px;
}

.course-meta span {
    background: #eef2ff;
    padding: 6px 10px;
    border-radius: 14px;
    font-weight: 600;
    text-align: center;
}

/* NAVBAR */
.navbar {
    background: #0f172a;
    color: #fff;
    padding: 14px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar .title {
    font-size: 18px;
    font-weight: 700;
}

.navbar a {
    text-decoration: none;
    background: #6366f1;
    color: #fff;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    transition: 0.3s;
}

.navbar a:hover {
    background: #4f46e5;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div class="title">📘 Secondary Courses</div>
    <a href="../secondary.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>📘 Secondary Level Courses</h1>
    <p>Explore subject-wise courses designed for secondary education</p>
</div>

<!-- CONTENT -->
<div class="container">

<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="course">
            <div class="course-icon">📚</div>

            <div class="course-details">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <span>Added on: <?php echo date("d M Y", strtotime($row['created_at'])); ?></span>
            </div>

            <div class="course-meta">
    <span>📌 Core Concepts</span>
    <span>🧠 Skill Development</span>
    <span>📝 Quizzes & Assignments</span>
</div>

        </div>
    <?php endwhile; ?>
<?php else: ?>
    <div class="empty">
        <h2>No courses available</h2>
        <p>Please check back later.</p>
    </div>
<?php endif; ?>

</div>

<div class="footer">
    © <?php echo date("Y"); ?> Unified Edu – Secondary Courses
</div>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
