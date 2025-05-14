<!DOCTYPE html>
<html>
<head>
    <title>Automotive Services</title>
    <style>
        body {
            font-family: Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-image: url('../../img/backviewM4.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            backdrop-filter: blur(10px);
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: white;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        input[type='submit'] {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 12px;
            text-decoration: none;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type='submit']:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
<?php
// Database connection
$host = "localhost";
$dbname = "AutomotiveServicesDB";
$username = "root";
$password = ""; // Change to your database password

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if OwnerID is set
    if (isset($_POST["ownerid"])) {
        $ownerid = $_POST["ownerid"];

        // SQL query to delete owner and their cars
        $delete_sql = "DELETE FROM Owner WHERE OwnerID='$ownerid'; DELETE FROM Car WHERE OwnerID='$ownerid'";

        if ($conn->multi_query($delete_sql) === true) {
            echo "Record deleted successfully";
            // Redirect to refresh the page after deletion
            header("Refresh:0");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
}

// SQL query to retrieve owners and their cars, excluding admins
$sql = "SELECT Owner.OwnerID, Owner.name, Owner.lastName, Car.licensePlate, Car.make, Car.model, Car.color, Car.yearModel
        FROM Owner
        JOIN Car ON Owner.OwnerID = Car.OwnerID
        WHERE Owner.user_type != 'admin'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data as a table
    echo "<table border='1'>";
    echo "<tr><th>OwnerID</th><th>Owner</th><th>License Plate</th><th>Make</th><th>Model</th><th>Color</th><th>Year</th><th>Action</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["OwnerID"] . "</td>";
        echo "<td>" . $row["name"] . " " . $row["lastName"] . "</td>";
        echo "<td>" . $row["licensePlate"] . "</td>";
        echo "<td>" . $row["make"] . "</td>";
        echo "<td>" . $row["model"] . "</td>";
        echo "<td>" . $row["color"] . "</td>";
        echo "<td>" . $row["yearModel"] . "</td>";
        echo "<td><form method='post'><input type='hidden' name='ownerid' value='" .
            $row["OwnerID"] .
            "'><input type='submit' value='Delete'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
</body>
</html>
