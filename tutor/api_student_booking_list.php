<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";
noUser();
session_start();
$userId = $_SESSION['user_id'];

$cols = [
    "users.firstname",
    "users.lastname",
    "users.email"
];

$join = "
JOIN bookings ON bookings.student_id = users.id
JOIN tutoring_services ON bookings.tutoring_service_id = tutoring_services.id
";

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {
    if (isset($_POST["id"])) {
        $id = intval($_POST['id']);
        $condition = " WHERE tutoring_services.id = $id";
        $students = $obj->read("JSON", "users", $cols, $condition, $join);
    }
} else {
    http_response_code(405);
    exit();
}
