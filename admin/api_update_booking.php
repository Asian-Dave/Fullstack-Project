<?php
session_start();
if (!isset($_SESSION["role"])) {
    header("Location: ../../login/registration.php");
    exit();
}

if ($_SESSION["role"] != "admin") {
    header("Location: home.php");
    exit();
}
require_once "../components/headers.php";
require_once '../components/dbconnection.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'POST') {
    echo json_encode(["message" => "Only POST method is allowed"]);
    exit();
}

if (!isset($_POST['id'])) {
    echo json_encode(["message" => "Booking ID is required for updating"]);
    exit();
}
$booking_id = $_POST['id'];
$offer_id = $_POST['offer_id'];
$status = $_POST['status'];

$updateData = [
    "id" => $booking_id,
    "tutoring_service_id" => $offer_id,
    "status" => $status
];
$conditions = "id= $booking_id";
if ($obj->update("bookings", $updateData, $conditions)) {
    echo json_encode(["message" => "Booking updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update the booking"]);
}
