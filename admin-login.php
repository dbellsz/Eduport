<?php
    session_start();
    $errors=array();


    include('dbcon.php');
    // if($_SESSION['alogin']!=''){
    // $_SESSION['alogin']='';
    // }

    $salt = "";
    if(isset($_POST['login']))
    {
        $rollid = $_POST['rollid'];
        $Password= $_POST['Password'];



        //password encrption n check
        if (count($errors) == 0) {
        
            $querySalt = "SELECT salt FROM admin where RollId = :rollid";
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
        /*try {
   */

    $query = "SELECT * FROM admin WHERE RollId= :rollid AND Password= :Password";
    
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(':rollid', $rollid);
            $stmt->bindParam(':Password', $Password);
            $stmt->execute();
            $result =$stmt->fetchAll(PDO::FETCH_ASSOC);

 /*           echo "New record created successfully";
            echo $salt;
            echo $Password;
    }
catch(PDOException $e)
    {
    echo $query . "<br>" . $e->getMessage();
    }*/

                      

     if(count($result) > 0)
    {
    $_SESSION['alogin']=$_POST['rollid'];


     $ipaddress=$_SERVER['REMOTE_ADDR'];
                             //   $status=0;
                                $role = "admin";
                                $date =  date('m/d/Y h:i:s a', time());

                                $event = "Login Successful";
                              //  $usernameForDb = $_POST['username'];
                           
                                $stmt = $dbh->prepare("insert into tbllogs (Role,RollID,IPaddress,Event,date) values(:role,:rollid,:ipaddress,:event,:date_posted)");

                             $stmt->bindParam(":role", $role);
                             $stmt->bindParam(":rollid",$rollid);
                             $stmt->bindParam(":ipaddress", $ipaddress);
                             $stmt->bindParam(":date_posted", $date);

                             $stmt->bindParam(":event", $event);

                             $stmt->execute();


    echo "<script type='text/javascript'> document.location = 'dashboard.php'; </script>";
    } else{
        
        echo "<script>alert('Invalid Details');</script>";



//  EVENT LOGS START
                                $ipaddress=$_SERVER['REMOTE_ADDR'];
                             //   $status=0;
                                $role = "admin";
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

//EVENT LOGS END




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
        <title>Admin Login</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" > 
        <link rel="stylesheet" href="css/main.css" media="screen" >
        <script src="js/modernizr/modernizr.min.js"></script>
    </head>
    <body class="">

  <nav class="navbar top-navbar bg-white box-shadow">
                <div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header no-padding">
                            <a padding="50%" align="center" class="navbar-brand" href="index.php">
                                                    EDUPORT | School Portal
                            </a>
                        </div>
                   
                        </div>
                    </div>
                </nav>

        <div class="main-wrapper">

            
 <!-- <h1 align="center">EDUPORT</h1> -->
          
                    
                        <section class="section">
                            <div class="row mt-40">
                                <div class="col-md-10 col-md-offset-1 pt-50">

                                    <div class="row mt-30 ">
                                       
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <div class="panel-title text-center">
                                                        <h4>Admin Login</h4>
                                                    </div>
                                                </div>
                                                <div class="panel-body p-20">
<!-- 
                                                    <div class="section-title">
                                                        <p class="sub-title">Student Result Management System</p>
                                                    </div> -->

                                                    <form class="form-horizontal" method="post">
                                                    	<div class="form-group">
                                                    		<label for="inputEmail3" class="col-sm-2 control-label"> ID</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="text" name="rollid" class="form-control" id="inputEmail3" placeholder="UserName" pattern="([a])([d])([m])([0-9])([0-9])([0-9])([0-9])">
                                                    		</div>
                                                    	</div>
                                                    	<div class="form-group">
                                                    		<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                                                    		<div class="col-sm-10">
                                                    			<input type="password" name="Password" class="form-control" id="inputPassword3" placeholder="Password">
                                                    		</div>
                                                    	</div>
                                                    
                                                        <div class="form-group mt-20">
                                                    		<div class="col-sm-offset-2 col-sm-10">
                                                           
                                                    			<button type="submit" name="login" class="btn btn-success btn-labeled pull-right">Sign in<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                                    		</div>
                                                    	</div>
                                                    </form>

                                            

                                                 
                                                </div>
                                            </div>
                                            <!-- /.panel -->
                                           <p class="text-muted text-center"><small>Copyright © Dbellsz<a href="http://Linkedin.com/gbadebobellos"></a> 2018</small></p>
                           
                                        <!-- /.col-md-11 -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col-md-12 -->
                            </div>
                            <!-- /.row -->
                        </section>

                    <!-- /.col-md-6 -->
            

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

        <!-- ========== THEME JS ========== -->
        <script src="js/main.js"></script>
        <script>
            $(function(){

            });
        </script>

        <!-- ========== ADD custom.js FILE BELOW WITH YOUR CHANGES ========== -->
 
    </body>
</html>