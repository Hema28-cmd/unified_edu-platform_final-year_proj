<?php
session_start();

$level = $_SESSION['user_level'] ?? '';

switch ($level) {
    case 'kindergarten':
        header("Location: kindergarten.php");
        break;
    case 'primary':
        header("Location: primary.php");
        break;
    case 'secondary':
        header("Location: secondary.php");
        break;
    case 'highschool':
        header("Location: highschool.php");
        break;
    case 'undergraduate':
        header("Location: undergraduate.php");
        break;
    case 'postgraduate':
        header("Location: postgraduate.php");
        break;
    case 'ALL_LEVELS':
        header("Location: all_levels.php");
        break;
    default:
        header("Location: dashboard.php");
}

exit;
