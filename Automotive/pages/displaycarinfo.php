<?php
session_start();

// Check if OwnerID is set in session
if (!isset($_SESSION["OwnerID"])) {
    echo "<p>OwnerID not found in session.</p>";
    displayBackToHomeButton();
    exit();
}

// Include database connection
require_once "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ownerID = $_SESSION["OwnerID"];

// Retrieve car information for the owner
$sql = "SELECT * FROM Car WHERE OwnerID = '$ownerID'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Car Information</title>
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

                h2 {
                    color: #007bff;
                    text-align: center;
                }

                table {
                    width: 80%;
                    margin: 20px auto; /* Adjusted margin for better centering */
                    border-collapse: collapse;
                    border: 1px solid #ddd;
                }

                th, td {
                    padding: 10px;
                    border: 1px solid #ddd;
                }

                th {
                    background-color: #f2f2f2;
                }

                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                p {
                    color: #ff0000;
                    font-weight: bold;
                    text-align: center; /* Centered the error message */
                }

                .back-to-home {
                    text-align: center; /* Centered the back to home button */
                }

                .back-to-home button {
                    padding: 10px 20px;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                    transition: background-color 0.3s, color 0.3s;
                }

                .back-to-home button:hover {
                    background-color: #0056b3;
                }


                </style>
            </head>
            <body>";

    echo "<h2>Car Information</h2>";
    echo "<table>";
    echo "<tr><th>Car VIN Number</th><th>License Plate</th><th>Make</th><th>Model</th><th>Color</th><th>Year Model</th><th>View Services</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["carVinNumber"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["licensePlate"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["make"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["model"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["color"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["yearModel"]) . "</td>";
        echo '<td>
                <form action="displaycarservices.php" method="post">
                    <input type="submit" value="Services" />
                </form>
              </td>';
        echo "</tr>";
    }

    echo "</table>";
    displayBackToHomeButton();
} else {
    echo "<p>No car information found for this owner.</p>";
    displayBackToHomeButton();
}

// Free result and close connection
$result->free_result();
$conn->close();

// Function to display back to home button
function displayBackToHomeButton()
{
    echo '<form action="clienthomepage.php" method="post">
            <input type="submit" value="Back to Home" />
          </form>';
}
?>
</body>
</html>
