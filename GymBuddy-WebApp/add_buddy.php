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

$sql = "UPDATE buddies SET accepted=1 WHERE email_one='".$_POST["buddy"]."' AND email_two='".$_SESSION["email"]."'";

$result = $conn->query($sql);

if ($result) {
	echo "<center><p>You have Succefully Added Your New Buddy ".$_POST["buddy"]."</p></center>";
} else {
	echo "<center><p>Failed to Add Buddy</p></center>";
}
?>