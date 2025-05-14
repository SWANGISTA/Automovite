<?php
// Database connection parameters
$servername = "sql207.infinityfree.com";
    $username = "if0_36082143";
    $password = "Ps4CpFU9qu"; // Empty password
    $db_name = "if0_36082143_AutomotiveServicesDB";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user's email from the form
    $email = $_POST["email"];

    // Check if the email exists in the user table
    $sql = "SELECT * FROM `user` WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(32)); // Generate a random 32-byte hex token

        // Store the token in the database
        $sql_update_token = "UPDATE `user` SET reset_token = '$token' WHERE email = '$email'";
        if ($conn->query($sql_update_token) === TRUE) {
            // Send password reset email to the user
            $reset_link = "http://yourwebsite.com/reset_password_form.php?token=$token";
            $to = $email;
            $subject = "Password Reset";
            $message = "Please click the following link to reset your password:\n$reset_link";
            $headers = "From: your_email@example.com";

            // Send email
            if (mail($to, $subject, $message, $headers)) {
                echo "Password reset link sent to your email. Please check your inbox.";
            } else {
                echo "Failed to send password reset email.";
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Email not found. Please try again.";
    }
}

$conn->close();
?>
