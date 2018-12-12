<?php
session_start();
error_reporting(0);
include('dbcon.php');

if(strlen($_SESSION['slogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
    {

if((isset($_POST["xsrf"]) && $_POST["xsrf"] == $_SESSION["xsrfValue"]))
        {//start xsrf check


$rollid=$_SESSION['slogin'];

$Password = $_POST['Password'];

 if (count($errors) == 0) {
        
            $querySalt = "SELECT salt FROM tblstudents where RollId = :rollid";
            $stmtSalt = $dbh->prepare($querySalt);
             $stmtSalt->bindParam(':rollid', $rollid);
            $stmtSalt->execute();
            $resultSalt =$stmtSalt->fetchAll(PDO::FETCH_ASSOC);
          //  $row->topic

            //var_dump($resultSalt);

            if(count($resultSalt) > 0){
                foreach($resultSalt as $rowsalt){
                    $salt = $rowsalt['salt'];
                }
                // var_dump($salt);
                $options = [
                    'cost' => 11,
                    'salt' =>  $salt,
                    ];//got this  for http://php.net/manual/en/function.password-hash.php

                   
            $Password = password_hash($Password, PASSWORD_BCRYPT, $options);
        }
}

// New Password Hash

$optionsb = [
                'cost' => 11,
                'salt' =>  mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
                 ];//got this random generator for http://php.net/manual/en/function.password-hash.php
        $salt = $optionsb['salt'];
        //save user to database
        //Encrypt password in db using Bcrypt hash
        if (count($errors)==0){
            $newpassword=password_hash($newpassword, PASSWORD_BCRYPT,$optionsb);
        }











    $sql ="SELECT Password FROM tblstudents WHERE RollId=:rollid and Password=:Password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':rollid', $rollid);
$query-> bindParam(':Password', $Password);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_ASSOC);
 if(count($results) > 0)
{
$con="UPDATE tblstudents SET Password=:newpassword WHERE RollId=:rollid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':rollid', $rollid);
$chngpwd1-> bindParam(':newpassword', $newpassword);
$chngpwd1->execute();
$msg="Your Password succesfully changed";

// Activity logging

 $ipaddress=$_SERVER['REMOTE_ADDR'];
                             //   $status=0;
                                $role = "student";
                                $date =  date('m/d/Y h:i:s a', time());

                                $event = "Password change Successful";
                              //  $usernameForDb = $_POST['username'];
                           
                                $stmt = $dbh->prepare("insert into tbllogs (Role,RollID,IPaddress,Event,date) values(:role,:rollid,:ipaddress,:event,:date_posted)");

                             $stmt->bindParam(":role", $role);
                             $stmt->bindParam(":rollid",$rollid);
                             $stmt->bindParam(":ipaddress", $ipaddress);
                             $stmt->bindParam(":date_posted", $date);

                             $stmt->bindParam(":event", $event);

                             $stmt->execute();

}
else {
$error="Your current password is wrong"; 

// Activity logging

 $ipaddress=$_SERVER['REMOTE_ADDR'];
                             //   $status=0;
                                $role = "student";
                                $date =  date('m/d/Y h:i:s a', time());

                                $event = "Password change failed";
                              //  $usernameForDb = $_POST['username'];
                           
                                $stmt = $dbh->prepare("insert into tbllogs (Role,RollID,IPaddress,Event,date) values(:role,:rollid,:ipaddress,:event,:date_posted)");

                             $stmt->bindParam(":role", $role);
                             $stmt->bindParam(":rollid",$rollid);
                             $stmt->bindParam(":ipaddress", $ipaddress);
                             $stmt->bindParam(":date_posted", $date);

                             $stmt->bindParam(":event", $event);

                             $stmt->execute();


  
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
        <title>Admin change password</title>
        
        <link rel="stylesheet" href="css/bootstrap.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > <!-- USED FOR DEMO HELP - YOU CAN REMOVE IT -->
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
        <script type="text/javascript">
function valid()
{
if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
{
alert("New Password and Confirm Password Field do not match  !!");
document.chngpwd.confirmpassword.focus();
return false;
}
return true;
}
</script>
         <style>
        .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
        </style>
    </head>
    <body class="top-navbar-fixed">
        <div class="main-wrapper">
            <?php include('includes/stopbar.php');?>   
            <div class="content-wrapper">
                <div class="content-container">
<?php include('includes/sleftbar.php');?>                   
 <!-- /.left-sidebar -->

                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Student Change Password</h2>
                                 
                                </div>
                                
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
            							<li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
            						
            							<li class="active">Student change password</li>
            						</ul>
                                </div>
                               
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.container-fluid -->

                        <section class="section">
                            <div class="container-fluid">

                             

                              

                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Student Change Password</h5>
                                                </div>
                                            </div>
           <?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
  
                                            <div class="panel-body">

                                                <form  name="chngpwd" method="post" \ onSubmit="return valid();">
                                                    <div class="form-group has-success">
                                                        <label for="success" class="control-label">Current Password</label>
                                                		<div class="">
                                    <input type="password" name="Password" class="form-control" required="required" id="success">
                                                      
                                                		</div>
                                                	</div>
                                                       <div class="form-group has-success">
                                                        <label for="success" class="control-label">New Password</label>
                                                        <div class="">
                                                            <input type="password" name="newpassword" required="required" class="form-control" id="success">
                                                        </div>
                                                    </div>
                                                     <div class="form-group has-success">
                                                        <label for="success" class="control-label">Confirm Password</label>
                                                        <div class="">
                                                            <input type="password" name="confirmpassword" class="form-control" required="required" id="success">
                                                        </div>
                                                    </div>
  <div class="form-group has-success">

                                                        <div class="">
                                                           <button type="submit" name="submit" class="btn btn-success btn-labeled">Change<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    </div>


                                                    
                                                </form>

                                              
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-8 col-md-offset-2 -->
                                </div>
                                <!-- /.row -->

                               
                               

                            </div>
                            <!-- /.container-fluid -->
                        </section>
                        <!-- /.section -->

                    </div>
                    <!-- /.main-page -->

                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->

        </div>
        <!-- /.main-wrapper -->

        <!-- ========== COMMON JS FILES ========== -->
        <script src="js/jquery/jquery-2.2.4.min.js"></script>
        <script src="js/jquery-ui/jquery-ui.min.js"></script>
        <script src="js/bootstrap/bootstrap.min.js"></script>
        <script src="js/pace/pace.min.js"></script>
        <script src="js/lobipanel/lobipanel.min.js"></script>
        <script src="js/iscroll/iscroll.js"></script>

        <!-- ========== PAGE JS FILES ========== -->
        <script src="js/prism/prism.js"></script>

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>



        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
    </body>
</html>
<?php  } ?>
