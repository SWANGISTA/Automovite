<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | AutoServPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <!-- Navigation bar -->
    
    </nav>
    <div class="container" id="container">
        <div class="form-container">
            <form action="confirmation.php" method="POST">
                <h1>Payment</h1>
                <span>Complete your payment to confirm the booking</span>
                <input type="text" placeholder="Cardholder Name" name="cardholder_name" required>
                <input type="text" placeholder="Card Number" name="card_number" required>
                <input type="text" placeholder="Expiration Date (MM/YY)" name="expiration_date" required>
                <input type="text" placeholder="CVV" name="cvv" required>
                <a href="confirmation.php"><button type="submit" name="submit">Pay Now</button></a>
            </form>
        </div>
    </div>
	<!-- Footer -->
    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> AutoServPro. All rights reserved.</p>
    </footer>
</body>
</html>
