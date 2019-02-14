<html>
<head>
    <title>Ditto</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function display_filenames() {
            let x = document.getElementById("uploadinput").files;
            let y = "";
            for (let z = 0; z < x.length; z++){
                y += "<div class=" + "\"alert alert-info\" role=\"alert\">" + x[z].name + " selected." + "</div>";
            }
            document.getElementById('filenames-output').innerHTML = y;
        }
        function display_success() {
            let b = "";
            b += "<div class=" + "\"alert alert-success\" role=\"alert\"><strong>Success!</strong>" + " File has been uploaded." + "</div>";
            document.getElementById('filenames-output').innerHTML = b;
        }
        function display_error() {
            let c = "";
            c += "<div class=" + "\"alert alert-danger\" role=\"alert\"><strong>Failure!</strong>" + " File has NOT been uploaded." + "</div>";
            document.getElementById('filenames-output').innerHTML = c;
        }
    </script>
</head>

<body>
<h1>  Ditto Drive  </h1>

<br>

<div class="row">
    <div class="form-group col-md-6" id="filenames-output" title="Files">
<!--        <div class="alert alert-danger" role="alert">-->
<!--            No files selected.-->
<!--        </div>-->
    </div>
    <div class="form-group col-md-6">
        <ul>
            <li>Sent file: <?php echo $_FILES['fileToUpload']['name'];  ?>
            <li>File size: <?php echo $_FILES['fileToUpload']['size']/1000;  ?> KB
            <li>File type: <?php echo $_FILES['fileToUpload']['type']; ?>
        </ul>

    </div>
</div>

<br><br><br><br><br>

<div class="row">
    <div class="form-group col-md-12">
        <form action="" method="POST" enctype = "multipart/form-data">
            <input id="uploadinput" name="fileToUpload" oninput="display_filenames()" type="file" multiple/>
            <p>Drag your files here or click in this area.</p>
            <button type="submit">Upload</button>
        </form>
    </div>
</div>

<?php
if(isset($_FILES['fileToUpload'])){
    $errors= array();
    $file_name = $_FILES['fileToUpload']['name'];
    $file_size = $_FILES['fileToUpload']['size'];
    $file_tmp = $_FILES['fileToUpload']['tmp_name'];
    $file_type= $_FILES['fileToUpload']['type'];
    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));

    if($file_size > 2097152){
        $errors[]="File size must be < 2 MB";
    }

    // Check if file already exists
    if (file_exists("uploads/$file_name")) {
        $errors[]="Sorry, file already exists.";
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"uploads/$file_name");
        echo '<script>display_success();</script>';
    }else{
        echo '<script>display_error();</script>';
        echo 'fail';
    }
}
?>


</body>
</html>
