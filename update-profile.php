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

$sched='';
$list = array();

if(!empty($_POST['day'])){
	// Loop to store and display values of individual checked checkbox.
	foreach($_POST['day'] as $selected){
		array_push($list,$selected);
	}
	
	$sched = implode(",",$list);
}

// Used to check if entries are set and if an entry is not, then it won't be updated
$check_sql = "SELECT * FROM users WHERE email='".$_SESSION["email"]."'";

$check = $conn->query($check_sql);

$first = $_POST['firstname'];
$last = $_POST['lastname'];
$gender = $_POST['sex'];
$age = $_POST['age'];
$bio = $_POST['biography'];

if ($check_row = $check->fetch_assoc()) {
	if (empty($first)) {
		$first = $check_row['first'];
	}
	if (empty($last)) {
		$last = $check_row['last'];
	}
	if (empty($gender)) {
		$gender = $check_row['gender'];
	}
	if (empty($age)) {
		$age = $check_row['my_age'];
	}
	if (empty(trim($bio))) {
		$bio = $check_row['bio'];
	}
	if (empty($_POST['day'])) {
		$sched = $check_row['schedule'];
	}
	
}

$sql = "UPDATE users SET first='".$first."', last='".$last."', gender='" .$gender. "', my_age='".$age."', bio='".$bio."', schedule='$sched' WHERE email='".$_SESSION["email"]."'";



if ($conn->query($sql) == TRUE) {
	header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/profile_success.html");
			die();
} else {
	header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
			die();
}

mysqli_close($conn);
?>
