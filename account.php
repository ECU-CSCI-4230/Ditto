<?php
include('session.php');
include('functions.php');
if(!isset($_SESSION['login_user'])){
    header("Location:SigninOrRegister.html");
}

$conn = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$username = $_SESSION['login_username'];
$selectedpath = "";






loadShareExplorer($conn, $username);

if($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['currentpass'])) {
        $cur_password = trim($_POST['currentpass']);
        $new_pass = trim($_POST['newpass']);
        $new_pass_ver = trim($_POST[newpass2]);
        $cur_userID = $_SESSION['login_user'];

        $ses_sql = $conn->query("select * from User where User_ID='$cur_userID'");
        $row = mysqli_fetch_assoc($ses_sql);


        //check to see if current password matches password stored
        if (strcmp($row['Password'], $cur_password) == 0) {
            //check new passwords entered to see if they are the same
            if (strcmp($new_pass, $new_pass_ver) == 0) {
                $stmt = "UPDATE User SET Password = '$new_pass' WHERE User_id = '$cur_userID'";
                if (mysqli_query($conn, $stmt)) {

                    print "Your password has been updated successfully";
                } else {
                    print "Error updating password, please contact support. " . mysqli_error($conn);
                }
            } else {
                echo "New passwords entered do not match";
            }

        }else {
            echo "The current password you entered does not match what is on record.";
            //set variable for warning message to user
        }




    } else if (isset($_POST['email'])) {
        $new_email = $_POST['email'];
        $new_email_ver = $_POST['emailcheck'];
        $cur_userID = $_SESSION['login_user'];
        $ses_sql = $conn->query("select * from User where User_ID='$cur_userID'");
        $row = mysqli_fetch_assoc($ses_sql);
        //check to see if two emails entered match
        if (strcmp($new_email, $new_email_ver) == 0) {
            $stmt = "UPDATE User SET Username = '$new_email', Email = '$new_email'  WHERE User_id = '$cur_userID'";
            if (mysqli_query($conn, $stmt)) {

                print "Your password has been updated successfully";
            } else {
                print "Error updating email, please contact support. " . mysqli_error($conn);
            }
        } else {
            print "The two emails entered do not match.";
        }



    }
}
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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="style.css" rel="stylesheet">

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

<br>
<br>
<br>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3">
            <h1 class="my-4">User Account Settings</h1>
            <div class="list-group" id="folderlist">
                <button type= "submit" class= "contact-submit btn btn-outline-dark" data-toggle="modal" data-target="#Changeemail">Change Email</button>

                <button type= "button" class= "btn btn-outline-dark" data-toggle="modal" data-target="#Changepassword">Change Password</button>

                <button onclick = "location.href =' logout.php'" type="button" class="btn btn-danger">Logout</button>
            </div>
        </div>
        <!-- /.col-lg-3 -->
        <div class="col-lg-9">

            <div class="card card-outline-secondary my-4" id="explorer">
                <div class="card-header">
                    User Information
                </div>
                <div class="card-body">
                    First Name: <?php Echo $_SESSION['first_name'] ?> <br>
                    Last Name: <?php Echo $_SESSION['last_name'] ?> <br>
                    Email: <?php Echo $_SESSION['email'] ?> <br>
                </div>
            </div>

            <div class="card card-outline-secondary my-4" id="explorer">
                <div class="card-header">
                    Here are the files you have shared.
                </div>
                <div class="card-body" id="fileexplorer2">
                    <ul class="list-group" id="filelist2">
                    </ul>
                </div>
            </div>

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>

<br>
<br>
<br>
<div class="row"></div>
<!-- / Page Content -->



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
                    <input placeholder="Enter your current password." type="text" name="currentpass" tabindex="1" required autofocus>
                </fieldset>
                <fieldset>
                    <input placeholder="Enter your new password." type="text" name="newpass" tabindex="1">
                </fieldset>
                <fieldset>
                    <input placeholder="Enter your new password again." type="text" name="newpass2" tabindex="1">
                </fieldset>
                <fieldset>
                    <button type="submit" id="contact-submit" value="Submit" name="login" > Submit</button>

                </fieldset>
            </form>



        </div>
    </div>
</div>
<!-- END Change email MODAL -->

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
<!-- END Change email MODAL -->




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
