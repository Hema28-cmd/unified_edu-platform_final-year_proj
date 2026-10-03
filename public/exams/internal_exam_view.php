<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$exam = $_GET['exam'] ?? 'mid1';

$exam_details = [
    'mid1' => [
        'title' => 'Mid-Term Exam 1',
        'desc'  => 'First internal assessment focusing on foundational concepts and early syllabus coverage.',
	'sample' => [
    'before' => "
    • Revise important topics and formulas<br>
    • Prepare necessary materials (hall ticket, ID card, stationery)<br>
    • Sleep well before the exam day<br>
    • Reach exam hall at least 30 minutes early
    ",

    'during' => "
    • Read question paper carefully before answering<br>
    • Manage time properly for each section<br>
    • Attempt known questions first<br>
    • Avoid malpractice and maintain discipline
    ",

    'after' => "
    • Review your answers if time permits<br>
    • Submit paper properly<br>
    • Do not discuss answers immediately to avoid confusion<br>
    • Prepare for next exam
    "
]
    ],
    'mid2' => [
        'title' => 'Mid-Term Exam 2',
        'desc'  => 'Second internal exam evaluating advanced units and applied knowledge.',
	'sample' => [
    'before' => "
    • Revise important topics and formulas<br>
    • Prepare necessary materials (hall ticket, ID card, stationery)<br>
    • Sleep well before the exam day<br>
    • Reach exam hall at least 30 minutes early
    ",

    'during' => "
    • Read question paper carefully before answering<br>
    • Manage time properly for each section<br>
    • Attempt known questions first<br>
    • Avoid malpractice and maintain discipline
    ",

    'after' => "
    • Review your answers if time permits<br>
    • Submit paper properly<br>
    • Do not discuss answers immediately to avoid confusion<br>
    • Prepare for next exam
    "
]
    ],
    'model' => [
        'title' => 'Model Examination',
        'desc'  => 'A full-length mock test conducted before the final university examinations.',
	'sample' => [
    'before' => "
    • Revise entire syllabus thoroughly<br>
    • Practice previous year question papers<br>
    • Plan time management strategy<br>
    • Keep all required materials ready
    ",

    'during' => "
    • Treat it like a real final exam<br>
    • Follow proper time allocation<br>
    • Attempt all questions confidently<br>
    • Avoid spending too much time on one question
    ",

    'after' => "
    • Analyze your performance honestly<br>
    • Identify weak areas and improve them<br>
    • Review mistakes and correct them<br>
    • Focus on preparation for final exams
    "
]
    ],
    'lab' => [
        'title' => 'Internal Laboratory Exam',
        'desc'  => 'Hands-on practical assessment conducted inside the laboratory.',
	'sample' => [
    'before' => "
    • Revise lab experiments and procedures<br>
    • Understand formulas and observations<br>
    • Bring record notebook and required materials<br>
    • Practice diagrams and calculations
    ",

    'during' => "
    • Follow lab instructions carefully<br>
    • Perform experiment step-by-step correctly<br>
    • Record observations neatly<br>
    • Handle equipment safely
    ",

    'after' => "
    • Verify results and calculations<br>
    • Submit record/work properly<br>
    • Clean workspace before leaving<br>
    • Prepare for viva questions if required
    "
]
    ],
    'viva' => [
        'title' => 'Viva / Oral Examination',
        'desc'  => 'Oral evaluation focusing on conceptual clarity and communication skills.',
	'sample' => [
    'before' => "
    • Revise key concepts and definitions clearly<br>
    • Practice explaining answers verbally<br>
    • Be confident and prepare common questions<br>
    • Dress neatly and maintain professionalism
    ",

    'during' => "
    • Listen carefully to the examiner's questions<br>
    • Answer clearly and confidently<br>
    • If unsure, explain what you know instead of staying silent<br>
    • Maintain eye contact and polite communication
    ",

    'after' => "
    • Thank the examiner politely<br>
    • Reflect on questions asked for improvement<br>
    • Note down difficult questions for future revision
    "
]
    ]
];

$data = $exam_details[$exam] ?? $exam_details['mid1'];
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
    background:linear-gradient(120deg,#eef2ff,#ecfeff);
}

/* MAIN CARD */
.exam-wrapper{
    max-width:850px;
    margin:70px auto;
    background:#ffffff;
    border-radius:24px;
    box-shadow:0 20px 40px rgba(0,0,0,0.12);
    overflow:hidden;
}

/* HEADER */
.exam-header{
    background:linear-gradient(135deg,#4f46e5,#06b6d4);
    padding:30px;
    color:#fff;
}
.exam-header h1{
    margin:0;
    font-size:28px;
}
.exam-header p{
    margin-top:8px;
    opacity:0.95;
}

/* BODY */
.exam-body{
    padding:35px;
}

/* INFO GRID */
.info-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.info-card{
    background:#f8fafc;
    border-left:6px solid #4f46e5;
    padding:18px;
    border-radius:14px;
}
.info-card h4{
    margin:0 0 6px;
    color:#1e293b;
}
.info-card p{
    margin:0;
    font-size:14px;
    color:#475569;
}

/* NOTICE */
.notice{
    background:#ecfeff;
    border-left:6px solid #06b6d4;
    padding:18px;
    border-radius:14px;
    margin-bottom:30px;
    color:#075985;
}

/* ACTIONS */
.actions{
    display:flex;
    gap:18px;
    flex-wrap:wrap;
}
.actions a{
    padding:12px 26px;
    text-decoration:none;
    border-radius:30px;
    font-weight:600;
    font-size:14px;
}
.actions a.instructions{
    background:#10b981;
    color:#fff;
}
.actions a.instructions:hover{
    background:#059669;
}
.actions a.back{
    background:#ef4444;
    color:#fff;
}
.actions a.back:hover{
    background:#dc2626;
}

/* FOOTER */
.exam-footer{
    text-align:center;
    padding:18px;
    background:#f1f5f9;
    font-size:13px;
    color:#64748b;
}
</style>
</head>

<body>

<div class="exam-wrapper">

    <!-- HEADER -->
    <div class="exam-header">
        <h1><?php echo $data['title']; ?></h1>
        <p><?php echo $data['desc']; ?></p>
    </div>

    <!-- BODY -->
    <div class="exam-body">

        <!-- INFO SECTION -->
        <div class="info-grid">
            <div class="info-card">
                <h4>Exam Type</h4>
                <p>Internal Assessment</p>
            </div>
            <div class="info-card">
                <h4>Evaluation Mode</h4>
                <p>Theory / Practical / Oral</p>
            </div>
        </div>

        <!-- NOTICE -->
        <div class="notice">
            <strong>Important:</strong> Students must strictly follow all institutional examination rules.
            Any form of malpractice will result in disqualification.
        </div>

<?php if(!empty($data['sample'])): ?>

<div class="info-card" style="margin-bottom:20px;">
    <h4>Before the Exam</h4>
    <p><?php echo $data['sample']['before']; ?></p>
</div>

<div class="info-card" style="margin-bottom:20px;">
    <h4>During the Exam</h4>
    <p><?php echo $data['sample']['during']; ?></p>
</div>

<div class="info-card" style="margin-bottom:20px;">
    <h4>After the Exam</h4>
    <p><?php echo $data['sample']['after']; ?></p>
</div>

<?php endif; ?>

        <!-- ACTIONS -->
        <div class="actions">
            <a href="internal_exams.php" class="back">
                ← Back to Exams
            </a>
        </div>

    </div>

    <!-- FOOTER -->
    <div class="exam-footer">
        © Unified Edu | Undergraduate Examination Portal
    </div>

</div>

</body>
</html>
