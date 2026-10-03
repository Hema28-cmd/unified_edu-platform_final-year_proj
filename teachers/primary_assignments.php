<?php
session_start();
$teacher_id = $_SESSION['user_id'];

/* DATABASE CONNECTION */
$conn = new mysqli("localhost","root","","unified_edu");

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

/* ADD NEW ASSIGNMENT */
if(isset($_POST['add_assignment'])){

    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $subject = $conn->real_escape_string($_POST['subject']);

    $sql = "INSERT INTO assignments
            (title,description,level,subject,created_by_role,status,created_by)
            VALUES
            ('$title','$description','primary','$subject','teacher','pending','{$_SESSION['user_id']}')";

    $conn->query($sql);

    header("Location: primary_assignments.php");
    exit;
}


/* FETCH NEWLY CREATED ASSIGNMENTS */
$db_assignments = [];

$sql = "SELECT * FROM assignments 
        WHERE level='primary'
        AND created_by = '$teacher_id'
        ORDER BY created_at DESC";

$result = $conn->query($sql);

if($result && $result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $db_assignments[]=$row;
    }
}

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];

/* Primary Class Assignments Data */
$assignments = [
    [
        'title'=>'Math Assignments',
        'description'=>'Counting, addition & subtraction, shapes, patterns, and simple word problems.',
        'icon'=>'➕',
        'color'=>'#dbeafe',
        'samples'=>[
            'Count and write numbers 1–20.',
            'Solve 3 + 5 and 7 - 2.',
            'Identify shapes in the picture.'
        ]
    ],
    [
        'title'=>'English Assignments',
        'description'=>'Alphabet tracing, sight words, sentence formation, and reading exercises.',
        'icon'=>'🔤',
        'color'=>'#fde68a',
        'samples'=>[
            'Trace letters A to Z.',
            'Match sight words with pictures.',
            'Write a simple 3-word sentence.'
        ]
    ],
    [
        'title'=>'Science Assignments',
        'description'=>'Plants, animals, seasons, weather, and simple hands-on experiments.',
        'icon'=>'🔬',
        'color'=>'#bbf7d0',
        'samples'=>[
            'Draw your favorite animal.',
            'Identify 3 parts of a plant.',
            'Observe today’s weather and note it.'
        ]
    ],
    [
        'title'=>'Art & Craft',
        'description'=>'Drawing, coloring, paper crafts, clay modeling, and creative projects.',
        'icon'=>'🎨',
        'color'=>'#fbcfe8',
        'samples'=>[
            'Draw a colorful rainbow.',
            'Make a paper flower.',
            'Create a simple clay model of a fruit.'
        ]
    ],
    [
        'title'=>'Life Skills',
        'description'=>'Good habits, daily routines, community awareness, and basic etiquette.',
        'icon'=>'🌍',
        'color'=>'#fed7aa',
        'samples'=>[
            'List 3 morning routines.',
            'Draw a picture of helping someone.',
            'Practice washing hands properly.'
        ]
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Assignments | Teacher Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&family=Fredoka+One&display=swap" rel="stylesheet">

<style>
*{margin:0;padding:0;box-sizing:border-box;}
body{
    font-family:'Poppins', sans-serif;
    background: linear-gradient(135deg,#fefce8,#dbeafe);
    color:#1f2937;
    padding:20px;
}

/* NAVBAR */
.navbar{
    display:flex; justify-content:space-between; align-items:center;
    background: linear-gradient(90deg,#8b5cf6,#ec4899);
    padding:12px 25px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    margin-bottom:15px;
}
.navbar h2{
    font-family:'Fredoka One', cursive;
    font-size:20px;
    color:#fff;
}
.navbar a{
    color:#fff;
    text-decoration:none;
    margin-left:18px;
    font-weight:500;
    transition:0.3s;
}
.navbar a:hover{color:#fde68a;}

/* BACK BUTTON */
.back-btn{
    display:inline-block;
    margin-bottom:20px;
    padding:12px 25px;
    background: linear-gradient(90deg,#3b82f6,#60a5fa);
    color:#fff;
    border-radius:25px;
    text-decoration:none;
    font-weight:500;
    box-shadow:0 8px 20px rgba(0,0,0,0.2);
    transition:0.3s;
}
.back-btn:hover{transform:translateY(-3px); box-shadow:0 12px 30px rgba(0,0,0,0.25);}

/* HEADER */
.header{
    margin-bottom:20px;
    background: #fff0f6;
    padding:25px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.15);
    text-align:center;
}
.header h1{
    font-family:'Fredoka One', cursive;
    font-size:26px;
    font-weight:400;
    color:#d946ef;
}
.header p{font-size:14px; color:#374151;}

/* ASSIGNMENT ROW */
.assignment-row{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    padding:20px;
    border-radius:20px;
    box-shadow:0 6px 20px rgba(0,0,0,0.15);
    transition:0.3s;
}
.assignment-row:nth-child(even){flex-direction:row-reverse;}
.assignment-row:hover{transform:translateY(-5px); box-shadow:0 10px 30px rgba(0,0,0,0.25);}

.assignment-left{
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:50px;
}
.assignment-left span{display:block; text-align:center;}

.assignment-right{
    flex:2;
    background:#ffffff;
    padding:15px 20px;
    border-radius:15px;
}
.assignment-right h3{
    font-family:'Fredoka One', cursive;
    font-size:18px;
    color:#1e293b;
    margin-bottom:8px;
    font-weight:400;
}
.assignment-right p{
    font-size:14px;
    color:#4b5563;
    margin-bottom:10px;
}
.assignment-right ul{padding-left:18px; margin-top:5px;}
.assignment-right ul li{
    font-size:13px;
    margin-bottom:4px;
    color:#1f2937;
}

/* QUICK ACTIONS */
.actions{
    margin-top:25px;
    display:flex;
    flex-wrap:wrap;
    gap:15px;
}
.action-btn{
    padding:12px 20px;
    border-radius:25px;
    background: linear-gradient(90deg,#f97316,#facc15);
    color:#fff;
    font-weight:500;
    text-decoration:none;
    text-align:center;
    box-shadow:0 6px 20px rgba(0,0,0,0.2);
    transition:0.3s;
}
.action-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h2>Primary Assignments</h2>
    <div>
        <a href="primary_lesson.php">Lessons</a>
        <a href="primary_books.php">Books</a>
        <a href="primary_quizzes.php">Quizzes</a>
        <a href="primary_assignments.php">Assignments</a>
        <a href="primary_project.php">Projects</a>
        
        <a href="../public/logout.php">Logout</a>
    </div>
</div>

<!-- BACK BUTTON -->
<a href="primary.php" class="back-btn">⬅ Back to Dashboard</a>

<!-- HEADER -->
<div class="header">
    <h1>Primary Class Assignments</h1>
    <p>Interactive and fun assignments for your primary students across various subjects.</p>

    <button onclick="openModal()" style="
    margin-top:15px;
    padding:12px 25px;
    border:none;
    border-radius:25px;
    background:linear-gradient(90deg,#22c55e,#4ade80);
    color:white;
    font-weight:500;
    cursor:pointer;">
    ➕ Add New Assignment
    </button>

</div>
<!-- ASSIGNMENT ROWS -->
<?php foreach($assignments as $assign): ?>
<div class="assignment-row" style="background:<?php echo $assign['color']; ?>">
    <div class="assignment-left">
        <span><?php echo $assign['icon']; ?></span>
    </div>
    <div class="assignment-right">
        <h3><?php echo $assign['title']; ?></h3>
        <p><?php echo $assign['description']; ?></p>
        <ul>
            <?php foreach($assign['samples'] as $sample): ?>
            <li>• <?php echo $sample; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php endforeach; ?>
<?php if(!empty($db_assignments)): ?>

<div class="header" style="background:#eef2ff;margin-top:30px;">
<h2 style="font-family:'Fredoka One';color:#4338ca;">Your Created Assignments</h2>
</div>

<?php foreach($db_assignments as $a): ?>

<div class="assignment-row" style="background:#f1f5f9">

<div class="assignment-left">
📄
</div>

<div class="assignment-right">

<h3><?php echo htmlspecialchars($a['title']); ?></h3>

<p><?php echo htmlspecialchars($a['description']); ?></p>

<p><b>Subject:</b> <?php echo $a['subject']; ?></p>

<p>
<b>Status:</b> 
<span style="
padding:4px 10px;
border-radius:10px;
background:#fef3c7;
font-size:12px;">
<?php echo ucfirst($a['status']); ?>
</span>
</p>

</div>

</div>

<?php endforeach; ?>
<?php endif; ?>

<!-- QUICK ACTIONS -->
<div class="actions">
    <a href="primary_lesson.php" class="action-btn">📘 View Lessons</a>
    <a href="primary_books.php" class="action-btn">📚 Browse Books</a>
    <a href="primary_quizzes.php" class="action-btn">📝 View Quizzes</a>
    <a href="primary_project.php" class="action-btn">🚀 Projects</a>
</div>

<!-- ADD ASSIGNMENT MODAL -->

<div id="assignmentModal" style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
justify-content:center;
align-items:center;">

<div style="
background:white;
padding:25px;
border-radius:15px;
width:400px;">

<h3 style="margin-bottom:15px;">Add New Assignment</h3>

<form method="POST">

<input type="text" name="title" placeholder="Assignment Title" required
style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">

<textarea name="description" placeholder="Assignment Description" required
style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;"></textarea>

<select name="subject" required
style="width:100%;padding:10px;margin-bottom:10px;border:1px solid #ccc;border-radius:8px;">

<option value="">Select Subject</option>
<option value="Mathematics">Mathematics</option>
<option value="English">English</option>
<option value="Science">Science</option>
<option value="Art">Art</option>
<option value="General">General</option>

</select>

<div style="display:flex;gap:10px;justify-content:flex-end;">

<button type="button" onclick="closeModal()" style="padding:8px 15px;border:none;border-radius:8px;background:#e5e7eb;">Cancel</button>

<button type="submit" name="add_assignment" style="padding:8px 15px;border:none;border-radius:8px;background:#22c55e;color:white;">Save</button>

</div>

</form>

</div>
</div>
<script>

function openModal(){
document.getElementById("assignmentModal").style.display="flex";
}

function closeModal(){
document.getElementById("assignmentModal").style.display="none";
}

</script>
</body>
</html>
