<?php
include_once(__DIR__ . "/../../php/dbvalues.php");

$dbpass = htmlspecialchars($_POST['dbPassword']);


// Create connection
$con = new mysqli($dbhost, $dbusername, $dbpass, $dbname);
// Check connection
if ($con->connect_error) {
	die("Connection failed: " . $con->connect_error . "\r\n");
}


$checkAfterDate = mysqli_real_escape_string($con, $_POST['date']);

if ($checkAfterDate == "")
	die("Error: Comments since \"date\" missing from posted data: \r\n Format: YYYY-MM-DD \r\n\r\n");
	
$sql = "SELECT * FROM `Comments` WHERE `ComDate` >= '" . $checkAfterDate . "'";


$result = $con->query($sql);

/*if (($result = $con->query($sql)) === TRUE) {
	echo "No errors running comment retrieval query \r\n\r\n";
} else {
	die ("Error: " . $sql . "\r\n" . $con->error . "\r\n\r\n");
}*/

if ($result->num_rows > 0)
{
	while($row = $result->fetch_assoc()) 
	{
		echo 	"ID :" . $row['ID'] . " - Comment Date :" . $row['ComDate'] . " - Disp :" . $row['Display'] . "\r\n" 	. 
			"Name :" . $row['Name'] . " - Email :" . $row['Email'] . "\r\n" 							.
			"Posted to : " . $row['postID'] . "\r\n\r\n"							.
			$row['Comment'] . "\r\n\r\n\r\n";
	}
		
}

else
	echo "No comments since " . $checkAfterDate . "\r\n\r\n";

?>