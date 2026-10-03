<?php
session_start();
require_once '../../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'secondary') {
    header("Location: ../dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* =============================
   FETCH ALL SECONDARY QUIZZES
============================= */
$quizzes = [];

$stmt = $conn->prepare("
    SELECT id, title 
    FROM quizzes 
    WHERE level = 'secondary'
    ORDER BY id ASC
");

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $quizzes[] = $row;
}
$stmt->close();

/* =============================
   FETCH PASSED QUIZZES
============================= */
$passedQuizzes = [];

$stmt = $conn->prepare("
    SELECT DISTINCT qa.quiz_id
    FROM quiz_attempts qa
    WHERE qa.user_id = ?
    AND qa.score >= (
        SELECT CEIL(COUNT(*) * 0.5)
        FROM quiz_questions
        WHERE quiz_id = qa.quiz_id
    )
");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $passedQuizzes[] = $row['quiz_id'];
}
$stmt->close();

/* =============================
   GROUP QUIZZES BY CLASS
============================= */
$groupedQuizzes = [];

foreach ($quizzes as $quiz) {

    if (preg_match('/Class\s(\d+)\s(.*)\sQuiz/i', $quiz['title'], $matches)) {
        $class = "Class " . $matches[1];
        $subject = trim($matches[2]);

        $groupedQuizzes[$class][] = [
            'id' => $quiz['id'],
            'subject' => $subject
        ];
    }
}

/* =============================
   CERTIFICATE STATUS
============================= */
$progressStmt = $conn->prepare("
    SELECT certificate_unlocked
    FROM user_progress
    WHERE user_id = ?
    AND level = 'secondary'
");

$progressStmt->bind_param("i", $user_id);
$progressStmt->execute();
$progressResult = $progressStmt->get_result();

$allCompleted = false;
if ($row = $progressResult->fetch_assoc()) {
    $allCompleted = $row['certificate_unlocked'] == 1;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Secondary Learning Portal</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}

body{
    background:#f1f5f9;
    padding:40px 20px;
    color:#334155;
}

/* HEADER */
.header{text-align:center;margin-bottom:50px;}
.header h1{color:#2563eb;font-size:30px;}
.header p{color:#64748b;margin-top:8px;}

/* CLASS CARDS */
.class-container{
    max-width:1000px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:30px;
}

.class-card{
    background:white;
    padding:35px;
    border-radius:18px;
    text-align:center;
    cursor:pointer;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    transition:0.3s;
    border-top:6px solid #3b82f6;
}

.class-card:hover{
    transform:translateY(-8px);
}

.class-card h3{
    font-size:20px;
    margin-bottom:10px;
    color:#2563eb;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.4);
    justify-content:center;
    align-items:center;
}

.modal-content{
    background:white;
    padding:40px;
    border-radius:18px;
    width:350px;
    text-align:center;
    position:relative;
    animation:fadeIn 0.3s ease;
}

.close{
    position:absolute;
    top:15px;
    right:20px;
    font-size:24px;
    cursor:pointer;
}

.subject-btn{
    margin:15px 0;
    padding:12px;
    background:#e0f2fe;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
    transition:0.3s;
}

.subject-btn:hover{
    background:#3b82f6;
    color:white;
}

.completed{
    background:#dcfce7;
    border:2px solid #22c55e;
}

/* CERTIFICATE */
.certificate-banner{
    margin-top:70px;
    background:#fef9c3;
    padding:35px;
    text-align:center;
    border-radius:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.unlock-btn{
    margin-top:15px;
    padding:12px 25px;
    border:none;
    border-radius:30px;
    background:#f59e0b;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

.unlock-btn:hover{
    background:#d97706;
}

.lock{
    margin-top:15px;
    padding:8px 14px;
    background:#ef4444;
    color:white;
    border-radius:20px;
    display:inline-block;
}

.footer{
    text-align:center;
    margin-top:50px;
    color:#94a3b8;
}

@keyframes fadeIn{
    from{transform:scale(0.8);opacity:0;}
    to{transform:scale(1);opacity:1;}
}
/* TOP BACK BUTTON */
.top-bar{
    max-width:1000px;
    margin:0 auto 20px auto;
}

.top-bar a{
    text-decoration:none;
    background:#2563eb;
    color:white;
    padding:10px 18px;
    border-radius:25px;
    font-weight:500;
    transition:0.3s;
    display:inline-block;
}

.top-bar a:hover{
    background:#1d4ed8;
}
</style>
</head>

<body>
<div class="top-bar">
    <a href="/unified_edu/public/secondary.php">⬅ Back</a>
</div>
<div class="header">
    <h1>📘 Secondary Learning Portal</h1>
    <p>Select your class to start learning</p>
</div>

<div class="class-container">

<?php foreach($groupedQuizzes as $className => $subjects): ?>

<div class="class-card"
     onclick="openSubjects('<?php echo $className; ?>')">

    <h3><?php echo $className; ?></h3>
    <p>Click to view subjects</p>

</div>

<div class="modal" id="modal-<?php echo str_replace(' ','',$className); ?>">
    <div class="modal-content">

        <span class="close"
        onclick="closeSubjects('<?php echo $className; ?>')">&times;</span>

        <h2><?php echo $className; ?> Subjects</h2>

        <?php foreach($subjects as $sub): 
            $done = in_array($sub['id'], $passedQuizzes);
        ?>

        <div class="subject-btn <?php echo $done ? 'completed' : ''; ?>"
            onclick="window.location='secondary_quiz.php?quiz_id=<?php echo $sub['id']; ?>'">

            <?php echo $sub['subject']; ?>
            <?php echo $done ? ' ✅' : ''; ?>

        </div>

        <?php endforeach; ?>

    </div>
</div>

<?php endforeach; ?>

</div>

<!-- CERTIFICATE -->
<div class="certificate-banner">

<h2>🎓 Secondary Certificate</h2>

<?php if($allCompleted): ?>
    <p>Congratulations! Your certificate is ready.</p>
    <button id="certBtn" class="unlock-btn"
onclick="window.location='../certificate/secondary_certificate.php'">
Download Certificate
</button>

<?php else: ?>
    <p>Complete all quizzes to unlock your certificate.</p>
    <div class="lock">Locked 🔒</div>
<?php endif; ?>


</div>

<div class="footer">
© <?php echo date("Y"); ?> Unified Education Platform
</div>

<script>
function openSubjects(className){
    let id = "modal-" + className.replace(" ","");
    document.getElementById(id).style.display = "flex";
}

function closeSubjects(className){
    let id = "modal-" + className.replace(" ","");
    document.getElementById(id).style.display = "none";
}
</script>

<script>

<?php if($allCompleted): ?>

window.onload = function(){

    // Big confetti burst
    confetti({
        particleCount: 200,
        spread: 120,
        origin: { y: 0.6 }
    });

    // Multiple bursts
    setTimeout(()=>confetti({particleCount:150,spread:100,origin:{y:0.7}}),500);
    setTimeout(()=>confetti({particleCount:120,spread:90,origin:{y:0.8}}),900);

};

<?php endif; ?>

</script>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

</body>
</html>