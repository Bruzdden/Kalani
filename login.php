<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['idUser'])) {
    header('Location: index.php');
    exit();
}


//It needs mysqlidb class so this will include it
require_once "MySQLiDB.php";

// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Connect to the database
$db->_connect();

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

            $_SESSION["idUser"] = $user["idUser"];
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
        }

        .container{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background: white;
            border-radius: 10px;
            box-shadow: 10px 10px 15px rgba(0,0,0,0.05);
        }
        .container h1{
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid silver;
        }
        .container form{
            padding: 0 40px;
            box-sizing: border-box;
        }
        form .form-group{
            position: relative;
            border-bottom: 2px solid #adadad;
            margin: 30px 0;
        }
        .form-group input{
            width: 100%;
            padding: 0 5px;
            height: 40px;
            font-size: 16px;
            border: none;
            background: none;
            outline: none;
        }
        .form-group label{
            position: absolute;
            top: 50%;
            left: 5px;
            color: #adadad;
            transform: translateY(-50%);
            font-size: 16px;
            pointer-events: none;
            transition: .5s;
        }
        .form-group span::before{
            content: '';
            position: absolute;
            top: 40px;
            left: 0;
            width: 0;
            height: 2px;
            background: #2691d9;
            transition: .5s;
        }
        .form-group input:focus ~ label,
        .form-group input:valid ~ label{
            top: -5px;
            color: #2691d9;
        }
        .form-group input:focus ~ span::before,
        .form-group input:valid ~ span::before{
            width: 100%;
        }
        .submit-btn{
            width: 100%;
            height: 50px;
            border: 1px solid;
            background: #683E8C;
            border-radius: 25px;
            font-size: 18px;
            color: #e9f4fb;
            font-weight: 700;
            cursor: pointer;
            outline: none;
        }
        .submit-btn:hover{
            border-color: #2691d9;
            transition: .5s;
        }
        .signup_link{
            margin: 30px 0;
            text-align: center;
            font-size: 16px;
            color: #666666;
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
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)): ?>
            <div style="color: red;"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <input type="text" name="name" class="form-control" required>
                <span></span>
                <label for="name">Username:</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" required>
                <span></span>
                <label for="password">Password:</label>
            </div>
            <div>
                <button type="submit" name="login" class="submit-btn">Login</button>
            </div>
            <div class="signup_link">
                <button onclick="window.location.href='register.php'">Not registered yet?</button>
            </div>
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
