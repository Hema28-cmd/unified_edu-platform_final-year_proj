<?php
session_start();

if (!isset($_SESSION['quiz_completed']) || $_SESSION['quiz_completed'] !== true) {
    die("Certificate Locked. Complete the quiz.");
}

header("Location: certificate_template.php");
exit;
