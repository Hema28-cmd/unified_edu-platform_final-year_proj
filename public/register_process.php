<?php
session_start();
include('../config/db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer/src/Exception.php';
require '../vendor/PHPMailer/src/PHPMailer.php';
require '../vendor/PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

$name  = mysqli_real_escape_string($conn,$_POST['name']);
$email = mysqli_real_escape_string($conn,$_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role  = mysqli_real_escape_string($conn,$_POST['role']);
$level = mysqli_real_escape_string($conn,$_POST['education']);

$check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

if(mysqli_num_rows($check)>0){
    echo "<script>alert('Email already registered'); window.location='register.php';</script>";
    exit;
}

$otp = rand(100000,999999);

$_SESSION['otp']=$otp;
$_SESSION['name']=$name;
$_SESSION['email']=$email;
$_SESSION['password']=$password;
$_SESSION['role']=$role;
$_SESSION['level']=$level;

$mail = new PHPMailer(true);

try{

$mail->isSMTP();
$mail->Host='smtp.gmail.com';
$mail->SMTPAuth=true;
$mail->Username='unified@gmail.com'; #senders mail id
$mail->Password='abcd e123 fghi ndls';  #set password
$mail->SMTPSecure='tls';
$mail->Port=587;

$mail->setFrom('unified@gmail.com','Unified Edu');
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject="Email Verification Code";
$mail->Body = "
<div style='font-family:Arial, sans-serif; line-height:1.6; color:#333;'>

<h2 style='color:#2c7be5;'>Welcome to Unified Edu 🎓</h2>

<p>Dear <b>$name</b>,</p>

<p>Thank you for registering at <b>Unified Edu</b>. We are excited to have you as part of our learning community.</p>

<p>Your account registration process has started. To complete your registration and verify your email address, please use the following One-Time Password (OTP):</p>

<div style='background:#f2f2f2; padding:15px; text-align:center; font-size:24px; font-weight:bold; letter-spacing:3px; border-radius:6px;'>
$otp
</div>

<p>Once your email is verified, you will be able to log in to the platform using your registered email and password.</p>

<br>

<p>Thank you,<br>
<b>Unified Edu Team</b><br>
Empowering Learning Everywhere</p>

</div>
";
$mail->send();

echo "<script>
alert('OTP sent to your email');
window.location='register.php?otp=1';
</script>";

}
catch(Exception $e){
echo "Mailer Error: ".$mail->ErrorInfo;
}

}
?>
