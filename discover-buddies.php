<?php

function getDistance($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
    $miles = acos($miles);
    $miles = rad2deg($miles);
    $miles = $miles * 60 * 1.1515;
    $kilometers = $miles * 1.609344;
    return $kilometers;
}




$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csc301"; // will probably have to change this

session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
	echo "your not logged in";
	exit;
}

echo "<tr><th>Email</th><th>FirstName</th><th>LastName</th></tr>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM pref WHERE pref.email='".$_SESSION["email"]."'"; // finds logged in user's saved prefrences
$get_sched =  "SELECT schedule FROM users WHERE users.email='".$_SESSION["email"]."'";

$pref_result = $conn->query($sql);
$pref_sched = $conn->query($get_sched);

if ($pref_result->num_rows == 1 && $pref_sched->num_rows == 1) { // There prefrences exist

	$pref_row = $pref_result->fetch_assoc();
	$pref_email_loc = explode(",",$pref_row["pref_location"]);
	$pref_lat = $pref_email_loc[0];
	$pref_long = $pref_email_loc[1];
	$pref_range = $pref_row["proximity"];
  $pref_row_two = $pref_sched->fetch_assoc();

	// matches users that are in the age limit and are of the required gender
	$base_sql = "SELECT email, first, last FROM users WHERE users.my_age >=". $pref_row["start_age"]." AND users.my_age <=". $pref_row["end_age"]." AND users.gender='".$pref_row["sex"]."' AND users.schedule='".$pref_row_two["schedule"]."' AND users.email!='".$_SESSION["email"]."'";
	$get_loc =  "SELECT base.email, p.pref_location FROM (".$base_sql.") AS base JOIN pref AS p ON base.email=p.email";

	$name_distance = [];
	if ($result=$conn->query($get_loc))
  {
  // Get field information for all fields
  while ($fieldinfo=$result->fetch_assoc())
    {
		$hold_points=explode(",",$fieldinfo["pref_location"]);
		$lat_point=$hold_points[0];
		$long_point=$hold_points[1];
		$res=getDistance((float)$lat_point,(float)$long_point,(float)$pref_lat,(float)$pref_long);
		$name_distance[$fieldinfo["email"]]=$res;
    }
  mysqli_free_result($result);
}

foreach ($name_distance as $key => $val){
    if($val > $pref_range){
			$name_distance[$key]=NULL;
		}
}

$final_emails=[];
foreach ($name_distance as $keyy => $vall) {
    if($vall !== NULL){
			array_push($final_emails,"'".$keyy."'");
		}
}

	$location_sql = "SELECT base.email, base.first, base.last FROM (".$base_sql.") AS base WHERE base.email IN (".implode(',',$final_emails).")";

	$result = $conn->query($location_sql);

	if ($pref_row["stat"] == "Similar to mine") {
		$personal_stat_sql = "SELECT * FROM stats WHERE stats.email='".$_SESSION["email"]."'";

		$pers_stats = $conn->query($personal_stat_sql);

		if ($pers_stats->num_rows == 1) {

			$pers_row = $pers_stats->fetch_assoc();
			$stat_sql = "SELECT * FROM (".$location_sql.") AS local JOIN stats AS s ON local.email=s.email";

			$other_stats = $conn->query($stat_sql);

			// personal stats

			$per_bench = explode(",", $pers_row["bench_press"]);
			$per_squat = explode(",", $pers_row["squat"]);
			$per_dead = explode(",", $pers_row["dead_lift"]);
			$per_shoulder = explode(",", $pers_row["shoulder_press"]);
			$per_ver_rows = explode(",", $pers_row["rows"]);
			$per_lat_pull = explode(",", $pers_row["lateral_pulldown"]);
			$per_lat_raise = explode(",", $pers_row["lateral_raise"]);
			$per_leg_press = explode(",", $pers_row["leg_press"]);
			$per_incline = explode(",", $pers_row["incline_bench"]);
			$per_decline = explode(",", $pers_row["decline_bench"]);
			$per_cable = explode(",", $pers_row["cable_crunch"]);
			$per_curls = explode(",", $pers_row["curls"]);
			$per_tricep = explode(",", $pers_row["tricep_extension"]);

			$per_exercises = array($per_bench, $per_squat, $per_dead, $per_shoulder,
					$per_ver_rows, $per_lat_pull, $per_lat_raise, $per_incline, $per_decline,
					$per_cable, $per_curls, $per_tricep);

			while ($row = $other_stats->fetch_assoc()) {
				// explode strings
				$bench = explode(",", $row["bench_press"]);
				$squat = explode(",", $row["squat"]);
				$dead = explode(",", $row["dead_lift"]);
				$shoulder = explode(",", $row["shoulder_press"]);
				$ver_rows = explode(",", $row["rows"]);
				$lat_pull = explode(",", $row["lateral_pulldown"]);
				$lat_raise = explode(",", $row["lateral_raise"]);
				$leg_press = explode(",", $row["leg_press"]);
				$incline = explode(",", $row["incline_bench"]);
				$decline = explode(",", $row["decline_bench"]);
				$cable = explode(",", $row["cable_crunch"]);
				$curls = explode(",", $row["curls"]);
				$tricep = explode(",", $row["tricep_extension"]);

				$exercises = array($bench, $squat, $dead, $shoulder,
						$ver_rows, $lat_pull, $lat_raise, $incline,
						$decline, $cable, $curls, $tricep);

				for ($i = 0; $i < count($exercises); $i++) {
					if ($exercises[$i][0] != 0 && $per_exercises[$i][0]) {
						if ($exercises[$i][0] <= ($per_exercises[$i][0] + 20) && ($per_exercises[$i][0] - 20) <= $exercises[$i][0]) {
							echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>".$row["email"]."</td><td>".$row["first"]."</td><td>".$row["last"]."</td><td><form role=\"form\" class=\"buddy_request\" name=\"buddy_request\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row["email"]."\"><input type=\"submit\" value=\"Send Request\" ></form></td></tr>";
							break;
						}

					}
				}

			}
		} else {
			echo "No Stats found for this account";
		}


	} else {
		while($row = $result->fetch_assoc()) {
			echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>".$row["email"]."</td><td>".$row["first"]."</td><td>".$row["last"]."</td><td><form role=\"form\" class=\"buddy_request\" name=\"buddy_request\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row["email"]."\"><input type=\"submit\" value=\"Send Request\" ></form></td></tr>";
		}
	}

}





mysqli_close($conn);


?>
