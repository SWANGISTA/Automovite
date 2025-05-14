<?php
// Database connection settings
$host = "sql11.freesqldatabase.com"; // Change to your database host
    $dbname = "sql11701255"; // Change to your database name
    $username = "sql11701255"; // Change to your database username
    $password = "y4bq5IUQaq"; // Change to your database password
// Create connection
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Start output buffering
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        p {
            background: #fff;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 8px;
        }
        form {
            margin-top: 20px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve VIN from POST data
    $vin = $_POST['vin'];

    // Prepare SQL statement to retrieve car information
    $stmt = $pdo->prepare("SELECT * FROM `car info` WHERE `carVinNumber` = :vin");
    $stmt->execute(['vin' => $vin]);
    $carInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($carInfo) {
        // Display car information
        echo "<h2>Car Information</h2>";
        echo "<p><strong>VIN Number:</strong> " . htmlspecialchars($carInfo['carVinNumber']) . "</p>";
        echo "<p><strong>Car Model:</strong> " . htmlspecialchars($carInfo['carModel']) . "</p>";
        echo "<p><strong>Color:</strong> " . htmlspecialchars($carInfo['color']) . "</p>";
        echo "<p><strong>Year Bought:</strong> " . htmlspecialchars($carInfo['yearBought']) . "</p>";
        echo "<p><strong>Last Service Date:</strong> " . htmlspecialchars($carInfo['lastServiceDate']) . "</p>";
        echo "<p><strong>Next Service Date:</strong> " . htmlspecialchars($carInfo['nextServiceDate']) . "</p>";

        // Add button for record deletion
        echo "<form method='post' action='../scripts/delete_car_process.php'>";
        echo "<input type='hidden' name='vin' value='" . htmlspecialchars($vin) . "'>";
        echo "<button type='submit'>Delete Record</button>";
        echo "</form>";
    } else {
        echo "<p>No car found with VIN: " . htmlspecialchars($vin) . "</p>";
    }
}
?>
</body>
</html>
<?php
// End output buffering and flush output
ob_end_flush();
?>
