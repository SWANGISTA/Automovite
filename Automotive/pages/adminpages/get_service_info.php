<!DOCTYPE html>
<html>
<head>
    <title>Service Details</title>
    <style>
    body {
        font-family: Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        overflow: hidden;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        color: white;
        position: relative;
    }
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('../../img/backviewM4.jpg');
        background-size: cover;
        background-position: center;
        filter: blur(3px);
        z-index: -1;
    }
    .form-container {
        background-color: rgba(0, 0, 0, 0.5);
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Enter Service ID to View Details</h2>
        <form method="post" action="">
            <label for="serviceID">Service ID:</label>
            <input type="text" id="serviceID" name="serviceID" required>
            <button type="submit">View Details</button>
        </form>

        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $serviceID = $_POST["serviceID"];

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
            $sql = "SELECT * FROM Service WHERE serviceID = '$serviceID'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<h2>Service Details:</h2>";
                    echo "<p><strong>Service ID:</strong> " .
                        $row["serviceID"] .
                        "</p>";
                    echo "<p><strong>Date:</strong> " . $row["date"] . "</p>";
                    echo "<p><strong>Description:</strong> " .
                        $row["description"] .
                        "</p>";
                }
            } else {
                echo "<p>No service found with ID: $serviceID</p>";
            }

            $conn->close();
        } ?>
    </div>
</body>
</html>
