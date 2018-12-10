<?php 
  session_start();
  $Stdid="";
  $email="";
  $errors=array();

?>
<?php include('cscdn.php') ?>
<?php include('jscdn.php') ?>
<?php include('dbcon.php') ?>

<?php

error_reporting(E_ALL);
  ini_set("display_errors", 1);

  // if the register button is clicked
  // Escape variables for security to prevent xss
  if (isset($_POST['submit']))
  {
    $studentname = $_POST['fullname'];
    $roolid = $_POST['rollid'];
    $classid = $_POST['stclass'];
    $studentemail = $_POST['email'];
    $dob = $_POST['dob'];
    $Password = $_POST['Password'];
    $RPassword = $_POST['RPassword'];
    $gender = $_POST['gender'];
   

      
    

    //Password check

    if ($Password != $RPassword){
      array_push($errors, "Passwords do not match");
    }

    //user exist check



    else{





      $options = [
        'cost' => 11,
        'salt' =>  mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
         ];//got this random generator for http://php.net/manual/en/function.password-hash.php
    $salt = $options['salt'];
    //save user to database
    //Encrypt password in db using Bcrypt hash
    if (count($errors)==0){
      $Password=password_hash($Password, PASSWORD_BCRYPT,$options);
    

     /* $sql="INSERT INTO  tblstudents (StudentName,RollId,StudentEmail,Gender, DOB,ClassId,Status,Password,salt) 
        VALUES (:studentname,:roolid,:studentemail,:gender,:dob,:classid,:status,:Password,:salt)";*/
/*$sql= "INSERT INTO tblstudents (StudentName, RollId, StudentEmail, Gender, DOB, ClassId, RegDate, Status, Password, salt) VALUES ($studentname,$roolid,$studentemail,$gen
der,$dob,$classid,$status,$Password,$salt);";
*/   


    $queryRollId = "select * FROM tblstudents where Rollid = :rollid AND StudentEmail= :studentemail";
    
            $stmtRoll = $dbh->prepare($queryRollId);
            $stmtRoll->bindParam(':rollid', $roolid);
            $stmtRoll->bindParam(':studentemail', $studentemail);
  


            $stmtRoll->execute();
            $resultRoll = $stmtRoll->fetchAll(PDO::FETCH_ASSOC);

            if(count($resultRoll) > 0)

            {
  
              $msg = "Invalid Registration Data";
              echo $msg;
            
            }

else{

  try {
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql="INSERT INTO  tblstudents (StudentName,StudentEmail,RollId,Gender, DOB,ClassId,Password,salt) 
        VALUES (:studentname,:studentemail,:rollid,:gender,:dob,:classid,:Password,:salt)";

        $query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname);
$query->bindParam(':rollid',$roolid);
$query->bindParam(':studentemail',$studentemail);
$query->bindParam(':gender',$gender);
$query->bindParam(':dob',$dob);
$query->bindParam(':classid',$classid);
$query->bindParam(':Password',$Password);
$query->bindParam(':salt',$salt);

  

    // use exec() because no results are returned
    $query->execute();
    $msg="Registration Successful";
    echo $msg;

//Get New RollID
$studentname = $_POST['fullname'];
    $roolid = $_POST['rollid'];
    $classid = $_POST['stclass'];
    $studentemail = $_POST['email'];
    $dob = $_POST['dob'];
    $Password = $_POST['Password'];
    $RPassword = $_POST['RPassword'];
    $gender = $_POST['gender'];









   //  echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    }
catch(PDOException $e)
    {
      echo "oops!! there was an error";
    echo $sql . "<br>" . $e->getMessage();
    }




 /*    $_SESSION['Stdid'] = $Stdid;*/
      $_SESSION['success'] = "You are now Registered.";
     // header('location:student-login.php'); //go back to homepage
    }
      }
        
      else {
        echo "Registration Failed !!!";
      }
    }
   }
 
  

  ?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Edit Student < </title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/select2/select2.min.css" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/
<script type="text/javascript"> 
		$(document).ready(function() {
		 $('.mdb-select').materialSelect();
		});
</script>
<script>
  				$( function() {
 				   $( "#datepicker" ).datepicker();
 					 } );
 </script>

</head>


	
<body>

   <nav class="navbar top-navbar bg-white box-shadow">
                <div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header no-padding">
                            <a align="center" class="navbar-brand" href="index.php">
                                                    EDUPORT | School Portal
                            </a>
                        </div>
                    </div>
                     <div class="row">
            </div>
        </div>
    </nav>
<!-- Default form register -->
<form class="text-center border border-light p-5" action="student-register.php" method="POST">

        	<?php include('error.php')?>

    <p class="h4 mb-4">Register</p>

    <div class="form-row mb-4">
        <div class="col">
            <!-- First name -->
            <input type="text" id="defaultRegisterFormFirstName" class="form-control" name="fullname" placeholder="Full Name" required>
        </div>
        <div class="col">
            <!-- Roll id -->
            <input type="text" id="defaultRegisterFormLastName" class="form-control" name="rollid" placeholder="Student Roll" maxlength="7" autocomplete="off" pattern="([s])([t])([d])([0-9])([0-9])([0-9])([0-9])" required>
        </div>
    </div>

    <!-- E-mail -->
    <input type="email" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Email Address" name="email" required>

    <!-- Password -->
    <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="Password" minlength="10" required>
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        1 Upper case, 1 Lower case and at least 8 characters and 1 digit
    </small>

       <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Re-enter Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="RPassword" required>
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        Must be the same as above
    </small>

      <!-- Default inline 1-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input" value="Male" id="defaultInline1" name="gender">
			  <label class="custom-control-label" for="defaultInline1">Male</label>
			</div>

			<!-- Default inline 2-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input" value="Female" id="defaultInline2" name="gender">
			  <label class="custom-control-label" for="defaultInline2">Female</label>
			</div>

			</br>
	
          
      <select name="stclass" class="form-control" id="default" required="required">
        <option value="">Select Class</option>
        <?php $sql = "SELECT * from tblclasses";
        $query = $dbh->prepare($sql);
        $query->execute();
        $results=$query->fetchAll(PDO::FETCH_OBJ);
        if($query->rowCount() > 0)
        {
        foreach($results as $result)
        {   ?>
        <option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>
        <?php }} ?>
    </select>
     

      <div class="form-group">
          <label for="date" class="col-sm-2 control-label">DOB</label>
             <div class="col-sm-10">
             <input type="date"  name="dob" class="form-control" id="date">
             </div>
       </div>
                                                      

    <button class="btn btn-info my-4 btn-block" type="submit" name="submit">Sign up</button>

     <!-- Terms of service -->
    <p>By clicking
        <em>Sign up</em> you agree to our
        <a href="" target="_blank">terms of service</a> and
        <a href="" target="_blank">terms of service</a>. </p>

</form>
<!-- Default form register -->