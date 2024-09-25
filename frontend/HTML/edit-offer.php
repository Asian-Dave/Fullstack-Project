<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: home.php");
    exit();
}

if ($_SESSION["role"] == "student") {
    header("Location: home.php");
    exit();
}

require_once "../../components/dbconnection.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $offer = $obj->read("", "tutoring_services", "*", "WHERE id= $id");
    $subject = $obj->read("", "subjects");
    $university = $obj->read("", "universities", "*");

    if ($_SESSION["role"] == "admin") {
        $trainer = $obj->read("", "users", "*", " WHERE role = 'trainer'");
    }

    if ($_SESSION["role"] == "trainer") {
        $trainer = $_SESSION["user_id"];
    }

    $date_from = date('Y-m-d\TH:i', strtotime($offer[0]["date_from"]));
    $date_to = date('Y-m-d\TH:i', strtotime($offer[0]["date_to"]));
} else {
    header("Location: home.php");
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
    <style>
        .card-title {
            color: #fff;
            font-weight: 600;
            padding: 15px;
            background: #5a84ff;
            /*8e84ad*/
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row my-5 d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <h5 class="card-title mb-5 mt-4 text-center fs-3">
                            Update Offer </h5>
                        <form id="update_offer_form">
                            <input class="form-control" type="hidden" name="id" id="service_id" value="<?= $offer[0]['id'] ?>">
                            <?php if ($_SESSION["role"] == "admin") { ?>

                                <label for="trainer_id" class="mb-2">Trainer</label>
                                <select class="form-select mb-3" name='trainer_id' id='trainer_id'>
                                    <?php
                                    foreach ($trainer as $value) {
                                        $selected = $value["id"] == $offer[0]["trainer_id"] ? "selected" : "";
                                        echo "<option value='{$value["id"]}' $selected>{$value["firstname"]} {$value["lastname"]}</option>";
                                    }
                                    ?>
                                </select>
                            <?php } ?>
                            <label for="subject_id" class="mb-2">Subject</label>
                            <select class="form-select mb-3" name="subject_id" id="subject_id">
                                <?php foreach ($subject as $value) {
                                    $selected = $value["id"] == $offer[0]["subject_id"] ? "selected" : "";
                                    echo "<option value='{$value["id"]}' $selected>{$value["name"]}</option>";
                                } ?>
                            </select>


                            <label for="university_id" class="mb-2">University</label>
                            <select class="form-select mb-3" name="university_id" id="university_id">
                                <?php foreach ($university as $value) {
                                    $selected = $value["id"] == $offer[0]["university_id"] ? "selected" : "";
                                    echo "<option value='{$value["id"]}' $selected>{$value["name"]}</option>";
                                } ?>
                            </select>
                            <label for="title" class="mb-2">Title</label>
                            <input name="title" class="form-control mb-3" id="title" rows="4" value="<?= $offer[0]["title"] ?>"></input>

                            <label for="description" class="mb-2">Description</label>
                            <textarea name="description" class="form-control mb-3" id="description" rows="4"><?= $offer[0]["description"] ?></textarea>

                            <label for="price" class="mb-2">Price</label>
                            <input type="number" class="form-control mb-3" id='price' placeholder="price" name="price" value="<?= $offer[0]["price"] ?>">

                            <label for="capacity" class="mb-2">Capacity</label>
                            <input type="number" class="form-control mb-3" id="capacity" placeholder="capacity" name="capacity" value="<?= $offer[0]["capacity"] ?>">

                            <div class="mb-4">
                                <label for="start_date" class="mb-2">Start Date/Time</label>
                                <input type="datetime-local" name="start_date" id="start_date" class="form-control mb-3" value="<?= $offer[0]["date_from"] ?>" required>
                            </div>

                            <div class="mb-4">
                                <label for="end_date" class="mb-2">End Date/Time</label>
                                <input type="datetime-local" name="end_date" id="end_date" class="form-control mb-3" value="<?= $offer[0]["date_to"] ?>" required>
                            </div>
                            <input type="submit" value="Update offer" name="edit" class="btn btn-primary px-5 mb-4 mt-4">
                        </form>
                        <?php if ($_SESSION["role"] == "admin") { ?> <p class="text-center"><a href="dashboard.php" class="btn btn-secondary px-5 mb-4 mt-4"> Back to dashboard</a></p> <?php } ?>
                        <?php if ($_SESSION["role"] == "trainer") { ?> <p class="text-center"><a href="mainpanel.php" class="btn btn-secondary px-5 mb-4 mt-4"> Back to mainpanel</a></p> <?php } ?>


                        <script
                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                            crossorigin="anonymous"></script>
                        <script src="../JS/edit_offers.js"></script>
</body>

</html>