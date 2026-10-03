<?php
$subject = $_GET['subject'] ?? '';
$subject = strtolower($subject);

$baseDir = __DIR__ . "/highschool/$subject/";
$webPath = "highschool/$subject/";
$lessons = [];

if (is_dir($baseDir)) {
    foreach (scandir($baseDir) as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $lessons[] = $file;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= ucfirst($subject) ?> Lessons</title>

<style>
body{
    margin:0;
    font-family: "Segoe UI", Arial, sans-serif;
    background:linear-gradient(135deg,#2d1b4f,#ff7a18);
    min-height:100vh;
    color:#fff;
}

/* Wrapper */
.wrapper{
    max-width:700px;
    margin:70px auto;
    background:rgba(255,255,255,0.12);
    backdrop-filter: blur(12px);
    border-radius:20px;
    padding:40px 30px;
}

/* Title */
h1{
    margin-top:0;
    text-align:center;
    font-size:34px;
    letter-spacing:1px;
}
.subtitle{
    text-align:center;
    opacity:.85;
    margin-bottom:40px;
}

/* Timeline */
.timeline{
    position:relative;
    padding-left:30px;
}
.timeline::before{
    content:'';
    position:absolute;
    left:8px;
    top:0;
    bottom:0;
    width:4px;
    background:#ffd180;
    border-radius:5px;
}

/* Lesson Item */
.lesson{
    position:relative;
    margin-bottom:30px;
}
.lesson::before{
    content:'';
    position:absolute;
    left:-4px;
    top:8px;
    width:18px;
    height:18px;
    background:#ffcc80;
    border-radius:50%;
    box-shadow:0 0 0 6px rgba(255,204,128,.3);
}

.lesson a{
    display:inline-block;
    padding:14px 22px;
    background:rgba(255,255,255,.2);
    border-radius:30px;
    color:#fff;
    text-decoration:none;
    font-size:18px;
    font-weight:600;
    transition:background .3s ease, transform .3s ease;
}
.lesson a:hover{
    background:#ffcc80;
    color:#4e342e;
    transform:translateX(8px);
}

/* Empty */
.empty{
    text-align:center;
    font-size:18px;
    opacity:.9;
}

/* Back Button */
.back{
    text-align:center;
    margin-top:50px;
}
.back a{
    padding:14px 36px;
    background:#ffffff;
    color:#4a148c;
    border-radius:40px;
    text-decoration:none;
    font-weight:700;
    box-shadow:0 8px 25px rgba(0,0,0,.3);
}
.back a:hover{
    opacity:.85;
}
</style>
</head>

<body>

<div class="wrapper">
    <h1><?= ucfirst($subject) ?> Lessons</h1>
    <div class="subtitle">
        Choose your class to open lesson notes (new tab)
    </div>

    <?php if (!empty($lessons)): ?>
        <div class="timeline">
            <?php foreach ($lessons as $lesson): ?>
                <div class="lesson">
                    <a href="<?= $webPath . $lesson ?>" target="_blank">
                        <?= strtoupper(str_replace('.html','',$lesson)) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty"><b>No lessons available yet.</b></div>
    <?php endif; ?>

    <div class="back">
        <a href="highschool_lessons.php">← Back to Subjects</a>
    </div>
</div>

</body>
</html>
