<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

/* 🔔 NOTE:
   For countdown, we store an actual date.
   You can later fetch this from database.
*/

$assignments = [
    'essay' => [
    'title' => 'Critical Thinking Essay',
    'description' => 'Write a structured 1500-word essay analyzing modern education systems and emerging pedagogical models.',
    'topics' => 'Digital classrooms, AI in education, personalized learning, global education trends',
    'deadline_text' => '15 Days from release',
    'deadline_date' => '2025-01-15 23:59:59',
    'marks' => '20 Marks',
    'instructions' => 'Use academic language, proper citations, and plagiarism-free content. Submit in PDF format.',
    'evaluation' => 'Clarity of ideas, critical analysis, references, originality',

    // ✅ ADD THIS NEW FIELD
    'sample' => "
    <b>Title: The Evolution of Modern Education Systems</b><br><br>

    Education has undergone a significant transformation over the past few decades. Traditional classroom-based learning has gradually shifted toward digital and student-centered approaches. This evolution is driven by technological advancements and the need for more personalized learning experiences.<br><br>

    One of the most notable changes is the rise of digital classrooms. Online learning platforms and virtual classrooms have made education more accessible and flexible. Students can now learn at their own pace, which enhances understanding and retention.<br><br>

    Artificial Intelligence (AI) is also playing a crucial role in modern education. AI-powered tools can analyze student performance and provide personalized recommendations. This helps in identifying strengths and weaknesses, allowing educators to tailor their teaching methods.<br><br>

    However, these advancements also come with challenges. Not all students have equal access to technology, leading to a digital divide. Additionally, excessive reliance on technology may reduce face-to-face interaction, which is essential for social development.<br><br>

    In conclusion, modern education systems are evolving rapidly with the integration of technology. While digital tools and AI offer numerous benefits, it is important to address the associated challenges to ensure inclusive and effective learning for all students.
    "
],
   'case-study' => [
    'title' => 'Case Study Analysis',
    'description' => 'Analyze a real-world academic or industry case and propose actionable solutions.',
    'topics' => 'Problem identification, solution design, feasibility analysis',
    'deadline_text' => '10 Days from release',
    'deadline_date' => '2025-01-10 23:59:59',
    'marks' => '15 Marks',
    'instructions' => 'Minimum 1200 words. Include diagrams or flowcharts where applicable.',
    'evaluation' => 'Problem understanding, solution relevance, presentation',

    // ✅ ADD SAMPLE
    'sample' => "
    <b>Title: Improving Student Engagement in Online Learning</b><br><br>

    <b>Problem Identification:</b><br>
    A university observed a decline in student engagement in online classes. Attendance dropped, participation was minimal, and assignment submissions were delayed.<br><br>

    <b>Analysis:</b><br>
    The main causes identified were lack of interaction, monotonous teaching methods, and absence of real-time feedback. Students felt disconnected from instructors and peers.<br><br>

    <b>Proposed Solutions:</b><br>
    1. Introduce interactive tools such as quizzes and live polls.<br>
    2. Use breakout rooms for group discussions.<br>
    3. Provide instant feedback using AI-based tools.<br>
    4. Incorporate multimedia (videos, animations) to improve understanding.<br><br>

    <b>Feasibility:</b><br>
    These solutions require minimal investment as most tools are already available in modern learning platforms. Faculty training may be needed for effective implementation.<br><br>

    <b>Conclusion:</b><br>
    By adopting interactive and technology-driven strategies, student engagement in online learning can be significantly improved.
    "
]
 
];

$id = $_GET['id'] ?? '';
if (!isset($assignments[$id])) {
    header("Location: assignments.php");
    exit;
}

$data = $assignments[$id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $data['title'] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#ecfeff,#f1f5f9);
}

.wrapper{
    max-width:1100px;
    margin:60px auto;
    padding:20px;
}

.card{
    background:#fff;
    border-radius:24px;
    box-shadow:0 20px 50px rgba(0,0,0,0.1);
    overflow:hidden;
}

/* HEADER */
.card-header{
    background:linear-gradient(90deg,#10b981,#0f766e);
    color:#fff;
    padding:35px;
}

.card-header h2{
    margin:0;
    font-size:30px;
}

/* BODY */
.card-body{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:30px;
    padding:35px;
}

.section{
    margin-bottom:28px;
}

.section h3{
    margin-bottom:10px;
    color:#0f172a;
    display:flex;
    align-items:center;
    gap:10px;
}

.section p{
    color:#475569;
    line-height:1.7;
    font-size:15px;
}

/* INFO BOX */
.info-box{
    background:#f8fafc;
    border-radius:18px;
    padding:25px;
}

.info-item{
    display:flex;
    gap:12px;
    margin-bottom:18px;
    align-items:center;
}

.info-item i{
    color:#10b981;
}

/* COUNTDOWN */
.timer{
    background:#0f766e;
    color:#fff;
    padding:15px;
    border-radius:14px;
    text-align:center;
    margin-top:20px;
}

.timer h4{
    margin:0 0 8px;
    font-weight:600;
}

.time{
    font-size:20px;
    font-weight:700;
}

/* FOOTER */
.card-footer{
    background:#f1f5f9;
    padding:25px 35px;
    display:flex;
    justify-content:space-between;
}

.back{
    color:#0f766e;
    font-weight:600;
    text-decoration:none;
}

.badge{
    background:#d1fae5;
    color:#065f46;
    padding:8px 18px;
    border-radius:25px;
    font-weight:600;
}

/* RESPONSIVE */
@media(max-width:900px){
    .card-body{
        grid-template-columns:1fr;
    }
}
.full-width{
    grid-column: 1 / -1; /* 🔥 This makes it span full width */
}

.sample-box{
    background:#f8fafc;
    padding:25px;
    border-radius:15px;
    line-height:1.8;
    color:#334155;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}
</style>
</head>

<body>

<div class="wrapper">
<div class="card">

    <div class="card-header">
        <h2><?= $data['title'] ?></h2>
    </div>

    <div class="card-body">

        <!-- LEFT -->
        <div>
            <div class="section">
                <h3><i class="fa-solid fa-file-lines"></i> Description</h3>
                <p><?= $data['description'] ?></p>
            </div>

            <div class="section">
                <h3><i class="fa-solid fa-list-check"></i> Focus Topics</h3>
                <p><?= $data['topics'] ?></p>
            </div>

            <div class="section">
                <h3><i class="fa-solid fa-pen-ruler"></i> Instructions</h3>
                <p><?= $data['instructions'] ?></p>
            </div>

          

        </div>
  <?php if ($id === 'essay' || $id === 'case-study'): ?>
<div class="section full-width">
    <h3><i class="fa-solid fa-lightbulb"></i> Sample Answer</h3>

    <div class="sample-box">
        <?= $data['sample'] ?>
    </div>
</div>
<?php endif; ?>
      
    </div>

    <div class="card-footer">
        <a href="assignment.php" class="back">← Back to General Assignments</a>
            </div>

</div>
</div>


</body>
</html>  