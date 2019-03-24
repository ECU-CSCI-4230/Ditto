<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
    header("Location:signOReg.html");
}

$conn = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$username = $_SESSION['login_username'];
$selectedpath = "";

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="Ditto Drive (Totally not trademarked) is a very file hosting service. We are a small team of students at East Carolina University working on our final project.">
    <meta name="author" content="">
    <script type="text/javascript" src="script.js"></script>

    <title>Ditto Drive</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/mainDrive.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Ditto Drive</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="upload.php">Upload</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3">
            <h1 class="my-4">My Drive</h1>
            <div class="list-group" id="folderlist">
                <a onclick="changefold(0);" class="list-group-item active" id="fold0">Home</a>
            </div>
        </div>
        <!-- /.col-lg-3 -->
        <div class="col-lg-9">

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
                <div class="card-body">
                    <h3 class="card-title">Quick Access</h3>
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Folders
                </div>
                <div class="card-body">
                </div>
            </div>

            <div class="card card-outline-secondary my-4" id="explorer">
                <div class="card-header">
                    File Explorer
                </div>
                <div class="card-body" id="fileexplorer0">
                    <ul class="list-group" id="filelist0">

                    </ul>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->

<!-- MODAL -->
<div class="modal fade" id="modalSubscriptionForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Create Directory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <i class="fas fa-user prefix grey-text"></i>
                    <input type="text" id="form3" class="form-control validate" name="dirname">
                    <label data-error="wrong" data-success="right" for="form3">Directory Name</label>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-indigo">Create <i class="fas fa-paper-plane-o ml-1"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL -->


<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Ditto Drive 2019</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php

function loaddirs($conn, $username)
{
//                        <-- START DIRECTORY VIEWER SCRIPT -->
    $stmt = "SELECT * FROM File join FileShare on File.File_ID = FileShare.File_ID join User on
User.User_ID = FileShare.User_ID where User.User_ID=" . $_SESSION['login_user'] . " and File_Path like '%uploads/$username%'
and File_Type like 'directory';";

    $result = mysqli_query($conn, $stmt);

//echo $stmt; // for  debug
//Check to see the the query ran
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
    } else {
        $rows = mysqli_num_rows($result);
        $text = "<script>";
        while ($res = $result->fetch_assoc()) {

            $filename = $res['File_Path'];
            $filetype = $res['File_Type'];
            $lastmod = $res['Last_Modified'];
            $size = $res['File_Size'];

            $len = strlen($filename);
            $pos = strrpos($filename, $username);
            $filename = substr($filename, $pos - $len + 1);

            $text .= "addfolderitem('" . $filename . "');";
        }
        echo $text . '</script>';
    }
    echo "<script>addaddfolder()</script>";
//                        <-- END DIRECTORY VIEWER SCRIPT -->
}

loaddirs($conn, $username);

function loadfileexplorer($conn, $username)
{
//                        <-- DISPLAY FILE EXPLORER CONTENTS -->
    $selectedpath = 'uploads/' . $username . '/';

//                        $stmt = "select * from File where File_Path like '%uploads/$username%' ;";

    $stmt = "SELECT * FROM File join FileShare on File.File_ID = FileShare.File_ID join User on
                          User.User_ID = FileShare.User_ID where User.User_ID=" . $_SESSION['login_user'] . " and File_Path like '%$selectedpath%' 
                          and File_Type not like 'directory';";

    $result = mysqli_query($conn, $stmt);

//echo $stmt; // for  debug
//Check to see the the query ran
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
    } else {
        $rows = mysqli_num_rows($result);
        $text = "<script>";
        while ($res = $result->fetch_assoc()) {

            $filename = $res['File_Path'];
            $filetype = $res['File_Type'];
            $lastmod = $res['Last_Modified'];
            $size = $res['File_Size'];

            $len = strlen($filename);
            $pos = strrpos($filename, '/');
            $filename = substr($filename, $pos - $len + 1);

            //echo '<li class="list-group-item file-desc">' . $filename . '</li>';
            $text .= "addfiletoexplorer(0,'" . $filename . "','" . $filetype . "','" . $lastmod . "','" . $size . "');";
        }
        echo $text . '</script>';
    }
//                        <-- END DISPLAY FILE EXPLORER CONTENTS -->
}

loadfileexplorer($conn, $username, 'Home');


//                        <-- START CREATE DIRECTORY SCRIPT -->
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $dirname = $_POST['dirname'];
    $filepath = "uploads/" . $_SESSION['login_username'] . '/' . $dirname . '/';
    $sqlF = "INSERT INTO File (File_Path, File_Type, Last_Modified, File_Size) VALUES (?, ?, ?, ?);";
    if ($stmtF = mysqli_prepare($conn, $sqlF)) {
        // Bind variables to the prepared statement as parameters
        $dat = date("Y-m-d");
        $dir = 'directory';
        $size = 0;
        mysqli_stmt_bind_param($stmtF, "sssi", $filepath, $dir, $dat, $size);

        mysqli_stmt_execute($stmtF);
    } else {
        echo "ERROR: Could not prepare query: $sqlF. " . mysqli_error($link);
    }

    mysqli_stmt_close($stmtF);

    $sqlFID = "SELECT File_ID FROM File WHERE File_Path = '$filepath'";
    $resultFID = mysqli_query($conn, $sqlFID);
    $rowsFID = mysqli_num_rows($resultFID);
    if ($rowsFID == 0) {
        echo "SELECT File_ID FROM File WHERE File_Path = '$filepath';";
        $msg .= 'display_error("Unable to connect to the database. ");';
        $err = 3;
    } else {
        $res = $resultFID->fetch_assoc();
        $file_id = $res["File_ID"];
    }

    $sqlFS = "INSERT INTO FileShare (User_ID, File_ID, Permission) VALUES (?, ?, ?);";
    if ($stmtFS = mysqli_prepare($conn, $sqlFS)) {
        // Bind variables to the prepared statement as parameters
        $own = 1;
        mysqli_stmt_bind_param($stmtFS, "ssi", $_SESSION['login_user'], $file_id, $own);

        mysqli_stmt_execute($stmtFS);

        mkdir('uploads/' . $username . '/' . $dirname, 0777, true);
        chown('uploads/' . $username . '/' . $dirname, 'www-data:www-data');
    } else {
        echo "ERROR: Could not prepare query: $sqlFS. " . mysqli_error($conn);
    }

    //header('Location: red.php');
    echo "<script>red()</script>";
}
//                        <-- END CREATE DIRECTORY SCRIPT -->
?>

</body>

</html>
