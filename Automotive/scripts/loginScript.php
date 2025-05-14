<?php
session_start();



$host = "localhost";
$dbname = "AutomotiveServicesDB";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $email = filter_var($_POST['user'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['pass'];

        try {
            $stmt = $pdo->prepare("SELECT * FROM Owner WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['OwnerID'] = $user['OwnerID'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['name'];

                if ($user['user_type'] == 'admin') {
                    header("Location: ../pages/adminhomepage.php");
                    exit();
                } else {
                    header("Location: ../pages/clienthomepage.php");
                    exit();
                }
            } else {
                header("Location: ../pages/loginerror.php");
                exit();
            }
        } catch (PDOException $e) {
            die("Error: Could not execute query. " . $e->getMessage());
        }
    } else {
        die("Invalid request method.");
    }
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}
?>
