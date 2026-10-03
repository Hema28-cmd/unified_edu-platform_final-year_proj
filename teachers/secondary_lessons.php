<?php
session_start();
require_once "../config/db.php";

$teacher_id = $_SESSION['user_id'];

/* ADD LESSON */
if(isset($_POST['add_lesson'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("
        INSERT INTO lessons (title,description,category,level,created_by)
        VALUES (?, ?, ?, 'secondary', ?)
    ");
    $stmt->bind_param("sssi",$title,$description,$category,$teacher_id);
    $stmt->execute();
}

/* FETCH LESSONS */
$stmt = $conn->prepare("
SELECT title,status,created_at 
FROM lessons
WHERE created_by=? AND level='secondary'
ORDER BY created_at DESC
");

$stmt->bind_param("i",$teacher_id);
$stmt->execute();
$lessons = $stmt->get_result();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Secondary Lessons | Unified Edu</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@600&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Inter', sans-serif;
    background:linear-gradient(135deg,#f8fafc,#e0f2fe);
    color:#0f172a;
    padding:20px;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 30px;
    background:linear-gradient(90deg,#334155,#1e40af);
    border-radius:14px;
    box-shadow:0 8px 24px rgba(0,0,0,0.25);
}
.navbar h2{
    font-family:'Montserrat', sans-serif;
    font-size:22px;
    color:#fff;
}
.navbar a{
    color:#e0f2fe;
    text-decoration:none;
    margin-left:20px;
    font-weight:500;
}
.navbar a:hover{color:#fde68a;}

/* BACK BUTTON */
.back{
    margin:20px 0;
}
.back a{
    display:inline-block;
    padding:10px 22px;
    border-radius:25px;
    background:linear-gradient(90deg,#fb7185,#f97316);
    color:#fff;
    font-weight:500;
    text-decoration:none;
    box-shadow:0 6px 18px rgba(0,0,0,0.2);
}

/* HEADER */
.header{
    margin-bottom:30px;
    padding:30px;
    border-radius:26px;
    background:linear-gradient(135deg,#ccfbf1,#ddd6fe);
    box-shadow:0 12px 28px rgba(0,0,0,0.15);
}
.header h1{
    font-family:'Montserrat', sans-serif;
    font-size:28px;
}
.header p{
    margin-top:8px;
    color:#334155;
}

/* MAIN LAYOUT */
.layout{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:25px;
}

/* SUBJECT PANEL */
.panel{
    background:#ffffff;
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.12);
}
.panel h2{
    font-size:20px;
    margin-bottom:15px;
    color:#1e40af;
}
.panel ul{
    padding-left:18px;
}
.panel li{
    margin-bottom:8px;
    font-size:14px;
}

/* TIMELINE */
.timeline{
    display:flex;
    flex-direction:column;
    gap:15px;
}
.step{
    background:linear-gradient(135deg,#e0f2fe,#bae6fd);
    padding:18px;
    border-radius:18px;
}
.step h4{
    color:#075985;
    margin-bottom:5px;
}
.step p{
    font-size:13px;
}

/* SPECIAL BOX */
.highlight{
    margin-top:25px;
    background:linear-gradient(135deg,#fef3c7,#fde68a);
    padding:20px;
    border-radius:22px;
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}
.highlight h3{
    color:#92400e;
    margin-bottom:8px;
}
.highlight p{
    font-size:14px;
}

/* RESPONSIVE */
@media(max-width:900px){
    .layout{grid-template-columns:1fr;}
}

/* ADD LESSON BUTTON */
.add-lesson-btn{
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    border:none;
    padding:12px 24px;
    border-radius:30px;
    color:#fff;
    font-size:15px;
    font-weight:600;
    cursor:pointer;
    box-shadow:0 8px 18px rgba(0,0,0,0.25);
    transition:all 0.3s ease;
}

.add-lesson-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 24px rgba(0,0,0,0.3);
}

/* LESSON CARD */
.lesson-card{
    background:linear-gradient(135deg,#ffffff,#f1f5f9);
    padding:18px;
    border-radius:14px;
    margin-bottom:14px;
    box-shadow:0 6px 16px rgba(0,0,0,0.15);
    border-left:6px solid #6366f1;
}

/* STATUS BADGES */
.status{
    padding:4px 10px;
    border-radius:14px;
    font-size:12px;
    font-weight:600;
}

.status.pending{
    background:#fef3c7;
    color:#92400e;
}

.status.approved{
    background:#dcfce7;
    color:#166534;
}

.status.rejected{
    background:#fee2e2;
    color:#991b1b;
}

/* POPUP OVERLAY */
#lessonPopup{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(15,23,42,0.6);
    backdrop-filter:blur(4px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

/* POPUP BOX */
.popup-box{
    background:#ffffff;
    padding:28px;
    width:420px;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.35);
    animation:popupShow 0.35s ease;
}

@keyframes popupShow{
    from{
        transform:scale(0.8);
        opacity:0;
    }
    to{
        transform:scale(1);
        opacity:1;
    }
}

.popup-box h3{
    margin-bottom:15px;
    color:#1e40af;
}

.popup-box input,
.popup-box textarea{
    width:100%;
    padding:10px;
    margin-bottom:12px;
    border-radius:8px;
    border:1px solid #cbd5f5;
    font-size:14px;
}

/* POPUP BUTTONS */
.popup-actions{
    display:flex;
    justify-content:space-between;
}

.save-btn{
    background:#22c55e;
    border:none;
    padding:10px 16px;
    border-radius:8px;
    color:white;
    font-weight:600;
    cursor:pointer;
}

.cancel-btn{
    background:#ef4444;
    border:none;
    padding:10px 16px;
    border-radius:8px;
    color:white;
    font-weight:600;
    cursor:pointer;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Secondary Lessons</h2>
    <div>
        <a href="secondary_lessons.php">Lessons</a>
        <a href="secondary_books.php">Books</a>
        <a href="secondary_quizzes.php">Quizzes</a>
        <a href="secondary_assignments.php">Assignments</a>
        <a href="secondary_projects.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK -->
<div class="back">
    <a href="secondary.php">⬅ Back to Dashboard</a>
</div>

<!-- HEADER -->
<div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 👋</h1>
    <p>Plan, organize, and deliver structured lessons aligned with the secondary school curriculum.</p>
<br><br>
<button class="add-lesson-btn" onclick="openLessonPopup()">
➕ Add New Lesson
</button>
</div>

<!-- MAIN CONTENT -->
<div class="layout">

<!-- LEFT COLUMN -->
<div>

<div class="panel">
    <h2>📘 Core Subjects</h2>
    <ul>
        <li><strong>Mathematics:</strong> Algebra, Geometry, Mensuration, Statistics</li>
        <li><strong>Science:</strong> Physics, Chemistry, Biology (Theory + Lab)</li>
        <li><strong>Social Studies:</strong> History, Geography, Civics, Economics</li>
        <li><strong>Languages:</strong> English Grammar, Literature, Writing Skills</li>
        <li><strong>Computer Science:</strong> HTML, Basics of Programming, Cyber Safety</li>
    </ul>
</div>

<div class="highlight">
    <h3>🎯 Teaching Focus</h3>
    <p>
        Emphasis on conceptual understanding, analytical thinking,
        real-world applications, and exam readiness.
    </p>
</div>

</div>

<!-- RIGHT COLUMN -->
<div>

<div class="panel">
    <h2>🧠 Lesson Flow (Weekly)</h2>
    <div class="timeline">
        <div class="step">
            <h4>Introduction</h4>
            <p>Brief recap of previous concepts and lesson objectives.</p>
        </div>
        <div class="step">
            <h4>Concept Explanation</h4>
            <p>Detailed explanation using examples and diagrams.</p>
        </div>
        <div class="step">
            <h4>Activity / Practice</h4>
            <p>Worksheets, problem-solving, or group discussion.</p>
        </div>
        <div class="step">
            <h4>Assessment</h4>
            <p>Short quiz or oral questioning.</p>
        </div>
        <div class="step">
            <h4>Homework</h4>
            <p>Assignments reinforcing classroom learning.</p>
        </div>
    </div>
</div>

<div class="highlight">
    <h3>💡 Tips & Tricks</h3>
    <p>
        • Use real-life examples  
        • Encourage questions  
        • Blend digital tools with textbook learning  
        • Provide regular feedback
    </p>
</div>

</div>
</div>

<h2>Your Lessons</h2>

<?php while($row = $lessons->fetch_assoc()): ?>

<div class="lesson-card">

<strong><?php echo htmlspecialchars($row['title']); ?></strong>

<br><br>

Status:
<span class="status <?php echo $row['status']; ?>">
<?php echo ucfirst($row['status']); ?>
</span>

<br><br>

<small>Created: <?php echo $row['created_at']; ?></small>

</div>
<?php endwhile; ?>

<!-- ADD LESSON POPUP -->
<div id="lessonPopup">

<div class="popup-box">

<h3>📚 Add New Lesson</h3>

<form method="POST">

<input type="text" name="title" placeholder="Lesson Title" required>

<textarea name="description" placeholder="Lesson Description"></textarea>

<input type="text" name="category" placeholder="Category / Subject">

<div class="popup-actions">

<button type="submit" name="add_lesson" class="save-btn">
Save Lesson
</button>

<button type="button" onclick="closeLessonPopup()" class="cancel-btn">
Cancel
</button>

</div>

</form>

</div>
</div>
<script>

function openLessonPopup(){
    document.getElementById("lessonPopup").style.display = "flex";
}

function closeLessonPopup(){
    document.getElementById("lessonPopup").style.display = "none";
}

</script>

</body>
</html>
