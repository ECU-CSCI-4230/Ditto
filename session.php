<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$conn = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");

// Selecting Database
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];

// SQL Query To Fetch Complete Information Of User
$ses_sql = $conn->query("select * from User where User_ID='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);

$login_session = $row['User_ID'];
//set session variables for user
$_SESSION["first_name"] = $row['First_name'];
$_SESSION["last_name"] = $row['Last_name'];
$_SESSION["email"] = $row['Email'];

//end session if session is open
if(!isset($login_session)){
    mysqli_close($connection); // Closing Connection
    header('Location: index.php'); // Redirecting To Home Page
}
?>