<?php
session_start();
if (isset($_SESSION["role"])) {
  if ($_SESSION["role"] == "admin") {
    header("Location: ../frontend/HTML/dashboard.php");
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
}

require_once "../components/dbconnection.php";
require_once "../login/fileUpload.php";

$fname = $lname = $email = $password = $profile_info = $picture = "";
$fnameError = $lnameError = $emailError = $passwordError = $profile_infoError = $pictureError = "";
$error = false;
if (isset($_POST['btn-signup'])) {

  $fname = cleanedInput($_POST["firstname"]);
  $lname = cleanedInput($_POST["lastname"]);
  $email = cleanedInput($_POST["email"]);
  $password = cleanedInput($_POST["password"]);
  $profile_info = cleanedInput($_POST["profile_info"]);
  $picture = fileUpload($_FILES['picture']);



  if (empty($fname)) {
    $error = true;
    $fnameError = "first name can't be empty!";
  } elseif (strlen($fname) < 3) {
    $error = true;
    $fnameError = "first name can't be less than 2 characters";
  } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
    $error = true;
    $fnameError = "first name must contain only letters and spaces!";
  }

  if (empty($lname)) {
    $error = true;
    $lnameError = "last name can't be empty!";
  } elseif (strlen($lname) < 3) {
    $error = true;
    $lnameError = "last name can't be less than 2 chars";
  } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
    $error = true;
    $lnameError = "last name must contain only letters and spaces!";
  }

  if (empty($email)) {
    $error = true;
    $emailError = "Email is required!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {  # jhfgk@jgj.aj
    $error = true;
    $emailError = "Please type a valid email!";
  } else {
    $condition = "WHERE email = '$email'";
    $searchIfEmailExists = $obj->read("", "users", "email", $condition);

    if ($searchIfEmailExists != null) {
      $error = true;
      $emailError = "Email already exists!";
    }
  }

  if (empty($password)) {
    $error = true;
    $passwordError = "Password can't be empty!";
  } elseif (strlen($password) < 6) {
    $error = true;
    $passwordError = "Password can't be less than 6 Chars";
  }


  if (!$error) {

    $password = hash("sha256", $password);

    $newuserdata = [
      "firstname" => $fname,
      "lastname" => $lname,
      "password" => $password,
      "email" => $email,
      "picture" => $picture[0],
      "profile_info" => $profile_info
    ];


    $newuser = $obj->create("users", $newuserdata);

    if ($newuser) {
      echo "<div class='alert alert-success' role='alert'>
      <h4 class='alert-heading'>Registered Successfully!</h4>
      <p>Aww yeah, you successfully created a new account on our website!<br> enjoy it while it is free! ;)</p>
      <hr>
      <p class='mb-0'>$picture[1]</p>You will be redirected in <span id ='timer'>3</span> seconds!</p>
    </div>";
      $fname = $lname = $email = $password = $profile_info = "";
    } else {
      echo "<div class='alert alert-danger' role='alert'>
      <h3>Something went wrong, please try again later!</h3>
    </div>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <?php include "../frontend/php_components/navbar.php" ?>


  <div class="container my-5">
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST" class="w-50 mx-auto mt-2 mb-5">
      <h2 class="mb-3">Registration Form
      </h2>
      <div class="mb-3">
        <label for="name">First name</label>
        <input type="text" class="form-control" id="name" name="firstname" value="<?= $fname ?>">
        <p class="text-danger"><?= $fnameError ?></p>
      </div>
      <div class="mb-3">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" id="lastName" name="lastname" value="<?= $lname ?>">
        <p class="text-danger"><?= $lnameError ?></p>
      </div>
      <div class="mb-3">
        <label for="picture">Picture</label>
        <input type="file" class="form-control" id="picture" name="picture">
      </div>
      <div class="mb-3">
        <label for="profile_info">Additional profile information</label>
        <textarea class="form-control" placeholder="Add Info here" id="floatingTextarea" name="profile_info"></textarea>
        <p class="text-danger"><?= $profile_infoError ?></p>
      </div>
      <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
        <p class="text-danger"><?= $emailError ?></p>
      </div>
      <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password">
        <p class="text-danger"><?= $passwordError ?></p>

      </div>
      <div class="mb-3">
        <button type="submit" class="btn btn-success" name="btn-signup">Register</button>
      </div>
    </form>
    <div class="col-12">
      <h4 class="m-0 text-secondary text-center">You have an account?</h4>
      <p class="m-0 text-secondary text-center"><a href="login.php" class="link-primary text-decoration-none">Log in</a></p>
    </div>
  </div>
</body>
<script>
  let timer = 3;
  const countdown = setInterval(() => {
    timer--;
    document.getElementById("timer").innerText = timer;
    if (timer === 0) {
      clearInterval(countdown);
      window.location.href = 'login.php';
    }
  }, 1000);
</script>

</html>