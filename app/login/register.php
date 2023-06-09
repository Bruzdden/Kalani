<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
//It needs mysqlidb class so this will include it
require_once(dirname(__DIR__)."/db/MySQLiDB.php");

// Create a new MySQLiDB instance
$db = new MySQLiDB();

// Environment variables setup
$SMTP_UN = getenv('SMTP_UN');
$SMTP_PW = getenv('SMTP_PW');
$SMTP_HOST = getenv('SMTP_HOST');
$SMTP_PORT = getenv('SMTP_PORT');
$SMTP_ENC = getenv('SMTP_ENC');

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
    // Generate a random verification code
    $verificationCode = rand(100000, 999999);
    $mail = new PHPMailer(true);

    $settings = parse_ini_file(dirname(__DIR__) . 'config.ini');

    // Send the verification email
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = $SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = $SMTP_UN;
        $mail->Password = $SMTP_PW;
        $mail->SMTPSecure = $SMTP_ENC;
        $mail->Port = $SMTP_PORT;

        //Send Email
        $mail->setFrom($SMTP_UN);

        //Recipients
        $mail->addAddress($email);
        $mail->addReplyTo($SMTP_UN);

        //Content
        $mail->isHTML(true);
        $mail->Subject = "Account registration confirmation";
        $message = "Here is the verification code to register on kalani: " . $verificationCode;
        $mail->Body = $message;

        $mail->send();

    } catch (Exception $e) {
        $_SESSION['result'] = 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        $_SESSION['status'] = 'error';
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
        "password" => $hashed_password,
        "code" => $verificationCode
    );
    $insert = $db->_insert("user", $user_data);

    // Handle registration errors
    if (!$insert) {
        $error_info = $db->getLastError();
        // Other database error
        echo "Error: " . $error_info[2];
        exit();
    }
    // Redirect the user to the login/verification page
    //header("Location: verification.php");
    header("location: verification.php?name=".$username."&email=".$email."");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .userbtn img {
            width: 50px;
            height: 50px;
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
    <div class="container">
        <h1>Registration Form</h1>
        <?php if (isset($error)): ?>
        <div style="color: red;"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <input type="text" name="name" id="name" class="form-control" required>
                <span></span>
                <label for="name">Username:</label>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" class="form-control" required>
                <span></span>
                <label for="email">Email:</label>
            </div>
            <div class="form-group">
                <input type="password" name="password" id="password" class="form-control" required>
                <span></span>
                <label for="password">Password:</label>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                <span></span>
                <label for="confirm_password">Confirm Password:</label>
            </div>
            <input type="submit" value="Register" class="submit-btn">
        </form>
    </div>
    <script src="script.js"></script>
</body>
</html>
