<?php
session_start();
require_once "../frontend/HTML/session_checker.php";
$cols = [
    "tutoring_services.id",
    "tutoring_services.title",
    "tutoring_services.description",
    "tutoring_services.price",
    "tutoring_services.capacity",
    "tutoring_services.date_from",
    "tutoring_services.date_to",
    "subjects.name AS subject_name",
    "universities.name AS university_name"
];
$join = "
    JOIN subjects ON tutoring_services.subject_id = subjects.id
    JOIN universities ON tutoring_services.university_id = universities.id
";



if ($_SESSION["role"] == "trainer") {
    $condition = " WHERE tutoring_services.trainer_id = " . $_SESSION["user_id"];
} elseif ($_SESSION["role"] == "student" || $_SESSION["role"] == "admin") {
    $cols[] = "users.firstname";
    $cols[] = "users.lastname";
    $join .= " JOIN users ON tutoring_services.trainer_id = users.id";

    $condition = "";
} else {
    $condition = "";
}

require_once "../components/headers.php";
require_once '../components/dbconnection.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    http_response_code(405);
    exit();
}
$data = $obj->read("", "tutoring_services", $cols, $condition, $join);

$response = [
    "role" => $_SESSION["role"],
    "data" => $data
];

echo json_encode($response);
