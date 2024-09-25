<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: ../../login/registration.php");
    exit();
}

if ($_SESSION["role"] == "student") {
    header("Location: home.php");
    exit();
}
if ($_SESSION["role"] == "trainer") {
    header("Location: mainpanel.php");
    exit();
}

require_once "../../components/dbconnection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $cols = [
        "bookings.id",
        "bookings.student_id",
        "bookings.tutoring_service_id",
        "bookings.booking_date",
        "bookings.status",
        "users.firstname AS student_name",
        "users.lastname AS student_lastname",
        "tutoring_services.title AS tutoring_title"

    ];
    $join = "JOIN users ON bookings.student_id=users.id 
            JOIN tutoring_services ON bookings.tutoring_service_id=tutoring_services.id";

    $booking = $obj->read("", "bookings", $cols, "WHERE bookings.id = $id", $join);

    $tutoring_service_id = $booking[0]['tutoring_service_id'];
    $status = $booking[0]['status'];

    $offer = $obj->read("", "tutoring_services", "*");
    // var_dump($booking);
    // exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
</head>

<body>
    <div class="container">
        <div class="row my-5 d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <div id="status_message" style="display: none; font-weight: bold;"></div>
                        <h5 class="card-title mb-2 mt-4 text-center fs-3">
                            Edit a Booking for User:
                        </h5>
                        <p class="text-center mb-5"><?= $booking[0]['student_name'] . " " . $booking[0]['student_lastname'] ?></p>
                        <form id="update_booking_form">
                            <input
                                class="form-control" type="hidden" name="id" id="booking_id" value="<?= $booking[0]['id'] ?>">
                            <div class="mb-4">
                                <label for="offer_id" class="mb-2">Offer</label> <select name="offer_id" id="offer_id" class="form-select">
                                    <?php foreach ($offer as $value) {
                                        $selected = $value["id"] == $tutoring_service_id ? "selected" : "";
                                        echo "<option value='{$value["id"]}' $selected>{$value["title"]}</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <p class="mb-3">Booked at: <?= $booking[0]['booking_date'] ?></p>
                                <label for="status" class="mb-2">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="booked" <?= $status == 'booked' ? 'selected' : '' ?>>Booked</option>
                                    <option value="completed" <?= $status == 'completed' ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= $status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>
                            <input type="submit" value="Update booking" name="edit" class="btn btn-primary px-5 mb-2 mt-4">
                        </form>
                        <p class="text-center">
                            <a href="dashboard.php" class="btn btn-secondary px-5 mb-4 mt-4"> Back to dashboard</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../JS/edit_booking.js"></script>
</body>

</html>