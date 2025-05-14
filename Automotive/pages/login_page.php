<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="../css/style3.css"/>
    <script>
        function handlePlaceholder(inputId, placeholderText) {
            var inputField = document.getElementById(inputId);
            inputField.placeholder = placeholderText;
            inputField.addEventListener('input', function() {
                if (inputField.value.trim() !== '') {
                    inputField.placeholder = '';
                } else {
                    inputField.placeholder = placeholderText;
                }
            });
        }

        window.onload = function() {
            handlePlaceholder('user', 'Email');
            handlePlaceholder('pass', 'Password');
        };
    </script>
</head>
<body>
<header>
    <nav class="navbar">
        <div class="nav-logo">
            <a href="../index.php"><img src='../img/white_logo.png'  width="150" height="auto"></a>
        </div>
        <ul class="nav-links">
            <li><a href="about.php">About Us</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
    </nav>
</header>

<div class="login-container">
    <h2>AutoServPro</h2>
    <p>Where service meets convenience.</p>
    <div id="container">
        <div id="form">
            <h1>Login</h1>
            <form name="form" action="../scripts/loginScript.php" method="POST">
                <input type="text" id="user" name="user"><br><br>
                <input type="password" id="pass" name="pass"><br><br>
                <input type="submit" id="btn" value="Login" name="submit">
            </form>
            <p style="color: aliceblue;">Don't have an account? <a href="register.php">Sign Up</a></p>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> AutoServPro. All rights reserved.</p>
</footer>

</body>
</html>
