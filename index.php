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
<meta charset=utf-8>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="account.php">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<br><br><br>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3">
            <h1 class="my-4"><?php echo $_SESSION['first_name'] ?>'s Drive</h1>
            <div class="list-group" id="folderlist">
                <a onclick="changefold(0);" class="list-group-item active" id="fold0">Home</a>
                <a onclick="changefold(1);" class="list-group-item" id="fold1">File Share</a>
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
                    File Explorer
                </div>
                <div class="card-body" id="fileexplorer0">
                    <ul class="list-group" id="filelist0">

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

<!-- CREATE DIR MODAL -->
<div class="modal fade" id="createDirForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
<!-- END CREATE DIR MODAL -->

<!-- CREATE FS MODAL -->
<div class="modal fade" id="FSForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Share File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body mx-3">
                    <div class="md-form mb-5" id="FSData">

                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn btn-indigo">Share<i class="fas fa-paper-plane-o ml-1"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END CREATE FS MODAL -->

<!-- Move FILE MODAL -->
<div class="modal fade" id="moveForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Move File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <li class="list-group-item">Select a Folder:
                <select id="uploadfolders" form="movefileform" class="form-control validate" name="moveTo">
                    <option value="Home">Home</option>
                </select>
            </li>
            <form method="POST" id="movefileform">
                <div class="modal-body mx-3">
                    <div class="md-form mb-5" id="move">
                        <input type="hidden" id="form5" class="form-control validate" name="move">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Move FILE MODAL -->

<!-- Delete FILE MODAL -->
<div class="modal fade" id="deleteForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Delete File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body mx-3">
                    <div class="md-form mb-5" id="delete">
                        <input type="text" id="form4" class="form-control validate" name="delete">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Delete FILE MODAL -->


<!-- Delete Directory MODAL -->
<div class="modal fade" id="deleteDirectoryForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Delete Directory</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body mx-3">
                    <p>Are you sure you want to delete this directory and its contents?</p>
                    <div class="md-form mb-5" id="deleteDirectory">
                        <input type="text" id="form4" class="form-control validate" name="deleteDirectory">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END Delete Directory MODAL -->

<!-- REMOVE SHARED MODAL -->
<div class="modal fade" id="removeSharedForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Revoke Permissions</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST">
                <div class="modal-body mx-3">
                    <p>Are you sure you want to remove this file (<b id="sharedfilename"></b>)
                        from your list of files shared with you?</p><br>
                    <div class="md-form mb-5" id="removeShared">

                    </div>
                </div>
            </form>



        </div>
    </div>
</div>
<!-- REMOVE SHARED MODAL -->


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

/*
 * loaddirs adds each folder owned by the user to the drive viewer(index.php).
 * loaddirs adds each folder owned by the user to the folder tab.
 */
function loaddirs($conn, $username)
{

    $stmt = "SELECT * FROM File join FileShare on File.File_ID = FileShare.File_ID join User on
User.User_ID = FileShare.User_ID where User.User_ID=" . $_SESSION['login_user'] . " and File_Path like '%uploads/$username%'
and File_Type like 'directory';";

    $result = mysqli_query($conn, $stmt);

    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
    } else {
        $text = "<script>";
        while ($res = $result->fetch_assoc()) {

            $filepath = $res['File_Path'];
            $fileID = $res['File_ID'];

            $foldername = substr($filepath, strpos($filepath, $username) + strlen($username) + 1, -1);
            $text .= "addfolderitem('" . $foldername . "','" . $fileID . "');";
        }
        echo $text . '</script>';
    }
    echo "<script>addaddfolder()</script>";
}

loaddirs($conn, $username);



/*
 * loadfileexplorer adds each file owned by the user to their respective folder views(explorers).
 */
function loadfileexplorer($conn, $username)
{
//                        <-- DISPLAY FILE EXPLORER CONTENTS -->
    $text = "<script>";
    $selectedpath = 'uploads/' . $username . '/';

//                        $stmt = "select * from File where File_Path like '%uploads/$username%' ;";

    $stmt = "SELECT * FROM File join FileShare on File.File_ID = FileShare.File_ID join User on
                          User.User_ID = FileShare.User_ID where User.User_ID=" . $_SESSION['login_user'] . "
                          and File_Path like '%$selectedpath%' and File_Type not like 'directory';";

    $result = mysqli_query($conn, $stmt);


//echo $stmt; // for  debug
    if (!$result) {
        printf("Error: %s\n", mysqli_error($conn));
    } else {
        $rows = mysqli_num_rows($result);
        while ($res = $result->fetch_assoc()) {

            $filename = $res['File_Path'];
            $filePath = $res['File_Path'];
            $filetype = $res['File_Type'];
            $fileID = $res['File_ID'];
            $lastmod = $res['Last_Modified'];
            $size = $res['File_Size'];

            $len = strlen($filename);
            $pos = strrpos($filename, '/');
            $filename = substr($filename, $pos - $len + 1);

            $foldername = substr($filePath, strpos($filePath, $username) + strlen($username) + 1, 0 - strlen($filename)-1);

            if ($foldername == '') {
                $foldername = "Home";
            }

            //echo '<li class="list-group-item file-desc">' . $filename . '</li>';
            $text .= "addfiletoexplorer('" . $foldername . "','" . $filename . "','" . $filetype . "','" . $lastmod .
                "','" . $size . "','" . $filePath . "','" . $fileID . "');";
        }
    }

    $stmtFSE = "SELECT * FROM File join FileShare on File.File_ID = FileShare.File_ID
                  join User on User.User_ID = FileShare.User_ID
                  where FileShare.User_ID=" . $_SESSION['login_user'] . " and Permission = 2
                  and File_Type not like 'directory';";

    $resultFSE = mysqli_query($conn, $stmtFSE);

//echo $stmt; // for  debug
    if (!$resultFSE) {
        printf("Error: %s\n", mysqli_error($conn));
    } else {
        while ($resFSE = $resultFSE->fetch_assoc()) {
            $filenameFS = $resFSE['File_Path'];
            $filePathFS = $resFSE['File_Path'];
            $filetypeFS = $resFSE['File_Type'];
            $lastmodFS = $resFSE['Last_Modified'];
            $sizeFS = $resFSE['File_Size'];
            $fileID = intval($resFSE['File_ID']);

            // Get file owner email from database
            $stmtFSE2 = "SELECT * FROM  FileShare join User where FileShare.User_ID = User.User_ID and FileShare.Permission = 1 and FileShare.File_ID = " . $fileID . " ;";
            $resultFSE2 = mysqli_query($conn, $stmtFSE2);
            $resFSE2 = $resultFSE2->fetch_assoc();
            $fileownerFS = $resFSE2['Email'];
            $ownerID = $resFSE['User_ID'];

            $lenFS = strlen($filenameFS);
            $posFS = strrpos($filenameFS, '/');
            $filenameFS = substr($filenameFS, $posFS - $lenFS + 1);

            $foldernameFS = "#FS";

            //echo '<li class="list-group-item file-desc">' . $filename . '</li>';
            $text .= "addfiletoexplorer2('" . $foldernameFS . "','" . $filenameFS . "','" . $filetypeFS . "','" .
                $lastmodFS . "','" . $sizeFS . "','" . $filePathFS . "','" . $fileID . "','" . $fileownerFS . "','" . $ownerID . "');";
        }
    }

    echo $text . '</script>';
//                        <-- END DISPLAY FILE EXPLORER CONTENTS -->
}

loadfileexplorer($conn, $username);


//                        <-- START CREATE DIRECTORY SCRIPT -->
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (isset($_POST['dirname'])) {

        $dirname = $_POST['dirname'];



        if ( strlen($dirname) != 0 && $dirname != '#FS') {
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


            echo "<script>alert(" . $_SESSION['login_username'] . ")</script>";
            echo "<script>red()</script>";
        }

    } else if (isset($_POST['FS'])) {
        $shareUN = $_POST['FS'][1];
        $fid = $_POST['FS'][0];

        $sqlUID = "SELECT User_ID FROM User WHERE Username = '$shareUN';";
        $resultUID = mysqli_query($conn, $sqlUID);
        $rowsUID = mysqli_num_rows($resultUID);
        if ($rowsUID == 0) {
            echo "SELECT User_ID FROM User WHERE Username = '$shareUN';";
            $msg .= 'display_error("Unable to connect to the database. ");';
            $err = 3;
        } else {
            $res = $resultUID->fetch_assoc();
            $User_ID = $res["User_ID"];
            echo $User_ID;
        }


        $sqlFS = "INSERT INTO FileShare (User_ID, File_ID, Permission) VALUES (?, ?, ?);";
        if ($stmtFS = mysqli_prepare($conn, $sqlFS)) {
            // Bind variables to the prepared statement as parameters
            $own = 2;
            mysqli_stmt_bind_param($stmtFS, "ssi", $User_ID, $fid, $own);

            mysqli_stmt_execute($stmtFS);

        } else {
            echo "ERROR: Could not prepare query: $sqlFS. " . mysqli_error($conn);
        }

        //header('Location: red.php');
        echo "<script>red()</script>";
    }
    else if (isset($_POST['delete'])) {
        $fid = $_POST['delete'][0];
        $filePath = $_POST['delete'][1];

        $sqlUID = "DELETE FROM File WHERE File_ID = '$fid'";

        $conn->query($sqlUID);
        //$resultUID = mysqli_query($conn, $sqlUID);

        unlink($filePath);


        //header('Location: red.php');
        echo "<script>red()</script>";
    }
    else if (isset($_POST['move'])) {


        $fid = $_POST['move'][0];
        $fileName = $_POST['move'][1];
        $filePath = $_POST['move'][2];
        $foldername = $_POST['moveTo'];

        //echo $foldername;


        // Decides if it is being moved to the home directory or sub directory.
        if ($foldername == 'Home') {
            $newFilepath = "uploads/$username/$fileName";
        } else {
            $newFilepath = "uploads/$username/$foldername/$fileName";
        }

        $sqlUID = "UPDATE File SET File_Path = '$newFilepath' WHERE File_ID = '$fid';";
        $conn->query($sqlUID);
        //echo $sqlUID;

        // Moves the file at filePath and moves it to the new position newFilepath
        rename($filePath,$newFilepath);

        //header('Location: red.php');
        echo "<script>red()</script>";
    }
    else if (isset($_POST['deleteDirectory'])) {

        $folderName = $_POST['deleteDirectory'][0];
        $fid = $_POST['deleteDirectory'][1];
        $filepath = "uploads/$username/$folderName/";

        // Delete the  directory in the database
        $sqlUID = "DELETE FROM File WHERE File_ID = '$fid'";

        // Delete all files in the directory from the database
        $sqlUID2 = "DELETE FROM File WHERE File_Path LIKE '$filepath%'";

        $conn->query($sqlUID);
        $conn->query($sqlUID2);


        // Remove all files in directory before deleting
        $iterator = new RecursiveDirectoryIterator($filepath);
        foreach (new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::CHILD_FIRST) as $file)
        {
            if ($file->isDir()) {
                @rmdir($file->getPathname());
            } else {
                unlink($file->getPathname());
            }
        }
        @rmdir($filepath);

        echo "<script>red()</script>";
    }
    else if (isset($_POST['removeShared'])) {


        $text = "";

        $recip_ID = $_POST['userID'];
        $file_ID = $_POST['fileID'];

        $stmt = "Delete from FileShare where User_ID='$recip_ID' and File_ID='$file_ID' and Permission=2;";

        if (mysqli_query($conn, $stmt)) {

            $text = "File removed successfully.";
        } else {
            $text = "Error Encountered. Action was not successful. " . mysqli_error($conn);
        }

        echo '<script>alert("' . $text . '");</script>';
        echo '<script>red();</script>';

    }

}
//                        <-- END CREATE DIRECTORY SCRIPT -->
?>

</body>

</html>
