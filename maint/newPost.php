<?php
include_once(__DIR__ . "/../../php/dbvalues.php");

$dbpass = htmlspecialchars($_POST['dbPassword']);


// Create connection
$con = new mysqli($dbhost, $dbusername, $dbpass, $dbname);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error . "\r\n");
}


$heading = mysqli_real_escape_string($con, $_POST['postName']);
$post = mysqli_real_escape_string($con, $_POST['postText']);

if ($heading == "")
	die("Error: Header \"postName\" missing from posted data \r\n\r\n");
	
if ($post == "")
	die("Error: Post Content \"postText\" missing from posted data \r\n\r\n");

$sql = "INSERT INTO `PostTestPosts` (`Heading`, `Content`)
VALUES ('$heading', '$post')";

if ($con->query($sql) === TRUE) {
    echo "New record created successfully \r\n\r\n";
} else {
    echo "Error: " . $sql . "\r\n" . $con->error . "\r\n\r\n";
}

?>