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

$error = false;
$email = $passwordError = $emailError = "";

if (isset($_POST["login-btn"])) {

  $email = cleanedInput($_POST["email"]);
  $password = cleanedInput($_POST["password"]);


  if (empty($email)) {
    $error = true;
    $emailError = "Email is required!";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
    $emailError = "Not a valid email!";
  }

  if (empty($password)) {
    $error = true;
    $passwordError = "Password is required!";
  }

  if (!$error) {

    $password = hash("sha256", $password);
    $result = $obj->read("", "users", "*", "WHERE email = '" . $email . "' AND password = '" . $password . "'");

    if ($result != null) {

      $_SESSION["user_id"] = $result[0]["id"];
      $_SESSION["email"] = $result[0]["email"];
      $_SESSION["role"] = $result[0]["role"];

      // Redirect based on role
      if ($result[0]["role"] == 'admin') {
        header("Location: ../frontend/HTML/dashboard.php");
      } elseif ($result[0]["role"] == 'trainer') {
        header("Location: ../frontend/HTML/mainpanel.php");
      } elseif ($result[0]["role"] == 'student') {
        header("Location: ../frontend/HTML/home.php");
      }
      exit();
    } else {
      echo "<div class='alert alert-danger' role='alert'>
            <h3>Incorrect credentials!</h3>
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

  <div class="container">
    <section class="bg-light py-3 py-md-5">
      <h2 class="text-center my-5">Login</h2>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
            <div class="card border border-light-subtle rounded-3 shadow-sm">
              <div class="card-body p-3 p-md-4 p-xl-5">
                <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Login in to your account</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="row gy-2 overflow-hidden">
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
                        <label for="email" class="form-label">Email</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
                        <label for="password" class="form-label">Password</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid my-3">
                        <button class="btn btn-primary btn-lg" type="submit" name="login-btn">Login</button>
                      </div>
                    </div>
                    <div class="col-12">
                      <p class="m-0 text-secondary text-center">Don't have an account? <a href="registration.php" class="link-primary text-decoration-none">Sign up</a></p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</body>

</html>