<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";

session_start();
noUser();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized"]);
    exit();
}

$userId = $_SESSION['user_id'];

$cols = [
    "bookings.id AS booking_id",
    "tutoring_services.description",
    "tutoring_services.price",
    "tutoring_services.capacity",
    "tutoring_services.date_from",
    "tutoring_services.date_to",
    "subjects.name AS subject_name",
    "users.firstname AS trainer_firstname",
    "users.lastname AS trainer_lastname",
    "bookings.booking_date",
    "bookings.status",
    "bookings.tutoring_service_id"
];

$join = "
    JOIN tutoring_services ON bookings.tutoring_service_id = tutoring_services.id
    JOIN subjects ON tutoring_services.subject_id = subjects.id
    JOIN users ON tutoring_services.trainer_id = users.id
";

$condition = "WHERE bookings.student_id = $userId GROUP BY bookings.id";

$bookings = $obj->read("JSON", "bookings", $cols, $condition, $join);
