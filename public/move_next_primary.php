<?php
session_start();
require_once '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'] ?? 'Student';

$stmt = $conn->prepare("
    SELECT certificate_unlocked 
    FROM user_progress 
    WHERE user_id=? AND level='primary'
    LIMIT 1
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$certificate_unlocked = 0;

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $certificate_unlocked = (int)$row['certificate_unlocked'];
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && $certificate_unlocked === 1) {
    $_SESSION['user_level'] = 'secondary';
    header("Location: secondary.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Level Up</title>

<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<style>
body{
    margin:0;
    font-family: 'Segoe UI', sans-serif;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: linear-gradient(135deg,#7c3aed,#06b6d4);
}

.card{
    background:#fff;
    padding:60px;
    border-radius:20px;
    text-align:center;
    width:500px;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
}

.btn{
    margin-top:25px;
    padding:15px 40px;
    border:none;
    border-radius:40px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
}

.enabled{
    background:#22c55e;
    color:#fff;
}

.enabled:hover{
    background:#16a34a;
}

.disabled{
    background:#ccc;
    color:#666;
    cursor:not-allowed;
}

/* Popup Modal */
.modal{
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    display:none;
    justify-content:center;
    align-items:center;
}

.modal-content{
    background:#fff;
    padding:40px;
    border-radius:20px;
    text-align:center;
    animation: pop 0.5s ease;
}

@keyframes pop{
    from{transform:scale(0.5); opacity:0;}
    to{transform:scale(1); opacity:1;}
}

.close-btn{
    margin-top:20px;
    padding:10px 25px;
    border:none;
    border-radius:20px;
    background:#ef4444;
    color:#fff;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="card">

<?php if($certificate_unlocked === 1): ?>

    <h1>🏆 Congratulations <?php echo htmlspecialchars($user_name); ?>!</h1>
    <p>Your Primary Certificate is Unlocked!</p>

    <form method="POST">
        <button type="submit" class="btn enabled">
            🚀 Move to Secondary Level
        </button>
    </form>

<?php else: ?>

    <h1>🔒 Certificate Locked</h1>
    <p>Complete all quizzes to unlock your certificate.</p>

    <button class="btn disabled" disabled>
        Move to Secondary Level
    </button>

<?php endif; ?>

</div>

<?php if($certificate_unlocked === 1): ?>

<!-- Popup -->
<div class="modal" id="congratsModal">
    <div class="modal-content">
        <h2>🎉 Well Done <?php echo htmlspecialchars($user_name); ?>!</h2>
        <p>You completed all Primary quizzes successfully!</p>
        <button class="close-btn" onclick="closeModal()">Close</button>
    </div>
</div>

<script>
window.onload = function() {

    // Show popup
    document.getElementById("congratsModal").style.display = "flex";

    // Fire confetti
    var duration = 3 * 1000;
    var end = Date.now() + duration;

    (function frame() {
        confetti({
            particleCount: 5,
            angle: 60,
            spread: 55,
            origin: { x: 0 }
        });
        confetti({
            particleCount: 5,
            angle: 120,
            spread: 55,
            origin: { x: 1 }
        });

        if (Date.now() < end) {
            requestAnimationFrame(frame);
        }
    }());
}

function closeModal(){
    document.getElementById("congratsModal").style.display = "none";
}
</script>

<?php endif; ?>

</body>
</html>