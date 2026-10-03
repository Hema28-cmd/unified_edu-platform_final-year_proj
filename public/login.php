<?php
include('../config/db.php');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = trim($_POST['password']);

    $q = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $r = mysqli_query($conn, $q);

    if (!$r) {
        die("SQL ERROR: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($r) === 1) {

        $user = mysqli_fetch_assoc($r);

        /* CHECK EMAIL VERIFIED */
        if ($user['email_verified'] == 0) {
            $error = "Please verify your email before logging in.";
        }

        /* CHECK PASSWORD */
        elseif (password_verify($password, $user['password'])) {

            $_SESSION['user_id']    = $user['id'];
            $_SESSION['user_name']  = $user['name'];
            $_SESSION['user_role']  = $user['role'];
            $_SESSION['user_level'] = $user['level'];

            header("Location: dashboard.php");
            exit;
        }
        else {
            $error = "Invalid email or password!";
        }

    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | Unified Education</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="container-fluid auth-bg">
  <div class="row min-vh-100 align-items-center justify-content-center">

    <!-- LEFT CARD : LOGIN -->
    <div class="col-md-4 mb-4">
      <div class="card auth-card shadow-sm">

        <div class="card-body p-4">

          <div class="text-center mb-3">
            <div class="auth-emoji">🎒🚀</div>
            <h3 class="auth-title">Welcome Back</h3>
            <p class="text-muted">Login to your learning dashboard</p>
          </div>

          <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>

          <form action="login.php" method="POST">
            <input type="email" name="email"
                   class="form-control mb-3"
                   placeholder="📧 Email Address" required>

            <input type="password" name="password"
                   class="form-control mb-4"
                   placeholder="🔑 Password" required>

            <button class="btn btn-login-outline w-100">
              🚀 Login to Dashboard
            </button>
          </form>

          <p class="auth-link text-center mt-4">
            Don’t have an account?
            <a href="register.php">Register here ✨</a>
          </p>

        </div>
      </div>
    </div>

    <!-- RIGHT CARD : CONTENT -->
    <div class="col-md-6 d-none d-md-block">
      <div class="card info-card shadow-sm">

        <div class="card-body p-5">

          <h2 class="fw-bold mb-3">
            📘 Unified Digital Education Platform
          </h2>

          <p class="lead text-muted">
            A single learning space designed for every stage of education.
          </p>

          <div class="row mt-4">
            <div class="col-6 feature-item">🧸 Kindergarten Learning</div>
            <div class="col-6 feature-item">📖 Primary & Secondary</div>
            <div class="col-6 feature-item">🎓 Undergraduate</div>
            <div class="col-6 feature-item">🏫 Post-Graduation</div>
          </div>

          <div class="mt-4 highlight-box">
            🌟 Learn • Practice • Grow • Succeed 🌟
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

<script src="assets/js/auth.js"></script>

</body>
</html>