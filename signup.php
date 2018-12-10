<?php 
// DB credentials.
$server='localhost';
$root='root';
$password='';
$db='srms';
// Establish database connection.
$dbh = new mysqli($server, $root, $password, $db);
if (isset($_POST['submit']))
  {
    $studentname = $_POST['fullname'];
    $roolid = $_POST['rollid'];
    
    $studentemail = $_POST['email'];
    $dob = $_POST['dob'];
    $Pass = $_POST['Password'];
    $RPassword = $_POST['RPassword'];
    $gender = $_POST['gender'];
    $status='1';

      
    

    //Password check
 
      $Passwo=password_hash($Pass, PASSWORD_BCRYPT);
	$sql= "INSERT INTO tblstudents (`StudentName`, `RollId`, `StudentEmail`, `Gender`,` DOB`, `Status`,` Password`)
     VALUES ($studentname,$roolid,$studentemail,$gender,$dob,$status,$Passwo)";
	if($dbh->query($sql)===TRUE){
		echo "New record created successfully";
	}else{
		echo "Error";
    }
  }

?>