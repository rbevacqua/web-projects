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

$qry = "SELECT * FROM users WHERE email='".$_POST["target"]."'";

$result = $conn->query($qry);

if ($row = $result->fetch_assoc()) {
	echo "<table><tbody><tr><th></th><th></th></tr>
	<tr><td>Firstname:</td><td>".$row["first"]."</td></tr>
	<tr><td>Lastname:</td><td>".$row["last"]."</td></tr>
	<tr><td>Age:</td><td>".$row["my_age"]."</td></tr>
	<tr><td>Gender:</td><td>".$row["gender"]."</td></tr>
	<tr><td>Bio:</td><td>".$row["bio"]."</td></tr>
	<tr><td><button type='button' id='close'>CLOSE</button></td></tr></tbody></table>";
}
?>