<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['user_level'] !== 'primary'){
    header("Location: ../dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Primary Live Classes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #e3f2fd, #f1f8ff);
            font-family: 'Segoe UI', sans-serif;
        }

        .page-title {
            text-align: center;
            font-weight: 700;
            margin-bottom: 30px;
            color: #0d47a1;
        }

        .class-card {
            border-radius: 15px;
            transition: 0.3s;
        }

        .class-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .btn-join {
            border-radius: 20px;
        }
    </style>
</head>

<body>

<div class="container py-5">

    <h2 class="page-title">
        📚 Primary Level Live Classes
    </h2>

    <div class="row g-4">

        <!-- Math Class -->
        <div class="col-md-6">
            <div class="card class-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-calculator text-primary"></i> Mathematics
                    </h5>
                    <p class="card-text">
                        Learn concepts, problem-solving techniques, and practice exercises.
                    </p>
                    <a href="https://meet.google.com/abc-defg-hij"
                       target="_blank"
                       class="btn btn-primary btn-join">
                        <i class="fa-solid fa-video"></i> Join Live Class
                    </a>
                </div>
            </div>
        </div>

        <!-- English Class -->
        <div class="col-md-6">
            <div class="card class-card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fa-solid fa-book-open text-success"></i> English
                    </h5>
                    <p class="card-text">
                        Improve reading, writing, grammar, and communication skills.
                    </p>
                    <a href="https://meet.google.com/xyz-pqrs-tuv"
                       target="_blank"
                       class="btn btn-success btn-join">
                        <i class="fa-solid fa-video"></i> Join Live Class
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="../primary.php" class="btn btn-outline-dark">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>
