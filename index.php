<?php
include_once(__DIR__ . "/../php/dbvalues.php");

	

// Create connection
$con = new mysqli($dbhost, $dbusername, $dbpasswd, $dbname);
// Check connection
if ($con->connect_error) {
    //die("Connection failed: " . $con->connect_error);
}

$month = mysqli_real_escape_string($con, $_GET['month']);

if ($month == "")
	$month = "316";

$postCounts = "SELECT `Date`, DATE_FORMAT(`Date`, '%M %Y') AS month, DATE_FORMAT(`Date`, '%c%y') AS monthNum, COUNT(*) FROM `Posts` GROUP BY month ORDER BY `Date`";
$postResult = $con->query($postCounts);


echo 	"<html lang=en-us>
	 <head>
	 <LINK REL=StyleSheet HREF=\"/style.css?v=1.1\" TYPE=\"text/css\" MEDIA=screen>
	 </head>";
	 
/*echo 	"<body id=\"background\">
	 <div id=\"header\">
		<div style=\"width:18%;
			float:left;\">
			<img src=\"/images/PeaceCorps-Logo2.jpg\" style=\"height:100%;vertical-align: bottom;\"/>
			<h1 style=\"font-size: 28px; margin-bottom: 0; padding-bottom: 0; \">Mark in Mozambique</h1>
			<p style=\"margin-top: 0; padding-top: 0; \"><a href=\"mailto:mark@markinmozambique.com\">Mark@MarkInMozambique.com</a></p>
		</div>
		
		<div style=\"margin-left:20%;\">
			<img src=\"/images/header.jpg\" style=\"height:100%;width:100%;vertical-align: bottom;\"/>
		</div>
	 </div>

	 <div id=\"sidebar\">";
*/

echo 	"<body id=\"background\">
	 <div id=\"header\">
			<img src=\"/images/PeaceCorps-Logo3.jpg\" style=\"width:100%;vertical-align: bottom;\"/>
		</div>
	 </div>

	 <div id=\"sidebar\">";

if ($postResult->num_rows > 0) 
{

	echo "<h2>Previous Posts: </h2>
	      <ul>";

	while($row = $postResult->fetch_assoc()) 
	{
		echo "<li><a href=\"/index.php?month=" . $row["monthNum"] . "\">" . $row["month"] . "(". $row["COUNT(*)"] . ")</a></li>";
	}
}
	 	
echo	"</ul>
	 <img src=\"/images/map.jpg\" id=\"map\" style=\"margin-left:-10px;\"/>
	 <p style=\"font-style: italic;\">The contents of this website are my personal opinions and writings and do not reflect the position of the U.S. government or the Peace Corps.

Unless otherwise noted all posts and images on this website are licensed under Creative Commons CC BY-SA. Any software and source code are licensed GPLv3</p>
	 </div>
	 <div id=\"content\">";
	 
	 
$postDisp = "SELECT DATE_FORMAT(`Date`, '%c-%e-%Y') AS calDate, `Heading`, `Content`, `ID`, DATE_FORMAT(`Date`, '%c%y') AS month FROM `Posts` Having month = " . $month . " ORDER BY `ID` DESC";
$postResult = $con->query($postDisp);
$curPost = "";

if ($postResult->num_rows > 0) 
{
	echo "<ul id=\"posts\">";

	while($row = $postResult->fetch_assoc()) 
	{
		echo "<li class=\"post\">";
		$curPost = $row["ID"];
	 
		echo 	"<h2>" . $row["Heading"] . "</h2>" .
			"<h3>" . $row["calDate"] . "</h3>" .
			"<p>"  . $row["Content"] . "</p>";
		 
		$commentDisp = "SELECT `Name`, `Email`, `Comment`, `PostID`, DATE_FORMAT(`ComDate`, '%c-%e-%Y') AS comDate, `Display` FROM `Comments` WHERE `PostID`='" . $curPost . "'";
		$comResult = $con->query($commentDisp);
		
		echo "<ul class=\"commentList\">";
		if ($comResult->num_rows > 0) 
		{
			while($row = $comResult->fetch_assoc()) 
			{
	 			echo 	"<ul class=\"comment\">"		.
	 				 	"<li class=\"commentHead\">"  	.
					 	 $row["Name"]			.
						"</li>"				.
						"<li class=\"commentHead\">"	.
						 $row["comDate"] 		. 
						"</li>" 			.
						"<li class=\"commentCont\">"	.
					 	$row["Comment"] 		. 
					 	"</li>" 			.
					 "</ul>";
		
			}
		}	
		
		($posted = htmlspecialchars($_GET['posted']) === $curPost) ? $disableSub = 1 : $disableSub = 0;
			
		$thanksMsg = "";
		
		echo 	'Comment on this post:<form class="comment" enctype="multipart/form-data" method="post" name="comForm"'; echo "  action=\"./comForm.php?post=" . $curPost . "&url=" .  $_SERVER['REQUEST_URI'] . "\">";
		echo	'<input class="comInput" maxlength="50" name="comName" placeholder="Name" type="text" /> 
			 <input class="comInput" maxlength="80" name="comEmail" placeholder="Email (Won\'t be displayed)" type="text"/> <br>
			 <textarea class="comText" name="comPost" placeholder="Comment" required">'; if ($disableSub) echo $thanksMsg;
			 
		echo	'</textarea> <br><br> <input class="comInput" type="submit" value="Submit" '; if ($disableSub) echo "disabled"; 
		
		echo	"/></form>
			 </ul>
		</li>";
	}
	echo "</ul>";
}
echo "</div>";

?>

