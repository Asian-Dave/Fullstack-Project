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
    <?php include "../php_components/navbar.php" ?>

    <h1 class="text-center">Dashboard</h1>

    <div class="container" style="margin-left: -1vh;">
        <div class="row">
            <div class="col-3">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action text-center active" id="list-offer-list" data-bs-toggle="list" href="#list-offers" role="tab" aria-controls="list-offers">Offers</a>
                    <a class="list-group-item list-group-item-action text-center" id="list-profile-list" data-bs-toggle="list" href="#list-profile" role="tab" aria-controls="list-profile">Users</a>
                    <a class="list-group-item text-center list-group-item-action" id="list-booking-list" data-bs-toggle="list" href="#list-bookings" role="tab" aria-controls="list-bookings">Bookings</a>
                </div>
            </div>
            <div class="col-9">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-offers" role="tabpanel" aria-labelledby="list-offer-list">
                        <div class="list-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Trainer name</th>
                                        <th scope="col">Capacity</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">University</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider" id="offers">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
                        <div class="list-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Picture</th>
                                        <th scope="col">Firstname</th>
                                        <th scope="col">Lastname</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Profile Info</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider" id="users">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="list-bookings" role="tabpanel" aria-labelledby="list-booking-list">
                        <div class="list-group">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Descrition</th>
                                        <th scope="col">Trainer</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Capacity</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Booked By</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider" id="booking">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>





    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../JS/read_offers.js"></script>
    <script src="../JS/read_users.js"></script>
    <script src="../JS/read_bookings.js"></script>
    <script></script>
</body>

</html>