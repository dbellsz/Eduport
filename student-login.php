<?php 
    session_start();
    unset($_SESSION['LAST_ACTIVITY']);
    $errors=array();

?>

<?php //include('includes/config.php') ?>
<?php include('dbcon.php') ?>


<?php
    
    if (isset($_POST['login']))
    {

        $rollid = $_POST['rollid'];
        $Password= $_POST['Password'];




        //password encrption n check
        if (count($errors) == 0) 
        {
        
            $querySalt = "select salt FROM tblstudents where RollId = :rollid";
            $stmtSalt = $dbh->prepare($querySalt);
             $stmtSalt->bindParam(':rollid', $rollid);
            $stmtSalt->execute();
            $resultSalt =$stmtSalt->fetchAll(PDO::FETCH_ASSOC);
          //  $row->topic

            //var_dump($resultSalt);

            if(count($resultSalt) > 0)
            {
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


    $query = "select * FROM tblstudents where RollId= :rollid AND Password= :Password";
    
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':rollid', $rollid);
            $stmt->bindParam(':Password', $Password);
            $stmt->execute();
            $result =$stmt->fetchAll(PDO::FETCH_OBJ);
           
                //        $result =$stmt->fetchAll(PDO::FETCH_ ASSOC);



            

            if(count($result) > 0)
           // Log User
            {
            $_SESSION['slogin']=$rollid;
            $_SESSION['xsrfValue'] = md5(uniqid(mt_rand(), true));;

            echo "<script type='text/javascript'> document.location = 'student-dashboard.php'; </script>";
            } else
            {
                


   // $host  = $_SERVER['HTTP_HOST'];
                              //  $_SESSION['username']=$_POST['username'];
                                $ipaddress=$_SERVER['REMOTE_ADDR'];
                             //   $status=0;
                                $role = "student";
                                $date =  date('m/d/Y h:i:s a', time());

                                $event = "Login Failed";
                              //  $usernameForDb = $_POST['username'];
                           
                                $stmt = $dbh->prepare("insert into tbllogs (Role,RollID,IPaddress,Event,date) values(:role,:rollid,:ipaddress,:event,:date_posted)");

                             $stmt->bindParam(":role", $role);
                             $stmt->bindParam(":rollid",$rollid);
                             $stmt->bindParam(":ipaddress", $ipaddress);
                             $stmt->bindParam(":date_posted", $date);

                             $stmt->bindParam(":event", $event);

                             $stmt->execute();











                echo "<script>alert('Invalid Details');</script>";




        }

                }
}


?>



<?php include('cscdn.php') ?>
<?php include('jscdn.php') ?>


<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="register.css">
<script type="text/javascript" src="static/jquery-ui.min"></script>

<head>

	<title >Student Login</title>
</head>
<body>
	


<!-- Default form login -->
<form class="text-center border border-light p-5" method="POST" action="index.php">

	<?php include('error.php');

if(isset($_SESSION['timeouterr']))
{
echo $_SESSION['timeouterr'];
}
    ?>



    <p class="h4 mb-4">Sign in</p>

    <!-- Email -->
    <input type="text" id="defaultLoginFormEmail" class="form-control mb-4" placeholder="Student Roll ID" name="rollid" required>

    <!-- Password -->
    <input type="password" id="defaultLoginFormPassword" class="form-control mb-4" placeholder="Password" name="Password" required>

    <div class="d-flex justify-content-around">
       
        <div>
            <!-- Forgot password -->
           <!--  <a href="">Forgot password?</a> -->
        </div>
    </div>

    <!-- Sign in button -->
    <button class="btn btn-info btn-block my-4" type="submit"  name="login">Sign in</button>

    <!-- Register -->
    <p>New here?
        <a href="student-register.php">Register</a>
    </p>


</form>
<!-- Default form login -->

</body>
</html>