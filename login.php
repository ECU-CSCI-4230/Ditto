<html>
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
<div class="container" id="signIn">
    <form action="login.php" method="post">
        <div class="row">
            <center><input id="info" type="text" placeholder="Enter Username" name="uname" required></center>
            <div class="row">
                <center><input id="info" type="password" placeholder="Enter Password" name="psw" required></center>
            </div>
            <div class="row">
                <center><input type="submit" class="btn btn-primary" value="Submit" name="login"></center>
            </div>
        </div>
    </form>
</div>

<?php
session_start(); // Starting Session
$error = "Begin Error Message: "; // Variable To Store Error Message
if (isset($_POST['login'])) {
    if (empty($_POST['uname']) || empty($_POST['psw'])) {
        echo "Username or Password is empty ";
    }
    else
    {
        echo "Doing Stuff ";
// Define $username and $password

        $username= preg_replace('/\s+/', '', $_POST['uname']);
        $password= preg_replace('/\s+/', '', $_POST['psw']);
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
        $conn = mysqli_connect("localhost", "root", "admin", "Ditto_Drive");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {

            //$db = mysqli_select_db($conn, "Ditto_Drive");


            echo "Doing Stuff2 ";
// To protect MySQL injection for Security purpose
//        $username = stripslashes($username);
//        $password = stripslashes($password);
//        $username = mysqli_real_escape_string($username);
//        $password = mysqli_real_escape_string($password);

// SQL query to fetch information of registerd users and finds user match.
            //$query = mysqli_query("select User_ID from User where Password='$password' AND Username='$username';", $conn);
            $query = mysqli_query($conn, "SELECT * FROM User");


            echo "Doing Stuff3 ";
            echo "select User_ID from User where Password='$password' AND Username='$username'; ";

            /*if ($rows == 1) {
                $res = $query->fetch_assoc();
                $_SESSION['login_user'] = $res["User_ID"]; // Initializing Session
                header("location: profile.php"); // Redirecting To Other Page
            } else {
                $error = "Username or Password is invalid ";
            }*/

            if (mysqli_num_rows($query) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "id: " . $row["User_ID"] . " - User: " . $row["Username"] . "<br>";
                }
            } else {
                echo "0 results ";
            }

            mysqli_close($conn); // Closing Connection
        }
    }
}

echo $error;
?>

</body>
</html>