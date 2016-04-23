<?php
session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
echo "wow";
exit;
}
else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];

	$exer='';
	if(!empty($_POST['myexer'])){
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['myexer'] as $selected){
			$exer .= $selected . ',';
		}
	}
	$set='';
	if(!empty($_POST['myset'])){
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['myset'] as $selected){
			$set .= (String)$selected . ',';
		}
	}
	$rep='';
	if(!empty($_POST['myreps'])){
		// Loop to store and display values of individual checked checkbox.
		foreach($_POST['myreps'] as $selected){
			$rep .= (String)$selected . ',';
		}
	}
	
	
	
	$qry = "SELECT * FROM routine WHERE email='$email'";
	$result = mysqli_query($connect,$qry);
	$cnt=mysqli_num_rows($result);
	if($cnt==1){
		$row = $result->fetch_assoc();
		$exerr=explode(",",rtrim($row["exercises"], ","));
		$sets=explode(",",rtrim($row["sets"], ","));
		$reps=explode(",",rtrim($row["reps"], ","));
		
		$in_exer=explode(",",rtrim($exer,","));
		$in_set=explode(",",rtrim($set,","));
		$in_rep=explode(",",rtrim($rep,","));
		

		foreach($in_exer as $selected){
			if(in_array($selected,$exerr)){
				$index=array_search($selected, $exerr);
				$indexx=array_search($selected, $in_exer);
				$sets[$index]=$in_set[$indexx];
				$reps[$index]=$in_rep[$indexx];
			}else{
				$index=array_search($selected, $in_exer);
				array_push($exerr,$selected);
				array_push($sets,$in_set[$index]);
				array_push($reps,$in_rep[$index]);
			}
		}
		$impld_exer=implode(",",$exerr) . ',';
		$impld_sets=implode(",",$sets) . ',';
		$impld_reps=implode(",",$reps) . ',';
		$sqll = "UPDATE routine SET exercises = '$impld_exer',sets = '$impld_sets',reps = '$impld_reps' where email = '$email'";
		if(mysqli_query($connect,$sqll)){
				echo "your routine has been updated";
		} else{
			echo "could not update routine";
		}
	}
	if($cnt == 0){
		$sql = "INSERT INTO routine(exercises,sets,reps,email) VALUES('$exer','$set','$rep','$email')";
		if(mysqli_query($connect,$sql)){
			echo "Your routine has been saved";
		}else{
			echo "could add your routine";
		}
	}
}




?>