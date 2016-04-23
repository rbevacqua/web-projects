<?php
session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
echo "your not logged in";
exit;
}else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];
	$qry = "SELECT * FROM scheduled_workouts WHERE email_one='$email' AND accepted=1";
	$qry2 = "SELECT * FROM scheduled_workouts WHERE email_two='$email' AND accepted=1";
	$result = mysqli_query($connect,$qry);
	$result2 = mysqli_query($connect,$qry2);
	
	echo "<tr><th>Email</th><th>Firstname</th><th>Lastname</th><th>Day To Workout</th><th>Exercise Focus</th><th>Description</th><th></th></tr>";
	
	$r = "";
	while ($row = $result->fetch_assoc()) {
		
		$e = $row['email_two'];
		
		$sql = "SELECT * FROM users WHERE email='$e'";
		$res = $connect->query($sql);
		$res_row = $res->fetch_assoc();
		
		$r .= "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>".$res_row["email"]."</td>";
		$r .= "<td>".$res_row['first']."</td>";
		$r .= "<td>".$res_row['last']."</td>";
		
		$r .= "<td>".$row['day']."</td>";
		$r .= "<td>".$row['exercise']."</td>";
		$r .= "<td>".$row['content']."</td><td><form role=\"form\" class=\"remove_form\" name=\"remove_form\" method=\"post\"><input type=\"hidden\" name=\"buddy\" value=\"".$res_row['email']."\"><input type=\"submit\" value=\"Remove Task\" ></form></td></tr>";
		
	}
	
	while ($row2 = $result2->fetch_assoc()) {
		
		$sql2 = "SELECT * FROM users WHERE email='".$row2['email_one']."'";
		
		$res2 = $connect->query($sql2);
		$res2_row = $res2->fetch_assoc();
		
		$r .= "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>".$res2_row["email"]."</td>";
		$r .= "<td>".$res2_row['first']."</td>";
		$r .= "<td>".$res2_row['last']."</td>";
		$r .= "<td>".$row2['day']."</td>";
		$r .= "<td>".$row2['exercise']."</td>";
		$r .= "<td>".$row2['content']."</td><td><form role=\"form\" class=\"remove_form\" name=\"remove_form\" method=\"post\"><input type=\"hidden\" name=\"buddy\" value=\"".$res2_row['email']."\"><input type=\"submit\" value=\"Remove Task\" ></form></td></tr>";
	}
	
	if ($r === "") {
		echo "<tr><td><h6>No Workouts Scheduled</h6></td></tr>";
	} else {
		echo $r;
	}

}




?>