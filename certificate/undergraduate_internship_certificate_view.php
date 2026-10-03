<?php
session_start();

// Allow only undergraduate users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$student_name   = $_SESSION['user_name'] ?? "Undergraduate Student";
$internship_org = "Unified Tech Solutions";
$duration       = "3 Months";
$certificate_id = "UG-INT-" . date("Ymd") . "-" . rand(1000,9999);
$date_of_issue  = date("d M Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Internship Certificate</title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Inter:wght@400;500&display=swap');

body{
    margin:0;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:linear-gradient(135deg,#ede9fe,#f8fafc);
    font-family:'Inter',sans-serif;
}

/* CERTIFICATE FRAME */
.certificate{
    width:940px;
    background:#ffffff;
    border-radius:18px;
    display:flex;
    overflow:hidden;
    box-shadow:0 28px 65px rgba(0,0,0,0.25);
}

/* LEFT ACCENT PANEL */
.side-panel{
    width:120px;
    background:linear-gradient(180deg,#7c3aed,#f59e0b);
    display:flex;
    justify-content:center;
    align-items:center;
    color:#fff;
    writing-mode:vertical-rl;
    transform:rotate(180deg);
    font-family:'Cinzel',serif;
    font-size:24px;
    letter-spacing:3px;
}

/* MAIN CONTENT */
.content{
    padding:60px 70px;
    flex:1;
    text-align:center;
}

/* ICON */
.icon{
    font-size:56px;
    margin-bottom:10px;
}

/* HEADINGS */
h1{
    font-family:'Cinzel',serif;
    font-size:38px;
    color:#4c1d95;
    margin-bottom:12px;
}

.subtitle{
    font-size:17px;
    color:#64748b;
    margin-bottom:28px;
}

/* STUDENT NAME */
.name{
    font-size:34px;
    font-weight:700;
    color:#f59e0b;
    margin:18px 0;
}

/* TEXT */
.text{
    font-size:17px;
    color:#334155;
    line-height:1.9;
}

/* HIGHLIGHTS */
.highlight{
    font-weight:600;
    color:#7c3aed;
}

/* FOOTER INFO */
.footer{
    display:flex;
    justify-content:space-between;
    margin-top:40px;
    font-size:14px;
    color:#475569;
}

/* BUTTONS */
.actions{
    margin-top:45px;
}

.print-btn{
    padding:13px 36px;
    background:#7c3aed;
    color:#fff;
    border:none;
    border-radius:30px;
    font-size:15px;
    cursor:pointer;
    margin-right:15px;
    transition:0.3s;
}

.print-btn:hover{
    background:#5b21b6;
    transform:scale(1.05);
}

.back-btn{
    padding:13px 36px;
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
@media(max-width:960px){
    .certificate{
        flex-direction:column;
    }
    .side-panel{
        width:100%;
        height:70px;
        writing-mode:horizontal-tb;
        transform:none;
        font-size:18px;
    }
    .footer{
        flex-direction:column;
        gap:10px;
        text-align:center;
    }
}
</style>
</head>

<body>

<div class="certificate">

    <div class="side-panel">
        INTERNSHIP CERTIFICATE
    </div>

    <div class="content">

        <div class="icon">🎓</div>

        <h1>Certificate of Internship</h1>
        <p class="subtitle">This certificate is awarded to</p>

        <div class="name"><?php echo htmlspecialchars($student_name); ?></div>

        <p class="text">
            for successfully completing an internship at
            <span class="highlight"><?php echo htmlspecialchars($internship_org); ?></span>
            for a duration of <span class="highlight"><?php echo $duration; ?></span>.
        </p>

        <p class="text">
            The student demonstrated professional responsibility,
            technical skills, and active participation as part of the
            Undergraduate academic requirements.
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
