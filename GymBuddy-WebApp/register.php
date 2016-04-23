<?php
$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
$first= $_POST['first_name'];
$last = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['sex'];
$age = $_POST['age'];
$password_confirmation = $_POST['password_confirmation'];
if(empty($first) || empty($password) || empty($email) || empty($last) || empty($gender) || empty($age) ){
    header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
			die();
}else{
	$checker= "SELECT * from users where first='$first' and last='$last' and email='$email' ";
	$res=mysqli_query($connect,$checker);
	$num=mysqli_num_rows($res);
	if($num == 1){
		header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/register_failed.html");
				die();
	}else{
		$sql = "INSERT INTO users(first,last,my_age,gender,email,password) VALUES('$first','$last','$age','$gender','$email','$password')";
		if(mysqli_query($connect,$sql)){
			header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/register_success.html");
			die();
			
			
		} else{
			header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/failed.html");
			die();

			
		}
	}
}
mysqli_close($connect);

?>

?>