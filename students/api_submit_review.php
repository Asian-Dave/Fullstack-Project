<?php
require_once '../components/dbconnection.php';
require_once "../frontend/HTML/session_checker.php";
session_start();
noUser();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_SESSION['user_id'];
    $tutoringServiceId = intval($_POST['tutoring_service_id']);
    $rating = intval($_POST['rating']);
    $comment = trim($_POST['comment']);


    $params = [
        'student_id' => $studentId,
        'tutoring_service_id' => $tutoringServiceId,
        'rating' => $rating,
        'comment' => $comment
    ];

    $obj = new DbConfig();
    $obj->create('reviews', $params, 'JSON');
}
