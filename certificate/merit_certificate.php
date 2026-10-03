<?php
session_start();

// Allow only undergraduate users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$student_name   = $_SESSION['user_name'] ?? "Undergraduate Student";
$achievement    = "Outstanding Academic Performance";
$certificate_id = "UG-MERIT-" . date("Ymd") . "-" . rand(1000,9999);
$date_of_issue  = date("d M Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Merit & Excellence Certificate</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Montserrat:wght@400;500;600&display=swap');

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#e0e7ff,#fefce8);
    font-family:'Montserrat',sans-serif;
}

/* OUTER FRAME */
.outer-frame{
    padding:18px;
    border-radius:22px;
    background:linear-gradient(135deg,#1e40af,#f59e0b);
}

/* CERTIFICATE */
.certificate{
    width:900px;
    background:#fffdf5;
    border-radius:18px;
    padding:60px 70px;
    text-align:center;
    position:relative;
}

/* GOLD SEAL */
.seal{
    position:absolute;
    top:30px;
    right:40px;
    width:90px;
    height:90px;
    background:#f59e0b;
    color:#1e3a8a;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    box-shadow:0 10px 25px rgba(0,0,0,0.25);
}

/* HEADINGS */
h1{
    font-family:'Libre Baskerville',serif;
    font-size:40px;
    color:#1e40af;
    margin-bottom:10px;
}

.subtitle{
    font-size:18px;
    color:#475569;
    margin-bottom:35px;
}

/* STUDENT NAME */
.name{
    font-size:36px;
    font-weight:700;
    color:#b45309;
    margin:20px 0;
}

/* CONTENT */
.text{
    font-size:17px;
    color:#334155;
    line-height:1.8;
}

.highlight{
    font-weight:600;
    color:#1e40af;
}

/* DIVIDER */
.divider{
    width:160px;
    height:4px;
    background:#f59e0b;
    margin:28px auto;
    border-radius:5px;
}

/* FOOTER */
.footer{
    display:flex;
    justify-content:space-between;
    margin-top:45px;
    font-size:14px;
    color:#475569;
}

/* BUTTONS */
.actions{
    margin-top:45px;
}

.print-btn{
    padding:13px 38px;
    background:#1e40af;
    color:#fff;
    border:none;
    border-radius:30px;
    font-size:15px;
    cursor:pointer;
    margin-right:15px;
    transition:0.3s;
}

.print-btn:hover{
    background:#1e3a8a;
    transform:scale(1.05);
}

.back-btn{
    padding:13px 38px;
    background:#f59e0b;
    color:#1f2937;
    text-decoration:none;
    border-radius:30px;
    font-size:15px;
    font-weight:600;
    transition:0.3s;
}

.back-btn:hover{
    background:#d97706;
    transform:scale(1.05);
}

/* RESPONSIVE */
@media(max-width:940px){
    .certificate{
        padding:40px 30px;
    }
    .footer{
        flex-direction:column;
        gap:12px;
        text-align:center;
    }
}
</style>
</head>

<body>

<div class="outer-frame">
    <div class="certificate">

        <div class="seal">⭐</div>

        <h1>Merit & Excellence Certificate</h1>
        <p class="subtitle">Awarded for exceptional academic achievement</p>

        <div class="divider"></div>

        <p class="text">This certificate is proudly presented to</p>

        <div class="name"><?php echo htmlspecialchars($student_name); ?></div>

        <p class="text">
            in recognition of <span class="highlight"><?php echo $achievement; ?></span>
            and consistent dedication to excellence as part of the
            Undergraduate academic program.
        </p>

        <p class="text">
            This achievement reflects high standards of discipline,
            perseverance, and scholastic distinction.
        </p>

        <div class="footer">
            <div>
                Certificate ID<br>
                <strong><?php echo $certificate_id; ?></strong>
            </div>
            <div>
                Date of Issue<br>
                <strong><?php echo $date_of_issue; ?></strong>
            </div>
        </div>

        <div class="actions">
            <button class="print-btn" onclick="window.print()">🖨️ Print / Save</button>
            <a href="undergraduate_certificate.php" class="back-btn">⬅ Back</a>
        </div>

    </div>
</div>

</body>
</html>
