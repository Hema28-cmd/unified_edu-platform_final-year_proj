<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'undergraduate') {
    header("Location: ../../dashboard.php");
    exit;
}

$labs = [
'programming' => [
'title' => 'Programming Lab',
'description' => 'Hands-on programming experiments to strengthen algorithmic thinking and problem-solving skills.',
'experiments' => 'Loops, arrays, functions, file handling',
'tools' => 'C / Python / Java',
'sample' => "
<b>Experiment: Sum of Array Elements</b><br><br>

<b>Aim:</b><br>
To write a program to find the sum of elements in an array.<br><br>

<b>Algorithm:</b><br>
1. Start<br>
2. Initialize array<br>
3. Set sum = 0<br>
4. Loop through array elements<br>
5. Add each element to sum<br>
6. Print sum<br>
7. Stop<br><br>

<b>Code (C):</b><br>
<pre>
#include<stdio.h>
int main(){
    int arr[5]={1,2,3,4,5}, i, sum=0;
    for(i=0;i<5;i++){
        sum += arr[i];
    }
    printf(\"Sum = %d\", sum);
    return 0;
}
</pre>

<b>Output:</b><br>
Sum = 15<br><br>

<b>Result:</b><br>
Program executed successfully.
",
'mode' => 'Individual Lab Work',
'evaluation' => 'Correctness, code quality, output accuracy',
'outcomes' => 'Develop logical thinking and coding efficiency'
],

'database' => [
'title' => 'Database Lab',
'description' => 'Design and implement relational databases using SQL.',
'experiments' => 'DDL, DML, joins, normalization',
'tools' => 'MySQL / PostgreSQL',
'sample' => "
<b>Experiment: Student Table Creation</b><br><br>

<b>Aim:</b><br>
To create a student table and perform basic SQL operations.<br><br>

<b>SQL Queries:</b><br>

<pre>
CREATE TABLE students (
    id INT PRIMARY KEY,
    name VARCHAR(50),
    marks INT
);

INSERT INTO students VALUES (1,'Arun',85);
INSERT INTO students VALUES (2,'Priya',90);

SELECT * FROM students;
</pre>

<b>Output:</b><br>
1 | Arun  | 85<br>
2 | Priya | 90<br><br>

<b>Result:</b><br>
Table created and data retrieved successfully.
",
'mode' => 'Individual Lab Work',
'evaluation' => 'Query accuracy, schema design',
'outcomes' => 'Understand database design and SQL operations'
],

'electronics' => [
'title' => 'Electronics Lab',
'description' => 'Design, simulate, and test electronic circuits.',
'experiments' => 'Rectifiers, amplifiers, logic gates',
'tools' => 'Multisim / Proteus',
'sample' => "
<b>Experiment: Half Wave Rectifier</b><br><br>

<b>Aim:</b><br>
To study the working of a half-wave rectifier.<br><br>

<b>Components Required:</b><br>
Diode, Transformer, Resistor, CRO<br><br>

<b>Procedure:</b><br>
1. Connect the circuit as per diagram<br>
2. Apply AC input<br>
3. Observe output waveform using CRO<br><br>

<b>Observation:</b><br>
Output shows only positive half cycles of input signal.<br><br>

<b>Result:</b><br>
Half-wave rectification is successfully achieved.
",
'mode' => 'Group Lab Work',
'evaluation' => 'Circuit design, observations, viva',
'outcomes' => 'Learn practical circuit design and testing'
]
];

$id = $_GET['id'] ?? '';

if(!isset($labs[$id])){
header("Location: labs.php");
exit;
}

$data = $labs[$id];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= $data['title'] ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
margin:0;
font-family:'Segoe UI',sans-serif;
background:#f8fafc;
}

/* WRAPPER */

.wrapper{
max-width:1100px;
margin:60px auto;
padding:20px;
}

/* CARD */

.card{
background:white;
border-radius:22px;
box-shadow:0 10px 30px rgba(0,0,0,.08);
overflow:hidden;
}

/* HEADER */

.header{
background:linear-gradient(90deg,#6366f1,#60a5fa);
color:white;
padding:35px;
}

.header h2{
margin:0;
font-size:28px;
}

/* BODY */

.body{
display:grid;
grid-template-columns:2fr 1fr;
gap:30px;
padding:35px;
}

/* SECTION */

.section{
margin-bottom:25px;
}

.section h3{
color:#1e293b;
margin-bottom:8px;
}

.section p{
color:#475569;
line-height:1.6;
}

/* HIGHLIGHT */

.highlight{
background:#f1f5f9;
padding:16px;
border-left:4px solid #6366f1;
border-radius:10px;
}

/* RIGHT PANEL */

.info{
background:#f8fafc;
padding:22px;
border-radius:16px;
border:1px solid #e2e8f0;
}

/* INFO ITEM */

.info-item{
margin-bottom:14px;
padding:10px;
background:white;
border-radius:8px;
border:1px solid #e2e8f0;
}

.info-item strong{
display:block;
color:#1e293b;
}

/* BADGE */

.badge{
background:#e0e7ff;
color:#3730a3;
padding:8px 16px;
border-radius:20px;
font-weight:600;
}

/* FOOTER */

.footer{
background:#f1f5f9;
padding:22px;
display:flex;
justify-content:space-between;
align-items:center;
}

.back{
text-decoration:none;
color:#4f46e5;
font-weight:600;
}

.back:hover{
text-decoration:underline;
}

@media(max-width:900px){
.body{
grid-template-columns:1fr;
}

</style>
</head>

<body>

<div class="wrapper">
<div class="card">

<!-- HEADER -->
<div class="header">
<h2><?= $data['title'] ?></h2>
<p>Practical laboratory training for undergraduate students</p>
</div>

<!-- BODY -->
<div class="body">

<!-- LEFT CONTENT -->

<div>

<div class="section">
<h3>📘 Description</h3>
<p><?= $data['description'] ?></p>
</div>

<div class="section highlight">
<h3>🧪 Experiments Covered</h3>
<p><?= $data['experiments'] ?></p>
</div>

<div class="section">
<h3>💻 Tools & Software</h3>
<p><?= $data['tools'] ?></p>
</div>

<div class="section">
<h3>📊 Evaluation Criteria</h3>
<p><?= $data['evaluation'] ?></p>
</div>

<div class="section highlight">
<h3>🎯 Learning Outcomes</h3>
<p><?= $data['outcomes'] ?></p>
</div>


</div>

<!-- RIGHT SIDEBAR -->

<div class="info">

<div class="info-item">
<strong>🏫 Lab Mode</strong>
<?= $data['mode'] ?>
</div>


<div class="info-item">
<strong>🎓 Level</strong>
Undergraduate Practical Lab
</div>

</div>

<div class="section" style="grid-column:1/-1;">
<h3>📝 Sample Lab Work</h3>

<div class="highlight">
<?= $data['sample'] ?>
</div>
</div>

</div>

<!-- FOOTER -->

<div class="footer">
<a href="labs.php" class="back">← Back to Labs</a>
<span style="color:#64748b">Laboratory Module</span>
</div>

</div>
</div>

</body>
</html>