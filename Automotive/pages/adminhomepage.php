<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home Page</title>
    <link rel="stylesheet" href="css/style3.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        nav {
            background-color: #666;
            padding: 10px;
            text-align: center;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
        }
        nav ul li a:hover {
            background-color: #444;
        }
        section {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
        }
        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 20px;
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        .card h3 {
            margin-bottom: 10px;
            color: #333;
        }
        footer {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
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
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the Admin Panel</h1>
    </header>
    <nav>
        <ul>
            <li><a href="adminpages/delete_page.php">Delete Client</a></li>
            <li><a href="adminpages/get_service_info.php">Display Service history</a></li>
            <li><a href="adminpages/full_car_history.php">Display Car history</a></li>
            <!-- Add more navigation links as needed -->
        </ul>
        <ul>

            <!-- Add more navigation links as needed -->
        </ul>
    </nav>
</body>
</html>
