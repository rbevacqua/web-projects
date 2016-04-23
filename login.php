<?php
$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
$email= $_POST['email'];
$pass = $_POST['pass'];
$qry = "SELECT first FROM users WHERE email='$email' AND password='$pass'"; 
$result = mysqli_query($connect,$qry);
$cnt=mysqli_num_rows($result);
if($cnt == 1){
	session_start();
	$_SESSION["email"] = $email;
	header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/profile.html");
	die();
	

	
} else{
	
	header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/login_failed.html");
				die();
	
	
}

mysqli_close($connect);

?>