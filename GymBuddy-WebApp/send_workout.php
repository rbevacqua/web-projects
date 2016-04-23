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

$sql_checker = "SELECT * FROM scheduled_workouts WHERE (email_one='".$_SESSION["email"]."' OR email_two='".$_SESSION["email"]."') AND (email_one='".$_POST["target"]."' OR email_two='".$_POST["target"]."')";

$sql = "INSERT INTO scheduled_workouts (email_one, email_two, day, content, exercise, accepted) VALUES ('".$_SESSION["email"]."','".$_POST["target"]."','".$_POST["day"]."','".$_POST["comment"]."','".$_POST["exercise"]."', 0)";

$check = $conn->query($sql_checker);

if ($check->num_rows == 1) {
	echo "Notice: You Are already have a scheduled workout day with this buddy first remove the previous one to add new workout day for ". $_POST["target"]."";
} else {
	$result = $conn->query($sql);
	
	if ($result) {
		echo "<p>You have Successfully Sent a Request to ". $_POST["target"]."</p>";
	} else {
		echo "<p>something unexpected happened</p>";
	}
}
?>