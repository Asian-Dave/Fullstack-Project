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
    $conditions = "WHERE id = $id";

    $user = $obj->read(null, "users", "*", $conditions);
    // var_dump($user);
    // exit();
    if (isset($_GET["delete"]) && $user) {
        if ($user[0]["picture"] != "avatar.png") {
            unlink("../components/pictures/{$user[0]["picture"]}");
        }
        $delete = $obj->delete("users", "id=$id");
        if ($delete == true) {
            header("Location: ../frontend/HTML/dashboard.php");
        }
    }
} else {
    header("Location: ../frontend/HTML/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
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
        <?php if ($user) : ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Are you sure you want to remove the <?= $user[0]["role"] . " " . $user[0]["firstname"] . " " . $user[0]["lastname"] ?>?</strong>
                <a href="delete_user.php?id=<?= $user[0]["id"] ?>&delete=true" class="btn btn-danger">Yes</a>
                <a href="../frontend/HTML/dashboard.php" class="btn btn-secondary">No</a>
            </div>
        <?php else : ?>
            <p>User not found</p>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>