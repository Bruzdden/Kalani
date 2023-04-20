<?php
//It needs mysqlidb class so this will include it
require_once "IDB.php";
require_once "MySQLiDB.php";

// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Connect to the database
$db->_connect("localhost", "root", "root", "kalani");

// Check if the registration form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form input
    $username = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password != $confirm_password) {
        // Passwords do not match
        echo "Error: Passwords do not match";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        echo "Error: Invalid email format";
        exit();
    }

    // Check if username or email already exists
    $existing_user = $db->_select("user", array(), array("name" => $username));
    $existing_email = $db->_select("user", array(), array("email" => $email));

    if (!empty($existing_user) || !empty($existing_email)) {
        // Username or email already exists
        echo "Error: Username or email already exists";
        exit();
    }

    // Create a new user account
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into database table
    $user_data = array(
        "name" => $username,
        "email" => $email,
        "password" => $hashed_password
    );
    $insert = $db->_insert("user", $user_data);

    // Handle registration errors
    if (!$insert) {
        $error_info = $db->getLastError();
        // Other database error
        echo "Error: " . $error_info[2];
        exit();
    }

    // Redirect the user to the login page
    header("Location: login.php");
    exit();
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <input type="text" placeholder="Search...">
            <button>Search</button>
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
        <h1>Registration Form</h1>
        <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="name">Username:</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <input type="submit" value="Register" class="submit-btn">
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
