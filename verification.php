<?php

session_start();

require_once "MySQLiDB.php";

// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Connect to the database
$db->_connect();


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $code = $_POST["code"];
    $select = $db->_select('user', [], ['code' => $code]);
    if (count($select) == 1){
            header("Location: login.php");
            exit();
        }
        else{
            echo 'This is not the code';
        }



}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification code</title>
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
        <h1>Verification <code></code></h1>
        <?php if (isset($error)): ?>
            <div style="color: red;"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <input type="text" name="code" class="form-control" required>
                <span></span>
                <label for="code">Code:</label>
            </div>
            <input type="submit" value="Register" class="submit-btn">
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>