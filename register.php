<?php
// Initiate connection to database
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
//create variables to hold user information
$username  = $confirm_password = $password = $first_name = $last_name =
$confirm_password_err = $password_err = $email = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"]);
    $username = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
        echo "<script>passErr($password_err)</script>";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Validate that passwords match
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords did not match.";
        }
    }
//test to see if any errors were generated
    if(empty($password_err) && empty($confirm_password_err)) {
// Prepare an insert statement
        $sql = "INSERT INTO User (Username, Password, First_name, Last_name, Email) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $username, $password, $first_name, $last_name, $email);
            //execute statment
            mysqli_stmt_execute($stmt);

            mkdir('uploads/' . $email, 0777, true);
            chown('uploads/' . $email, 'www-data:www-data');

            echo "<script>regSuccess()</script>";
            header("Location:signIn.php");
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
        }
// Close statement
        mysqli_stmt_close($stmt);
// Close connection
        mysqli_close($link);
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
</head>

<body>

<div class="container">
    <form id="contact" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <img src="images\logo.png" height="350" width="350" style = "text-align:center">
        <h3>Create a new Account</h3>
        <fieldset>
            <input placeholder="Your first name" type="text" name="first_name" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
            <input placeholder="Your last name" type="text" name="last_name" tabindex="1">
        </fieldset>
        <fieldset>
            <input placeholder="Your Email Address (used as your username)" type="email" name="email" tabindex="1">
        </fieldset>
        <div class = "container<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
        <fieldset>
            <input placeholder="Password" type="text" name="password" tabindex="1">
            <span class="help-block"><?php echo $password_err; ?></span>
        </fieldset>
        </div>
        <div class = "container<?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
        <fieldset>
            <input placeholder="Confirm Password" type="text" name="confirm_password" tabindex="1">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </fieldset>
        </div>
        <fieldset>
            <button type="submit" id="contact-submit">Submit</button>
            <p>Already have an account? <a href="signIn.php">Sign in</a>.</p>
        </fieldset>
    </form>
</div>

</body>

</html>




