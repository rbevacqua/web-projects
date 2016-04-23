<?php

session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
	echo "your not logged in";
	exit;
}else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];
	$qry = "SELECT * FROM stats WHERE email='$email'";
	$result = mysqli_query($connect,$qry);
	
	//start Table of Stats
	echo "<tr><th>Exercise</th><th>Weight</th><th>Reps</th></tr>";
	
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

	echo "<tr><td>Bench Press</td><td>".$bench_press[0]." lb</td><td>".$bench_press[1]."</td></tr>";
	echo "<tr><td>Squats</td><td>".$squats[0]." lb</td><td>".$squats[1]."</td></tr>";
	echo "<tr><td>Dead Lift</td><td>".$dead[0]." lb</td><td>".$dead[1]."</td></tr>";
	echo "<tr><td>Shoulder Press</td><td>".$shoulder[0]." lb</td><td>".$shoulder[1]."</td></tr>";
	echo "<tr><td>Rows</td><td>".$rows[0]." lb</td><td>".$rows[1]."</td></tr>";
	echo "<tr><td>Lateral Pulldown</td><td>".$pulldown[0]." lb</td><td>".$pulldown[1]."</td></tr>";
	echo "<tr><td>Lateral Raise</td><td>".$raise[0]." lb</td><td>".$raise[1]."</td></tr>";
	echo "<tr><td>Leg Press</td><td>".$leg_press[0]." lb</td><td>".$leg_press[1]."</td></tr>";
	echo "<tr><td>Incline Bench</td><td>".$incline[0]." lb</td><td>".$incline[1]."</td></tr>";
	echo "<tr><td>Decline Bench</td><td>".$decline[0]." lb</td><td>".$decline[1]."</td></tr>";
	echo "<tr><td>Cable Crunches</td><td>".$cable[0]." lb</td><td>".$cable[1]."</td></tr>";
	echo "<tr><td>Bicep Curls</td><td>".$curls[0]." lb</td><td>".$curls[1]."</td></tr>";
	echo "<tr><td>Tricep Extensions</td><td>".$extension[0]." lb</td><td>".$extension[1]."</td></tr>";
}




?>