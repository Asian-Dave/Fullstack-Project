<?php
session_start();

if ($_SESSION["role"] == "trainer" || $_SESSION["role"] == "admin") {

    require_once "../components/headers.php";
    require_once '../components/dbconnection.php';

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== 'POST') {
        // http_response_code(405);
        echo json_encode(["message" => "Only POST method is allowed"]);
        exit();
    }


    if (!isset($_POST['subject_id'], $_POST['university_id'], $_POST['description'], $_POST['title'], $_POST['price'], $_POST['capacity'], $_POST['start_date'], $_POST['end_date'])) {
        // http_response_code(400);
        echo json_encode(["message" => "Missing required fields"]);
        exit();
    }


    if ($_SESSION["role"] == "trainer") {
        $trainer_id = intval($_SESSION["user_id"]);
    } elseif ($_SESSION["role"] == "admin") {
        if (!isset($_POST['trainer_id'])) {
            // http_response_code(400);
            echo json_encode(["message" => "Missing required field"]);
            exit();
        }
        $trainer_id = intval($_POST['trainer_id']);
    } else {
        // http_response_code(403); 
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



    $insertData = [
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


    if ($obj->create("tutoring_services", $insertData)) {
        // http_response_code(201);
        echo json_encode(["message" => "Tutoring service created successfully"]);
    } else {
        // http_response_code(500);
        echo json_encode(["message" => "Failed to create tutoring service"]);
    }
}

// Tried:
// URL: YOUR LOCAL URL
// Método: POST
// Cuerpo de la solicitud (JSON):
// {
//     "trainer_id": 1,
//     "subject_id": 2,
//     "university_id": 3,
//     "description": "Math tutoring for first-year students",
//     "price": 50.00,
//     "capacity": 10
// }
