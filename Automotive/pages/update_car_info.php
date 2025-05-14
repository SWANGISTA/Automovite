<?php
session_start();

if (!isset($_SESSION["OwnerID"])) {
    header("Location: login.php");
    exit();
}

require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update"])) {
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare(
        "UPDATE `Car` SET licensePlate=?, make=?, model=?, color=?, yearModel=? WHERE carVinNumber=?"
    );

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
    }

    $stmt->bind_param(
        "ssssis",
        $licensePlate,
        $make,
        $model,
        $color,
        $yearModel,
        $carVinNumber
    );

    $carVinNumbers = $_POST["carVinNumber"];
    $licensePlates = $_POST["licensePlate"];
    $makes = $_POST["make"];
    $models = $_POST["model"];
    $colors = $_POST["color"];
    $yearModels = $_POST["yearModel"];

    for ($i = 0; $i < count($carVinNumbers); $i++) {
        $carVinNumber = $carVinNumbers[$i];
        $licensePlate = $licensePlates[$i];
        $make = $makes[$i];
        $model = $models[$i];
        $color = $colors[$i];
        $yearModel = $yearModels[$i];

        if (!$stmt->execute()) {
            echo "Error updating record: " . $conn->error;
        }
    }

    echo "<p>Car information updated successfully!</p>";

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Car Information</title>
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
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 0 auto;
        }
        table, th {
            color: black;
        } td {
            border: 1px solid #ddd;
            padding: 12px;
            color: white;
        }
        th {
            background-color: #f2f2f2;
        }
        input[type="text"],
        input[type="number"] {
            padding: 10px;
            width: calc(100% - 20px);
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        input[type="submit"],
        button {
            padding: 12px 24px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover,
        button:hover {
            background-color: #0056b3;
        }
        button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Update Car Information</h2>

    <form method="post" action="">
        <table>
            <tr>
                <th>Car VIN Number</th>
                <th>License Plate</th>
                <th>Make</th>
                <th>Model</th>
                <th>Color</th>
                <th>Year Model</th>
                <th>Action</th>
            </tr>
            <?php
            $ownerID = $_SESSION["OwnerID"];
            $conn = new mysqli($host, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM `Car` WHERE OwnerID = '$ownerID'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" .
                        htmlspecialchars($row["carVinNumber"]) .
                        "</td>";
                    echo "<td><input type='text' name='licensePlate[]' value='" .
                        htmlspecialchars($row["licensePlate"]) .
                        "'></td>";
                    echo "<td><input type='text' name='make[]' value='" .
                        htmlspecialchars($row["make"]) .
                        "'></td>";
                    echo "<td><input type='text' name='model[]' value='" .
                        htmlspecialchars($row["model"]) .
                        "'></td>";
                    echo "<td><input type='text' name='color[]' value='" .
                        htmlspecialchars($row["color"]) .
                        "'></td>";
                    echo "<td><input type='number' name='yearModel[]' value='" .
                        htmlspecialchars($row["yearModel"]) .
                        "'></td>";
                    echo "<td><input type='hidden' name='carVinNumber[]' value='" .
                        htmlspecialchars($row["carVinNumber"]) .
                        "'>";
                    echo "<input type='submit' name='update' value='Update'></td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    </form
