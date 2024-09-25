<?php
require_once "../components/dbconnection.php";
require_once "../components/headers.php";
require_once "../frontend/HTML/session_checker.php";
session_start();
noUser();

$method = $_SERVER['REQUEST_METHOD'];

if ($method == "GET") {
    $subject = $obj->read("JSON", "subjects", "*");
} elseif ($method == "POST") {

    $userId = $_SESSION['user_id'];
    $id = intval($_POST['subject_id']);
    $selectedDate = isset($_POST['date']) ? $_POST['date'] : null;

    if (isset($_POST["subject_id"])) {
        $cols = [
            "tutoring_services.id",
            "tutoring_services.description",
            "tutoring_services.title",
            "tutoring_services.price",
            "tutoring_services.capacity",
            "subjects.name AS subject_name",
            "universities.name AS university_name",
            "users.firstname AS firstname",
            "users.lastname AS lastname",
            "users.email AS users_email",
            "universities.city AS university_city",
            "universities.address AS university_address",
            "tutoring_services.date_from",
            "tutoring_services.date_to",
            "COUNT(CASE WHEN bookings.status != 'cancelled' THEN bookings.id ELSE NULL END) AS booking_count",
            "SUM(CASE WHEN bookings.student_id = $userId AND bookings.status != 'cancelled' THEN 1 ELSE 0 END) AS user_booked"
        ];

        $join = "
            JOIN subjects ON tutoring_services.subject_id = subjects.id
            JOIN universities ON tutoring_services.university_id = universities.id
            JOIN users ON tutoring_services.trainer_id = users.id
            LEFT JOIN bookings ON bookings.tutoring_service_id = tutoring_services.id
        ";

        $join .= " LEFT JOIN availability ON availability.trainer_id = users.id 
                   AND availability.unavailable_date = '$selectedDate'
                   AND availability.is_available = 0";

        $condition = "WHERE tutoring_services.subject_id = $id 
                      AND availability.trainer_id IS NULL";

        // if ($selectedDate) {
        //     $condition .= " AND DATE(tutoring_services.date_from) <= '$selectedDate' 
        //                     AND DATE(tutoring_services.date_to) >= '$selectedDate'";
        // }

        $condition .= " GROUP BY tutoring_services.id";

        $subject = $obj->read("JSON", "tutoring_services", $cols, $condition, $join);
    } else {
        // http_response_code(400);
        echo json_encode(["message" => "Subject ID is required."]);
    }
} else {
    // http_response_code(405);
    exit();
}
