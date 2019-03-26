<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
    header("Location:signOReg.html");
}
$username = $_SESSION['login_username'];

$link = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
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
    <script src="script.js"></script>
</head>

<body>

<div class="row">
    <div class="col-md-1">
        <a href="index.php"><img id="logo3" src=".\images\logo.png" style="max-width: 400px"></a>
    </div>
    <div class="col-md-8">
    </div>
    <div class="form-group col-md-3">
        <ul class="list-group" id="namebar">
            <li class="list-group-item">Logged in as: <?php echo $username; ?></li>
            <li class="list-group-item">Select a Folder:
        <select id="uploadfolders" form="uploadform" name="selectedfolder">
            <option value="">Home</option>
        </select>
            </li>
        </ul>
    </div>
</div>

<br>

<div class="row">
    <div class="form-group col-md-12" id="filealert" title="FileAlerts">
        <!--        <div class="alert alert-danger" role="alert">-->
        <!--            No files selected.-->
        <!--        </div>-->
    </div>
</div>

<br><br><br><br>

<div class="row">
    <div class="form-group col-md-12">
        <form action="" method="POST" enctype = "multipart/form-data" id="uploadform">
            <input type="text"  name="directory">
            <input id="uploadinput" name="fileToUpload[]" oninput="display_filenames()" type="file" multiple>
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
            $foldername = substr($filepath, strpos($filepath, $username) + strlen($username) + 1, -1);
            $text .= "adduploaddir('" . $foldername . "');";
        }
        echo $text . '</script>';
    }
}

loaddirs($link, $username);

if(isset($_FILES['fileToUpload'])){
    $err = 0;
    $total = count($_FILES['fileToUpload']['name']);
    $msg = "<script>";


    $foldername = $_POST['selectedfolder'];

    for ($i = 0; $i < $total; $i++) {

        $file_name = $_FILES['fileToUpload']['name'][$i];
        $file_size = $_FILES['fileToUpload']['size'][$i];
        $file_tmp = $_FILES['fileToUpload']['tmp_name'][$i];
        $file_type = $_FILES['fileToUpload']['type'][$i];
//        $file_ext = strtolower(end(explode('.',$_FILES['image']['name'][$i])));

        if ($foldername == '') {
            $filepath = "uploads/$username/$file_name";
        } else {
            $filepath = "uploads/$username/$foldername/$file_name";
        }

        if (file_exists($filepath)) {
            $msg .= "display_error(\"" . $file_name . " A file with this name exists already. \" );";
            $err = 1;
        } else if ($file_size > 8388608) {
            $msg .= 'display_error("' . $file_name . ' is ' . $file_size / 1048576 . ' Mb... Max size is 8 Mb ");';
            $err = 2;
        } else if ($err == 0) {
            move_uploaded_file($file_tmp, $filepath);
            $msg .= 'display_success("' . $file_name . '");';
            $msg .= 'display_upload_stats("' . $file_name . '","' . $file_size / 1000 . '","' . $file_type . '");';

            // Prepare an insert For adding th eFile to the File table
            $sqlF = "INSERT INTO File (File_Path, File_Type, Last_Modified, File_Size) VALUES (?, ?, ?, ?);";
            if ($stmtF = mysqli_prepare($link, $sqlF)) {
                // Bind variables to the prepared statement as parameters
                $dat = date("Y-m-d");
                mysqli_stmt_bind_param($stmtF, "sssi", $filepath, $file_type, $dat, $file_size);

                mysqli_stmt_execute($stmtF);
            } else {
                echo "ERROR: Could not prepare query: $sqlF. " . mysqli_error($link);
            }

            mysqli_stmt_close($stmtF);


            //Get the File_ID for the file we just made
            $sqlFID = "SELECT File_ID FROM File WHERE File_Path = '$filepath'";
            $resultFID = mysqli_query($link, $sqlFID);
            $rowsFID = mysqli_num_rows($resultFID);

            if ($rowsFID == 0) {
                echo "SELECT File_ID FROM File WHERE File_Path = '$filepath';";
                $msg .= 'display_error("Unable to connect to the database. ");';
                $err = 3;
            } else {
                $res = $resultFID->fetch_assoc();
                $file_id = $res["File_ID"];
            }

            //Insert into FileShare
            $sqlFS = "INSERT INTO FileShare (User_ID, File_ID, Permission) VALUES (?, ?, ?)";
            if ($stmtFS = mysqli_prepare($link, $sqlFS)) {
                // Bind variables to the prepared statement as parameters
                $own = 1;
                mysqli_stmt_bind_param($stmtFS, "ssi", $_SESSION['login_user'], $file_id, $own);

                mysqli_stmt_execute($stmtFS);
            } else {
                echo "ERROR: Could not prepare query: $sqlFS. " . mysqli_error($link);
            }

            mysqli_stmt_close($stmtFS);
        }
    }

    mysqli_close($link);/**/

    $msg .= '</script>';

    echo $msg;
}
?>

</body>
</html>
