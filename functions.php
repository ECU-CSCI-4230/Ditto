<?php
$conn = mysqli_connect("localhost", "josh", "jcc15241711", "Ditto_Drive");

if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$username = $_SESSION['login_username'];
$selectedpath = "";

/*
 * loadfileexplorer adds each file owned by the user to their respective folder views(explorers).
 */

function loadShareExplorer($conn)
{
    $text = "<script>";

    $stmtFSE =
        "SELECT *
    FROM File
        JOIN
          (
          SELECT 
            FileShare.File_ID,
            f.User_ID AS Recip,
            FileShare.User_ID AS Shared
          FROM
            FileShare
            JOIN 
              (
              SELECT *
              FROM
                FileShare
              WHERE
                Permission = 2
              ) AS f 
            ON f.File_ID = FileShare.File_ID
          WHERE
            FileShare.Permission = 1
            AND FileShare.User_ID = " . $_SESSION['login_user'] . "
          ) AS Shared 
        ON File.File_ID = Shared.File_ID
        JOIN
        User ON User.User_ID = Recip;";

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
            $recip = $resFSE['Username'];


            $lenFS = strlen($filenameFS);
            $posFS = strrpos($filenameFS, '/');
            $filenameFS = substr($filenameFS, $posFS - $lenFS + 1);

            $foldernameFS = "#FS";

            //echo '<li class="list-group-item file-desc">' . $filename . '</li>';
            $text .= "addfiletoexplorer3('" . $foldernameFS . "','" . $filenameFS . "','" . $filetypeFS . "','" .
                $lastmodFS . "','" . $sizeFS . "','" . $filePathFS . "','" . $fileID . "','" . $recip . "');";
        }
    }

    echo $text . '</script>';
}

//