<?php
$conn = new mysqli("localhost","root","","unified_edu");

$id = (int)$_GET['id'];

/* Get quiz */
$q = $conn->query("SELECT * FROM quizzes WHERE id=$id");
if($q->num_rows == 0){
    $q = $conn->query("SELECT * FROM quizzes1 WHERE id=$id");
}
$quiz = $q->fetch_assoc();

/* Get questions */
$res = $conn->query("SELECT * FROM quiz_questions WHERE quiz_id=$id");

$questions = [];
while($row = $res->fetch_assoc()){
    $questions[] = $row;
}

echo json_encode([
    "quiz" => $quiz,
    "questions" => $questions
]);