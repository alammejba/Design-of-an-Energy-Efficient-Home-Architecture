<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "iot";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

$device = $_GET["device"];

$rowexists = "SELECT * FROM $device WHERE `date` = CURDATE()";
$rowexistsresult = $conn->query($rowexists);

if ($rowexistsresult->num_rows > 0) {
	// output data of each row
	$currentdata = $rowexistsresult->fetch_assoc();
	$newdata = $currentdata["consumed"]+$_GET["consumed"];
	$updatedata = "UPDATE $device SET consumed=$newdata WHERE `date`=CURDATE()";
	$conn->query($updatedata);
} else {
	$zeroinsert = "INSERT INTO $device (consumed, `date`) VALUES (0, CURDATE())";
	if ($conn->query($zeroinsert) === TRUE) {
		$currentdata = $rowexistsresult->fetch_assoc();
		$newdata = $currentdata["consumed"]+$_GET["consumed"];
		$updatedata = "UPDATE $device SET consumed=$newdata WHERE `date`=CURDATE()";
		$conn->query($updatedata);
	}
}

?>