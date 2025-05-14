<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Login Page | AsmrProg</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            max-width: 80%;
        }

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

        .form-container {
            text-align: center;
            margin-top: 20px;
        }

        .form-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        .form-container input {
            width: calc(100% - 20px);
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form-container button {
            width: calc(100% - 20px);
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        .form-container span {
            display: block;
            margin-bottom: 10px;
            color: #666;
        }

        .form-container a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="../scripts/registerScript.php" method="POST">
                <h1>Create Account</h1>
                <span>or use your email for registration</span>
                <input type="text" placeholder="Name" name="name" required>
                <input type="text" placeholder="Last Name" name="lastName" required>
                <input type="text" placeholder="Address" name="address" required>
                <input type="email" placeholder="Email" name="user" required>
                <input type="password" placeholder="Password" name="pass" required>
                <input type="password" placeholder="Confirm Password" name="confirmpass" required>
                <input type="text" placeholder="Phone Number" name="cellNumber" required>
                <button type="submit" name="submit">Sign Up</button>
                <span>Already have an account? <a href="#">Sign in</a></span>
            </form>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
