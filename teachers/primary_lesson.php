<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

include "../config/db.php";

/* Fetch approved lessons */
$approved = $conn->query("
    SELECT * FROM primary_lessons
    WHERE status='approved'
    ORDER BY created_at DESC
");

/* Fetch teacher lesson status */
$my_lessons = $conn->query("
    SELECT title,status 
    FROM primary_lessons 
    WHERE created_by=".(int)$_SESSION['user_id']."
    ORDER BY created_at DESC
");

$teacher_name = $_SESSION['user_name'];

/* Default lesson cards */
$lessons = [
    ['title'=>'Reading & Writing','description'=>'Letter recognition, phonics, sight words, simple sentence writing, and story reading exercises.','icon'=>'📖','color'=>'#fde68a'],
    ['title'=>'Basic Math','description'=>'Counting 1–20, basic addition and subtraction, number patterns, shapes, and fun number games.','icon'=>'➕','color'=>'#bfdbfe'],
    ['title'=>'Science & Nature','description'=>'Learning about plants, animals, seasons, weather, and simple hands-on experiments.','icon'=>'🔬','color'=>'#bbf7d0'],
    ['title'=>'Social Skills & Environment','description'=>'Community helpers, good manners, festivals, cultural awareness, and taking care of our surroundings.','icon'=>'🌍','color'=>'#fbcfe8'],
    ['title'=>'Art & Craft','description'=>'Drawing, coloring, paper crafts, clay modeling, and creative projects.','icon'=>'🎨','color'=>'#fed7aa'],
    ['title'=>'Music & Movement','description'=>'Action rhymes, simple songs, dance steps, clapping games, and exploring rhythm and sounds.','icon'=>'🎶','color'=>'#c7d2fe'],
    ['title'=>'Life Skills','description'=>'Daily routines, hygiene, healthy habits, and cooperative play activities.','icon'=>'🧩','color'=>'#fcd34d'],
    ['title'=>'Storytelling & Drama','description'=>'Role-play, puppet shows, dramatization of short stories, and confidence building exercises.','icon'=>'🎭','color'=>'#a5f3fc'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Lessons | Teacher Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Fredoka+One&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#fff1f8,#dbeafe);color:#1e293b;padding:20px;}
.navbar{display:flex;justify-content:space-between;align-items:center;background:linear-gradient(90deg,#ec4899,#f472b6);padding:15px 25px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.15);}
.navbar h2{font-family:'Fredoka One',cursive;font-size:22px;color:#fff;}
.navbar a{color:#fff;text-decoration:none;margin-left:18px;font-weight:500;}
.navbar a:hover{opacity:0.8;}
.back-btn{display:inline-block;margin:20px 0;padding:12px 25px;background:linear-gradient(90deg,#3b82f6,#60a5fa);color:#fff;border-radius:25px;text-decoration:none;font-weight:500;}
.back-btn:hover{opacity:0.9;}
.header{margin:20px 0;background:#fff0f6;padding:25px;border-radius:25px;box-shadow:0 5px 20px rgba(0,0,0,0.1);text-align:center;}
.header h1{font-family:'Fredoka One',cursive;color:#d946ef;font-size:26px;margin-bottom:5px;}
.header p{color:#374151;}
.main{display:flex;flex-wrap:wrap;gap:20px;}
.lessons-column{flex:2;display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;}
.lesson-card{display:flex;align-items:flex-start;padding:18px;border-radius:20px;box-shadow:0 4px 15px rgba(0,0,0,0.1);transition:0.3s;}
.lesson-card:hover{transform:translateY(-3px);box-shadow:0 8px 25px rgba(0,0,0,0.15);}
.lesson-icon{font-size:38px;margin-right:12px;}
.lesson-content h3{font-family:'Fredoka One',cursive;font-size:18px;margin-bottom:6px;}
.lesson-content p{font-size:13px;line-height:1.4;color:#4b5563;}
.side-column{flex:1;display:flex;flex-direction:column;gap:15px;}
.resources{background:linear-gradient(135deg,#d1fae5,#6ee7b7);padding:18px;border-radius:20px;box-shadow:0 3px 15px rgba(0,0,0,0.08);}
.resources h2{font-family:'Fredoka One',cursive;font-size:18px;margin-bottom:10px;}
.resources ul{padding-left:18px;margin-top:8px;}
.resources li{margin-bottom:6px;font-size:13px;color:#065f46;}
.actions{display:flex;flex-direction:column;gap:10px;}
.action-btn{padding:12px;border-radius:25px;background:linear-gradient(90deg,#f97316,#facc15);color:#fff;text-decoration:none;text-align:center;font-weight:500;transition:0.3s;}
.action-btn:hover{transform:translateY(-2px);box-shadow:0 4px 15px rgba(0,0,0,0.2);}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);align-items:center;justify-content:center;z-index:100;}
.modal-form{background:#fff;padding:25px;border-radius:20px;width:100%;max-width:400px;box-shadow:0 5px 25px rgba(0,0,0,0.2);}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:14px;}
.form-group label{font-size:14px;font-weight:600;}
.form-group input,.form-group textarea,.form-group select{padding:10px;border-radius:10px;border:1px solid #ccc;width:100%;}
.form-actions{display:flex;justify-content:flex-end;gap:12px;margin-top:15px;}
</style>
</head>

<body>

<div class="navbar">
    <h2>Primary Lessons</h2>
    <div>
        <a href="primary_lesson.php">Lessons</a>
        <a href="primary_books.php">Books</a>
        <a href="primary_quizzes.php">Quizzes</a>
        <a href="primary_assignments.php">Assignments</a>
        <a href="primary_project.php">Projects</a>
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<a href="primary.php" class="back-btn">⬅ Back to Dashboard</a>

<div class="header">
    <h1>Welcome, <?php echo htmlspecialchars($teacher_name); ?> 🌟</h1>
    <p>Manage lessons, explore activities, and guide your primary students.</p>
</div>

<div style="text-align:center;margin:15px 0;">
    <button class="action-btn" onclick="openLessonForm()">➕ Add New Lesson</button>
</div>

<div class="main">
    <!-- LEFT COLUMN: Lessons -->
    <div class="lessons-column">
        <?php foreach($lessons as $lesson): ?>
        <div class="lesson-card" style="background:<?php echo $lesson['color']; ?>">
            <span class="lesson-icon"><?php echo $lesson['icon']; ?></span>
            <div class="lesson-content">
                <h3><?php echo $lesson['title']; ?></h3>
                <p><?php echo $lesson['description']; ?></p>
            </div>
        </div>
        <?php endforeach; ?>

        <?php while($row = $approved->fetch_assoc()): ?>
        <div class="lesson-card" style="background:<?php echo $row['color']; ?>">
            <span class="lesson-icon"><?php echo $row['icon']; ?></span>
            <div class="lesson-content">
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
            </div>
        </div>
        <?php endwhile; ?>
    </div>

    <!-- RIGHT COLUMN: Status & Resources -->
    <div class="side-column">
        <!-- My Lesson Status -->
        <div class="resources">
            <h2>📊 My Lesson Status</h2>
            <?php while($l = $my_lessons->fetch_assoc()):
            $clr=$l['status']=='approved'?'green':($l['status']=='rejected'?'red':'orange'); ?>
            <p><strong><?php echo htmlspecialchars($l['title']); ?></strong> – 
            <span style="color:<?php echo $clr; ?>"><?php echo ucfirst($l['status']); ?></span></p>
            <?php endwhile; ?>
        </div>

        <!-- Tips / Notes -->
        <div class="resources">
            <h2>💡 Tips & Notes</h2>
            <ul>
                <li>Remember to update lessons regularly.</li>
                <li>Encourage students to complete activities.</li>
                <li>Check lesson feedback from previous submissions.</li>
                <li>Plan interactive sessions to increase engagement.</li>
            </ul>
        </div>

        <!-- Additional Resources -->
        <div class="resources">
            <h2>📚 Additional Resources</h2>
            <ul>
                <li>Interactive PDFs for Reading & Math</li>
                <li>Educational Videos & Tutorials</li>
                <li>Worksheets for Practice at Home</li>
                <li>Fun Quizzes & Games</li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="actions">
            <a href="primary_books.php" class="action-btn">📚 Browse Books</a>
            <a href="primary_quizzes.php" class="action-btn">📝 View Quizzes</a>
            <a href="primary_assignments.php" class="action-btn">📂 Assignments</a>
            <a href="primary_project.php" class="action-btn">🚀 Projects</a>
        </div>
    </div>
</div>

<!-- MODAL: Add Lesson -->
<div id="lessonModal" class="modal-overlay">
<form method="POST" action="../admin/save_lesson.php" class="modal-form">
<h2 style="margin-bottom:15px;">➕ Add New Lesson</h2>
<input type="hidden" name="created_by" value="<?php echo (int)$_SESSION['user_id']; ?>">
<input type="hidden" name="status" value="pending">

<div class="form-group">
    <label>Lesson Title</label>
    <input type="text" name="title" required>
</div>

<div class="form-group">
    <label>Lesson Type</label>
    <select name="lesson_type" required>
        <option value="">Select Type</option>
        <option value="theory">Theory</option>
        <option value="practical">Practical</option>
        <option value="activity">Activity</option>
    </select>
</div>

<div class="form-group">
    <label>Difficulty Level</label>
    <select name="difficulty" required>
        <option value="">Select Level</option>
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
    </select>
</div>

<div class="form-group">
    <label>Lesson Description</label>
    <textarea name="description" rows="4" required></textarea>
</div>

<div class="form-actions">
    <button type="submit" class="action-btn">Submit</button>
    <button type="button" class="action-btn" onclick="closeLessonForm()">Cancel</button>
</div>
</form>
</div>

<script>
function openLessonForm(){document.getElementById('lessonModal').style.display='flex'}
function closeLessonForm(){document.getElementById('lessonModal').style.display='none'}
</script>

</body>
</html>
