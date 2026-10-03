<?php
session_start();

/* Allow only secondary users */
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../dashboard.php");
    exit;
}

/* FOLDER PATH */
$lessonDir = __DIR__ . '/../../uploads/notes';

/* PUBLIC URL */
$baseURL = "/unified_edu/uploads/notes/";

$grouped_lessons = [];

/* READ FILES */
if (is_dir($lessonDir)) {

    $files = array_diff(scandir($lessonDir), ['.', '..']);

    foreach ($files as $file) {

        if (preg_match('/^Class(\d+)_(\w+)_/i', $file, $matches)) {

            if (isset($matches[1]) && isset($matches[2])) {

                $classNumber = (int)$matches[1];

                if ($classNumber >= 6 && $classNumber <= 9) {

                    $class = "Class " . $classNumber;
                    $subject = ucfirst(strtolower($matches[2]));

                    $group = $class;

                    $grouped_lessons[$group][] = [
                        'title' => $class . " " . $subject . " Notes",
                        'file' => $file
                    ];
                }
            }
        }
    }
}

/* ADD DEFAULT CARDS */
$default_classes = [6, 7, 8, 9];
$subjects = ['English', 'Mathematics', 'Science'];

foreach ($default_classes as $classNum) {

    foreach ($subjects as $sub) {

        if ($classNum == 6 && $sub != 'Science') continue;

        $class = "Class " . $classNum;

        $exists = false;

        if (isset($grouped_lessons[$class])) {
            foreach ($grouped_lessons[$class] as $lesson) {
                if (stripos($lesson['title'], $sub) !== false) {
                    $exists = true;
                    break;
                }
            }
        }

        if (!$exists) {
            $grouped_lessons[$class][] = [
                'title' => $class . " " . $sub . " Notes",
                'file' => null
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Secondary School Lessons</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

/* SAME PRIMARY DESIGN */

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(135deg,#f0f9ff,#fefce8);
}

/* NAVBAR */
.navbar{
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 30px;
background:linear-gradient(90deg,#2563eb,#06b6d4);
color:white;
box-shadow:0 4px 10px rgba(0,0,0,0.15);
}

.navbar h1{
margin:0;
font-size:22px;
letter-spacing:0.5px;
}

.navbar a{
text-decoration:none;
color:white;
background:rgba(255,255,255,0.2);
padding:8px 16px;
border-radius:25px;
transition:0.3s;
}

.navbar a:hover{
background:white;
color:#2563eb;
}

/* CONTENT */
.content{
padding:40px 20px;
max-width:1100px;
margin:auto;
}

.page-title{
text-align:center;
font-size:32px;
color:#1e3a8a;
margin-bottom:50px;
font-weight:600;
}

/* CLASS SECTION */
.class-section{
margin-bottom:40px;
background:white;
padding:25px;
border-radius:16px;
box-shadow:0 6px 18px rgba(0,0,0,0.08);
transition:0.3s;
}

.class-section:hover{
box-shadow:0 10px 25px rgba(0,0,0,0.12);
}

.class-title{
font-size:22px;
margin-bottom:18px;
color:#d97706;
border-left:5px solid #facc15;
padding-left:10px;
font-weight:600;
}

/* CARDS */
.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

/* CARD */
.card{
background:white;
border-radius:14px;
padding:22px;
text-align:center;
cursor:pointer;
transition:all 0.3s ease;
border:1px solid #e5e7eb;
position:relative;
}

.card:hover{
transform:translateY(-6px);
box-shadow:0 10px 20px rgba(0,0,0,0.12);
border-color:#38bdf8;
}

.card h3{
color:#0f172a;
margin-bottom:10px;
font-size:17px;
font-weight:600;
}

.card p{
font-size:14px;
color:#64748b;
}

/* SMALL TAG EFFECT */
.card::after{
content:"";
position:absolute;
bottom:0;
left:0;
width:100%;
height:4px;
background:linear-gradient(90deg,#3b82f6,#22c55e);
border-radius:0 0 14px 14px;
}

/* FOOTER */
.footer{
text-align:center;
padding:15px;
background:#1e40af;
color:white;
margin-top:50px;
font-size:14px;
}
</style>
</head>

<body>

<div class="navbar">
<h1>📘 Secondary School Lessons</h1>
<a href="../secondary.php">⬅ Back to Dashboard</a>
</div>

<div class="content">

<div class="page-title">
Choose Your Learning Notes
</div>

<?php if (!empty($grouped_lessons)): ?>

<?php foreach ($grouped_lessons as $class => $lessons): ?>

<div class="class-section">

<div class="class-title">
<?= htmlspecialchars($class) ?>
</div>

<div class="cards">

<?php foreach ($lessons as $lesson): ?>

<?php
$title = $lesson['title'];
$file = $lesson['file'];
$url = $file ? $baseURL . urlencode($file) : '';
?>

<div class="card"
onclick="<?php if ($file): ?>
window.open('<?= $url ?>','_blank')
<?php else: ?>
alert('⚠️ Notes not uploaded yet!')
<?php endif; ?>">

<h3><?= htmlspecialchars($title) ?></h3>

<p>
<?= $file ? '📄 Click to open lesson notes' : '⏳ Coming Soon' ?>
</p>

</div>

<?php endforeach; ?>

</div>
</div>

<?php endforeach; ?>

<?php else: ?>

<p style="text-align:center;font-size:18px;color:#555;">
🚫 No secondary lessons available yet.
</p>

<?php endif; ?>

</div>

<div class="footer">
© <?php echo date("Y"); ?> Secondary Learning Portal | Learn • Grow • Shine 🌟
</div>

</body>
</html>