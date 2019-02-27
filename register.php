<?php
// Define $firstname, $lastname, $username, $password, $email
$firstname=$_POST['fname'];
$lastname=$_POST['lname'];
$username=$_POST['uname'];
$password=$_POST['psw'];
$password2=$_POST['psw-repeat'];
$email=$_POST['email'];

// Check to see if passwords match, if not give error
if (strcmp($password, $password2) != 0 ) {
    $error = "Passwords do not match.";
}

// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$connection = mysqli_connect("localhost", "root", "admin");

// To protect MySQL injection for Security purpose
$firstname = stripslashes($firstname);
$lastname = stripslashes($lastname);
$username = stripslashes($username);
$password = stripslashes($password);

$firstname =mysqli_real_escape_string($firstname);
$lastname =mysqli_real_escape_string($lastname);
$username = mysqli_real_escape_string($username);
$password = mysqli_real_escape_string($password);

// Selecting Database
$db = mysqli_select_db("Ditto_Drive", $connection);

//prepare statement
$sql = "INSERT INTO ";


//close database connection
mysqli_close($connection); // Closing Connection

