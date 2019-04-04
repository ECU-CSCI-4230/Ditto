<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;

//create database connection
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'josh');
define('DB_PASSWORD', 'jcc15241711');
define('DB_NAME', 'Ditto_Drive');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$Unvalid_email = '';
// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//create variables to hold users email password
    $user_email = $message = $newpass = $email_error = $email = '';

//generate random 7 character password
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 7; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $newpass = $randomString;

//get email from form
    $email = trim($_POST["email"]);


    $stmt = "select User_ID from User where Email ='$email' ;";
    $result = mysqli_query($link, $stmt);
    $rows = mysqli_num_rows($result);


    if ($rows == 1) {
        //change user password to random generated string
        $sql = "UPDATE User SET Password = ? WHERE Email = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $newpass, $email);
            //execute statment
            mysqli_stmt_execute($stmt);
            //setup PHPMailer
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            //Create a new PHPMailer instance
            $mail = new PHPMailer;

            //Tell PHPMailer to use SMTP
            $mail->isSMTP();

            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;

            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;

            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "dittodrivepassmanager@gmail.com";

            //Password to use for SMTP authentication
            $mail->Password = "jcc52896";

            //Set who the message is to be sent from
            $mail->setFrom('noreply@dittodrive.us', 'Ditto Drive');


            //Set who the message is to be sent to
            $mail->addAddress($email);

            //Set the subject line
            $mail->Subject = 'Your Password Has Been Reset';

            $mail->Body    = "Your new password is:  '$newpass'";

            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                header("Location:PassChangeSuccess.html");

            }
        }
    }
    else {
        $Unvalid_email = "The email entered is not associated with a account.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ditto Drive</title>

    <link rel="stylesheet" href="css/regstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="script.js"></script>

</head>

<body>

<div class="container">
    <form id="contact" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <img src="images\logo.png" height="350" width="350" style="text-align:center">
        <h3>Reset Your Password</h3>
        <div class = "container<?php echo (!empty($Unvalid_email)) ? 'has-error' : ''; ?>">
            <fieldset>
                <input placeholder="Please enter your email." type="text" name="email" tabindex="1" required autofocus>
                <span class="help-block"><?php echo $Unvalid_email; ?></span>
            </fieldset>
        </div>
        <fieldset>
            <button type="submit" id="contact-submit" value="Submit" name="login">Submit</button>
            <p>Don't have an account? <a href="register.php">Open a new one.</a>.</p>
        </fieldset>
    </form>
</div>

</body>

</html>
