<?php
session_start();

// Check if the user is coming from the payment page
if (!isset($_POST['service']) || !isset($_POST['preferred_date']) || !isset($_POST['preferred_time'])) {
    header("Location: booknow.php");
    exit();
}

// Get the service details from the POST request
$service = $_POST['service'];
$preferredDate = $_POST['preferred_date'];
$preferredTime = $_POST['preferred_time'];

// Get the car details from the session
$carDetails = []; // Variable to store the car details
if (isset($_SESSION['OwnerID'])) {
    $ownerID = $_SESSION['OwnerID'];

    // Establish database connection
    $servername = "localhost";
    $dbname = "AutomotiveServicesDB";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query = "SELECT CarModel, CarYear FROM Car WHERE OwnerID = ?";
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ownerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $carDetails[] = $row;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation | AutoServPro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Booking Confirmation</h1>
            <p>Thank you for booking a service with AutoServPro!</p>
            <div class="confirmation-details">
                <h3>Your Booking Details</h3>
                <p><strong>Service:</strong> <?php echo htmlspecialchars($service); ?></p>
                <p><strong>Preferred Date:</strong> <?php echo htmlspecialchars($preferredDate); ?></p>
                <p><strong>Preferred Time:</strong> <?php echo htmlspecialchars($preferredTime); ?></p>
                <?php if (!empty($carDetails)): ?>
                    <h3>Your Car Details</h3>
                    <?php foreach ($carDetails as $car): ?>
                        <p><strong>Model:</strong> <?php echo htmlspecialchars($car['CarModel']); ?></p>
                        <p><strong>Year:</strong> <?php echo htmlspecialchars($car['CarYear']); ?></p>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No car details found. Please register your car.</p>
                <?php endif; ?>
            </div>
            <p>We look forward to servicing your car. Have a great day!</p>
        </div>
    </div>
</body>
</html>
