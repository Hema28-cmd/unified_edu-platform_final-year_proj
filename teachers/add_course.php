<?php
session_start();
$conn = new mysqli("localhost","root","","unified_edu");

if ($conn->connect_error) {
    die("Database connection failed");
}

/* ======================
   ACCESS CONTROL
   (ADMIN + TEACHER)
====================== */
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['user_role'], ['teacher','admin'])) {
    header("Location: ../login.php");
    exit;
}

$user_id   = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role']; // teacher / admin

/* ======================
   CREATE COURSES TABLE (SAFE)
====================== */
$conn->query("
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    level VARCHAR(50) NOT NULL,
    created_by INT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

/* ======================
   CREATE NOTIFICATIONS TABLE (SAFE)
====================== */
$conn->query("
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    sender_role VARCHAR(20),
    type VARCHAR(50),
    message TEXT,
    related_level VARCHAR(50),
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

/* ======================
   FORM SUBMIT
====================== */
$success = "";
$error   = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title       = trim($_POST['title']);
    $description = trim($_POST['description']);
    $level       = $_POST['level'];

    if ($title === "" || $level === "") {
        $error = "❌ Course title and level are required.";
    } else {

        /* Insert course */
        $stmt = $conn->prepare("
            INSERT INTO courses (title, description, level, created_by)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("sssi", $title, $description, $level, $user_id);
        $stmt->execute();
        $stmt->close();

        /* Notify admin */
        $msg = "New course \"$title\" created by $user_name ($user_role)";

        $stmt = $conn->prepare("
            INSERT INTO notifications
            (sender_id, sender_role, type, message, related_level)
            VALUES (?, ?, 'course', ?, ?)
        ");
        $stmt->bind_param("isss", $user_id, $user_role, $msg, $level);
        $stmt->execute();
        $stmt->close();

        $success = "✅ Course submitted successfully! Awaiting admin approval.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Course | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#e0f2fe,#fdf4ff,#ecfeff);
    margin:0;
}
.container{
    max-width:540px;
    margin:90px auto;
    background:#ffffff;
    padding:42px;
    border-radius:26px;
    box-shadow:0 25px 45px rgba(0,0,0,.15);
}
h2{
    text-align:center;
    margin-bottom:8px;
}
p{
    text-align:center;
    color:#475569;
    margin-bottom:20px;
}
label{
    display:block;
    margin-top:20px;
    font-weight:600;
}
input, textarea, select{
    width:100%;
    padding:12px;
    margin-top:6px;
    border-radius:14px;
    border:1px solid #c7d2fe;
    font-size:15px;
}
textarea{
    resize:none;
    height:90px;
}
button{
    width:100%;
    margin-top:30px;
    padding:15px;
    font-size:16px;
    font-weight:bold;
    border:none;
    border-radius:30px;
    background:linear-gradient(90deg,#22c55e,#3b82f6,#f97316);
    color:#fff;
    cursor:pointer;
    transition:.3s;
}
button:hover{
    transform:scale(1.05);
}
.success{
    background:#dcfce7;
    color:#166534;
    padding:12px;
    border-radius:12px;
    margin-bottom:15px;
    text-align:center;
    font-weight:600;
}
.error{
    background:#fee2e2;
    color:#991b1b;
    padding:12px;
    border-radius:12px;
    margin-bottom:15px;
    text-align:center;
    font-weight:600;
}
.back{
    display:block;
    text-align:center;
    margin-top:22px;
    text-decoration:none;
    color:#2563eb;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="container">

    <h2>📘 Add New Course</h2>
    <p>Create a course for students</p>

    <?php if($success): ?>
        <div class="success"><?php echo $success; ?></div>
    <?php endif; ?>

    <?php if($error): ?>
        <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="post">

        <label>Course Title</label>
        <input type="text" name="title" placeholder="Eg: Introduction to Physics" required>

        <label>Description</label>
        <textarea name="description" placeholder="Brief course overview"></textarea>

        <label>Education Level</label>
        <select name="level" required>
            <option value="">Select Level</option>
            <option value="kindergarten">Kindergarten</option>
            <option value="primary">Primary</option>
            <option value="secondary">Secondary</option>
            <option value="highschool">High School</option>
            <option value="undergraduate">Undergraduate</option>
            <option value="postgraduate">Postgraduate</option>
        </select>

        <button type="submit">🚀 Submit Course</button>

    </form>

    <a class="back" href="dashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
