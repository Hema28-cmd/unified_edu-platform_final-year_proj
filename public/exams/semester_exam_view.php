<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$type = $_GET['type'] ?? 'odd';

$examData = [
    'odd' => [
        'title' => 'Odd Semester Examination',
        'desc'  => 'Formal university examination conducted at the end of odd semesters.',
        'color' => '#0f766e',
        'bg'    => '#ecfeff'
    ],
    'even' => [
        'title' => 'Even Semester Examination',
        'desc'  => 'Comprehensive evaluation conducted after completion of even semesters.',
        'color' => '#1d4ed8',
        'bg'    => '#eff6ff'
    ],
    'supplementary' => [
        'title' => 'Supplementary Examination',
        'desc'  => 'Opportunity for students to clear arrears and improve academic performance.',
        'color' => '#92400e',
        'bg'    => '#fff7ed'
    ]
];

$data = $examData[$type] ?? $examData['odd'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $data['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f8fafc;
}

/* HEADER */
.header{
    background:<?php echo $data['color']; ?>;
    color:#fff;
    padding:45px 20px;
    text-align:center;
}
.header h1{
    margin:0;
    font-size:34px;
}
.header p{
    margin-top:10px;
    opacity:0.95;
}

/* CONTAINER */
.container{
    max-width:1000px;
    margin:50px auto;
    padding:0 20px;
}

/* INFO PANEL */
.info-panel{
    background:<?php echo $data['bg']; ?>;
    border-left:8px solid <?php echo $data['color']; ?>;
    padding:30px;
    border-radius:24px;
    margin-bottom:40px;
}
.info-panel h2{
    margin-top:0;
    color:#0f172a;
}
.info-panel p{
    color:#475569;
    line-height:1.7;
}

/* TIMELINE */
.timeline{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:30px;
}
.step{
    background:#ffffff;
    padding:28px;
    border-radius:22px;
    box-shadow:0 14px 30px rgba(0,0,0,0.1);
}
.step h3{
    margin-top:0;
    color:<?php echo $data['color']; ?>;
}
.step p{
    color:#475569;
    font-size:14px;
    line-height:1.6;
}

/* NOTE BOX */
.note{
    margin-top:45px;
    padding:26px;
    background:#f1f5f9;
    border-radius:22px;
    color:#334155;
}

/* BUTTONS */
.actions{
    margin-top:40px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}
.actions a{
    padding:12px 30px;
    border-radius:30px;
    text-decoration:none;
    font-weight:600;
    font-size:14px;
}
.instructions{
    background:<?php echo $data['color']; ?>;
    color:#fff;
}
.back{
    background:#ef4444;
    color:#fff;
}
.actions a:hover{
    opacity:0.9;
}

/* FOOTER */
.footer{
    margin-top:60px;
    padding:18px;
    text-align:center;
    background:#e5e7eb;
    font-size:13px;
    color:#475569;
}
</style>
</head>

<body>

<div class="header">
    <h1><?php echo $data['title']; ?></h1>
    <p><?php echo $data['desc']; ?></p>
</div>

<div class="container">

    <div class="info-panel">
        <h2>📌 Examination Overview</h2>
        <p>
            This examination is conducted as per university academic regulations.
            Students must satisfy attendance and internal assessment requirements
            to be eligible for appearing.
        </p>
    </div>

    <div class="timeline">

        <div class="step">
            <h3>📖 Syllabus Coverage</h3>
            <p>
                All units prescribed in the current semester syllabus are included.
                Question papers test conceptual understanding and application skills.
            </p>
        </div>

        <div class="step">
            <h3>📝 Evaluation Method</h3>
            <p>
                Answer scripts are evaluated externally following university norms.
                Marks contribute significantly to SGPA and CGPA.
            </p>
        </div>

        <div class="step">
            <h3>🏛 Examination Rules</h3>
            <p>
                Students must follow examination discipline.
                Any malpractice will lead to severe academic penalties.
            </p>
        </div>

        <div class="step">
            <h3>📊 Result Declaration</h3>
            <p>
                Results are published on the university portal.
                Students are advised to regularly check official notifications.
            </p>
        </div>

    </div>

    <div class="note">
        <strong>Academic Advisory:</strong>
        Ensure all internal components are completed before the semester examination.
        Failure to meet eligibility criteria may result in disqualification.
    </div>

    <div class="actions">
        <a href="exam_instructions.php?exam=<?php echo $type; ?>" class="instructions">
            View Instructions
        </a>
        <a href="semester_exams.php" class="back">
            ← Back to Semester Exams
        </a>
    </div>

</div>

<div class="footer">
    © Unified Edu | Semester Examination Details
</div>

</body>
</html>
