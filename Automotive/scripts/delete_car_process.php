<?php
// Database connection settings (same as retrieve_car.php)
$host = "sql11.freesqldatabase.com"; // Change to your database host
    $dbname = "sql11701255"; // Change to your database name
    $username = "sql11701255"; // Change to your database username
    $password = "y4bq5IUQaq"; // Change to your database password

try {
    // Create connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Process deletion request
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve VIN from POST data
        $vin = $_POST['vin'];

        // Prepare SQL statement to delete car record
        $stmt = $pdo->prepare("DELETE FROM `car info` WHERE `carVinNumber` = :vin");
        $stmt->execute(['vin' => $vin]);
        header("Location: ../pages/deleted_car_page.php");

      //  echo "Record with VIN $vin has been deleted successfully.";
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
