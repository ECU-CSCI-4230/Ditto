<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
    header("Location:SigninOrRegister.html");
}

$conn = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$username = $_SESSION['login_username'];
$selectedpath = "";

?>

<?php ?><style><?php include 'css/mainDrive.css'; ?></style>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
          content="Ditto Drive (Totally not trademarked) is a very file hosting service. We are a small team of students at East Carolina University working on our final project.">
    <meta name="author" content="">
    <script type="text/javascript" src="script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <title>Ditto Drive</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!-- <link href="css/mainDrive.css" rel="stylesheet"> -->

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
                    <a class="nav-link" href="upload.php" id="trigger">Upload File</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Account</a>
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
            <h1 class="my-4">User Account Settings</h1>
            <div class="list-group" id="folderlist">
                <button type= "submit" class= "contact-submit" data-toggle="modal" data-target="#Changeemail">Change Email</button>
                <button type= "button" class= "" data-toggle="modal" data-target="#Changepassword">Change Password</button>
                <button onclick = "location.href =' logout.php'" type="button" class="btn btn-danger">Logout</button>









            </div>
        </div>
        <!-- /.col-lg-3 -->
        <div class="col-lg-9">

            <!--            <div class="card mt-4">-->
            <!--                <img class="card-img-top img-fluid" id="logo" src="images/logo.png" alt="">-->
            <!--                <div class="card-body">-->
            <!--                    <h3 class="card-title">Quick Access</h3>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            <!-- /.card -->
            <!---->
            <!--            <div class="card card-outline-secondary my-4">-->
            <!--                <div class="card-header">-->
            <!--                    Folders-->
            <!--                </div>-->
            <!--                <div class="card-body">-->
            <!--                </div>-->
            <!--            </div>-->

            <div class="card card-outline-secondary my-4" id="explorer">
                <div class="card-header">
                    Welcome, <?php Echo $_SESSION['first_name'] ?>
                </div>
                <div class="card-body" id="fileexplorer0">
                    <ul class="list-group" id="filelist0">
                        Here you can change your individual account settings.
                    </ul>
                </div>
                <div class="card-body d-none" id="fileexplorer1">
                    <ul class="list-group" id="filelist1">

                    </ul>
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>

<br>
<br>
<br>
<div class="row"></div>
<!-- /.container -->


<!-- Change password MODAL -->
<div class="modal fade" id="Changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Change password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="contact" action="" method="POST">
                <fieldset>
                    <input placeholder="Enter your current password." type="text" name="email" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input placeholder="Enter your new password." type="text" name="emailcheck" tabindex="1">
                </fieldset>
                <fieldset>
                    <input placeholder="Enter your new password again." type="text" name="emailcheck" tabindex="1">
                </fieldset>
                <fieldset>
                    <button type="submit" id="contact-submit" value="Submit" name="login" > Submit</button>

                </fieldset>
            </form>



        </div>
    </div>
</div>
<!-- END Change password MODAL -->

<!-- Change password MODAL -->
<div class="modal fade" id="Changeemail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Change password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="contact" action="" method="POST">
                <fieldset>
                    <input placeholder="Enter your desired email." type="email" name="email" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input placeholder="Enter your email again." type="email" name="emailcheck" tabindex="1">
                </fieldset>
                <fieldset>
                    <button type="submit" id="contact-submit" value="Submit" name="login" > Submit</button>

                </fieldset>
            </form>



        </div>
    </div>
</div>
<!-- END Change password MODAL -->




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
