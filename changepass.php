<?php
//create database connection
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'josh');
define('DB_PASSWORD', 'jcc15241711');
define('DB_NAME', 'Ditto_Drive');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
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

            //email password to user



            echo "password should be changed to $newpass";

        } else {
            $password_wrong_err = "Username or Password is invalid";
        }
    }
}





?>

<!DOCTYPE html>
<html lang="en" >

<head>
    <meta charset="UTF-8">
    <title>Ditto Drive</title>

    <link rel="stylesheet" href="css/regstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="script.js"></script>

</head>

<body>

<div class="container">
    <form id="contact" action="" method="POST">
        <img src="images\logo.png" height="350" width="350" style = "text-align:center">
        <h3>Reset Your Password</h3>
        <fieldset>
            <input placeholder="Please enter your email." type="text" name="email" tabindex="1" required autofocus>
        </fieldset>

        <fieldset>
            <button type="submit" id="contact-submit" value="Submit" name="login" > Login</button>
            <p>Don't have an account? <a href="register.php">Open a new one.</a>.</p>
        </fieldset>
    </form>
</div>

</body>

</html>
