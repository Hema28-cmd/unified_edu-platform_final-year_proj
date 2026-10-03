<?php
session_start();

/* ADMIN CHECK */
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../public/login.php");
    exit;
}

/* INIT SESSION STORAGE */
if(!isset($_SESSION['classes'])){
    $_SESSION['classes'] = [ 
       [
            "id" => 1,
            "title" => "Algebra Basics",
            "subject" => "Mathematics",
            "level" => "primary",
            "class_date" => "2026-04-10",
            "class_time" => "10:00:00",
            "meet_link" => "https://meet.google.com/abc-defg-hij",
            "status" => "upcoming"
        ],

        [
            "id" => 2,
            "title" => "Trigonometry Introduction",
            "subject" => "Mathematics",
            "level" => "secondary",
            "class_date" => "2026-04-12",
            "class_time" => "11:30:00",
            "meet_link" => "https://meet.google.com/tri-1234",
            "status" => "upcoming"
        ],

        [
            "id" => 3,
            "title" => "Newton's Laws Explained",
            "subject" => "Physics",
            "level" => "secondary",
            "class_date" => "2026-04-07",
            "class_time" => "14:00:00",
            "meet_link" => "https://meet.google.com/phy-5678",
            "status" => "live"
        ],

        [
            "id" => 4,
            "title" => "Chemical Reactions Basics",
            "subject" => "Chemistry",
            "level" => "highschool",
            "class_date" => "2026-04-15",
            "class_time" => "09:00:00",
            "meet_link" => "https://meet.google.com/chem-1111",
            "status" => "upcoming"
        ],

        [
            "id" => 5,
            "title" => "English Grammar & Writing",
            "subject" => "English",
            "level" => "primary",
            "class_date" => "2026-04-08",
            "class_time" => "13:00:00",
            "meet_link" => "https://meet.google.com/eng-2222",
            "status" => "live"
        ],

        [
            "id" => 6,
            "title" => "World War II Overview",
            "subject" => "Social Studies",
            "level" => "highschool",
            "class_date" => "2026-04-05",
            "class_time" => "16:00:00",
            "meet_link" => "https://meet.google.com/his-3333",
            "status" => "completed"
        ],

        [
            "id" => 7,
            "title" => "HTML & CSS Basics",
            "subject" => "Computer Science",
            "level" => "undergraduate",
            "class_date" => "2026-04-11",
            "class_time" => "18:00:00",
            "meet_link" => "https://meet.google.com/web-4444",
            "status" => "upcoming"
        ]

    ];
}

/* ADD CLASS */
if(isset($_POST['create_class'])){

    $_SESSION['classes'][] = [
        "id" => time(),
        "title" => $_POST['title'],
        "subject" => $_POST['subject'],
        "level" => $_POST['level'],
        "class_date" => $_POST['date'],
        "class_time" => $_POST['time'],
        "meet_link" => $_POST['link'],
        "status" => "upcoming"
    ];

    header("Location: live_classes.php");
    exit;
}

/* DELETE CLASS */
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    foreach($_SESSION['classes'] as $key => $c){
        if($c['id'] == $id){
            unset($_SESSION['classes'][$key]);
        }
    }

    header("Location: live_classes.php");
    exit;
}

/* AUTO STATUS UPDATE */
date_default_timezone_set('Asia/Kolkata');
$current = time();

foreach($_SESSION['classes'] as &$c){
    $class_time = strtotime($c['class_date']." ".$c['class_time']);

    if($class_time < $current){
        $c['status'] = 'completed';
    } elseif($class_time <= strtotime("+1 hour")){
        $c['status'] = 'live';
    } else {
        $c['status'] = 'upcoming';
    }
}

/* DEFAULT DATE (YEAR 2026) */
$defaultDate = "2026-" . date("m-d");

$classes = $_SESSION['classes'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Live Classes</title>

<style>
body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:linear-gradient(120deg,#0f172a,#1e293b);
color:white;
}

/* HEADER */
.header{
padding:25px 40px;
display:flex;
justify-content:space-between;
align-items:center;
background:linear-gradient(90deg,#06b6d4,#3b82f6);
}

.header h2{margin:0;}

.header a{
background:white;
color:#1e293b;
padding:8px 15px;
border-radius:20px;
text-decoration:none;
font-weight:bold;
}

/* CONTAINER */
.container{
max-width:1200px;
margin:30px auto;
padding:20px;
}

/* CREATE BOX */
.create-box{
background:linear-gradient(135deg,#1e293b,#334155);
padding:25px;
border-radius:20px;
margin-bottom:30px;
box-shadow:0 10px 30px rgba(0,0,0,.4);
}

.create-box input,
.create-box select{
width:100%;
padding:12px;
margin:8px 0;
border:none;
border-radius:10px;
background:#0f172a;
color:white;
}

/* BUTTON */
button{
background:linear-gradient(90deg,#22c55e,#4ade80);
border:none;
padding:12px;
border-radius:12px;
color:white;
font-weight:bold;
cursor:pointer;
width:100%;
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
background:#1e293b;
border-radius:15px;
overflow:hidden;
}

th{
background:#0ea5e9;
padding:12px;
}

td{
padding:12px;
border-bottom:1px solid #334155;
}

tr:hover{
background:#334155;
}

/* STATUS */
.status{
padding:5px 12px;
border-radius:12px;
font-size:12px;
font-weight:bold;
}

.upcoming{background:#facc15;color:#000;}
.live{background:#22c55e;color:#fff;}
.completed{background:#64748b;color:#fff;}

/* ACTION */
.delete{
background:#ef4444;
padding:6px 10px;
border-radius:10px;
color:white;
text-decoration:none;
}
</style>
</head>

<body>

<div class="header">
<h2>🎥 Live Class Management</h2>
<a href="admin.php">⬅ Back</a>
</div>

<div class="container">

<!-- CREATE -->
<div class="create-box">
<h3>➕ Schedule Live Class</h3>

<form method="POST">

<input type="text" name="title" placeholder="Class Title" required>

<input type="text" name="subject" placeholder="Subject (Math, Science...)" required>

<select name="level">
<option value="primary">Primary</option>
<option value="secondary">Secondary</option>
<option value="highschool">Highschool</option>
<option value="undergraduate">Undergraduate</option>
<option value="postgraduate">Postgraduate</option>
</select>

<input type="url" name="link" placeholder="https://meet.google.com/..." required>

<input type="date" name="date" value="<?= $defaultDate ?>" required>

<input type="time" name="time" required>

<button type="submit" name="create_class">Create Live Class</button>

</form>
</div>

<!-- TABLE -->
<table>

<tr>
<th>Title</th>
<th>Subject</th>
<th>Level</th>
<th>Date</th>
<th>Time</th>
<th>Status</th>
<th>Join</th>
<th>Action</th>
</tr>

<?php if(count($classes) > 0): ?>
    <?php foreach($classes as $row): ?>
<tr>

<td><?= htmlspecialchars($row['title']) ?></td>
<td><?= htmlspecialchars($row['subject']) ?></td>
<td><?= ucfirst($row['level']) ?></td>
<td><?= $row['class_date'] ?></td>
<td><?= date("h:i A", strtotime($row['class_time'])) ?></td>

<td>
<span class="status <?= $row['status'] ?>">
<?= ucfirst($row['status']) ?>
</span>
</td>

<td>
<a href="<?= $row['meet_link'] ?>" target="_blank" style="color:#22c55e;">Join</a>
</td>

<td>
<a class="delete" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete class?')">Delete</a>
</td>

</tr>
    <?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="8" style="text-align:center;color:#94a3b8;">
No Live Classes Created Yet
</td>
</tr>
<?php endif; ?>

</table>

</div>

</body>
</html>