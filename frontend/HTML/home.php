<?php
session_start();

if (isset($_SESSION["role"])) {
  if ($_SESSION["role"] == "admin") {
    header("Location: dashboard.php");
    exit();
  }

  if ($_SESSION["role"] == "trainer") {
    header("Location: mainpanel.php");
    exit();
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
  <?php include "../php_components/navbar.php" ?>

  <div class="container-fluid p-0 mb-5 hero-size">
    <div class="background">
      <div class="container">
        <div class="headline py-4 py-md-5">
          <h1 class="mb-1">Master Your Courses <br> Find the right tutor for your academic success.</h1>
          <p>Book your class today</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row my-5">
      <div class="col-md-12 text-center">
        <h1 class="mb-4 display-4">Start Learning Today</h1>
        <p class="mb-0 lead">Choose a subject below to explore personalized tutoring sessions designed to boost your academic performance.</p>
      </div>
    </div>
    <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1 row-cols-xs-1" id="result"></div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="../JS/subjects_read.js"></script>
</body>

</html>