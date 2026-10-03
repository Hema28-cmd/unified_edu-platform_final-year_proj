<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$type = $_GET['type'] ?? 'semester';

$exam_data = [
    'semester' => [
        'title' => 'University Semester Examination',
        'desc'  => 'End-semester examination conducted by the university covering the complete syllabus.',
        'color' => '#ea580c',
	'sample' => [
    'before' => "
    • Revise entire syllabus with focus on important topics<br>
    • Practice previous university question papers<br>
    • Prepare short notes and formulas<br>
    • Plan a proper study timetable
    ",
    'during' => "
    • Read question paper carefully and choose wisely<br>
    • Allocate time for each section<br>
    • Write answers clearly with proper structure<br>
    • Include diagrams and examples wherever needed
    ",
    'after' => "
    • Review answers if time permits<br>
    • Avoid discussing answers immediately<br>
    • Prepare for next exam without delay
    ",
    'tips' => "
    • Focus on high-weightage topics<br>
    • Write neat and well-structured answers<br>
    • Highlight key points and keywords<br>
    • Manage time effectively
    "
],
        'details' => [
            'Conducted by affiliating university',
            'Covers entire semester syllabus',
            'Centralized valuation system',
            'Mandatory for progression'
        ]
    ],
    'supplementary' => [
        'title' => 'Supplementary Examination',
        'desc'  => 'Opportunity for students to clear failed subjects from regular exams.',
        'color' => '#0d9488',
	'sample' => [
    'before' => "
    • Focus on previously failed subject topics<br>
    • Understand mistakes from past attempt<br>
    • Practice important questions repeatedly<br>
    • Build confidence through revision
    ",
    'during' => "
    • Stay calm and confident<br>
    • Attempt all questions carefully<br>
    • Avoid repeating previous mistakes<br>
    • Manage time wisely
    ",
    'after' => "
    • Analyze performance honestly<br>
    • Prepare backup plan if needed<br>
    • Stay positive and focused
    ",
    'tips' => "
    • Focus on passing marks strategy first<br>
    • Attempt easy questions first<br>
    • Avoid leaving questions unanswered<br>
    • Improve weak areas
    "
],
        'details' => [
            'For backlog subjects only',
            'Separate exam schedule',
            'Same syllabus as regular exam',
            'Marks considered final'
        ]
    ],
    'revaluation' => [
        'title' => 'Revaluation / Rechecking',
        'desc'  => 'Process to apply for rechecking or revaluation of answer scripts.',
        'color' => '#7c3aed',
	'sample' => [
    'before' => "
    • Carefully review your marks and answers<br>
    • Compare with expected performance<br>
    • Decide whether revaluation is necessary<br>
    • Apply within deadline
    ",
    'during' => "
    • Track application status<br>
    • Keep acknowledgement receipt safe<br>
    • Be patient during evaluation process
    ",
    'after' => "
    • Check updated results<br>
    • Accept final marks as per university decision<br>
    • Plan next steps accordingly
    ",
    'tips' => "
    • Apply only if confident about scoring error<br>
    • Avoid unnecessary applications<br>
    • Keep copies of answer scripts if available
    "
],
        'details' => [
            'Application through university portal',
            'Re-totaling or revaluation',
            'Updated marks are final',
            'Refund not applicable'
        ]
    ],
    'final' => [
        'title' => 'Final Degree Examination',
        'desc'  => 'Final examination required for successful degree completion.',
        'color' => '#2563eb',
	'sample' => [
    'before' => "
    • Revise all subjects thoroughly<br>
    • Practice full-length mock tests<br>
    • Focus on weak areas<br>
    • Maintain proper health and sleep
    ",
    'during' => "
    • Treat it as the most important exam<br>
    • Follow strict time management<br>
    • Attempt all questions with confidence<br>
    • Maintain neat and clear presentation
    ",
    'after' => "
    • Relax and avoid stress<br>
    • Wait for results patiently<br>
    • Prepare for career opportunities or higher studies
    ",
    'tips' => "
    • Give importance to all subjects equally<br>
    • Maintain consistency in performance<br>
    • Avoid last-minute cramming<br>
    • Stay confident and focused
    "
],
        'details' => [
            'Mandatory for degree award',
            'Includes theory & practical',
            'Final transcript generation',
            'Degree certificate issued'
        ]
    ]
];

$data = $exam_data[$type] ?? $exam_data['semester'];
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
    background:linear-gradient(120deg,#f8fafc,#ecfeff);
}

/* WRAPPER */
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
    background:<?php echo $data['color']; ?>;
    padding:35px;
    color:#fff;
}
.header h1{
    margin:0;
    font-size:30px;
}
.header p{
    margin-top:10px;
    opacity:0.95;
}

/* CONTENT */
.content{
    padding:35px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:22px;
}

/* CARD */
.card{
    background:#f8fafc;
    padding:20px;
    border-radius:18px;
    border-left:6px solid <?php echo $data['color']; ?>;
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

/* NOTICE */
.notice{
    margin-top:30px;
    background:#fff7ed;
    border-left:6px solid #f97316;
    padding:22px;
    border-radius:18px;
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
    background:#ef4444;
    color:#fff;
}
.actions a.back:hover{
    background:#dc2626;
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
        <h1><?php echo $data['title']; ?></h1>
        <p><?php echo $data['desc']; ?></p>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <div class="grid">
            <?php foreach ($data['details'] as $item): ?>
            <div class="card">
                <h4>Key Information</h4>
                <p><?php echo htmlspecialchars($item); ?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="notice">
            <strong>Note:</strong> All external examinations follow university rules and regulations.
            Students are advised to regularly check official university notifications.
        </div>

	<?php if(!empty($data['sample'])): ?>

<div class="card" style="margin-top:25px;">
    <h4>Before the Exam</h4>
    <p><?php echo $data['sample']['before']; ?></p>
</div>

<div class="card" style="margin-top:20px;">
    <h4>During the Exam</h4>
    <p><?php echo $data['sample']['during']; ?></p>
</div>

<div class="card" style="margin-top:20px;">
    <h4>After the Exam</h4>
    <p><?php echo $data['sample']['after']; ?></p>
</div>

<div class="card" style="margin-top:20px;">
    <h4>Tips to Score More Marks</h4>
    <p><?php echo $data['sample']['tips']; ?></p>
</div>

<?php endif; ?>

        <div class="actions">
            <a href="external_exams.php" class="back">← Back to External Exams</a>
        </div>

    </div>

    <div class="footer">
        © Unified Edu | External Examination Portal
    </div>

</div>

</body>
</html>
