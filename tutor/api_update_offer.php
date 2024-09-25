<?php
session_start();

if ($_SESSION["role"] == "trainer" || $_SESSION["role"] == "admin") {

    require_once "../components/headers.php";
    require_once '../components/dbconnection.php';

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== 'POST') {
        echo json_encode(["message" => "Only POST method is allowed"]);
        exit();
    }

    if (!isset($_POST['id'])) {
        echo json_encode(["message" => "Service ID is required for updating"]);
        exit();
    }

    if (!isset($_POST['subject_id'], $_POST['university_id'], $_POST['description'], $_POST['title'], $_POST['price'], $_POST['capacity'])) {
        echo json_encode(["message" => "Missing required fields"]);
        exit();
    }

    $service_id = intval($_POST['id']);

    if ($_SESSION["role"] == "trainer") {
        $trainer_id = intval($_SESSION["user_id"]);
    } elseif ($_SESSION["role"] == "admin") {
        if (!isset($_POST['trainer_id'])) {
            echo json_encode(["message" => "Missing required field: trainer_id"]);
            exit();
        }
        $trainer_id = intval($_POST['trainer_id']);
    } else {
        echo json_encode(["message" => "Unauthorized access"]);
        exit();
    }

    $subject_id = intval($_POST['subject_id']);
    $university_id = intval($_POST['university_id']);
    $description = htmlspecialchars(strip_tags($_POST['description']));
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $price = floatval($_POST['price']);
    $capacity = intval($_POST['capacity']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];


    $updateData = [
        "trainer_id" => $trainer_id,
        "subject_id" => $subject_id,
        "university_id" => $university_id,
        "description" => $description,
        "title" => $title,
        "price" => $price,
        "capacity" => $capacity,
        "date_from" => $start_date,
        "date_to" => $end_date
    ];

    $conditions = "id = $service_id AND trainer_id = $trainer_id";
    if ($_SESSION["role"] == "admin") {
        $conditions = "id = $service_id";
    }

    if ($obj->update("tutoring_services", $updateData, $conditions)) {
        echo json_encode(["message" => "Tutoring service updated successfully"]);
    } else {
        echo json_encode(["message" => "Failed to update tutoring service"]);
    }
} else {
    echo json_encode(["message" => "Unauthorized access"]);
    exit();
}
