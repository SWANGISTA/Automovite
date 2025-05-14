<!DOCTYPE html>
<html>
<head>
    <title>Service Details</title>
    <style>
    body {
        font-family: Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
        color: white;
        text-align: center;
    }

    .background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('../../img/backviewM4.jpg');
        background-size: cover;
        background-position: center;
        filter: blur(5px);
        z-index: -1;
    }

    .form-container {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        z-index: 1;
    }

    input[type="text"] {
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background-color: #f44336;
        color: white;
        cursor: pointer;
    }

    button:hover {
        background-color: #d32f2f;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        color: white; /* Changed to white */
    }

    th {
        background-color: #f2f2f2;
    }
    </style>
</head>
<body>
    <div class="background"></div>
    <div class="form-container">
        <h2>Enter Car VIN Number to View Service Details</h2>
        <form method="post" action="">
            <label for="carVinNumber">Car VIN Number:</label>
            <input type="text" id="carVinNumber" name="carVinNumber" required>
            <button type="submit">View Service Details</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $carVinNumber = $_POST["carVinNumber"];

            // Connect to database
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "AutomotiveServicesDB";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare SQL query
            $sql = "SELECT * FROM Service WHERE carVinNumber = '$carVinNumber'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Display table header
                echo "<h2>Service Details:</h2>";
                echo "<table>";
                echo "<tr><th>Service ID</th><th>Date</th><th>Description</th><th>Car VIN Number</th></tr>";

                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["serviceID"] . "</td>";
                    echo "<td>" . $row["date"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["carVinNumber"] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No services found for Car VIN Number: $carVinNumber</p>";
            }

            $conn->close();
        } ?>
    </div>
</body>
</html>
