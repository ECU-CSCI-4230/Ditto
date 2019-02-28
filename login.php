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
        $conn = mysqli_connect("localhost", "root", "admin", "Ditto_Drive");

// To protect MySQL injection for Security purpose
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysqli_real_escape_string($username);
        $password = mysqli_real_escape_string($password);

// SQL query to fetch information of registerd users and finds user match.
        $query = $conn->query("select User_ID from User where Password='$password' AND Username='$username'");

        $rows = mysqli_num_rows($query);
        if ($rows == 1) {
            $res = $query->fetch_assoc();
            $_SESSION['login_user'] = $res["User_ID"]; // Initializing Session
            header("location: profile.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
        }
        mysqli_close($conn); // Closing Connection
    }
}

echo $error;
?>