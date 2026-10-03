session_start();
include('../config/db.php');

$user_id = $_SESSION['user_id'];

mysqli_query($conn,"
    UPDATE user_progress
    SET quizzes_completed = quizzes_completed + 1
    WHERE user_id = $user_id AND level = '$level'
");
mysqli_query($conn,"
    UPDATE user_progress
    SET games_completed = games_completed + 1
    WHERE user_id = $user_id AND level = 'kindergarten'
");
