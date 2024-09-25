<?php
session_start();
require_once "../components/dbconnection.php";
require_once "../frontend/HTML/session_checker.php";
noUser();


if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Unauthorized access"]);
    exit();
}

$userId = $_SESSION['user_id'];

$columns = [
    "users.firstname AS firstname",
    "users.lastname AS lastname",
    "users.email AS email",
    "users.role AS role",
    "users.picture AS picture",
    "users.profile_info AS description   "
];

$condition = "WHERE users.id = $userId";

require_once "../components/headers.php";

$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
    exit();
} elseif ($method == "GET") {

    $userData = $obj->read("JSON", "users", $columns, $condition);
}
