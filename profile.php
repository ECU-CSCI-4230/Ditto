<?php
include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Home Page</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php
$servername = "localhost";
$dbname = "Diito_Drive";
$username = "josh";
$password = "jcc15241711";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT User_ID, Username, Email FROM User WHERE User_ID=" . $_SESSION['login_user'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Name</th></tr>";
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["User_ID"] . "</td><td>" . $row["Username"] . " " . $row["Email"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
echo "<div id=\"profile\">";
echo " <b id=\"welcome\">Welcome : <i>" . $row['Username'] . "</i></b>";
echo "<b id=\"logout\"><a href=\"logout.php\">Log Out</a></b>";
echo "</div>";

$conn->close();
?>

</body>
</html>