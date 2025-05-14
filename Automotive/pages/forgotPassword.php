<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/styleForgotPass.css"/>
    <script>
        // Function to handle placeholder behavior
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
        
        // Call the function for email and password fields
        window.onload = function() {
            handlePlaceholder('user', 'Email');
            handlePlaceholder('pass', 'Set Password');
        };
    </script>
</head>

<body>
    <!-- Top bar -->
   <header>
   <div class="top-bar">
        <div>Automotive Service</div> <!-- Text on the left side -->
        <!-- Login form -->
        <form class="login-form">
            <input type="text" class="login-input" placeholder="LoginEmail">
            <input type="password" class="login-input" placeholder="Password">
            <button type="submit" class="login-button">Login</button>
        </form>
    </div>
   </header>

   <div id="form"> <!-- Removed the extra div wrapper here -->
       <form name="form" action="../scripts/reset_password.php" method="POST" >
            <h2>Reset your Password</h2>
            <div >
                <h6>Enter your Email</h6>
                <input type="text" id="email" name="email" placeholder="Email"><br>
                <input type="submit" id="btn" value="Reset" name="Recover">
            </div> <!-- Closed the div here -->
       </form>
   </div> <!-- Closed the #form div here -->
</body>
</html>
