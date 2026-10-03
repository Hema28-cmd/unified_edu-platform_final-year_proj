<?php
// Database credentials
$host = "localhost";
$db_user = "root";       // XAMPP default
$db_pass = "";           // XAMPP default
$db_name = "unified_edu";

// Create connection
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
