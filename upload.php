<?php
include('session.php');
if(!isset($_SESSION['login_user'])){
  header("Location:SigninOrRegister.html");
}
$username = $_SESSION['login_username'];

$link = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");
if ($link === false) {
  die("ERROR: Could not connect. " . mysqli_connect_error());
}

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
    <script src="js/dittoj.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <title>Ditto Drive</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link rel="stylesheet" href="./test2_files/bootstrap.css">
    <link href="style.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ditto Drive</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
        aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="upload.php" id="trigger">Upload File</a>
                  <!-- <a class="nav-link" href="upload.php">Upload</a> -->
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home
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
          <div class="list-group">
            <a class="list-group-item"">Logged in as: <?php echo $username; ?> </a>
            <li class="list-group-item">Select a Folder:
              <select id="uploadfolders" form="uploadform" name="selectedfolder">
                <option value="">Home</option>
              </select>
            </li>
          </div>
        </div>
          <div class="col-lg-9">
              <div class="container" id="upload-notis">

              </div>
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

    </div>

<!-- Footer -->
<footer class="py-5 bg-dark">
  <div class="container">
    <p class="m-0 text-center text-white">Copyright © Ditto Drive 2019</p>
  </div>
  <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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

    echo "<script>clear_notifications()</script>";
  $err = 0;
  $total = count($_FILES['fileToUpload']['name']);
  $msg = "<script>";


  $foldername = $_POST['selectedfolder'];

  for ($i = 0; $i < $total; $i++) {

    $err = 0;
    $file_name = $_FILES['fileToUpload']['name'][$i];
    $file_size = $_FILES['fileToUpload']['size'][$i];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'][$i];
    $file_type = $_FILES['fileToUpload']['type'][$i];

    $file_type = substr($file_type, 0, 30);

    if ($foldername == '') {
      $filepath = "uploads/$username/$file_name";
    } else {
      $filepath = "uploads/$username/$foldername/$file_name";
    }

    if (file_exists($filepath)) {
      $msg .= "display_error(\"" . $file_name . " (A file with this name exists already.) \" );";
      $err = 1;
    } else if ($file_size > 8388608) {
      $msg .= 'display_error("' . $file_name . ' is ' . $file_size / 1048576 . ' Mb... Max size is 8 Mb ");';
      $err = 2;
    } else if ($err == 0) {
      move_uploaded_file($file_tmp, $filepath);
      $msg .= 'display_success("' . $file_name . ' (' . round($file_size / 1048576, 3) . ' Mb) into directory ' . $foldername . '/");';
//      $msg .= 'display_upload_stats("' . $file_name . '","' . $file_size / 1000 . '","' . $file_type . '");';

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
