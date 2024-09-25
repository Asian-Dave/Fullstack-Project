<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";
session_start();
noUser();
$reviewId = $_POST['review_id'];

$obj->delete("reviews", "id = $reviewId", "JSON");
