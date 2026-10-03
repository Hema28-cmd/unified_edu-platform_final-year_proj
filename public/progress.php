<?php
session_start();

$type = $_GET['type'] ?? '';

if (!isset($_SESSION['progress'])) {
    $_SESSION['progress'] = [
        'lessons_completed' => 0,
        'quizzes_completed' => 0,
        'games_completed' => 0
    ];
}

if ($type === 'lessons') $_SESSION['progress']['lessons_completed'] = 1;
if ($type === 'quizzes') $_SESSION['progress']['quizzes_completed'] = 1;
if ($type === 'games') $_SESSION['progress']['games_completed'] = 1;
