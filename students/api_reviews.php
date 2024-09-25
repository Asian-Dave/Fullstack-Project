<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";
session_start();
noUser();
$tutoringServiceId = $_POST['tutoring_service_id'];

$cols = [
    "reviews.id",
    "reviews.rating",
    "reviews.comment",
    "users.firstname AS firstname",
    "users.lastname AS lastname",
    "users.picture AS picture"
];

$join = "JOIN users ON reviews.student_id = users.id";
$condition = "WHERE reviews.tutoring_service_id = $tutoringServiceId";

$reviews = $obj->read("JSON", "reviews", $cols, $condition, $join);
