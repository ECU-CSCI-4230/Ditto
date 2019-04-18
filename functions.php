<?php
/**
 * Created by PhpStorm.
 * User: mccle
 * Date: 4/18/2019
 * Time: 4:06 PM
 */

$conn = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$username = $_SESSION['login_username'];
$selectedpath = "";

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
            $stmtFSE2 = "select * from fileshare join user where fileshare.User_ID = user.User_ID and fileshare.Permission = 1 and fileshare.File_ID = " . $fileID . ";";
            $resultFSE2 = mysqli_query($conn, $stmtFSE2);
            $resFSE2 = $resultFSE2->fetch_assoc();
            $fileownerFS = $resFSE2['Email'];

            $lenFS = strlen($filenameFS);
            $posFS = strrpos($filenameFS, '/');
            $filenameFS = substr($filenameFS, $posFS - $lenFS + 1);

            $foldernameFS = "#FS";

            //echo '<li class="list-group-item file-desc">' . $filename . '</li>';
            $text .= "addfiletoexplorer2('" . $foldernameFS . "','" . $filenameFS . "','" . $filetypeFS . "','" .
                $lastmodFS . "','" . $sizeFS . "','" . $filePathFS . "','" . $fileID . "','" . $fileownerFS . "');";
        }
    }

    echo $text . '</script>';
//                        <-- END DISPLAY FILE EXPLORER CONTENTS -->
}

function loadShareExplorer($conn, $username)
{
    $text = "<script>";
    $selectedpath = 'uploads/' . $username . '/';

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

//            // Get file owner email from database
//            $stmtFSE2 = "select * from fileshare join user where fileshare.User_ID = user.User_ID and fileshare.Permission = 1 and fileshare.File_ID = " . $fileID . ";";
//            $resultFSE2 = mysqli_query($conn, $stmtFSE2);
//            $resFSE2 = $resultFSE2->fetch_assoc();
//            $fileownerFS = $resFSE2['Email'];
            $fileownerFS = getOwnerEmail($fileID, $conn);

            $lenFS = strlen($filenameFS);
            $posFS = strrpos($filenameFS, '/');
            $filenameFS = substr($filenameFS, $posFS - $lenFS + 1);

            $foldernameFS = "#FS";

            //echo '<li class="list-group-item file-desc">' . $filename . '</li>';
            $text .= "addfiletoexplorer3('" . $foldernameFS . "','" . $filenameFS . "','" . $filetypeFS . "','" .
                $lastmodFS . "','" . $sizeFS . "','" . $filePathFS . "','" . $fileID . "','" . $fileownerFS . "');";
        }
    }

    echo $text . '</script>';
}

/*
 * getOwnerEmail
 */
function getOwnerEmail($fileID, $conn)
{
    // Get file owner email from database
    $stmtFSE2 = "select * from fileshare join user where fileshare.User_ID = user.User_ID and fileshare.Permission = 1 and fileshare.File_ID = " . $fileID . ";";
    $resultFSE2 = mysqli_query($conn, $stmtFSE2);
    $resFSE2 = $resultFSE2->fetch_assoc();
    return $resFSE2['Email'];
}
//