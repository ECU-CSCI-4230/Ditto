<?php
// Initiate connection to database

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'josh');
define('DB_PASSWORD', 'jcc15241711');
define('DB_NAME', 'Ditto_Drive');

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

