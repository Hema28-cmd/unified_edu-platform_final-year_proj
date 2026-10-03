<?php
session_start();

// Only allow postgraduate users
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'postgraduate') {
    header("Location: ../dashboard.php");
    exit;
}

// ================= SAMPLE SEMINARS =================
$seminars = [
    [
        'id' => 'S101',
        'title' => 'AI in Healthcare',
        'description' => 'This seminar explores how Artificial Intelligence is transforming healthcare through predictive analytics, disease detection, and intelligent monitoring systems. Real-world case studies will be discussed.',
        'venue' => 'Auditorium 1',
        'speaker' => 'Dr. Ravi Kumar',
        'date' => '2026-05-10',
        'duration' => '2 Hours',
        'topics' => ['AI in Diagnosis', 'Medical Data Analysis', 'Predictive Healthcare'],
        'objectives' => [
            'Understand AI applications in healthcare',
            'Learn predictive analytics techniques',
            'Explore real-world medical case studies'
        ]
    ],
    [
        'id' => 'S102',
        'title' => 'Cybersecurity Trends 2025',
        'description' => 'An in-depth discussion on emerging cybersecurity threats, ethical hacking practices, and advanced defense mechanisms used in modern systems.',
        'venue' => 'Conference Hall A',
        'speaker' => 'Ms. Anjali Sharma',
        'date' => '2026-05-12',
        'duration' => '1.5 Hours',
        'topics' => ['Cyber Attacks', 'Ethical Hacking', 'Network Security'],
        'objectives' => [
            'Identify modern cyber threats',
            'Understand security frameworks',
            'Learn prevention techniques'
        ]
    ],
    [
        'id' => 'S103',
        'title' => 'Cloud Computing Cost Optimization',
        'description' => 'Learn how organizations reduce cloud expenses using optimization strategies, efficient resource allocation, and cost monitoring tools.',
        'venue' => 'Auditorium 2',
        'speaker' => 'Mr. Arjun Nair',
        'date' => '2026-05-15',
        'duration' => '2 Hours',
        'topics' => ['Cloud Costing', 'AWS Optimization', 'Resource Allocation'],
        'objectives' => [
            'Understand cloud pricing models',
            'Optimize resource usage',
            'Reduce operational costs'
        ]
    ],
    [
        'id' => 'S104',
        'title' => 'Data Science for Social Good',
        'description' => 'This seminar focuses on using data science techniques to solve real-world social problems such as poverty, healthcare, and education.',
        'venue' => 'Online',
        'speaker' => 'Dr. Meena Iyer',
        'date' => '2026-05-18',
        'duration' => '1 Hour',
        'topics' => ['Social Analytics', 'Data Visualization', 'Public Welfare'],
        'objectives' => [
            'Apply data science for social impact',
            'Analyze community data',
            'Create meaningful insights'
        ]
    ],

    // ✅ NEW SEMINARS

    [
        'id' => 'S105',
        'title' => 'Blockchain Technology and Applications',
        'description' => 'Explore blockchain fundamentals, smart contracts, and real-world applications in finance, healthcare, and supply chain.',
        'venue' => 'Seminar Hall B',
        'speaker' => 'Mr. Karthik Raj',
        'date' => '2026-05-20',
        'duration' => '2 Hours',
        'topics' => ['Blockchain Basics', 'Smart Contracts', 'Cryptography'],
        'objectives' => [
            'Understand blockchain architecture',
            'Learn secure transaction methods',
            'Explore real-world applications'
        ]
    ],
    [
        'id' => 'S106',
        'title' => 'Big Data Analytics',
        'description' => 'Introduction to big data tools and technologies such as Hadoop and Spark, with focus on large-scale data processing.',
        'venue' => 'Auditorium 3',
        'speaker' => 'Prof. Suresh Babu',
        'date' => '2026-05-22',
        'duration' => '2 Hours',
        'topics' => ['Hadoop', 'Spark', 'Data Processing'],
        'objectives' => [
            'Understand big data concepts',
            'Learn distributed computing',
            'Analyze large datasets'
        ]
    ],
    [
        'id' => 'S107',
        'title' => 'Internet of Things (IoT)',
        'description' => 'Learn how IoT devices communicate and how they are used in smart homes, industries, and agriculture.',
        'venue' => 'Lab Hall 1',
        'speaker' => 'Ms. Priya Nandakumar',
        'date' => '2026-05-25',
        'duration' => '1.5 Hours',
        'topics' => ['IoT Devices', 'Sensors', 'Smart Systems'],
        'objectives' => [
            'Understand IoT architecture',
            'Learn sensor integration',
            'Explore real-world applications'
        ]
    ],
];
// ================= STATUS COLOR FUNCTION =================
function getStatusColor($status){
    return match($status){
        'Completed' => '#16a34a',
        'Ongoing' => '#f59e0b',
        'Upcoming' => '#ef4444',
        default => '#64748b',
    };
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Postgraduate Seminars</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
body {
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#f0f4f8;
    color:#1f2937;
}
.header {
    background:#4f46e5;
    color:white;
    text-align:center;
    padding:50px 20px;
    border-bottom-left-radius:50px;
    border-bottom-right-radius:50px;
}
.header h1 { font-size:36px; margin:0; }
.header p { margin-top:5px; opacity:0.85; font-size:16px; }

.container {
    max-width:1000px;
    margin:40px auto;
    padding:0 20px;
}

.seminar-item {
    display:flex;
    border-left:8px solid #4f46e5;
    background:white;
    border-radius:15px;
    margin-bottom:20px;
    padding:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}
.seminar-item:hover {
    transform: translateY(-3px);
    box-shadow:0 15px 30px rgba(0,0,0,0.15);
}
.seminar-info { flex:1; }
.seminar-info h2 { margin:0 0 10px; color:#4f46e5; font-size:22px; }
.seminar-info p { margin:5px 0; line-height:1.5; color:#475569; }
.meta { display:flex; flex-wrap:wrap; gap:10px; margin-top:10px; }
.meta span { background:#e0f2fe; padding:6px 12px; border-radius:12px; font-weight:600; font-size:13px; }
.status { padding:6px 12px; border-radius:15px; font-weight:600; color:white; }

.view-btn {
    text-decoration:none;
    padding:8px 20px;
    border-radius:20px;
    font-size:14px;
    font-weight:600;
    color:white;
    background:#ec4899;
    transition:0.3s;
    align-self:flex-start;
    margin-left:20px;
}
.view-btn:hover { background:#be185d; }

.back-btn {
    display:block;
    width:220px;
    margin:40px auto;
    padding:14px;
    background:#4f46e5;
    color:white;
    text-align:center;
    text-decoration:none;
    border-radius:30px;
    font-weight:500;
    text-transform:uppercase;
}
.back-btn:hover { background:#4338ca; }
</style>
</head>
<body>

<div class="header">
    <h1>🎓 Postgraduate Seminars</h1>
    <p>Explore all ongoing, upcoming, and completed seminars</p>
</div>

<div class="container">
<?php foreach($seminars as $s): ?>
    <div class="seminar-item">
        <div class="seminar-info">
            <h2><?php echo $s['title']; ?></h2>
            <p><?php echo $s['description']; ?></p>
                    </div>
        <a href="view_seminar.php?id=<?php echo $s['id']; ?>" class="view-btn">View Seminar</a>
    </div>
<?php endforeach; ?>
</div>

<a href="../postgraduate.php" class="back-btn">⬅ Back to Dashboard</a>

</body>
</html>
