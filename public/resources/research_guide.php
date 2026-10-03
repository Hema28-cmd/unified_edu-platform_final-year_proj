<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Research Paper Guide</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    margin:0;
    font-family:Segoe UI, sans-serif;
    background:#eef2ff;
}

/* HERO SECTION */

.hero{
    background:linear-gradient(135deg,#4f46e5,#6366f1);
    color:white;
    padding:60px 30px;
    text-align:center;
}

.hero h1{
    font-size:40px;
    margin-bottom:10px;
}

.hero p{
    max-width:700px;
    margin:auto;
    font-size:17px;
}

/* MAIN CONTAINER */

.container{
    max-width:1200px;
    margin:auto;
    padding:40px 20px;
}

/* SECTION TITLE */

.section-title{
    font-size:28px;
    margin-bottom:20px;
    color:#1e293b;
}

/* CARD GRID */

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

/* CARD DESIGN */

.card{
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card i{
    font-size:35px;
    color:#6366f1;
    margin-bottom:15px;
}

.card h3{
    margin-bottom:10px;
}

.card p{
    font-size:14px;
    color:#475569;
}

/* DOWNLOAD SECTION */

.download{
    margin-top:40px;
    background:white;
    padding:30px;
    border-radius:18px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
}

.download a{
    display:inline-block;
    margin-top:10px;
    padding:10px 18px;
    background:#6366f1;
    color:white;
    text-decoration:none;
    border-radius:20px;
}

.download a:hover{
    background:#4f46e5;
}

/* BACK BUTTON */

.back{
    margin-top:30px;
}

.back a{
    text-decoration:none;
    color:#4f46e5;
    font-weight:600;
}

</style>
</head>

<body>

<!-- HERO -->

<div class="hero">
    <h1>Research Paper Writing Guide</h1>
    <p>Learn how to write professional academic research papers, structure reports, and present your ideas effectively.</p>
</div>

<div class="container">

    <!-- WRITING STEPS -->

    <h2 class="section-title">Steps to Write a Research Paper</h2>

    <div class="grid">

        <div class="card">
            <i class="fa-solid fa-magnifying-glass"></i>
            <h3>Choose a Research Topic</h3>
            <p>Select a clear and focused topic related to your academic field. Make sure it is researchable and relevant.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-book"></i>
            <h3>Literature Review</h3>
            <p>Study existing books, journals, and articles to understand previous research on your topic.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-chart-line"></i>
            <h3>Research Methodology</h3>
            <p>Explain how your research is conducted including data collection, analysis methods, and tools used.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-pen"></i>
            <h3>Write the Draft</h3>
            <p>Organize your research into introduction, methodology, results, discussion, and conclusion.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-check"></i>
            <h3>Edit and Proofread</h3>
            <p>Check grammar, clarity, citations, and formatting before submitting your research paper.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-file-export"></i>
            <h3>Final Submission</h3>
            <p>Format the paper according to your university guidelines and submit it with references.</p>
        </div>

    </div>

    <!-- STRUCTURE SECTION -->

    <h2 class="section-title" style="margin-top:40px;">Standard Research Paper Structure</h2>

    <div class="grid">

        <div class="card">
            <i class="fa-solid fa-file"></i>
            <h3>Abstract</h3>
            <p>A short summary of your research including objectives, methods, and conclusions.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-lightbulb"></i>
            <h3>Introduction</h3>
            <p>Introduce your research problem, background information, and research objectives.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-database"></i>
            <h3>Methodology</h3>
            <p>Explain the methods, tools, and techniques used to conduct the research.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-chart-pie"></i>
            <h3>Results</h3>
            <p>Present the research findings using tables, charts, and analysis.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-comments"></i>
            <h3>Discussion</h3>
            <p>Interpret the results and explain the significance of your research findings.</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-flag-checkered"></i>
            <h3>Conclusion</h3>
            <p>Summarize the research outcomes and suggest future improvements.</p>
        </div>

    </div>

    <!-- DOWNLOAD SECTION -->

    <div class="download">

        <h2>Download Research Paper Templates</h2>

        <p>You can download sample templates to understand the correct structure of research papers.</p>

       <a href="research_template.pdf" target="_blank">
<i class="fa-solid fa-download"></i> Download Sample Template
</a>

    </div>

    <!-- BACK -->

    <div class="back">
        <a href="undergraduate_resources.php">
        ← Back to Resources
        </a>
    </div>

</div>

</body>
</html>