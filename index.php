
<?php
include('session.php');
session_start();
if(!isset($_SESSION['username'])){
    header("Location:Login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Ditto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
    <h1> Ditto Drive 1 </h1>
    <p>
        <a href="upload.php">UPLOAD FILES</a>
        <a href="register.html">REGISTER</a>
    </p>
</body>
</html>