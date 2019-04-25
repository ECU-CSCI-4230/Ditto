



<?php
  session_start(); // Starting Session
$password_wrong_err = ''; // Variable To Store Error Message
  if (isset($_POST['login'])) {
      if (empty($_POST['uname']) || empty($_POST['psw'])) {
          echo "Username or Password is empty ";
      }
      else
      {
          echo $_POST['uname'];
          echo $_POST['psw'];
// Define $username and $password and $password_wrong_err;

          $username= $_POST['uname'];
          $password= $_POST['psw'];


// Establishing Connection with Server by passing DB_SERVER, DB_USERNAME, DB_PASSWORD and DB_NAME as a parameter
          define('DB_SERVER', 'localhost');
          define('DB_USERNAME', 'josh');
          define('DB_PASSWORD', 'jcc15241711');
          define('DB_NAME', 'Ditto_Drive');
          $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          } else {

              //$db = mysqli_select_db($conn, "Ditto_Drive");


// To protect MySQL injection for Security purpose
//                  $username = stripslashes($username);
//                  $password = stripslashes($password);
//                  $username = mysqli_real_escape_string($username);
//                  $password = mysqli_real_escape_string($password);
//
// SQL query to fetch information of registerd users and finds user match.

              $stmt = "select * from User where Password='$password' AND Email='$username';";
              $result = mysqli_query($conn, $stmt);
              $rows = mysqli_num_rows($result);

              //echo $rows;

              if ($rows == 1) {
                  $res = $result->fetch_assoc();
                  $_SESSION['login_user'] = $res["User_ID"]; // Initializing Session
                  $_SESSION['login_username'] = $res["Username"];
                  header("location: index.php"); // Redirecting To Other Page
              } else {
                  $password_wrong_err = "Username or Password is invalid";
              }

//              if (rows > 0) {
//                  // output data of each row
//                  while ($row = mysqli_fetch_assoc($result)) {
//                      echo "id: " . $row["User_ID"] . " - User: " . $row["Username"] . "<br>";
//                  }
//              } else {
//                  echo "0 results ";
//                  echo $error;
//              }

              mysqli_close($conn); // Closing Connection
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
    <form id="contact" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <img src="images\logo.png" height="350" width="350" style = "text-align:center">
        <h3>Log In</h3>
        <fieldset>
            <input placeholder="Username Or Email" type="text" name="uname" tabindex="1" required autofocus>
        </fieldset>
        <fieldset>
            <input placeholder="Password" type="password" name="psw" tabindex="1">
            <span class="help-block"><?php echo $password_wrong_err; ?></span>
        </fieldset>

        <fieldset>
            <button type="submit" id="contact-submit" value="Submit" name="login" > Login</button>
            <p>Don't have an account? <a href="register.php">Create one.</a></p>
            <p>Forgot your password? <a href="changepass.php">Change it.</a></p>
        </fieldset>
    </form>
</div>

</body>

</html>


