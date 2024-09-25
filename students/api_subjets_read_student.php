<?php
require_once "../components/headers.php";

require_once '../components/dbconnection.php';


$method = $_SERVER['REQUEST_METHOD'];

if ($method !== 'GET') {
    http_response_code(405);
    exit();
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conditions = "WHERE id = $id";
} else {
    $conditions = "";
}

$obj->read("JSON", "subjects", "*", $conditions);
