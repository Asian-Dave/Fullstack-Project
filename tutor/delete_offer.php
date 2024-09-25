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

require_once "../components/dbconnection.php";

$isAdmin = $_SESSION['role'] == 'admin';
// var_dump($isAdmin);
// exit();

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $conditions = "WHERE id = $id";

    $offer = $obj->read(null, "tutoring_services", "*", $conditions);
    $trainer = $obj->read("", "users", ["users.firstname", "users.lastname"], "WHERE id = " . $offer[0]["trainer_id"]);

    // var_dump($offer);
    // var_dump($trainer);
    // exit();
    if (isset($_GET["delete"]) && $offer) {
        $delete = $obj->delete("tutoring_services", "id=$id");
        if ($delete == true) {
            header("Location: ../frontend/HTML/dashboard.php");
        }
    }
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
    <title>Delete Offer</title>
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
        <?php if ($offer) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Are you sure you want to remove this tutoring service
                    <?php if ($isAdmin): ?>
                        <?= "offered by " . $trainer[0]["firstname"] . " " . $trainer[0]["lastname"] ?>
                    <?php endif ?>
                    ?</strong>
                <a href="delete_offer.php?id=<?= $offer[0]["id"] ?>&delete=true" class="btn btn-danger">Yes</a>
                <a href="../frontend/HTML/dashboard.php" class="btn btn-secondary">No</a>
            </div>
        <?php else : ?>
            <p>Offer not found</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>