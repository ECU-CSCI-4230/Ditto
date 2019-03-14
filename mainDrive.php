
<?php
include('session.php');
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location:signOReg.html");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ditto Drive</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <link href=".\drive.css" rel='stylesheet'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body>

<div class="container-fluid header">
    <div class="row">

        <div class="col-sm-1"></div>
        <div class="col-sm-2">
            <a href="mainDrive.php">
                <img id="logo" alt="Ditto Drive" src="images\logo2.png">
            </a>
        </div>

        <div class="col-sm-6">
            <form>
                <input id="search" type="text" name="search" placeholder="Search..">
            </form>
        </div>

        <div class="col-sm-3" id="icon">
            <a href="upload.php"><i id="head" class="material-icons" style="font-size: 400%; margin-left:7%;">backup</i>
            </a>
            <a href="profile.php"><i id="head" class="material-icons" style="font-size: 400%; margin-left:7%;">account_circle</i>
            </a>
            <a href="profile.php"> <i id="head" class="material-icons" style="font-size: 400%; margin-left:7%;">help</i>
            </a>
            <a href="profile.php"> <i id="head" class="material-icons"
                                      style="font-size: 400%; margin-left:7%;">settings</i> </a>
        </div>

    </div>
</div

>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4 ">
            <div class="container-fluid background">
                <?php
                define('DB_SERVER', 'localhost');
                define('DB_USERNAME', 'josh');
                define('DB_PASSWORD', 'jcc15241711');
                define('DB_NAME', 'Ditto_Drive');
                /* Attempt to connect to MySQL database */
                $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                // Check connection
                if ($link === false) {
                    die("ERROR: Could not connect. " . mysqli_connect_error());
                }

                $sql = "select Username FROM User WHERE User_ID=" . $_SESSION['login_user'];
                $result = mysqli_query($conn, $sql);
                $rows = mysqli_num_rows($result);

                if ($rows != 0) {
                    $msg .= 'display_error("Unable to connect to the server");';
                    $err = 3;
                } else {
                    $res = $result->fetch_assoc();
                    $username = $res["Username"];
                    $user_dir = "uploads/";

                    $files = scandir($user_dir);
                    sort($files);
                    foreach ($files as $file) {
                        if ($file != "." && $file != "..")
                            echo "\n";
                        echo '<li><a href="uploads/' . $file . '">' . $file . '</a></li>';
                    }
                }
                // Close connection
                mysqli_close($link);
                ?>

            </div>
        </div>
        <div class="col-sm-8">
            <div class="row">
                <div class="container-fluid background">
                    HEYYYYYYY
                </div>
            </div>
            <div class="row">
                <div class="container-fluid background">
                    HEYYYYYYY
                </div>
            </div>
            <div class="row">
                <div class="container-fluid background">
                    HEYYYYYYY
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>
