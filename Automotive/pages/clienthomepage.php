<?php
session_start();

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login_page.php");
    exit;
}

require_once "connection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ownerData = '';

if (isset($_SESSION['OwnerID'])) {
    $ownerID = $_SESSION['OwnerID'];
    $query = "SELECT name, lastName FROM Owner WHERE OwnerID = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $ownerID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ownerData = "<p>Owner ID: $ownerID</p><p>Name: " . htmlspecialchars($row['name']) . " " . htmlspecialchars($row['lastName']) . "</p>";
    } else {
        $ownerData = "<p>No data found for this Owner ID.</p>";
    }
    $stmt->close();
} else {
    $ownerData = "<p>Owner ID not found in session.</p>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Homepage</title>
    <link rel="stylesheet" type="text/css" href="../css/clientHomepage.css"/>
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

        .nav-links {
            list-style: none;
            display: flex;
        }

        .nav-links li {
            margin-left: 20px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
        }

        .nav-links a:hover {
            background-color: #555;
        }

        .landing-container {
            padding: 50px;
            text-align: center;
            margin-top: -5px;
            animation-name: slideRight;
            animation-duration: 2s;
            animation-timing-function: ease-in-out;
            animation-fill-mode: forwards;
            padding-top: 70px;
            width: 100%;
            max-width: 800px;
            margin: auto;
        }

        @keyframes slideRight {
            from {
                transform: translateX(-100px);
            }
            to {
                transform: translateX(0px);
            }
        }

        .landing-container h1 {
            font-size: 2em;
            color: white;
            margin: 0;
            padding: 0;
            animation-name: slideRight;
            animation-duration: 1s;
            animation-timing-function: ease-in-out;
            animation-fill-mode: forwards;
        }

        .landing-container p {
            color: white;
            font-style: italic;
            font-size: medium;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 200px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .action-button {
            display: block;
            margin: 10px auto;
        }

        .logout-button {
            background-color: #dc3545;
        }

        .logout-button:hover {
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

        /* Add any additional CSS styles as needed */
    </style>
</head>
<body>
    <header class="top-bar">
        <nav class="navbar">
            <div class="nav-logo">
                <img src="../img/white_logo.png" width="150" height="auto">
            </div>
            <ul class="nav-links">
                <li><a href="profile_tab.php">Profile</a></li>
            </ul>
        </nav>
    </header>

    <div class="landing-container">
        <h1>Welcome to Your Dashboard</h1>
        <p class="slogan">Care For Your Beast</p>
        <p class="story">...she'll take you wherever you want</p>
        <div class="owner-data">
            <?php echo $ownerData; ?>
        </div>

        <form action="../pages/displaycarinfo.php" method="post">
            <button type="submit" class="action-button">Display Car Info</button>
        </form>
        <form action="../pages/update_car_info.php" method="post">
            <button type="submit" class="action-button">Update Car Info</button>
        </form>
        <form action="../pages/book_now.php" method="post">
            <button type="submit" class="action-button">Book Now</button>
        </form>

        <!-- Logout Button -->
        <form action="" method="post">
            <button type="submit" class="action-button logout-button" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
