<?php
session_start();

// Check if OwnerID is set in session
if (!isset($_SESSION["OwnerID"])) {
    echo "No Owner ID in session, please log in.";
    exit();
}

$ownerId = $_SESSION["OwnerID"];

// Include database connection
require_once "connection.php";

try {
    // Create a PDO instance
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Sanitize input data
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $lastName = filter_input(
            INPUT_POST,
            "lastName",
            FILTER_SANITIZE_STRING
        );
        $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $phoneNumber = filter_input(
            INPUT_POST,
            "phoneNumber",
            FILTER_SANITIZE_STRING
        );

        // Update owner information in the database
        $sql =
            "UPDATE Owner SET name = ?, lastName = ?, address = ?, email = ?, phoneNumber = ? WHERE OwnerID = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $name,
            $lastName,
            $address,
            $email,
            $phoneNumber,
            $ownerId,
        ]);

        echo "<p>Information updated successfully!</p>";
    }

    // Fetch owner information
    $sql = "SELECT * FROM Owner WHERE OwnerID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ownerId]);
    $owner = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Owner Information</title>
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
        h1 {
            color: #333;
            text-align: center;
            margin-top: 50px;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            max-width: 400px;
            margin: 0 auto;
        }
        input[type="text"], input[type="email"], input[type="submit"] {
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #5C8BC0;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4a6e8c;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <h1>Update Your Information</h1>

    <?php if ($owner): ?>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?= htmlspecialchars(
                $owner["name"]
            ) ?>"><br>
            <label for="lastName">Last Name:</label>
            <input type="text" name="lastName" id="lastName" value="<?= htmlspecialchars(
                $owner["lastName"]
            ) ?>"><br>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?= htmlspecialchars(
                $owner["address"]
            ) ?>"><br>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?= htmlspecialchars(
                $owner["email"]
            ) ?>"><br>
            <label for="phoneNumber">Phone Number:</label>
            <input type="text" name="phoneNumber" id="phoneNumber" value="<?= htmlspecialchars(
                $owner["phoneNumber"]
            ) ?>"><br>
            <input type="submit" value="Update Information">
        </form>

        <a href="clienthomepage.php">Go back home</a>
    <?php else: ?>
        <p>No owner found with ID: <?= htmlspecialchars($ownerId) ?></p>
    <?php endif; ?>
</body>
</html>
