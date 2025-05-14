<?php
session_start();

$servername = "localhost";
$dbname = "AutomotiveServicesDB";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: Could not connect to the database. " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $email = filter_var($_POST['user'], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $cellNumber = htmlspecialchars($_POST['cellNumber']);
    $lastName = htmlspecialchars($_POST['lastName']);
    $password = $_POST['pass'];
    $confirmPassword = $_POST['confirmpass'];
    $user_type = 'client';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    if ($password !== $confirmPassword) {
        die("Passwords do not match");
    }

    $minUserID = 1111111111111;
    $maxUserID = 9999999999999;
    $userID = mt_rand($minUserID, $maxUserID);

    try {
        $stmt = $pdo->prepare("SELECT * FROM Owner WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            die("Error: Email already registered.");
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Owner (OwnerID, name, lastName, address, email, password, phoneNumber, user_type) 
                VALUES (:userID, :username, :lastName, :address, :email, :password, :cellNumber, :user_type)";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $passwordHash);
        $stmt->bindParam(':cellNumber', $cellNumber);
        $stmt->bindParam(':user_type', $user_type);
        $stmt->execute();

        $_SESSION['ownerID'] = $userID;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;

        header("Location: ../pages/carInfo.php");
        exit();
    } catch (PDOException $e) {
        die("Error: Could not execute query. " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>
