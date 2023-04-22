<?php
session_start();

if (isset($_SESSION['idUser'])) {
    header('Location: index.php');
    exit();
}


//It needs mysqlidb class so this will include it
require_once "IDB.php";
require_once "MySQLiDB.php";

// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Connect to the database
$db->_connect("localhost", "root", "root", "kalani");

// Check if the login form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {

    // Retrieve the user's credentials from the form
    $username = $_POST["name"];
    $password = $_POST["password"];

    // Perform a SELECT query to retrieve the user's information
    $result = $db->_select("user", [], ["name" => $username]);

    // Check if the query returned a row
    if (count($result) == 1) {

        // Verify the hashed password
        $user = $result[0];
        if (password_verify($password, $user["password"])) {
            $_SESSION["name"] = $user["name"];
            $_SESSION["password"] = $user["password"];
            $_SESSION["rank"] = $user["rank"];
        }
    }

    // Display an error message if the login failed
    $error = "Invalid username or password";
}
if (isset($_SESSION["name"])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 10px;
        }

        .navbar img {
            height: 50px;
        }

        .navbar ul {
            display: flex;
            list-style: none;
        }

        .navbar li {
            margin: 0 10px;
        }

        .navbar li a {
            color: #fff;
            text-decoration: none;
        }

        .searchbar {
            display: flex;
            align-items: center;
        }

        .searchbar input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 3px;
            margin-right: 5px;
        }

        .searchbar button {
            padding: 5px 10px;
            border: none;
            border-radius: 3px;
            background-color: #4CAF50;
            color: #fff;
            cursor: pointer;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .form-control {
            margin-bottom: 10px;
            border: none;
            border-radius: 3px;
            background-color: #f2f2f2;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-control:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            background-color: #ffffff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .submit-btn {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            border-radius: 3px;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }

        .submit-btn:hover {
            background-color: #3e8e41;
        }
        .user {
            position: relative;
        }

        .userbtn {
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .userbtn img {
            width: 50px;
            height: 50px;
        }


        .userlist {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1;
            padding: 0;
            margin: 0;
            list-style: none;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }


        .listitem {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        .login button,
        .register button {
            border: none;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .login button:hover,
        .register button:hover {
            background-color: #0062cc;
        }

        @media only screen and (max-width: 600px) {
            .container {
                max-width: 100%;
                padding: 10px;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
<div class="navbar">
    <img src="logo.png" alt="Logo">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Calendar</a></li>
        <li><a href="login.php">List</a></li>
        <li><a href="#">Contact</a></li>
    </ul>

    <div class="searchbar">
        <form action="graphql.php" method="POST">
            <input type="text" name="search" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="user">
        <button class="userbtn" id="button"><img src="profile.png"></button>
        <ul class="userlist" id="list">
            <li class="listitem">
                <div class="login">
                    <button onclick="window.location.href='login.php'">Login</button>
                </div>
            </li>
            <li class="listitem">
                <div class="register">
                    <button onclick="window.location.href='register.php'">Register</button>
                </div>
            </li>
        </ul>
    </div>

</div>


<div class="container">
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="name">Username:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div>
            <button type="submit" name="login" class="submit-btn">Login</button>
        </div>

    </form>
    <div class="register">
        <button onclick="window.location.href='register.php'">Not registered yet?</button>
    </div>
</div>
<script src="script.js"></script>
</body>
</html>
