<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

/* SAME DATA SOURCE – ENHANCED CONTENT */
$publications = [
    'PUB001' => [
        'title' => 'Artificial Intelligence in Smart Education',
        
        'type' => 'Journal Paper',
        'domain' => 'Artificial Intelligence & Education',
        'institution' => 'National Institute of Technology',
        'doi' => '10.1000/ai.edu.2024',
       
        'abstract' => 'This paper explores how artificial intelligence enhances adaptive learning, personalized education, and intelligent tutoring systems.',
        'objectives' => 'To study AI-driven learning platforms and analyze personalized learning models.',
        'methodology' => 'Literature review, AI model evaluation, and case-study-based analysis.',
        'applications' => 'Smart classrooms, adaptive LMS platforms, automated assessments.',
        'future_scope' => 'Integration with AR/VR and emotion-aware learning systems.'
    ],
    'PUB002' => [
        'title' => 'Cyber Security Challenges in Web Applications',
                'type' => 'Conference Paper',
        'domain' => 'Cyber Security',
        'institution' => 'Indian Institute of Information Technology',
        'doi' => '10.1000/cyber.web.2023',
       
        'abstract' => 'The study analyzes modern cyber threats, vulnerabilities in web applications, and effective defense mechanisms.',
        'objectives' => 'To identify common web vulnerabilities and evaluate security countermeasures.',
        'methodology' => 'OWASP analysis, penetration testing, and real-world attack simulations.',
        'applications' => 'Secure web development, enterprise security auditing.',
        'future_scope' => 'AI-based intrusion detection systems.'
    ],
    'PUB003' => [
        'title' => 'Data Analytics for Academic Performance Prediction',
                'type' => 'Book Chapter',
        'domain' => 'Data Science & Analytics',
        'institution' => 'University of Delhi',
        'doi' => '10.1000/data.edu.2022',
       
        'abstract' => 'A predictive model using machine learning techniques to analyze student data and forecast academic outcomes.',
        'objectives' => 'To predict academic performance using historical student data.',
        'methodology' => 'Machine learning models, regression analysis, and data preprocessing.',
        'applications' => 'Student monitoring systems, early intervention tools.',
        'future_scope' => 'Integration with national education databases.'
    ]
];

$id = $_GET['id'] ?? '';
$pub = $publications[$id] ?? null;

if (!$pub) {
    die("<h2 style='text-align:center;color:red;'>Publication not found</h2>");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

<meta charset="UTF-8">
<title><?php echo $pub['title']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}
body{
    background:linear-gradient(120deg,#ecfeff,#fff7ed);
    color:#1e293b;
}

/* WRAPPER */
.wrapper{
    max-width:1150px;
    margin:60px auto;
    display:grid;
    grid-template-columns:320px 1fr;
    gap:30px;
    padding:0 20px;
}

/* LEFT PANEL */
.sidebar{
    background:linear-gradient(180deg,#115e59,#14b8a6);
    color:white;
    border-radius:25px;
    padding:32px;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
    font-family:'Montserrat', sans-serif;
}

.sidebar h2{
    font-size:22px;
    margin-bottom:22px;
    font-weight:700;
    letter-spacing:0.5px;
}

/* INFO BLOCK */
.item{
    margin-bottom:18px;
    padding-bottom:12px;
    border-bottom:1px dashed rgba(255,255,255,0.35);
}

/* LABEL */
.item strong{
    display:block;
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:1px;
    opacity:0.85;
    margin-bottom:4px;
}

/* VALUE */
.item span{
    font-size:15px;
    font-weight:600;
}


/* CENTER CONTENT */
.content{
    background:white;
    border-radius:25px;
    padding:40px;
    box-shadow:0 20px 40px rgba(0,0,0,0.12);
}
.content h1{
    color:#0f766e;
    font-size:32px;
}
.section{
    margin-top:28px;
}
.section h3{
    color:#92400e;
    margin-bottom:8px;
}
.section p{
    line-height:1.7;
    color:#334155;
}

/* BUTTON */
.back-btn{
    margin-top:35px;
}
.back-btn a{
    text-decoration:none;
    padding:12px 30px;
    background:#0f766e;
    color:white;
    border-radius:30px;
    font-weight:600;
}
.back-btn a:hover{
    background:#115e59;
}

@media(max-width:900px){
    .wrapper{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- LEFT PANEL -->
    <div class="sidebar">
    <h2>📌 Research Overview</h2>

    <div class="item">
        <strong>Publication ID</strong>
        <span><?php echo $id; ?></span>
    </div>

    
    <div class="item">
        <strong>Domain</strong>
        <span><?php echo $pub['domain']; ?></span>
    </div>

    <div class="item">
        <strong>Institution</strong>
        <span><?php echo $pub['institution']; ?></span>
    </div>

    
    <div class="item">
        <strong>DOI</strong>
        <span><?php echo $pub['doi']; ?></span>
    </div>
</div>


    <!-- CENTER PANEL -->
    <div class="content">
        <h1><?php echo $pub['title']; ?></h1>

        <div class="section">
            <h3>📘 Abstract</h3>
            <p><?php echo $pub['abstract']; ?></p>
        </div>

        <div class="section">
            <h3>🎯 Research Objectives</h3>
            <p><?php echo $pub['objectives']; ?></p>
        </div>

        <div class="section">
            <h3>🧪 Methodology</h3>
            <p><?php echo $pub['methodology']; ?></p>
        </div>

        <div class="section">
            <h3>💡 Applications</h3>
            <p><?php echo $pub['applications']; ?></p>
        </div>

        <div class="section">
            <h3>🚀 Future Scope</h3>
            <p><?php echo $pub['future_scope']; ?></p>
        </div>

        <div class="back-btn">
            <a href="publications.php">⬅ Back to Publications</a>
        </div>
    </div>

</div>

</body>
</html>
