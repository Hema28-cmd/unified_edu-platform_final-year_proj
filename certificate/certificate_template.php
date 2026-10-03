<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'kindergarten') {
    exit("Unauthorized");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kindergarten Certificate</title>
    <style>
        body {
            margin: 0;
            font-family: 'Comic Sans MS', cursive;
            background: #fff5f7;
        }
        .certificate {
            width: 1000px;
            height: 700px;
            margin: 30px auto;
            border: 12px solid #ff99cc;
            padding: 40px;
            text-align: center;
            background: #ffffff;
        }
        h1 {
            color: #cc3366;
            font-size: 48px;
        }
        h2 {
            color: #444;
            font-size: 30px;
        }
        .name {
            font-size: 40px;
            color: #ff6699;
            margin: 30px 0;
            font-weight: bold;
        }
        .date {
            margin-top: 40px;
            font-size: 18px;
        }
        .print-btn {
            display: block;
            margin: 30px auto;
            background: #ff6699;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            width: fit-content;
        }
        @media print {
            .print-btn { display: none; }
        }
    </style>
</head>
<body>

<div class="certificate">
    <h1>Certificate of Achievement</h1>
    <h2>This is proudly presented to</h2>

    <div class="name">
        <?php echo htmlspecialchars($_SESSION['username'] ?? 'Student'); ?>
    </div>

    <h2>For successfully completing the Kindergarten Quiz</h2>

    <div class="date">
        Date: <?php echo date('d M Y'); ?>
    </div>
</div>

<a href="#" onclick="window.print()" class="print-btn">
    🖨️ Print / Save as PDF
</a>

</body>
</html>
