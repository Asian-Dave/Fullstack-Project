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

require_once "../../components/dbconnection.php";

$trainer = $obj->read("", "users", "*", " WHERE role = 'trainer'");
$subject = $obj->read("", "subjects");
$university = $obj->read("", "universities");

if ($_SESSION["role"] == "trainer") {
    $trainer_id = $_SESSION["user_id"];
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
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <div class="container">
        <?php if ($_SESSION["role"] == "admin") {
            echo "<a href='dashboard.php' class='btn btn-secondary mt-3'>Go back</a>";
        } elseif ($_SESSION["role"] == "trainer") {
            echo "<a href='mainpanel.php' class='btn btn-secondary mt-3'>Go back</a>";
        } ?>
        <div class="row my-5 d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <h5 class="card-title card-title-custom mb-5 mt-4 text-center fs-3">
                            Create New Offer
                        </h5>
                        <form id="create_offer_form">
                            <?php if ($_SESSION["role"] == "admin") { ?>
                                <div class="mb-4">
                                    <label for="trainer_id" class="mb-2">Trainer</label>
                                    <select name='trainer_id' id='trainer_id' class="form-select" required>
                                        <?php
                                        foreach ($trainer as $value) {
                                            echo "<option value='{$value["id"]}'>{$value["firstname"]}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php } elseif ($_SESSION["role"] == "trainer") {
                                echo "<p hidden id='trainer_id'>{$trainer_id}</p>";
                            } ?>
                            <div class="mb-4">
                                <label for="subject_id" class="mb-2">Subject</label>
                                <select name="subject_id" id="subject_id" class="form-select"
                                    required>
                                    <?php foreach ($subject as $value) {
                                        echo "<option value='{$value["id"]}'>{$value["name"]}</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="university_id" class="mb-2">University</label>
                                <select name="university_id" id="university_id" class="form-select" required>
                                    <?php foreach ($university as $value) {
                                        echo "<option value='{$value["id"]}'>{$value["name"]}</option>";
                                    } ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="title" class="mb-2">Title</label>
                                <input name="title" id="title" class="form-control" placeholder="Title course" rows="5" required></input>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="mb-2">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Describe the course" rows="5" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="price" class="mb-2">Price</label>
                                <input type="number" step="0.01" id='price' placeholder="price" name="price" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="capacity" class="mb-2">Capacity</label>
                                <input type="number" id="capacity" class="form-control" placeholder="capacity" name="capacity">
                            </div>
                            <div class="mb-4">
                                <label for="start_date" class="mb-2">Start Date/Time</label>
                                <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label for="end_date" class="mb-2">End Date/Time</label>
                                <input type="datetime-local" name="end_date" id="end_date" class="form-control" required>
                            </div>
                            <input type="submit" value="Create Offer" name="submit" class="btn btn-primary px-5 mb-4 mt-4">

                        </form>
                        <script
                            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
                            crossorigin="anonymous"></script>
                        <script src="../JS/create_offers.js"></script>
</body>

</html>