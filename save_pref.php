<?php
session_start();
if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    echo("you arent logged in, please log in to continue");
}else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];
	$sex = $_POST['sex'];
	$street_addr = $_POST['gym_address'];
	$country = $_POST['country'];
	$city = $_POST['city'];
	$code = $_POST['code'];
	$stats=$_POST['stats'];
	$start_age=$_POST['start_age'];
	$end_age=$_POST['end_age'];
  $proximity=$_POST['proximity'];
	$full_addr = $street_addr . "," . $city . "," . $code . "," . $country;
	$Address = urlencode($full_addr);
	$request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=".$Address."&sensor=true";
	$xml = simplexml_load_file($request_url) or die("url not loading");
	$status = $xml->status;
	
	//Here is where I will check if entries are empty before saving prefrences
	
	$check_empty_sql = "SELECT * FROM pref WHERE email='$email'";
	
	$check_result = $connect->query($check_empty_sql);
	
	if ($check_row = $check_result->fetch_assoc()) {
		if (empty($sex)) {
			$sex = $check_row['sex'];
		}
		if (empty($stats)) {
			$stats = $check_row['stat'];
		}
		if (empty($start_age) || $start_age === 0) {
			$start_age = $check_row['sex'];
		}
		if (empty($end_age) || $end_age === 0) {
			$end_age = $check_row['sex'];
		}
		if (empty($proximity)) {
			$proximity = $check_row['proximity'];
		}
		if (empty($code)||empty($country)||empty($street_addr)||empty($city)) {
			$LatLng = $check_row['pref_location'];
		}
	}



	$qry = "SELECT * FROM pref WHERE email='$email'";
	$num_result = mysqli_query($connect, $qry);

	if ($status=="OK") {
		$Lat = $xml->result->geometry->location->lat;
		$Lon = $xml->result->geometry->location->lng;
		$LatLng = "$Lat,$Lon";

		if ($num_result->num_rows == 0) {

			$sql = "INSERT INTO pref(email,sex,stat,start_age,end_age,pref_location,proximity) VALUES('$email','$sex','$stats','$start_age','$end_age','$LatLng','$proximity')";
			$result = mysqli_query($connect,$sql);
			if($result){
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/pref_success.html");
				die();
			} else{
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
				die();

			}
		} else {
			$sql = "UPDATE pref SET sex='$sex', stat='$stats',start_age='$start_age',end_age='$end_age',pref_location='$LatLng',proximity='$proximity' WHERE email='$email'";
			$result = mysqli_query($connect,$sql);
			if($result){
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/pref_success.html");
				die();
			} else{
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
				die();
		}
	}

}
}


?>
