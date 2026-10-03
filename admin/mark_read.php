<?php
$conn = new mysqli("localhost","root","","unified_edu");
$id = (int)$_GET['id'];
$conn->query("UPDATE notifications SET is_read=1 WHERE id=$id");
header("Location: admin.php");
