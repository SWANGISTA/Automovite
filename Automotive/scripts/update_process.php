<?php
// Database connection parameters
$servername = "sql11.freesqldatabase.com"; // Change to your database host
    $dbname = "sql11701255"; // Change to your database name
    $username = "sql11701255"; // Change to your database username
    $password = "y4bq5IUQaq"; // Change to your database password

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve updated data from the form
    $carVinNumber = $_POST["vin_number"];
    $carModel = $_POST["car_model"];
    $color = $_POST["color"];
    $yearBought = $_POST["year_bought"];
    $lastServiceDate = $_POST["last_service_date"];
    $nextServiceDate = $_POST["next_service_date"];

    // Prepare SQL statement to update car information
    $sql = "UPDATE `car info` SET
            `carModel` = '$carModel',
            `color` = '$color',
            `yearBought` = '$yearBought',
            `lastServiceDate` = '$lastServiceDate',
            `nextServiceDate` = '$nextServiceDate'
            WHERE `carVinNumber` = '$carVinNumber'";

    if ($conn->query($sql) === TRUE) {
       // echo "Car information updated successfully.";
       header("Location: ../pages/updated_car.php");
    } else {
        echo "Error updating car information: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
