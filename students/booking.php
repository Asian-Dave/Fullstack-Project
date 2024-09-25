<?php
session_start();
require_once "../frontend/HTML/session_checker.php";
noUser();
$student_id = $_SESSION["user_id"];


$cols = [
  "bookings.booking_date",
  "bookings.status",
  "tutoring_services.description",
];
$join = "
    JOIN tutoring_services ON bookings.tutoring_service_id = tutoring_services.id
";
$condition = "WHERE student_id = $student_id";

require_once "../components/dbconnection.php";
require_once "../components/headers.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
  echo "<h2>Something went wrong</h2>";
  exit();
}
$obj->read("JSON", "bookings", $cols, $condition, $join);
