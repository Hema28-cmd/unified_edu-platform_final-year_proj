<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

/* Sample dynamic data (replace later with DB values) */
$studentName = $_SESSION['user_name'] ?? 'Student Name';
$program     = 'Master of Computer Science';
$course      = 'Networking';
$certificate = 'Course Completion Certificate';
$issueDate   = date("d F Y");
$certificateId = 'UE-PG-' . rand(10000,99999);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Certificate | Unified Education</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#f1f5f9,#e0e7ff);
    color:#0f172a;
}

/* HEADER */
.header{
    background:linear-gradient(120deg,#312e81,#1e40af);
    color:#fff;
    padding:40px 25px;
    text-align:center;
}
.header h1{
    margin:0;
    font-size:34px;
}
.header p{
    margin-top:8px;
    opacity:0.9;
}

/* LAYOUT */
.wrapper{
    max-width:1200px;
    margin:-40px auto 60px;
    padding:0 20px;
    display:grid;
    grid-template-columns:300px 1fr;
    gap:30px;
}

/* SIDEBAR */
.sidebar{
    background:#ffffff;
    border-radius:22px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}
.sidebar h3{
    margin-top:0;
    color:#1e40af;
}
.info{
    font-size:14px;
    margin:12px 0;
    color:#334155;
}
.info i{
    color:#4338ca;
    margin-right:6px;
}
.back{
    display:inline-block;
    margin-top:20px;
    padding:10px 18px;
    background:#0f172a;
    color:#fff;
    text-decoration:none;
    border-radius:20px;
    font-size:14px;
}
.back:hover{background:#020617;}

/* CERTIFICATE */
.certificate{
    background:#ffffff;
    border-radius:25px;
    padding:50px 40px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
    position:relative;
    border:6px solid #e0e7ff;
}
.certificate:before{
    content:"";
    position:absolute;
    inset:15px;
    border:2px dashed #c7d2fe;
    border-radius:20px;
}

/* CERT CONTENT */
.cert-content{
    position:relative;
    text-align:center;
    padding:20px;
}
.university{
    font-family:'Libre Baskerville',serif;
    font-size:28px;
    font-weight:700;
    color:#1e3a8a;
}
.subtitle{
    margin-top:5px;
    font-size:15px;
    color:#475569;
}
.title{
    margin:30px 0 10px;
    font-size:26px;
    color:#4338ca;
    font-weight:700;
}
.text{
    font-size:16px;
    line-height:1.8;
    margin:20px 0;
    color:#334155;
}
.student{
    font-family:'Libre Baskerville',serif;
    font-size:26px;
    font-weight:700;
    color:#0f172a;
    margin:10px 0;
}
.details{
    margin-top:25px;
    font-size:15px;
    color:#334155;
}

/* SIGNATURES */
.signatures{
    display:flex;
    justify-content:space-between;
    margin-top:50px;
}
.sign{
    text-align:center;
}
.sign hr{
    width:160px;
    border:0;
    border-top:1px solid #64748b;
}
.sign p{
    margin-top:6px;
    font-size:14px;
}

/* BUTTONS */
.actions{
    margin-top:35px;
    display:flex;
    justify-content:center;
    gap:15px;
}
.actions a{
    text-decoration:none;
    padding:12px 26px;
    border-radius:25px;
    font-weight:600;
    font-size:14px;
}
.print{
    background:#22c55e;
    color:#fff;
}
.print:hover{background:#16a34a;}
.download{
    background:#4338ca;
    color:#fff;
}
.download:hover{background:#3730a3;}

/* RESPONSIVE */
@media(max-width:900px){
    .wrapper{
        grid-template-columns:1fr;
    }
    .signatures{
        flex-direction:column;
        gap:25px;
        align-items:center;
    }
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <h1>🎓 Digital Certificate</h1>
    <p>Unified Education Platform – Postgraduate Program</p>
</div>

<!-- MAIN CONTENT -->
<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Certificate Details</h3>
        <div class="info"><i class="fa-solid fa-id-card"></i><b>ID:</b> <?php echo $certificateId; ?></div>
        <div class="info"><i class="fa-solid fa-user"></i><b>Student:</b> <?php echo $studentName; ?></div>
        <div class="info"><i class="fa-solid fa-book"></i><b>Course:</b> <?php echo $course; ?></div>
        <div class="info"><i class="fa-solid fa-calendar"></i><b>Issued:</b> <?php echo $issueDate; ?></div>

        <a href="../postgraduate.php" class="back">⬅ Back to Dashboard</a>
    </div>

    <!-- CERTIFICATE -->
    <div class="certificate">
        <div class="cert-content">

            <div class="university">Unified Education University</div>
            <div class="subtitle">Accredited Autonomous Institution</div>

            <div class="title"><?php echo $certificate; ?></div>

            <div class="text">
                This is to certify that
            </div>

            <div class="student"><?php echo $studentName; ?></div>

            <div class="text">
                has successfully completed the postgraduate course
                <b><?php echo $course; ?></b> under the program
                <b><?php echo $program; ?></b>, demonstrating academic excellence,
                practical competence, and professional integrity.
            </div>

            <div class="details">
                Issued on <?php echo $issueDate; ?> · Certificate No: <?php echo $certificateId; ?>
            </div>

            

            <div class="actions">
                <a href="#" onclick="window.print()" class="print">🖨 Print</a>
               
            </div>

        </div>
    </div>

</div>

</body>
</html>
