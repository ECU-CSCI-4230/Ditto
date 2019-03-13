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
    <form id="reg_box" action="action_page.php">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <div class="row">
          <div class="col-sm-6">
            <center><input type="text" placeholder="First Name" name="fname" required></center>
          </div>
          <div class="col-sm-6">
            <center><input type="text" placeholder="Last Name" name="lname" required></center>
          </div>
        </div>

        <div class="row">
        </div>
        <div class="row">
          <center><input type="text" placeholder="Enter Email" name="email" required></center>
        </div>
        <div class="row">
        </div>
        <div class="row">
          <center><input type="password" placeholder="Enter Password" name="psw" required></center>
        </div>
        <div class="row">
        </div>
        <div class="row">
          <center><input type="password" placeholder="Repeat Password" name="psw-repeat" required></center>
        </div>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
      <div class="container signin">
        <p>Already have an account? <a href="signIn.php">Sign in</a>.</p>
      </div>
    </form>
  </div>

</body>

</html>