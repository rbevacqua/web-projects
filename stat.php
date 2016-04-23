<?php
session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
echo "wow";
exit;
}
else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];
	$exer = str_replace(" ", "_",$_POST['current']);

	$weight = $_POST['weight'];
	$reps = $_POST['reps'];
	$insert_me = $weight . "," . $reps;
	$sqll = "UPDATE stats SET $exer = '$insert_me' where email = '$email'";
	$qry = "SELECT * FROM stats WHERE email='$email'";
	$result = mysqli_query($connect,$qry);
	$zero="0,0";
	$cnt=mysqli_num_rows($result);
	if($cnt == 0){
		$sql = "INSERT INTO stats(bench_press,squat,dead_lift,shoulder_press,rows,lateral_pulldown,lateral_raise,
		leg_press,incline_bench,decline_bench,cable_crunch,curls,tricep_extension,email) VALUES('$zero','$zero','$zero','$zero','$zero','$zero','$zero','$zero'
		,'$zero','$zero','$zero','$zero','$zero','$email')";
		if(mysqli_query($connect,$sql)){
			
			if(mysqli_query($connect,$sqll)){
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/stats_success.html");
				die();
			} else{
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
				die();
			}
		}else{
			header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
				die();
		}



	}else{
		if(mysqli_query($connect,$sqll)){
				
				header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/stats_success.html");
				echo "You have updated successfully";
				die();
		} else{
			header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
				die();
		}
	}
}




?>