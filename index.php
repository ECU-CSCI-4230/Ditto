
<?php
include('session.php');
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location:signOReg.html");
} else {
    header("Location:mainDrive.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ditto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script type="text/javascript">
        function redir() {
            window.location = "/signOReg.html";
        }
    </script>
</head>
<body>
    <script type="text/javascript">
        redir();
    </script>
    <h1> Ditto Drive 1 </h1>
    <p>
        <a href="upload.php">UPLOAD FILES</a>
        <a href="register.php">REGISTER</a>
    </p>
</body>
</html>