
<?php 
  session_start();
  $Stdid="";
  $email="";
  $errors=array();

?>
<?php include('cscdn.php') ?>
<?php include('jscdn.php') ?>
<?php include('includes/config.php');?>

<?php

error_reporting(E_ALL);
  ini_set("display_errors", 1);

  // if the register button is clicked
  // Escape variables for security to prevent xss
  if (isset($_POST['reg-submit'])){
    $studentname = $_POST['fullanme'];
    $roolid = $_POST['roolid'];
    $classid = $_POST['class'];
    $studentemail = $_POST['email'];
    $dob = $_POST['dob'];
    $Password = $_POST['Password'];
    $RPassword = $_POST['RPassword'];
    $gender = $_POST['gender'];
    $status=1;

      
    

    //Password check

    if ($Password != $RPassword){
      array_push($errors, "Passwords do not match");
    }




      $options = [
        'cost' => 11,
        'salt' =>  mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
         ];//got this random generator for http://php.net/manual/en/function.password-hash.php
    $salt = $options['salt'];
    //save user to database
    //Encrypt password in db using Bcrypt hash
    if (count($errors)==0){
      $Password=password_hash($Password, PASSWORD_BCRYPT,$options);
    

      $sql="INSERT INTO  tblstudents(StudentName,RollId,StudentEmail,Gender,ClassId,DOB,Status,Password,salt) VALUES(:studentname,:roolid,:studentemail,:gender,:classid,:dob,:status,:Password,:salt)";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$query->bindParam(':studentemail',$studentemail,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':Password',$Password,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':salt',$salt,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Student info added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

     $_SESSION['Stdid'] = $Stdid;
      $_SESSION['success'] = "You are now Registered.";
      header('location:student-login.php'); //go back to homepage
    }
    else {
      echo "Registration Failed !!!";
    }

  }

  ?>









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



<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>
	
<body>

<!-- Default form register -->
<form class="text-center border border-light p-5" action="student-register.php" method="POST">

        	<?php include('error.php')?>

    <p class="h4 mb-4">Register</p>

    <div class="form-row mb-4">
        <div class="col">
            <!-- First name -->
            <input type="text" id="defaultRegisterFormFirstName" class="form-control" name="fullanme" placeholder="Full Name" required>
        </div>
        <div class="col">
            <!-- Roll id -->
            <input type="text" id="defaultRegisterFormLastName" class="form-control" name="roolid" placeholder="Student Roll" maxlength="5" autocomplete="off" required>
        </div>
    </div>

    <!-- E-mail -->
    <input type="email" id="defaultRegisterFormEmail" class="form-control mb-4" placeholder="Email Address" name="emailid" required>

    <!-- Password -->
    <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="Password" required>
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        1 Upper case, 1 Lower case and at least 8 characters and 1 digit
    </small>

       <input type="password" id="defaultRegisterFormPassword" class="form-control" placeholder="Re-enter Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" name="RPassword" required>
    <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
        Must be the same as above
    </small>

      <!-- Default inline 1-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input" id="defaultInline1" name="gender">
			  <label class="custom-control-label" for="defaultInline1">Male</label>
			</div>

			<!-- Default inline 2-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input" id="defaultInline2" name="gender">
			  <label class="custom-control-label" for="defaultInline2">Female</label>
			</div>

			</br>
	
          
      <select name="class" class="form-control" id="default" required="required">
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
                                                      

    <button class="btn btn-info my-4 btn-block" type="submit" name="reg-submit">Sign up</button>

     <!-- Terms of service -->
    <p>By clicking
        <em>Sign up</em> you agree to our
        <a href="" target="_blank">terms of service</a> and
        <a href="" target="_blank">terms of service</a>. </p>

</form>
<!-- Default form register -->