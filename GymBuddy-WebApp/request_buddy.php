<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csc301"; // will probably have to change this

session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
	echo "your not logged in";
	exit;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql_checker = "SELECT * FROM buddies WHERE (email_one='".$_SESSION["email"]."' OR email_two='".$_SESSION["email"]."') AND (email_one='".$_POST["target"]."' OR email_two='".$_POST["target"]."')";

$sql = "INSERT INTO buddies (email_one, email_two, accepted) VALUES ('".$_SESSION["email"]."','".$_POST["target"]."', 0)";

$check = $conn->query($sql_checker);

if ($check->num_rows == 1) {
	echo "Notice: You Are already Buddies or have a pending buddy request that still needs to be accepted from ". $_POST["target"]."";
} else {
	$result = $conn->query($sql);
	
	if ($result) {
		echo "You have Successfully Sent a Request to ". $_POST["target"]."";
	} else {
		echo "something unexpected happened";
	}
}
?>