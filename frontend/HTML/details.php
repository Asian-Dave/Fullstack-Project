<?php
session_start();
require_once "session_checker.php";
noUser();

$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #details-page {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        #details-page h2 {
            color: #0056b3;
            margin-bottom: 40px;
            text-align: center;
        }

        #details-page h4 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        #details-page h5,
        #details-page h6,
        #details-page p {
            color: #333;
            margin-bottom: 20px;
        }

        .btn-custom-blue {
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            padding: 10px 20px;
            width: 100%;
        }

        .btn-custom-blue:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border-radius: 5px;
            padding: 10px 20px;
            width: 100%;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: #fff;
        }

        .course-meta {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #dee2e6;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .btn-group {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        @media (min-width: 768px) {

            #details-page .btn-custom-blue,
            #details-page .btn-back {
                width: auto;
            }

            .btn-group {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>
    <script>
        const userRole = "<?php echo $userRole; ?>";
    </script>

    <?php
    include "../php_components/navbar.php";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "No ID provided in the URL.";
    }
    ?>
    <div id="alertPlaceholder"></div>
    <p hidden id="chosenId"><?php echo htmlspecialchars($id); ?></p>

    <div id="details-page">
        <h2>Course Details</h2>
        <div id="info"></div>
    </div>
    <?php if ($userRole == "trainer") {
        // echo '<button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" id="students">
        //     Show Students
        // </button>';
    } ?>
    <div id="reviewSection" class="mt-5">
        <h4 class="text-center">Reviews</h4>
        <div class="container">
            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-sm-1" id="reviewList"></div>
        </div>
        <hr>
    </div>
    <?php
    include "../php_components/footer.php";
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../JS/details_script.js"></script>

</html>