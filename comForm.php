<?php
include_once(__DIR__ . "/../php/dbvalues.php");

// Create connection
$con = new mysqli($dbhost, $dbusername, $dbpasswd, $dbname);
// Check connection
if ($con->connect_error) {
    //die("Connection failed: " . $con->connect_error);
}

$retUrl = htmlspecialchars($_GET['url']);
$postNum = htmlspecialchars($_GET['post']);
$name = mysqli_real_escape_string($con, $_POST['comName']);
$email = mysqli_real_escape_string($con, $_POST['comEmail']);
$comment = mysqli_real_escape_string($con, $_POST['comPost']);
	
$sql = "INSERT INTO `Comments` (`Name`, `Email`, `Comment`, `PostID` )
VALUES ('$name', '$email', '$comment' , '$postNum')";

if ($con->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    //echo "Error: " . $sql . "<br>" . $con->error;
}

if (strpos($retUrl, '?') !== FALSE)
	header("Location: " . $retUrl . "&posted=" . $postNum);
else
	header("Location: " . $retUrl . "?posted=" . $postNum);
	
?>