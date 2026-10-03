<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

$labs = [
    [
        'id' => 'programming',
        'title' => 'Programming Lab',
        'desc' => 'Hands-on coding experiments using C / Python / Java',
        'type' => 'Coding Lab',
        'difficulty' => 'Intermediate',
        'experiments' => 12
    ],
    [
        'id' => 'database',
        'title' => 'Database Lab',
        'desc' => 'SQL queries, normalization, and schema design',
        'type' => 'Database Lab',
        'difficulty' => 'Beginner',
        'experiments' => 10
    ],
    [
        'id' => 'electronics',
        'title' => 'Electronics Lab',
        'desc' => 'Circuit design, simulation, and testing',
        'type' => 'Hardware Lab',
        'difficulty' => 'Advanced',
        'experiments' => 8
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Lab Work</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#eef2ff,#f8fafc);
}

.container{
    max-width:1100px;
    margin:50px auto;
    padding:30px;
}

h2{
    color:#312e81;
    margin-bottom:30px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:25px;
}

.card{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

.card h3{
    margin-bottom:8px;
    color:#1e1b4b
}

.card p{
    color:#475569;
}

/* INFO BOX */

.info{
    margin-top:14px;
    background:#eef2ff;
    padding:12px;
    border-radius:12px;
    font-size:14px;
    color:#312e81;
}

.info span{
    display:block;
    margin-bottom:4px;
}

/* BUTTON */

.view{
    display:inline-block;
    margin-top:16px;
    padding:9px 18px;
    background:#4f46e5;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:14px;
    transition:0.3s;
}

.view:hover{
    background:#4338ca;
}

.back{
    display:inline-block;
    margin-top:30px;
    color:#4f46e5;
    text-decoration:none;
    font-weight:600;
}
</style>
</head>

<body>

<div class="container">
<h2>🧪 Laboratory Work</h2>

<div class="grid">
<?php foreach($labs as $lab): ?>
    <div class="card">

        <h3><?= $lab['title'] ?></h3>
        <p><?= $lab['desc'] ?></p>

        <div class="info">
            <span>🔬 Lab Type: <?= $lab['type'] ?></span>
            <span>🧠 Difficulty: <?= $lab['difficulty'] ?></span>
            <span>📊 Experiments: <?= $lab['experiments'] ?></span>
        </div>

        <a href="lab_view.php?id=<?= $lab['id'] ?>" class="view">
            View Details
        </a>

    </div>
<?php endforeach; ?>
</div>

<a href="../undergraduate_assignments.php" class="back">← Back</a>
</div>

</body>
</html>