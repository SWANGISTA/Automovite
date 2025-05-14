<?php
session_start(); // Start the session to access session variables

// Database connection parameters
$servername = "localhost";
$dbname = "AutomotiveServicesDB";
$username = "root";
$password = "";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$carVinNumber = $_POST['carVinNumber'];
$make = $_POST['make'];
$licensePlate = $_POST['licensePlate'];
$carModel = $_POST['carModel'];
$color = $_POST['color'];
$yearBought = $_POST['yearBought'];

// Retrieve ownerID from session (assuming it was set during registration)
if (isset($_SESSION['ownerID'])) {
    $ownerID = $_SESSION['ownerID'];
} else {
    // Handle case where ownerID is not set in session (e.g., redirect to registration page)
    header("Location: ../index.php");
    exit(); // Stop further execution after redirection
}

// Prepare SQL statement to insert data into 'car' table using prepared statements
$sql = "INSERT INTO `car` (carVinNumber, make, licensePlate, model, color, yearModel, ownerID)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $carVinNumber, $make, $licensePlate, $carModel, $color, $yearBought, $ownerID);

if ($stmt->execute()) {
    // Redirect to car registered page upon successful insertion
    header("Location: ../pages/registered.php");
    exit(); // Stop further execution after redirection
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
