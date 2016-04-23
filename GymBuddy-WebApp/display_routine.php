<?php

class exercise
{
    public $name;
	public $num_set;
	public $num_rep;
	
    public function __construct($namee,$setss,$repps)
    {
        $this->name = (string)$namee;
		$this->num_set=(string)$setss;
		$this->num_rep=(string)$repps;
    }




}


session_start();
if (!(isset($_SESSION["email"]) && $_SESSION["email"] != '')) {
echo "your not logged in";
exit;
}else{
	$connect=mysqli_connect('localhost','root','','csc301') or die("could not connect to database");
	$email= $_SESSION["email"];
	$qry = "SELECT * FROM routine WHERE email='$email'";
	$result = mysqli_query($connect,$qry);
	$row = $result->fetch_assoc();
	$exer=explode(",",rtrim($row["exercises"], ","));
	$sets=explode(",",rtrim($row["sets"], ","));
	$reps=explode(",",rtrim($row["reps"], ","));
	
	$exerss=array();
	$sizz=0;
	$wut=count($exer);
	
	
	while($sizz!=$wut){
		array_push($exerss,new exercise($exer[$sizz],$sets[$sizz],$reps[$sizz]));
		$sizz++;
	}
	echo '<table>';

	foreach($exerss as $ex){
	
	   echo '<tr><td>', $ex->name, '</td>
			 <td>    Sets:', $ex->num_set, '</td>
			 <td>    Reps:', $ex->num_rep, '</td></tr>';
	}

	echo '</table>';
	
	
}


?>