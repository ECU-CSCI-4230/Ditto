<?php
include('session.php');
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location:signOReg.html");
} else {
    header("Location:mainDrive.php");
}
?>
<html>
<head>
    <title>Ditto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="js/dittoj.js"></script>
</head>

<body>

<a href="index.php"><h1>  Ditto Drive  </h1></a>

<br>

<div class="row">
    <div class="form-group col-md-12" id="filealert" title="FileAlerts">
<!--        <div class="alert alert-danger" role="alert">-->
<!--            No files selected.-->
<!--        </div>-->
    </div>
</div>

<br><br><br><br><br>

<div class="row">
    <div class="form-group col-md-12">
        <form action="" method="POST" enctype = "multipart/form-data">
            <input id="uploadinput" name="fileToUpload[]" oninput="display_filenames()" type="file" multiple/>
            <p>Drag your files here or click in this area.</p>
            <button type="submit">Upload</button>
        </form>
    </div>
</div>

<br><br><br><br><br><br><br>

<div class="row">
    <div class="form-group col-md-6">
    </div>
    <div class="form-group col-md-6">
        <ul class="list-group" id="stats">
        </ul>
    </div>
</div>

<?php

if(isset($_FILES['fileToUpload'])){
    $err = 0;
    $total = count($_FILES['fileToUpload']['name']);

    $msg = "<script>";
    for( $i=0 ; $i < $total ; $i++ ) {

        $file_name = $_FILES['fileToUpload']['name'][$i];
        $file_size = $_FILES['fileToUpload']['size'][$i];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'][$i];
        $file_type = $_FILES['fileToUpload']['type'][$i];
//        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'][$i])));

        if (file_exists("uploads/$file_name")) {
            $msg .= "display_error(\"" . $file_name . " A file with this name exists already.\");";
            $err = 1;
        } else if ($file_size > 8388608) {
            $msg .= 'display_error("' . $file_name . ' is ' . $file_size / 1048576 . ' Mb... Max size is 8 Mb");';
            $err = 1;
        } else if ($err == 0) {
            move_uploaded_file($file_tmp, "uploads/$file_name");
            $msg .= 'display_success("' . $file_name . '");';
            $msg .= 'display_upload_stats("' . $file_name . '","' . $file_size / 1000 . '","' . $file_type . '");';
        }
    }
    $msg .= '</script>';

    echo $msg;
}
?>

</body>
</html>
