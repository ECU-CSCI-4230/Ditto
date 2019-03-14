<?php
// Initiate connection to database

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'jcc52896');
define('DB_NAME', 'Ditto_Drive');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//create variables to hold user information
$username = $password = $confirm_password = $password = $first_name = $last_name =
$confirm_password_err = $password_err = "";


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
            $confirm_password_err = "Password did not match.";
        }
    }


if(empty($password_err) && empty($confirm_password_err)) {

// Prepare an insert statement
    $sql = "INSERT INTO User (Username, Password, Email) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {

        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $username, $password, $email);

        //execute statment
        mysqli_stmt_execute($stmt);


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
<html lang="en">
<head>
    <title>Ditto Drive</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href='.\style.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
</head>

<body>

<!-- The Reg Page -->
<div class="container" id="reg">
    <form id="reg_box" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <div class="row ">
            <div class="col-sm-6">
                <center><input type="text" placeholder="First Name" name="first_name" required></center>
            </div>
            <div class="col-sm-6">
                <center><input type="text" placeholder="Last Name" name="last_name" required></center>
            </div>
        </div>

        <div class="row">
        </div>
        <div class="row">
            <center><input type="text" placeholder="Enter Email" name="email" required></center>
        </div>
        <div class="row">
        </div>
        <div class="row <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <center><input type="password" placeholder="Enter Password" name="password" required></center>
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="row">
        </div>
        <div class="row <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <center><input type="password" placeholder="Repeat Password" name="confirm_password" required></center>
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
        <div class="container signin">
            <p>Already have an account? <a href="signIn.html">Sign in</a>.</p>
        </div>
    </form>
</div>

</body>

</html>