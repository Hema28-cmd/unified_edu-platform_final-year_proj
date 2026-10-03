<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

$course = $_GET['course'] ?? '';

/* ================= ALL COURSE MATERIALS ================= */
$all_materials = [

    /* ================= AI ================= */
    'ai' => [
        'Lecture Notes' => [
            ['title'=>'Introduction to AI', 'type'=>'PDF', 'uploaded'=>'2025-01-05', 'file'=>'notes/notes_intro_ai.pdf'],
           
        ],
        'Videos' => [
            ['title'=>'AI Basics', 'type'=>'YouTube', 'file'=>'https://www.youtube.com/embed/2ePf9rue1Ao'],
            
        ],
        'Assignments' => [
            ['title'=>'Assignment 1: AI Fundamentals', 'type'=>'PDF', 'uploaded'=>'2025-01-15', 'file'=>'notes/assignment1.pdf'],
           
        ]
    ],

    /* ================= ML ================= */
    'ml' => [
        'Lecture Notes' => [
            ['title'=>'Introduction to ML', 'type'=>'PDF', 'uploaded'=>'2025-01-07', 'file'=>'notes/notes_intro_ml.pdf'],
          
        ],
        'Videos' => [
            ['title'=>'Machine Learning Basics', 'type'=>'YouTube', 'file'=>'https://www.youtube.com/embed/GwIo3gDZCVQ'],
          
        ],
        'Assignments' => [
            ['title'=>'Assignment 1: ML Basics', 'type'=>'PDF', 'uploaded'=>'2025-01-17', 'file'=>'notes/assignment_ml1.pdf']
            
        ]
    ],

    /* ================= CYBER ================= */
    'cyber' => [
        'Lecture Notes' => [
            ['title'=>'Introduction to Cybersecurity', 'type'=>'PDF', 'uploaded'=>'2025-02-01', 'file'=>'notes/intro_cyber.pdf'],
           
        ],
        'Videos' => [
            ['title'=>'Cybersecurity Basics', 'type'=>'YouTube', 'file'=>'https://www.youtube.com/embed/inWWhr5tnEA'],
      
        ],
        'Assignments' => [
            ['title'=>'Assignment 1: Security Assessment', 'type'=>'PDF', 'uploaded'=>'2025-02-20', 'file'=>'notes/assignment_cyber1.pdf'],
            
        ]
    ],

    /* ================= DATA SCIENCE ================= */
    'data' => [
        'Lecture Notes' => [
            ['title'=>'Data Cleaning Techniques', 'type'=>'PDF', 'uploaded'=>'2025-03-05', 'file'=>'notes/data_cleaning.pdf'],
          
        ],
        'Videos' => [
            ['title'=>'Data Science Basics', 'type'=>'YouTube', 'file'=>'https://www.youtube.com/embed/ua-CiDNNj30'],
    
        ],
        'Assignments' => [
            ['title'=>'Assignment 1: Cleaning Data', 'type'=>'PDF', 'uploaded'=>'2025-03-20', 'file'=>'notes/assignment_ds1.pdf']
         
        ]
    ],

    /* ================= CLOUD ================= */
    'cloud' => [
        'Lecture Notes' => [
            ['title'=>'Cloud Computing Basics', 'type'=>'PDF', 'uploaded'=>'2025-04-01', 'file'=>'notes/cloud_basics.pdf'],
        
        ],
        'Videos' => [
            ['title'=>'Cloud Architecture', 'type'=>'YouTube', 'file'=>'https://www.youtube.com/embed/M988_fsOSWo'],
            
        ],
        'Assignments' => [
            ['title'=>'Assignment 1: Cloud Deployment', 'type'=>'PDF', 'uploaded'=>'2025-04-20', 'file'=>'notes/assignment_cloud1.pdf']
           
        ]
    ],

    /* ================= NETWORK ================= */
    'network' => [
        'Lecture Notes' => [
            ['title'=>'Network Fundamentals', 'type'=>'PDF', 'uploaded'=>'2025-05-01', 'file'=>'notes/network_fundamentals.pdf'],
         
        ],
        'Videos' => [
            ['title'=>'Networking Basics', 'type'=>'YouTube', 'file'=>'https://www.youtube.com/embed/qiQR5rTSshw'],
          
        ],
        'Assignments' => [
            ['title'=>'Assignment 1: Network Setup', 'type'=>'PDF', 'uploaded'=>'2025-05-20', 'file'=>'notes/assignment_network1.pdf'],
            
        ]
    ],

];

/* ================= SELECT MATERIALS ================= */
$materials = $all_materials[$course] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo strtoupper($course); ?> Materials | Postgraduate</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body{margin:0;font-family:'Segoe UI',sans-serif;background:#f4f7fa;}
.header{background:<?php echo ($course=='ai')?'linear-gradient(135deg,#ff9a9e,#fad0c4)':'linear-gradient(135deg,#4ade80,#16a34a)'; ?>;color:white;padding:50px 20px;text-align:center;border-radius:0 0 40px 40px;}
.header h1{margin:0;font-size:32px;}
.header p{margin:5px 0 0 0;opacity:0.9;}
.container{max-width:1000px;margin:40px auto;padding:0 20px;}
.material-section{margin-bottom:35px;}
.material-section h2{font-size:22px;margin-bottom:15px;border-bottom:2px solid <?php echo ($course=='ai')?'#6a11cb':'#15803d'; ?>;display:inline-block;padding-bottom:5px;}
.material-card{background:#fff;border-radius:20px;padding:20px;box-shadow:0 12px 25px rgba(0,0,0,0.08);margin-bottom:20px;}
.material-info{margin-bottom:10px;}
.material-info .title{font-weight:600;color:#1e1e2f;font-size:16px;}
.material-info .meta{font-size:13px;color:#6c757d;}
.material-content{margin-top:10px;border:1px solid #ddd;border-radius:10px;overflow:hidden;}
.material-content iframe, .material-content video{width:100%;height:500px;border:none;}
.back-btn{display:block;width:220px;margin:30px auto;padding:14px;background:<?php echo ($course=='ai')?'#ff9a9e':'#4ade80'; ?>;color:#fff;text-align:center;text-decoration:none;border-radius:30px;}
.back-btn:hover{background:<?php echo ($course=='ai')?'#e06b8c':'#16a34a'; ?>;}
@media(max-width:768px){.material-content iframe,.material-content video{height:300px;}}
</style>
</head>
<body>

<div class="header">
    <h1>📚 <?php echo strtoupper($course); ?> Course Materials</h1>
    <p>Postgraduate Course: <?php echo strtoupper($course); ?></p>
</div>

<div class="container">
<?php foreach($materials as $section => $items){ ?>
    <div class="material-section">
        <h2><?php echo $section; ?></h2>
        <?php foreach($items as $item){ ?>
            <div class="material-card">
                <div class="material-info">
                    <div class="title"><?php echo $item['title']; ?></div>
                    <div class="meta"><?php echo $item['type']; ?> | Uploaded: <?php echo $item['uploaded'] ?? 'N/A'; ?></div>
                </div>
                <div class="material-content">
                    <?php if($item['type']=='PDF'){ ?>

    <iframe src="<?php echo $item['file']; ?>"></iframe>

<?php } elseif($item['type']=='YouTube'){ ?>

    <iframe src="<?php echo $item['file']; ?>" allowfullscreen></iframe>

<?php } else { ?>

    <video controls>
        <source src="<?php echo $item['file']; ?>" type="video/mp4">
    </video>

<?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
</div>

<a href="course_detail.php?course=<?php echo $course; ?>" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
