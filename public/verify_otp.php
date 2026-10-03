<?php
session_start();
include('../config/db.php');

$otp = $_POST['otp'];

if($otp == $_SESSION['otp']){

$name=$_SESSION['name'];
$email=$_SESSION['email'];
$password=$_SESSION['password'];
$role=$_SESSION['role'];
$level=$_SESSION['level'];

mysqli_query($conn,"INSERT INTO users (name,email,password,role,level,email_verified)
VALUES('$name','$email','$password','$role','$level',1)");

session_destroy();

echo "success";

}else{
echo "fail";
}
?>