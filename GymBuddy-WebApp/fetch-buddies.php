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

echo "<tr><th>Email</th><th>Firstname</th><th>Lastname</th><th></th><th></th></tr>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// This query will only return Buddies of AlisonRuns1994, We will have to change this by using $_SESSION['User'] when logged in
$sql = "SELECT email, first, last FROM users INNER JOIN buddies ON buddies.email_two=users.email WHERE buddies.email_one='".$_SESSION["email"]."' AND buddies.accepted=1";
$sql2 = "SELECT email, first, last FROM users INNER JOIN buddies ON buddies.email_one=users.email WHERE buddies.email_two='".$_SESSION["email"]."' AND buddies.accepted=1";
$result = $conn->query($sql);
$result2 = $conn->query($sql2);

if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>".$row["email"]."</td><td>".$row["first"]."</td><td>".$row["last"]."</td><td><form role=\"form\" class=\"buddy_profile\" name=\"buddy_profile\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row["email"]."\"><input type=\"submit\" value=\"Check Profile\" ></form></td><td><form role=\"form\" class=\"buddy_stat\" name=\"buddy_stat\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row["email"]."\"><input type=\"submit\" value=\"Check Stats\" ></form></td><td><form role=\"form\" class=\"workout_req\" name=\"workout_req\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row["email"]."\"><input type=\"submit\" value=\"Send Workout Request\" ></form></td></tr>";
	}
} 

if ($result2->num_rows > 0) {
	while($row2 = $result2->fetch_assoc()) {
		echo "<tr style=\"border-width:5px;border-bottom-style:groove;\"><td>".$row2["email"]."</td><td>".$row2["first"]."</td><td>".$row2["last"]."</td><td><form role=\"form\" class=\"buddy_profile\" name=\"buddy_profile\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row2["email"]."\"><input type=\"submit\" value=\"Check Profile\" ></form></td><td><form role=\"form\" class=\"buddy_stat\" name=\"buddy_stat\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row2["email"]."\"><input type=\"submit\" value=\"Check Stats\" ></form></td><td><form role=\"form\" class=\"workout_req\" name=\"workout_req\" method=\"post\"><input type=\"hidden\" name=\"target\" value=\"".$row2["email"]."\"><input type=\"submit\" value=\"Send Workout Request\" ></form></td></tr>";
	}
}

if ($result2->num_rows == 0 && $result->num_rows == 0){
	echo "<tr><td>No Buddies Available</td></tr>";
}
?>
