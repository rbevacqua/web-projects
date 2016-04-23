<?php
session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
echo "your not logged in";
exit;
}else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];
	$qry = "SELECT * FROM users WHERE email='$email'";
	$result = mysqli_query($connect,$qry);

	$row = $result->fetch_assoc();
	echo "<tr><td>Firstname:</td><td>".$row["first"]."</td></tr>";
	echo "<tr><td>Lastname:</td><td>".$row["last"]."</td></tr>";
	echo "<tr><td>Age:</td><td>".$row["my_age"]."</td></tr>";
	echo "<tr><td>Gender:</td><td>".$row["gender"]."</td></tr>";
	echo "<tr><td>Bio:</td><td>".$row["bio"]."</td></tr>";

}




?>