<?php
// this file exists just to test database connection with mysqli
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'josh');
define('DB_PASSWORD', 'jcc15241711');
define('DB_NAME', 'Ditto_Drive');
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}