<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csc301"; // will probably have to change this

session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
	echo "your not logged in";
	exit;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$request_sql = "SELECT email_one FROM buddies WHERE email_two='".$_SESSION["email"]."' AND accepted=0";
$pending_sql = "SELECT email_two FROM buddies WHERE email_one='".$_SESSION["email"]."' AND accepted=0";
$tasks_sql = "SELECT * FROM scheduled_workouts WHERE email_two='".$_SESSION["email"]."' AND accepted=0";
$pending_tasks = "SELECT * FROM scheduled_workouts WHERE email_one='".$_SESSION["email"]."' AND accepted=0";

$result = $conn->query($request_sql);

$pend = $conn->query($pending_sql);

$task_result = $conn->query($tasks_sql);

$task2_result = $conn->query($pending_tasks);

while ($row = $result->fetch_assoc()) {
	$in = "SELECT * FROM users WHERE email='".$row['email_one']."'";
	$in_result = $conn->query($in);
	$in_row = $in_result->fetch_assoc();
	echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>Buddy Request</td><td>".$row['email_one']."</td><td>Age: ".$in_row['my_age']."</td><td> Gender: ".$in_row['gender']."</td><td><form role=\"form\" class=\"request\" name=\"request\" method=\"post\"><input type=\"hidden\" name=\"buddy\" value=\"".$row["email_one"]."\"><input type=\"submit\" value=\"ADD BUDDY\" ></form></td></tr>";
}

while ($pend_row = $pend->fetch_assoc()) {
	$info = "SELECT * FROM users WHERE email='".$pend_row['email_two']."'";
	$info_result = $conn->query($info);
	$info_row = $info_result->fetch_assoc();
	echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>Pending Buddy Request</td><td>".$pend_row['email_two']."</td><td> Age: ".$info_row['my_age']."</td><td> Gender: ".$info_row['gender']." </td></tr>";
}

while ($task_row = $task_result->fetch_assoc()) {
	
	echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>Workout Request</td><td>".$task_row['email_one']."</td><td>Scheduled Day: ".$task_row['day']."</td><td> Focus: ".$task_row['exercise']."</td><td> Message: ".$task_row['content']."</td><td><form role=\"form\" class=\"workout\" name=\"workout\" method=\"post\"><input type=\"hidden\" name=\"buddy\" value=\"".$task_row["email_one"]."\"><input type=\"submit\" value=\"Accept Workout\" ></form></td><td><form role=\"form\" class=\"close_task\" name=\"close_task\" method=\"post\"><input type=\"hidden\" name=\"buddy\" value=\"".$task_row["email_one"]."\"><input type=\"submit\" value=\"Decline Workout\" ></form></td></tr>";
}

while ($task2_row = $task2_result->fetch_assoc()) {

	echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>Pending Workout Request</td><td>".$task2_row['email_two']."</td><td>Scheduled Day: ".$task2_row['day']."</td><td> Focus: ".$task2_row['exercise']."</td><td> Message: ".$task2_row['content']."</td><td><form role=\"form\" class=\"close_task\" name=\"close_task\" method=\"post\"><input type=\"hidden\" name=\"buddy\" value=\"".$task2_row["email_two"]."\"><input type=\"submit\" value=\"Remove Workout\" ></form></td></tr>";
}


?>