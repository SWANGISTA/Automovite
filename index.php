<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoServPro</title>
    <link rel="stylesheet" href="css/style3.css"> <!-- Link the CSS file -->
</head>

<body>
    <!-- Navigation bar -->
    <nav class="navbar">
        <div class="nav-logo">
            <img src='img/white_logo.png'  width="150" height="auto">
        </div>
        <ul class="nav-links">
            <li><a href="./pages/login_page.php">Register/Login</a></li>
            <li><a href="./services.php">Services</a></li>
            <li><a href="./about.php">About Us</a></li>
            <li><a href="./contact.php">Contact Us</a></li>
        </ul>
    </nav>

    <!-- Landing page content -->
    <div class="landing-container">
        <h2>Welcome to AutoServPro!</h2>
        <p>Where service meets convenience.</p>
        <p>Your one-stop solution for all your car service needs. Book, service, and pay all in one place.</p>
        <a href="services.php" class="cta-button">Explore Services</a>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> AutoServPro. All rights reserved.</p>
    </footer>
</body>

</html>
