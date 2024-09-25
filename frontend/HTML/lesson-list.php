<?php
session_start();
require_once "session_checker.php";
noUser();

if ($_SESSION["role"] == "admin") {
  header("Location: dashboard.php");
  exit();
}

$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
$userRole = isset($_SESSION['role']);

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
  <style>
    #dropdownForm {
      max-width: 600px;
      margin: 20px auto;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    #dropdownForm .d-flex {
      gap: 15px;
    }

    #dropdownForm .form-select {
      border: 1px solid #ced4da;
      border-radius: 5px;
      padding: 10px;
      max-height: 40vh;
      overflow-y: auto;
    }

    #dropdownForm .form-control {
      border: 1px solid #ced4da;
      border-radius: 5px;
      padding: 10px;
    }

    @media (max-width: 768px) {
      #dropdownForm .d-flex {
        flex-direction: column;
      }

      #dropdownForm .form-select,
      #dropdownForm .form-control {
        max-width: 100%;
      }
    }
  </style>

</head>

<body>
  <script>
    const userRole = "<?php echo $userRole; ?>";
  </script>
  <?php include "../php_components/navbar.php" ?>
  <div id="alertPlaceholder"></div>

  <div class="container">
    <form method="post" id="dropdownForm">
      <div class="d-flex">
        <select class="form-select" aria-label="Default select example" id="subject" style="max-width: 30vh;">
        </select>
        <input type="date" hidden id="lessonDate" name="lessonDate" class="form-control" style="max-width: 30vh;">
      </div>
    </form>
    <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1" id="result"></div>
  </div>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="../JS/lesson_list.js"></script>

</body>

</html>