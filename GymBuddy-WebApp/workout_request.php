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

$sql = "SELECT * FROM users WHERE email='".$_POST["target"]."'";


$result = $conn->query($sql);

$select = "<select name=\"day\">";

if ($result) {
	$row = $result->fetch_assoc();
	$days = explode(",",$row["schedule"]);
	if (in_array("Monday", $days, true)) {
		$select .= "<option value=\"Monday\">Monday</option>";
	}
	if (in_array("Tuesday", $days, true)) {
		$select .= "<option value=\"Tuesday\">Tuesday</option>";
	}
	if (in_array("Wednesday", $days, true)) {
		$select .= "<option value=\"Wednesday\">Wednesday</option>";
	}
	if (in_array("Thursday", $days, true)) {
		$select .= "<option value=\"Thursday\">Thursday</option>";
	}
	if (in_array("Friday", $days, true)) {
		$select .= "<option value=\"Friday\">Friday</option>";
	}
	if (in_array("Saturday", $days, true)) {
		$select .= "<option value=\"Saturday\">Saturday</option>";
	}
	if (in_array("Sunday", $days, true)) {
		$select .= "<option value=\"Sunday\">Sunday</option>";
	}
	
	$select .= "</select>";
	
	$exercise = "<h5>What Exercise to Focus On:</h5><select id=\"current\" name=\"exercise\">
      <option value=\"Bench_Press\">Bench Press</option>
      <option value=\"Squat\">Squat</option>
      <option value=\"Dead_Lift\">Dead Lift</option>
      <option value=\"Shoulder_Press\">Shoulder Press</option>
      <option value=\"Rows\">Rows</option>
      <option value=\"Lateral_Pulldown\">Lateral Pulldown</option>
      <option value=\"Lateral_Raise\">Lateral Raise</option>
      <option value=\"Leg_Press\">Leg Press</option>
      <option value=\"Incline_Bench\">Incline Bench</option>
      <option value=\"Decline_Bench\">Decline Bench</option>
      <option value=\"Cable_Crunch\">Cable Crunch</option>
      <option value=\"Curls\">Curls</option>
      <option value=\"Tricep_Extension\">Tricep Extension</option></select>"; 
	
	echo "<form role=\"form\" class=\"workout_form\" name=\"workout_form\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$_POST["target"]."\"><h4>Workout Request</h4><br><br><h5>Message:</h5><textarea name=\"comment\" rows=\"10\" cols=\"30\"></textarea><br><br><h5>Days Available:</h5>".$select."<br><br>".$exercise."<br><br><input type=\"submit\" value=\"Send Request\" ><br><br><br><button type='button' id='close_req'>CLOSE</button></form>";
} else {
	echo "something unexpected happened";
}
?>
