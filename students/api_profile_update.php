<?php
session_start();
require_once "../frontend/HTML/session_checker.php";
noUser();

if (isset($_SESSION["role"])) {

    require_once "../components/headers.php";
    require_once '../components/dbconnection.php';
    require_once '../components/fileUpload.php';

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method !== 'POST') {
        echo json_encode(["message" => "Method incorrect."]);
        exit();
    }

    $fname = $lname = $email = $profile_info = $picture = "";
    $fnameError = $lnameError = $emailError = $profile_infoError = $pictureError = "";
    $error = false;



    if ($_SESSION["role"] == "admin") {
        // Admin can update any profile
        $id = $_GET['id'];
    } else {
        $id = $_SESSION['user_id'];
    }

    // Process and validate inputs
    if (isset($_POST['fname'])) {
        $fname = cleanedInput($_POST['fname']);
        if (empty($fname)) {
            $error = true;
            $fnameError = "First name can't be empty!";
        } elseif (strlen($fname) < 3) {
            $error = true;
            $fnameError = "First name can't be less than 3 characters.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
            $error = true;
            $fnameError = "First name must contain only letters and spaces!";
        }
    }

    if (isset($_POST['lname'])) {
        $lname = cleanedInput($_POST['lname']);
        if (empty($lname)) {
            $error = true;
            $lnameError = "Last name can't be empty!";
        } elseif (strlen($lname) < 3) {
            $error = true;
            $lnameError = "Last name can't be less than 3 characters.";
        } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
            $error = true;
            $lnameError = "Last name must contain only letters and spaces!";
        }
    }

    if (isset($_POST['email'])) {
        $email = cleanedInput($_POST['email']);
        if (empty($email)) {
            $error = true;
            $emailError = "Email is required!";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = true;
            $emailError = "Please type a valid email!";
        } else {
            $condition = "WHERE email = '$email' AND id != $id";
            $existingEmailCheck = $obj->read("", "users", ["email"], $condition);
            if ($existingEmailCheck) {
                $error = true;
                $emailError = "Email already exists!";
            }
        }
    }

    if (isset($_POST['profile_info'])) {
        $profile_info = cleanedInput($_POST['profile_info']);
    }


    if (isset($_FILES["picture"]["error"])) {
        if ($_FILES['picture']['error'] == 0) {
            [$pictureName, $uploadMessage] = fileUpload($_FILES['picture']);
            if ($uploadMessage !== "Ok") {
                $error = true;
                $pictureError = $uploadMessage;
            } else {
                // delete old pic
                if ($_POST['oldpicture'] != "avatar.png") {
                    unlink("../components/pictures/" . $_POST['oldpicture']);
                }
                $picture = $pictureName;
            }
        }
    } else {
        $picture = $_POST["oldpicture"];
    }

    if ($error) {
        echo json_encode([
            "message" => "Validation failed",
            "errors" => [
                "fname" => $fnameError,
                "lname" => $lnameError,
                "email" => $emailError,
                "picture" => $pictureError
            ]
        ]);
        exit();
    }

    $updateFields = ['firstname' => $fname, 'lastname' => $lname, 'email' => $email, 'picture' => $picture, 'profile_info' => $profile_info];

    if (empty($updateFields)) {
        echo json_encode(["message" => "Nothing to update"]);
        exit();
    }

    $where = "id = $id";
    $updateSuccess = $obj->update("users", $updateFields, $where, null);

    if ($updateSuccess) {
        echo json_encode([
            "message" => "Update successful"
        ]);
    } else {
        echo json_encode([
            "message" => "Update failed"
        ]);
    }

    exit();
} else {
    echo json_encode(["message" => "Unauthorized access"]);
    exit();
}
