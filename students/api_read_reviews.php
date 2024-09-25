<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";
session_start();
noUser();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["message" => "Unauthorized access"]);
    exit();
}

$userId = $_SESSION['user_id'];

$cols = [
    "reviews.id",
    "reviews.rating",
    "reviews.comment",
    "reviews.student_id",
    "tutoring_services.title AS title",
    "subjects.name AS subject",
    "users.firstname AS firstname",
    "users.lastname AS lastname",
    "users.picture AS picture"
];

$join = "
JOIN tutoring_services ON reviews.tutoring_service_id = tutoring_services.id
JOIN subjects ON tutoring_services.subject_id = subjects.id
JOIN users ON reviews.student_id = users.id
";

$condition = "WHERE reviews.student_id = $userId";

$reviews = $obj->read("JSON", "reviews", $cols, $condition, $join);
