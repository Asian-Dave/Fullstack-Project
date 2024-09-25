<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: ../login/registration.php");
    exit();
}

if ($_SESSION["role"] == "student") {
    header("Location: ../frontend/HTML/home.php");
    exit();
}

if ($_SESSION["role"] == "trainer") {
    header("Location: ../frontend/HTML/mainpanel.php");
    exit();
}
require_once "../components/dbconnection.php";
if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $cols = [
        "bookings.id",
        "bookings.student_id",
        "bookings.tutoring_service_id",
        "bookings.booking_date",
        "bookings.status",
        "users.firstname AS student_name",
        "users.lastname AS student_lastname"
    ];
    $join = "JOIN users ON bookings.student_id = users.id";

    $conditions = "WHERE bookings.id = $id";


    $booking = $obj->read(null, "bookings", $cols, $conditions, $join);

    $bookingDateTime = $booking[0]['booking_date'];
    $dateTime = new DateTime($bookingDateTime);
    $date = $dateTime->format('d-m-Y');
    $time = $dateTime->format('H:i');

    // var_dump($booking);
    // exit();
    if (isset($_GET["delete"]) && $booking) {
        $delete = $obj->delete("bookings", "id=$id");
        if ($delete == true) {
            header("Location: ../frontend/HTML/dashboard.php");
        }
    }
    // } else {
    //     header("Location: ../frontend/HTML/dashboard.php");
    //     exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #6c757d;
        }

        .navbar-brand img {
            border-radius: 50%;
        }

        .navbar-nav {
            margin-left: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <?php if ($booking) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Are you sure you want to remove the booking made by <?= $booking[0]["student_name"] . " " . $booking[0]["student_lastname"] . " " . $date . " at " . $time ?>?</strong>
                <a href="delete_booking.php?id=<?= $booking[0]["id"] ?>&delete=true" class="btn btn-danger">Yes</a>
                <a href="../frontend/HTML/dashboard.php" class="btn btn-secondary">No</a>
            </div>
        <?php else : ?>
            <p>Booking not found</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>