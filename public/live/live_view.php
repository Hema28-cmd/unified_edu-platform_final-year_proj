<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$type = $_GET['type'] ?? 'lecture';

/* SAMPLE MEETING LINKS */
$meeting_links = [
    'lecture' => [
        'title' => 'Live Lecture',
        'link'  => 'https://meet.google.com/abc-defg-hij'
    ],
    'lab' => [
        'title' => 'Live Lab Session',
        'link'  => 'https://zoom.us/j/9876543210'
    ],
    'workshop' => [
        'title' => 'Workshop',
        'link'  => 'https://meet.google.com/work-shop-123'
    ],
    'seminar' => [
        'title' => 'Seminar / Guest Talk',
        'link'  => 'https://zoom.us/j/1234567890'
    ],
    'doubt' => [
        'title' => 'Doubt Clearing Session',
        'link'  => 'https://meet.google.com/doubt-clear-456'
    ]
];

$data = $meeting_links[$type] ?? $meeting_links['lecture'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $data['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{
    font-family:'Segoe UI',sans-serif;
    background:#eef2ff;
    margin:0;
}
.container{
    max-width:700px;
    margin:60px auto;
    background:#fff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
    text-align:center;
}
h2{
    color:#1e293b;
    margin-bottom:25px;
}
.join{
    display:inline-block;
    padding:16px 34px;
    background:#4f46e5;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:18px;
    font-weight:600;
}
.join:hover{background:#4338ca;}
.back{
    display:inline-block;
    margin-top:25px;
    padding:10px 18px;
    background:#ef4444;
    color:#fff;
    text-decoration:none;
    border-radius:14px;
}
.back:hover{background:#dc2626;}
.note{
    margin-top:18px;
    font-size:14px;
    color:#64748b;
}
</style>
</head>
<body>

<div class="container">
    <h2><?php echo $data['title']; ?></h2>

    <!-- ONLY MEETING LINK -->
    <a href="<?php echo $data['link']; ?>" target="_blank" class="join">
        ▶ Join Live Class
    </a>

  

    <a href="undergraduate_live.php" class="back">← Back</a>
</div>

</body>
</html>
