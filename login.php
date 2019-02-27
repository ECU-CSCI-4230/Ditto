<?php
session_start(); // Starting Session
$error = "Begin Error Message: "; // Variable To Store Error Message
if (isset($_POST['login'])) {
    if (empty($_POST['uname']) || empty($_POST['psw'])) {
        echo "Username or Password is empty";
    }
    else
    {
        echo "Doing Stuff";
// Define $username and $password
        $username=$_POST['uname'];
        $password=$_POST['psw'];
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
        $connection = mysqli_connect("localhost", "root", "admin");
// To protect MySQL injection for Security purpose
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($username);
        $password = mysqli_real_escape_string($password);
// Selecting Database
        $db = mysqli_select_db("Ditto_Drive", $connection);
// SQL query to fetch information of registerd users and finds user match.
        $query = mysqli_query("select * from login where password='$password' AND username='$username'", $connection);
        $rows = mysqli_num_rows($query);
        if ($rows == 1) {
            $_SESSION['login_user']=$username; // Initializing Session
            header("location: profile.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
        }
        mysqli_close($connection); // Closing Connection
    }
}

echo $error;
?>