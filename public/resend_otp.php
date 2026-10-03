<?php
session_start();

$otp = rand(100000,999999);

$_SESSION['otp']=$otp;

/* send email again using PHPMailer */

echo "resent";
?>