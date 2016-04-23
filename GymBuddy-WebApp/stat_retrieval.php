<?php

session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
	echo "your not logged in";
	exit;
}else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_POST["target"];
	$qry = "SELECT * FROM stats WHERE email='$email'";
	$result = mysqli_query($connect,$qry);
	
	$row = $result->fetch_assoc();
	
	
	$bench_press = explode(",",$row["bench_press"]);
	$squats = explode(",",$row["squat"]);
	$dead = explode(",",$row["dead_lift"]);
	$shoulder = explode(",",$row["shoulder_press"]);
	$rows = explode(",",$row["rows"]);
	$pulldown = explode(",",$row["lateral_pulldown"]);
	$raise = explode(",",$row["lateral_raise"]);
	$leg_press = explode(",",$row["leg_press"]);
	$incline = explode(",",$row["incline_bench"]);
	$decline = explode(",",$row["decline_bench"]);
	$cable = explode(",",$row["cable_crunch"]);
	$curls = explode(",",$row["curls"]);
	$extension = explode(",",$row["tricep_extension"]);
	
	echo "<table><tr><th>Exercise</th><th>Weight</th><th>Reps</th></tr>";

	if (isset($row["bench_press"])) {
		echo "<tr><td>Bench Press</td><td>".$bench_press[0]." lb</td><td>".$bench_press[1]."</td></tr>";
	}
	if (isset($row["squat"])) {
		echo "<tr><td>Squats</td><td>".$squats[0]." lb</td><td>".$squats[1]."</td></tr>";
	}
	if (isset($row["dead_lift"])) {
		echo "<tr><td>Dead Lift</td><td>".$dead[0]." lb</td><td>".$dead[1]."</td></tr>";
	}
	if (isset($row["shoulder_press"])) {
		echo "<tr><td>Shoulder Press</td><td>".$shoulder[0]." lb</td><td>".$shoulder[1]."</td></tr>";
	}
	if (isset($row["rows"])) {
		echo "<tr><td>Rows</td><td>".$rows[0]." lb</td><td>".$rows[1]."</td></tr>";
	}
	if (isset($row["lateral_pulldown"])) {
		echo "<tr><td>Lateral Pulldown</td><td>".$pulldown[0]." lb</td><td>".$pulldown[1]."</td></tr>";
	}
	if (isset($row["lateral_raise"])) {
		echo "<tr><td>Lateral Raise</td><td>".$raise[0]." lb</td><td>".$raise[1]."</td></tr>";
	}
	if (isset($row["leg_press"])) {
		echo "<tr><td>Leg Press</td><td>".$leg_press[0]." lb</td><td>".$leg_press[1]."</td></tr>";
	}
	if (isset($row["incline_bench"])) {
		echo "<tr><td>Incline Bench</td><td>".$incline[0]." lb</td><td>".$incline[1]."</td></tr>";
	}
	if (isset($row["decline_bench"])) {
		echo "<tr><td>Decline Bench</td><td>".$decline[0]." lb</td><td>".$decline[1]."</td></tr>";
	}
	if (isset($row["cable_crunch"])) {
		echo "<tr><td>Cable Crunches</td><td>".$cable[0]." lb</td><td>".$cable[1]."</td></tr>";
	}
	if (isset($row["curls"])) {
		echo "<tr><td>Bicep Curls</td><td>".$curls[0]." lb</td><td>".$curls[1]."</td></tr>";
	}
	if (isset($row["tricep_extension"])) {
		echo "<tr><td>Tricep Extensions</td><td>".$extension[0]." lb</td><td>".$extension[1]."</td></tr>";
	}
	echo "<tr><td><button type='button' id='close'>CLOSE</button></td></tr></tbody></table>";
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}




?>