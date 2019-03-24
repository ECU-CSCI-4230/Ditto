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
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

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
            <div class="list-group">
                <a href="#" class="list-group-item active">New Folder</a>
                <a href="#" class="list-group-item">Test 1</a>
                <a href="#" class="list-group-item">Test 2</a>
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
                    <?php
                    echo 'uploads/' . $username . '/';
                    ?>
                </div>
            </div>

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    All Files
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php
                        $selectedpath = "";

                        $username = $username . $selectedpath;
                        $stmt = "select * from file where File_Path like '%uploads/$username%' ;";
                        $result = mysqli_query($conn, $stmt);

                        //Check to see the the query ran
                        if (!$result) {
                            printf("Error: %s\n", mysqli_error($conn));
                        } else {
                            $rows = mysqli_num_rows($result);

                            while ($res = $result->fetch_assoc()) {
                                $filename = $res['File_Path'];
                                $filetype = $res['File_Type'];
                                $lastmod = $res['Last_Modified'];
                                $size = $res['File_Size'];

                                $len = strlen($filename);
                                $pos = strrpos($filename, '/');
                                $filename = substr($filename, $pos - $len + 1);

                                echo '<li class="list-group-item file-desc">' . $filename . '</li>';
                                //echo '<script>addfile(' . $filename . ',' . $filetype . ',' . $lastmod . ',' . $size . ')</script>';
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->

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

</body>

</html>