<?php
session_start();

/* 🔐 Teacher-only access */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'teacher') {
    header("Location: ../public/login.php");
    exit;
}

$teacher_name = $_SESSION['user_name'];
$teacher_id = $_SESSION['user_id'];

/* DATABASE CONNECTION */
$conn = new mysqli("localhost","root","","unified_edu");

if($conn->connect_error){
    die("Connection failed: ".$conn->connect_error);
}

/* ADD NEW PROJECT */
if(isset($_POST['add_project'])){

    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $domain = $conn->real_escape_string($_POST['domain']);

    $sql="INSERT INTO project_topics
    (title,description,level,domain,created_by_role,created_by,status)
    VALUES
    ('$title','$description','primary','$domain','teacher','$teacher_id','pending')";

    if(!$conn->query($sql)){
    echo "Error: ".$conn->error;
}

    header("Location: primary_project.php");
    exit;
}

/* FETCH TEACHER PROJECTS */

$teacher_projects=[];

$sql="SELECT * FROM project_topics
WHERE level='primary'
AND created_by = $teacher_id
ORDER BY created_at DESC";
$result=$conn->query($sql);

if($result && $result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $teacher_projects[]=$row;
    }
}

/* Primary Class Project Data */
$projects = [
    [
        'title'=>'Color & Shape Collage',
        'description'=>'Create a colorful collage using different shapes to enhance recognition skills.',
        'materials'=>'Colored paper, scissors, glue, chart paper.',
        'sample'=>'A bright collage with circles, squares, triangles, and rectangles.',
        'color'=>'#fde68a',
        'icon'=>'🎨'
    ],
    [
        'title'=>'Plant Observation Journal',
        'description'=>'Students observe a plant for a week and note changes in a journal.',
        'materials'=>'Small plant, notebook, pencils.',
        'sample'=>'Daily sketches and notes of plant growth.',
        'color'=>'#bbf7d0',
        'icon'=>'🌱'
    ],
    [
        'title'=>'Family Tree Project',
        'description'=>'Draw a simple family tree to understand relationships and heritage.',
        'materials'=>'Paper, crayons, family photos.',
        'sample'=>'A colorful tree with names and pictures of family members.',
        'color'=>'#fbcfe8',
        'icon'=>'🌳'
    ],
    [
        'title'=>'Animal Habitat Diorama',
        'description'=>'Make a 3D diorama of an animal habitat to learn about nature and environments.',
        'materials'=>'Shoebox, clay, toy animals, colored paper.',
        'sample'=>'A miniature forest or ocean habitat.',
        'color'=>'#fed7aa',
        'icon'=>'🐾'
    ],
    [
        'title'=>'Simple Science Experiment',
        'description'=>'Conduct a simple experiment like mixing colors or growing seeds.',
        'materials'=>'Food colors, water, soil, seeds, transparent cup.',
        'sample'=>'Observe results and record findings in a notebook.',
        'color'=>'#c7d2fe',
        'icon'=>'🔬'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Primary Projects | Teacher Panel</title>

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
}

.header{
margin-bottom:30px;
background:#fff0f6;
padding:25px;
border-radius:25px;
box-shadow:0 10px 30px rgba(0,0,0,0.15);
text-align:center;
display:flex;
flex-direction:column;
align-items:center;
gap:10px;
}
/* ADD BUTTON */

.add-btn{
margin-top:10px;
padding:12px 30px;
background:linear-gradient(90deg,#22c55e,#4ade80);
color:white;
border:none;
border-radius:30px;
cursor:pointer;
font-size:15px;
font-weight:500;
display:inline-block;
}

.add-btn:hover{
transform:scale(1.05);
}
/* TIMELINE */

.timeline{
position:relative;
margin:30px 0;
padding-left:20px;
}

.timeline::before{
content:'';
position:absolute;
top:0;
left:20px;
width:4px;
height:100%;
background:#d1d5db;
}

/* PROJECT ITEM */

.project-item{
position:relative;
margin-bottom:30px;
display:flex;
gap:20px;
align-items:flex-start;
padding:20px;
border-radius:18px;
max-width:900px;
margin-left:auto;
margin-right:auto;
box-shadow:0 6px 15px rgba(0,0,0,0.1);
}
.project-item:nth-child(even){
flex-direction:row-reverse;
}

.project-icon{
font-size:38px;
min-width:60px;
display:flex;
align-items:flex-start;
justify-content:center;
}

.project-content{
background:#ffffff;
padding:20px;
border-radius:15px;
flex:1;
display:flex;
flex-direction:column;
gap:10px;
}

.project-content p{
font-size:15px;
line-height:1.6;
color:#374151;
}

.project-content ul{
margin-top:5px;
padding-left:18px;
}

.project-content li{
margin-bottom:5px;
font-size:14px;
}

.status{
margin-top:10px;
font-weight:bold;
}

.pending{color:#f59e0b;}
.approved{color:#16a34a;}
.rejected{color:#dc2626;}

/* MODAL */

.modal{
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(0,0,0,0.5);
align-items:center;
justify-content:center;
}

.modal-content{
background:white;
padding:25px;
border-radius:15px;
width:400px;
}

.modal input,.modal textarea,.modal select{
width:100%;
padding:10px;
margin-bottom:10px;
border-radius:8px;
border:1px solid #ccc;
}

.modal button{
padding:10px 15px;
border:none;
border-radius:8px;
cursor:pointer;
}

</style>
</head>

<body>

<div class="navbar">
<h2>Primary Projects</h2>
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
<h1>Primary Class Projects</h1>
<p>Engaging and interactive projects for students.</p>

<button class="add-btn" onclick="openModal()">➕ Add New Project</button>
</div>


<!-- EXISTING SAMPLE PROJECTS -->

<div class="timeline">
<?php foreach($projects as $proj): ?>
<div class="project-item" style="background:<?php echo $proj['color']; ?>">
<div class="project-icon"><?php echo $proj['icon']; ?></div>

<div class="project-content">
<h3><?php echo $proj['title']; ?></h3>
<p><?php echo $proj['description']; ?></p>
<ul>
<li><strong>Materials:</strong> <?php echo $proj['materials']; ?></li>
<li><strong>Sample Outcome:</strong> <?php echo $proj['sample']; ?></li>
</ul>
</div>

</div>
<?php endforeach; ?>
</div>


<!-- TEACHER CREATED PROJECTS -->

<div class="timeline">

<?php if(empty($teacher_projects)){ ?>
<p>No projects created yet.</p>
<?php } ?>

<?php foreach($teacher_projects as $proj): ?>
<div class="project-item" style="background:#e0f2fe">

<div class="project-icon">📂</div>

<div class="project-content">

<h3><?php echo htmlspecialchars($proj['title']); ?></h3>

<p><?php echo htmlspecialchars($proj['description']); ?></p>

<p><strong>Domain:</strong> <?php echo $proj['domain']; ?></p>

<p class="status <?php echo $proj['status']; ?>">
Status: <?php echo ucfirst($proj['status']); ?>
</p>

</div>
</div>

<?php endforeach; ?>

</div>


<!-- POPUP -->

<div class="modal" id="projectModal">

<div class="modal-content">

<h3>Add New Project</h3>

<form method="POST">

<input type="text" name="title" placeholder="Project Title" required>

<textarea name="description" placeholder="Project Description" required></textarea>

<select name="domain" required>

<option value="">Select Domain</option>
<option value="Science">Science</option>
<option value="Mathematics">Mathematics</option>
<option value="Art">Art</option>
<option value="General">General</option>

</select>

<button type="button" onclick="closeModal()">Cancel</button>

<button type="submit" name="add_project">Save</button>

</form>

</div>

</div>

<script>

function openModal(){
document.getElementById("projectModal").style.display="flex";
}

function closeModal(){
document.getElementById("projectModal").style.display="none";
}

</script>

</body>
</html>