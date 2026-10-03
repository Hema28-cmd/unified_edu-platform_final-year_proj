<?php
session_start();

$levels = require 'levels.php';

$currentLevel = $_SESSION['user_level'] ?? null;

if (!$currentLevel) {
    header("Location: login.php");
    exit;
}

$index = array_search($currentLevel, $levels);

/* If not last level → move to next */
if ($index !== false && $index < count($levels) - 1) {
    $_SESSION['user_level'] = $levels[$index + 1];
}
/* If last level completed */
else {
    $_SESSION['user_level'] = 'ALL_LEVELS';
}

/* Reset progress for next level */
unset($_SESSION['progress']);

header("Location: next_level_router.php");
exit;
