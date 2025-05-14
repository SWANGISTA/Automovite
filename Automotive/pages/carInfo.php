<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-image: url('../img/SideWayM4.webp');
            background-size: cover;
            background-position: center;
            height: 100vh;
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
            font-size: 14px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #007bff;
        }
    </style>
</head>
<body>
    <div id="form">
        <h1>Add Car Information</h1>
        <form action="../scripts/registerCar.php" method="post">
            <label for="carVinNumber">VIN Number:</label>
            <input type="text" id="carVinNumber" name="carVinNumber" required><br>

            <label for="make">Make:</label>
            <input type="text" id="make" name="make" required><br>

            <label for="licensePlate">License Plate:</label>
            <input type="text" id="licensePlate" name="licensePlate" required><br>

            <label for="carModel">Car Model:</label>
            <input type="text" id="carModel" name="carModel" required><br>

            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required><br>

            <label for="yearBought">Year Model:</label>
            <input type="number" id="yearBought" name="yearBought" required><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
