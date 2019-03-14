<?php
include('session.php');
session_start();
if(!isset($_SESSION['login_user'])){
    header("Location:signOReg.html");
}
?>
<html>
<head>
    <title>Ditto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet" type="text/css">
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

// Initiate connection to database
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

    for ($i = 0; $i < $total; $i++) {

        $file_name = $_FILES['fileToUpload']['name'][$i];
        $file_size = $_FILES['fileToUpload']['size'][$i];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'][$i];
        $file_type = $_FILES['fileToUpload']['type'][$i];
//        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'][$i])));

        if ($rows != 0) {
            $msg .= 'display_error("Unable to connect to the server");';
            $err = 3;
        } else {
            $res = $result->fetch_assoc();
            $username = $res["Username"];
            //$filepath = "uploads/$username/$file_name";
            $filepath = "uploads/$file_name";

            if (file_exists($filepath)) {
                $msg .= "display_error(\"" . $filepath . " A file with this name exists already.\");";
                $err = 1;
            } else if ($file_size > 8388608) {
                $msg .= 'display_error("' . $file_name . ' is ' . $file_size / 1048576 . ' Mb... Max size is 8 Mb");';
                $err = 2;
            } else if ($err == 0) {
                move_uploaded_file($file_tmp, $filepath);
                $msg .= 'display_success("' . $file_name . '");';
                $msg .= 'display_upload_stats("' . $file_name . '","' . $file_size / 1000 . '","' . $file_type . '");';

    // Prepare an insert statement
                $sql = "INSERT INTO File (File_Path, File_Type, LastModified, Size) VALUES (?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    // Bind variables to the prepared statement as parameters
                    mysqli_stmt_bind_param($stmt, "sss", $filepath, $file_type, date("Y/m/d"), $file_size);
                    //execute statement
                    mysqli_stmt_execute($stmt);
                } else {
                    echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
                }
                // Close statement
                mysqli_stmt_close($stmt);

                $sql = "select File_ID FROM File WHERE File_Path= $filepath";
                $result = mysqli_query($conn, $sql);
                $rows = mysqli_num_rows($result);

                if ($rows != 0) {
                    $msg .= 'display_error("Unable to connect to the database");';
                    $err = 3;
                } else {
                    $res = $result->fetch_assoc();
                    $file_id = $res["File_ID"];
                    $filepath = "uploads/$username/$file_name";

                    $sql = "INSERT INTO FileShare (User_ID, File_ID, Permission) VALUES (?, ?, ?)";
                    if ($stmt = mysqli_prepare($link, $sql)) {
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "sss", $_SESSION['login_user'], $file_id, 1);
                        //execute statement
                        mysqli_stmt_execute($stmt);
                    } else {
                        echo "ERROR: Could not prepare query: $sql. " . mysqli_error($link);
                    }
                }

    // Close statement
                mysqli_stmt_close($stmt);
    // Close connection
                mysqli_close($link);
            }


            $msg .= '</script>';

            echo $msg;
        }
    }
}
?>

</body>
</html>
