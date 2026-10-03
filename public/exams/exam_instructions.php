<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$exam = $_GET['exam'] ?? 'mid1';

$instructions = [
    'mid1' => 'This internal examination evaluates your understanding of foundational concepts.',
    'mid2' => 'This assessment focuses on advanced topics and problem-solving skills.',
    'model' => 'This is a full-length mock exam to prepare students for final examinations.',
    'lab' => 'This practical exam evaluates laboratory skills and experimental accuracy.',
    'viva' => 'This oral examination assesses conceptual clarity and communication.'
];

$intro = $instructions[$exam] ?? $instructions['mid1'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Exam Instructions</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(120deg,#ecfeff,#eef2ff);
}

/* MAIN WRAPPER */
.wrapper{
    max-width:900px;
    margin:70px auto;
    background:#fff;
    border-radius:26px;
    box-shadow:0 20px 40px rgba(0,0,0,0.12);
    overflow:hidden;
}

/* HEADER */
.header{
    background:linear-gradient(135deg,#0d9488,#4f46e5);
    padding:32px;
    color:#fff;
}
.header h2{
    margin:0;
    font-size:28px;
}
.header p{
    margin-top:8px;
    opacity:0.95;
}

/* CONTENT */
.content{
    padding:35px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
}

/* CARD */
.card{
    background:#f8fafc;
    border-left:6px solid #0d9488;
    padding:20px;
    border-radius:16px;
}
.card h4{
    margin:0 0 8px;
    color:#1e293b;
}
.card p{
    margin:0;
    font-size:14px;
    color:#475569;
}

/* WARNING */
.warning{
    margin-top:30px;
    background:#fff7ed;
    border-left:6px solid #f97316;
    padding:22px;
    border-radius:16px;
    color:#7c2d12;
}

/* ACTIONS */
.actions{
    margin-top:35px;
    display:flex;
    gap:18px;
    flex-wrap:wrap;
}
.actions a{
    padding:12px 28px;
    border-radius:30px;
    font-weight:600;
    font-size:14px;
    text-decoration:none;
}
.actions a.back{
    background:#4f46e5;
    color:#fff;
}
.actions a.back:hover{
    background:#4338ca;
}

/* FOOTER */
.footer{
    text-align:center;
    padding:18px;
    background:#f1f5f9;
    font-size:13px;
    color:#64748b;
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- HEADER -->
    <div class="header">
        <h2>Exam Instructions</h2>
        <p><?php echo htmlspecialchars($intro); ?></p>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="grid">

            <div class="card">
                <h4>General Rules</h4>
                <p>
                    Students must strictly adhere to all examination regulations.
                    Any form of malpractice will lead to disqualification.
                </p>
            </div>

            <div class="card">
                <h4>Exam Conduct</h4>
                <p>
                    Mobile phones, smart watches, and electronic gadgets
                    are strictly prohibited inside the examination hall.
                </p>
            </div>

            <div class="card">
                <h4>Identification</h4>
                <p>
                    Carry your valid college ID card and hall ticket
                    for verification purposes.
                </p>
            </div>

            <div class="card">
                <h4>Time Management</h4>
                <p>
                    Late entry is not permitted.
                    Students must submit answer scripts before leaving the hall.
                </p>
            </div>

        </div>

        <div class="warning">
            <strong>Important Notice:</strong>
            Failure to follow exam instructions may result in disciplinary action
            as per institutional rules.
        </div>

        <div class="actions">
            <a href="internal_exam_view.php?exam=<?php echo $exam; ?>" class="back">
                ← Back to Exam
            </a>
        </div>

    </div>

    <div class="footer">
        © Unified Edu | Examination Guidelines
    </div>

</div>

</body>
</html>
