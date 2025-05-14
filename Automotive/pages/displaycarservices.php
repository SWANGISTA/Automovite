<?php
session_start();

// Redirect to login page if OwnerID is not set in session
if (!isset($_SESSION["OwnerID"])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once "connection.php";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ownerID = $_SESSION["OwnerID"];

// Prepare and execute query to retrieve service information
$query = "SELECT s.serviceID, s.date, s.description
          FROM Service s
          JOIN Car c ON s.carVinNumber = c.carVinNumber
          WHERE c.OwnerID = ?
          ORDER BY s.date DESC";

$stmt = $conn->prepare($query);

$services = [];

if ($stmt) {
    $stmt->bind_param("s", $ownerID);
    $stmt->execute();
    $stmt->bind_result($serviceID, $date, $description);
    while ($stmt->fetch()) {
        $services[] = [
            "serviceID" => $serviceID,
            "date" => $date,
            "description" => $description,
        ];
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close database connection
$conn->close();

// Function to generate and output text file
function generateTextFile($services) {
    $content = "";
    foreach ($services as $service) {
        $content .= "Service ID: " . $service["serviceID"] . "\n";
        $content .= "Date: " . $service["date"] . "\n";
        $content .= "Description: " . $service["description"] . "\n\n";
    }

    // Set headers for file download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="services.txt"');

    // Output the file content
    echo $content;
    exit(); // Ensure no further output
}

// Check if download request is made
if (isset($_GET['download']) && $_GET['download'] === 'true') {
    generateTextFile($services);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
            line-height: 1.6;
            overflow: hidden;
            background-image: url('../img/SideWayM4.webp');
            background-size: cover;
            background-position: center;
            height: 100vh;
            backdrop-filter: blur(10px);
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th {
            color: black;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: white;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Service Information</h2>
    <table>
        <tr>
            <th>Service ID</th>
            <th>Date</th>
            <th>Description</th>
        </tr>
        <?php foreach ($services as $service): ?>
        <tr>
            <td><?php echo $service["serviceID"]; ?></td>
            <td><?php echo $service["date"]; ?></td>
            <td><?php echo $service["description"]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <!-- Save button to download text file -->
    <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="download" value="true">
        <button type="submit">Save to Text File</button>
    </form>
</body>
</html>
