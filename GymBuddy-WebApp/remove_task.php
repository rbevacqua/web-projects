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

$sql = "DELETE FROM scheduled_workouts WHERE (email_one='".$_POST["buddy"]."' AND email_two='".$_SESSION["email"]."') OR (email_one='".$_SESSION["email"]."' AND email_two='".$_POST["buddy"]."')";

$result = $conn->query($sql);

if ($result) {
	echo "<center><p>You have Succefully removed Workout Schedule ".$_POST["buddy"]."</p></center>";
} else {
	echo "<center><p>Failed to remove Workout</p></center>";
}
?>