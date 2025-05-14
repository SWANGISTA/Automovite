<?php
session_start();

// Establish database connection
require_once "connection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$carDetails = [];
if (isset($_SESSION['OwnerID'])) {
    $ownerID = $_SESSION['OwnerID'];
    $query = "SELECT model, yearModel FROM Car WHERE OwnerID = ?";
    
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("s", $ownerID);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die("Error executing query: " . $stmt->error);
    }
    
    while ($row = $result->fetch_assoc()) {
        $carDetails[] = $row;
    }
    $stmt->close();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['service']) || empty($_POST['service'])) {
        $message = "Please select a service.";
    } elseif (!isset($_POST['preferred_date']) || empty($_POST['preferred_date'])) {
        $message = "Please provide a preferred date.";
    } else {
        $service = $_POST['service'];
        $preferred_date = $_POST['preferred_date'];
        
        // Fetch the service details
        $serviceDetails = [
            "Oil Change" => "Price: R1050 | Includes oil and filter change",
            "Tire Rotation" => "Price: R500 | Includes tire rotation and balance check",
            "Brake Inspection" => "Price: R700 | Includes brake pads and rotors inspection",
            "Engine Tune-Up" => "Price: R1800 | Includes spark plugs and air filter replacement"
        ];
        
        $description = $serviceDetails[$service] ?? '';
        
        // Generate a unique service ID (example: 'SVC' + random 6 digits)
        $serviceID = 'SVC' . rand(1000, 9999);
        
        // Get the OwnerID and carVinNumber from the session
        $ownerID = $_SESSION['OwnerID'] ?? '';
        
        // Assuming you have the carVinNumber associated with the OwnerID
        $query = "SELECT carVinNumber FROM Car WHERE OwnerID = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("s", $ownerID);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            die("Error executing query: " . $stmt->error);
        }
        $car = $result->fetch_assoc();
        $carVinNumber = $car['carVinNumber'] ?? '';
        $stmt->close();

        if ($carVinNumber && $ownerID) {
            // Insert into the Service table
            $query = "INSERT INTO Service (serviceID, date, description, carVinNumber, OwnerID) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }
            $stmt->bind_param("sssss", $serviceID, $preferred_date, $description, $carVinNumber, $ownerID);
            
            if ($stmt->execute()) {
                $message = "Service booked successfully!";
            } else {
                $message = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            $message = "No car details found or session expired.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now | AutoServPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body {
            font-family: Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-image: url('../img/SideWayM4.webp');
            background-size: cover;
            background-position: center;
            height: 100vh;
            backdrop-filter: blur(10px);
        }

        .navbar {
            background-color: #333;
            padding: 5px;
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .nav-logo img {
            display: block;
        }

        button:hover {
            background-color: #0056b3;
        }

        .submit-button {
            background-color: #dc3545;
        }

        .submit-button:hover {
            background-color: #c82333;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 0.1%;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center vertically */
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            color: white;
        }

        #container {
            width: 100%;
            max-width: 400px;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            margin: 0 auto; /* Center horizontally */
        }

        #form {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: black;
            width: 100%;
        }

        #form input[type="date"],
        #form input[type="time"],
        #form button[type="submit"] {
            width: 70%; /* Adjust width to be narrower */
            padding: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin: 0 auto; /* Center horizontally */
        }

        #form input[type="submit"] {
            width: 70%;
            padding: 12px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        #form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        #form p {
            color: white;
            font-size: 14px;
            margin-top: 10px;
        }

        #form a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        #form a:hover {
            color: #0056b3;
        }

        /* Form container styles */
        .form-container {
            margin-top: 20px;
        }

        .form-container h1 {
            color: rgb(64, 124, 209);
            margin-bottom: 20px;
        }

        .form-container span {
            display: block;
            color: #666;
            margin-bottom: 20px;
        }

        .form-container input,
        .form-container select,
        .form-container button {
            width: 80%; /* Adjust width to be narrower */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-container button {
            background-color: rgb(64, 124, 209);
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: rgb(34, 94, 169);
        }
    </style>
    <script>
        function showServiceDetails() {
            const serviceDetails = {
                "Oil Change": "Price: R1050 | Includes oil and filter change",
                "Tire Rotation": "Price: R500 | Includes tire rotation and balance check",
                "Brake Inspection": "Price: R700 | Includes brake pads and rotors inspection",
                "Engine Tune-Up": "Price: R1800 | Includes spark plugs and air filter replacement"
            };
            const serviceSelect = document.getElementById('service');
            const detailsDiv = document.getElementById('serviceDetails');
            const selectedService = serviceSelect.value;
            detailsDiv.textContent = serviceDetails[selectedService] || '';
        }

        function confirmSubmission() {
            return confirm('Are you sure you want to book this service?');
        }
    </script>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container">
            <form action="" method="POST" onsubmit="return confirmSubmission()">
                <h1>Book a Service</h1>
                <span>Select the service you want and provide your details</span>
                <?php if (!empty($message)): ?>
                    <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>
                <select id="service" name="service" onchange="showServiceDetails()" required>
                    <option value="" disabled selected>Select Service</option>
                    <option value="Oil Change">Oil Change</option>
                    <option value="Tire Rotation">Tire Rotation</option>
                    <option value="Brake Inspection">Brake Inspection</option>
                    <option value="Engine Tune-Up">Engine Tune-Up</option>
                </select>
                <div id="serviceDetails"></div>
                <?php if (!empty($carDetails)): ?>
                    <div>
                        <h3>Your Car Details</h3>
                        <?php foreach ($carDetails as $car): ?>
                            <p>Model: <?php echo $car['model']; ?> | Year: <?php echo $car['yearModel']; ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No car details found. Please register your car.</p>
                <?php endif; ?>
                <input type="date" placeholder="Preferred Date" name="preferred_date" required>
                <input type="time" placeholder="Preferred Time" name="preferred_time" required>
                <button type="submit" name="submit">Book Service</button>
            </form>
            <form form action="payment.php" method="POST">
                <button type="submit" name="submit">Proceed to Payment</button>
            </form>
        </div>
    </div>
</body>
</html>
