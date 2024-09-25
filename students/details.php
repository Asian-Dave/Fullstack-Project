<?php
// Include the database connection file
require_once '../components/dbconnection.php';

// Create an instance of the DbConfig class
$obj = new DbConfig();

// Retrieve and validate the ID from the query parameters
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  echo "<p style='color:red;'>Invalid or missing ID.</p>";
  exit();
}

$serviceId = intval($_GET['id']); // Convert to integer for safety

// Fetch the tutoring service details from the database
$conditions = "WHERE id = $serviceId";
$serviceDetails = $obj->read("JSON", "tutoring_services", "*", $conditions);

// Check if any data was returned
if (empty($serviceDetails['data'])) {
  echo "<p style='color:red;'>No tutoring service found with this ID.</p>";
  exit();
}

$service = $serviceDetails['data'][0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tutoring Service Details</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-4">
    <h2>Tutoring Service Details</h2>
    <div class="card" style="width: 50rem;">
      <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($service['description']); ?></h5>
        <p class="card-text"><strong>Trainer ID:</strong> <?php echo htmlspecialchars($service['trainer_id']); ?></p>
        <p class="card-text"><strong>Subject ID:</strong> <?php echo htmlspecialchars($service['subject_id']); ?></p>
        <p class="card-text"><strong>University ID:</strong> <?php echo htmlspecialchars($service['university_id']); ?></p>
        <!-- Add more details as needed -->
        <a href="book.php?id=<?php echo $serviceId; ?>" class="btn btn-primary">Book Now</a>
      </div>
    </div>
  </div>
  <!-- Optionally include Bootstrap JS and dependencies -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>