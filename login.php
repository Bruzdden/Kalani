<?php
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

            // Start the session and set the user's ID and username
            session_start();
            $_SESSION["idUser"] = $user["id"];
            $_SESSION["name"] = $user["name"];

            // Redirect to the home page
            header("Location: index.php");
            exit;
        }
    }

    // Display an error message if the login failed
    $error = "Invalid username or password";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="post">
        <div>
            <label for="name">Username:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit" name="login">Login</button>
        </div>
    </form>
</body>
</html>
