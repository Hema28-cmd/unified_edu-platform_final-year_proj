<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'highschool') {
    header("Location: ../dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Highschool Lessons</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body { font-family:'Segoe UI', sans-serif; background:#fef9f0; margin:0; padding:0; }
.container { max-width:900px; margin:50px auto; text-align:center; }
h1 { font-size:36px; margin-bottom:10px; color:#1e293b; }
p { font-size:18px; color:#334155; margin-bottom:40px; }
.subjects { display:grid; grid-template-columns:repeat(2,1fr); gap:20px; }
.subject-card {
    padding:40px 20px;
    border-radius:15px;
    color:#fff;
    font-size:22px;
    font-weight:bold;
    cursor:pointer;
    transition:transform 0.3s, box-shadow 0.3s;
}
.subject-card:hover { transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.15);}
.maths { background: linear-gradient(135deg,#60a5fa,#3b82f6); }
.science { background: linear-gradient(135deg,#34d399,#10b981); }
.english { background: linear-gradient(135deg,#f472b6,#ec4899); }
.social { background: linear-gradient(135deg,#fbbf24,#f59e0b); }
.back-btn {
    margin-top:40px;
    display:inline-block;
    padding:12px 30px;
    border-radius:30px;
    background:#8b5cf6;
    color:#fff;
    text-decoration:none;
    transition:0.3s;
}
.back-btn:hover { background:#6366f1; }
</style>
</head>
<body>

<div class="container">
    <h1>Highschool Lessons 📚</h1>
    <p>Hello <?php echo htmlspecialchars($_SESSION['user_name']); ?>! Select your subject below.</p>

    <div class="subjects">
        <div class="subject-card maths" onclick="location.href='subject_lessons.php?subject=maths'">Maths</div>
        <div class="subject-card science" onclick="location.href='subject_lessons.php?subject=science'">Science</div>
        <div class="subject-card english" onclick="location.href='subject_lessons.php?subject=english'">English</div>
        <div class="subject-card social" onclick="location.href='subject_lessons.php?subject=social'">Social Studies</div>
    </div>

    <a href="../highschool.php" class="back-btn">⬅ Back to Dashboard</a>
</div>

</body>
</html>
