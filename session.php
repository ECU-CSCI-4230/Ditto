<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
$conn = mysqli_connect("localhost", "root", "admin", "ditto_Drive");
// Selecting Database
session_start();// Starting Session
// Storing Session
$user_check=$_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$ses_sql = $conn->query("select User_ID from User where User_ID='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['User_ID'];
if(!isset($login_session)){
    mysqli_close($connection); // Closing Connection
    header('Location: index.php'); // Redirecting To Home Page
}
?>