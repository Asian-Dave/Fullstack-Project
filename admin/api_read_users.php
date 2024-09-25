<?php
session_start();
if ($_SESSION["role"] == "admin") {

require_once "../components/headers.php";
require_once '../components/dbconnection.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    // http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    exit();
}

$role = $_SESSION["role"];

if ($role !== "admin") {
    // http_response_code(403);
    echo json_encode(["message" => "Unauthorized access"]);
    exit();
}

$cols=["id","firstname", "lastname", "email","role","picture","profile_info"];
// $result = 
$obj->read("JSON", "users", $cols);
}

// if ($result === null) {
//     http_response_code(500);
//     echo json_encode(["message" => "Failed to retrieve trainers"]);
// } else {
//     echo json_encode($result);
// }
