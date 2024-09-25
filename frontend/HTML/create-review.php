<?php
session_start();

if (!isset($_SESSION["role"])) {
    header("Location: ../../login/registration.php");
    exit();
}

if ($_SESSION["role"] == "student") {
    $user_id = $_SESSION["user_id"];
}

if (isset($_GET["id"])) {
    $service_id = $_GET["id"];
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
</head>

<body>
    <h2>Leave a review</h2>
    <form id="create-review">
        <?php echo "<input type='hidden' id='student_id' value='$user_id'>" ?>
        <?php echo "<input type='hidden' id='tutoring_service_id' value='$service_id'>" ?>
        <select id="rating" name="rating">
            <option value="5">5 - Excellent</option>
            <option value="4">4 - Very Good</option>
            <option value="3">3 - Good</option>
            <option value="2">2 - Fair</option>
            <option value="1">1 - Poor</option>
        </select>
        <br><br>
        <textarea name="comment" id="comment" placeholder="Leave your comment here!"></textarea>
        <input type="submit" value="Submit" name="submit">
    </form>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="../JS/create_review.js"></script>
</body>

</html>