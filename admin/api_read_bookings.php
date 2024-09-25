<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";

session_start();


if ($_SESSION["role"] !== "admin") {
    http_response_code(403);
    echo json_encode(["message" => "Access denied."]);
    exit();
}

$cols = [
    "bookings.id",
    "bookings.status",
    "subjects.name AS subject_name",
    "tutoring_services.description",
    "users.firstname AS trainer_firstname",
    "users.lastname AS trainer_lastname",
    "tutoring_services.price",
    "tutoring_services.capacity",
    "bookings.booking_date",
    "students.firstname AS student_firstname",
    "students.lastname AS student_lastname",
    "students.email AS student_email"
];

$join = "
JOIN tutoring_services ON bookings.tutoring_service_id = tutoring_services.id
JOIN users ON tutoring_services.trainer_id = users.id
JOIN subjects ON tutoring_services.subject_id = subjects.id
JOIN users AS students ON bookings.student_id = students.id
";

$bookings = $obj->read("JSON", "bookings", $cols, "", $join);
