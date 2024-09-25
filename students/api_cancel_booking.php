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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    exit();
}

$bookingId = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : null;

if ($bookingId === null) {
    http_response_code(400);
    echo json_encode(["message" => "Booking ID is required"]);
    exit();
}



$updateStatus = $obj->update("bookings", ["status" => "cancelled"], "id = $bookingId", "JSON");
