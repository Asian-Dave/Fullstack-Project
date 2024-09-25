<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: ../../login/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $edit_user_id = $_GET['id'];
} else {
    $edit_user_id = $_SESSION['user_id'];
}

// if (!$edit_user_id) {
//     header("Location: home.php");
//     exit();
// }

if ($_SESSION["role"] == 'trainer' || $_SESSION["role"] == 'student') {
    $user_id = $_SESSION['user_id'];

    if ($edit_user_id !== $user_id) {
        header("Location: edit_profile.php?id=$user_id");
        exit();
    }
}
require_once "../../components/dbconnection.php";

$edit_user = $obj->read("", "users", "*", "WHERE id = $edit_user_id");
// var_dump($edit_user);
// exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card-title {
            color: #fff;
            font-weight: 600;
            padding: 15px;
            background: #5a84ff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row my-5 d-flex justify-content-center">
            <div class="col-md-6">
                <div class="card shadow mb-5">
                    <div class="card-body">
                        <div id="status_message" style="display: none; color: green;"></div>
                        <h5 class="card-title mb-5 mt-4 text-center fs-3">
                            Edit Profile </h5>
                        <form id="edit_profile_info" enctype="multipart/form-data">
                            <input class="form-control" type="text" hidden name="id" id="id" value="<?php echo $edit_user[0]['id'] ?>">

                            <label for="fname" class="mb-2">Firstname</label>
                            <input class="form-control" type="text" id="fname" name="fname" value="<?php echo htmlspecialchars($edit_user[0]['firstname']); ?>">
                            <p id="fname_error" class="error text-danger"></p>
                            <label for="lname" class="mb-2">Lastname</label>
                            <input class="form-control" type="text" id="lname" name="lname" value="<?php echo htmlspecialchars($edit_user[0]['lastname']); ?>">
                            <p id="lname_error" class="error text-danger"></p>

                            <label for="email" class="mb-2">E-Mail</label>
                            <input class="form-control" type="email" id="email" name="email" value="<?php echo htmlspecialchars($edit_user[0]['email']); ?>">
                            <p id="email_error" class="error text-danger"></p>
                            <!-- Only admins see this -->
                            <?php if ($_SESSION["role"] == "admin") { ?>
                                <label for="role" class="mb-2">Role</label>
                                <select name="role" id="role" class="form-select">
                                    <option value="student" <?php echo ($edit_user[0]['role'] == 'student') ? 'selected' : ''; ?>>Student</option>
                                    <option value="trainer" <?php echo ($edit_user[0]['role'] == 'trainer') ? 'selected' : ''; ?>>Trainer</option>
                                    <option value="admin" <?php echo ($edit_user[0]['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            <?php } else ?>
                            <input class="form-control" type="hidden" id="currentrole" name="currentrole" value="<?php echo $edit_user[0]['role'] ?>">

                            <br>
                            <label for="picture" class="form-label mb-2">Picture</label><br>
                            <img src="../../components/pictures/<?= $edit_user[0]['picture']; ?>" alt="Profile Picture" style="width: 5vh; border-radius: 50%;">
                            <input type="file" id="picture" name="picture">
                            <input class="form-control" type="hidden" id="oldpicture" name="oldpicture" value="<?= $edit_user[0]['picture']; ?>">
                            <br>
                            <label for="profile_info" class="mb-2 mt-5">Profile Info</label>
                            <textarea class="form-control" rows="3" name="profile_info" id="profile_info"><?php echo htmlspecialchars($edit_user[0]['profile_info']); ?></textarea>
                            <br>
                            <input type="submit" value="Update Profile" name="edit" class="btn btn-primary px-5 mb-4 mt-4">

                        </form>
                        <?php if ($_SESSION["role"] == "admin") {
                            echo "<p class='text-center'>
                                <a href='dashboard.php' class='btn btn-secondary px-5 mb-4 mt-4'>Go back</a>
                            </p>";
                        } else {
                            echo "<p class='text-center'>
                            <a href='user-profile.php' class='btn btn-secondary px-5 mb-4 mt-4'>Go back</a>
                        </p>";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <script src="../JS/edit_profile.js"></script>
</body>

</html>