<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";

session_start();
noUser();
$user_id = $_SESSION['user_id'];

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "POST") {

    $lesson_id = cleanedInput($_POST['lesson_id']);


    $existingBooking = $obj->read("ARRAY", "bookings", "*", "WHERE student_id = $user_id AND tutoring_service_id = $lesson_id");

    if ($existingBooking) {
        http_response_code(400);
        echo json_encode(["message" => "You have already booked this lesson."]);
        exit();
    }

    $columns = [
        "student_id" => $user_id,
        "tutoring_service_id" => $lesson_id,
        "booking_date" => date("Y-m-d H:i:s")
    ];


    $result = $obj->create("bookings", $columns);

    if ($result) {
        http_response_code(201);
        echo json_encode(["message" => "Booking successful!"]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to create booking."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed."]);
}
