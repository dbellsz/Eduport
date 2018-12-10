<?php
session_start(); 
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 60*60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
unset($_SESSION['login']);
session_destroy(); // destroy session
header("location:index.php"); 



// Activity logging

 $ipaddress=$_SERVER['REMOTE_ADDR'];
                             //   $status=0;
                                $role = "student";
                                $date =  date('m/d/Y h:i:s a', time());

                                $event = "Student Logout";
                              //  $usernameForDb = $_POST['username'];
                           
                                $stmt = $dbh->prepare("insert into tbllogs (Role,RollID,IPaddress,Event,date) values(:role,:rollid,:ipaddress,:event,:date_posted)");

                             $stmt->bindParam(":role", $role);
                             $stmt->bindParam(":rollid",$rollid);
                             $stmt->bindParam(":ipaddress", $ipaddress);
                             $stmt->bindParam(":date_posted", $date);

                             $stmt->bindParam(":event", $event);

                             $stmt->execute();

?>

