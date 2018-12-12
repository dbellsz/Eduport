<?php	

/*	$db = mysqli_connect('localhost', 'root','','eduport');

	// check database connection

	if (mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: ";  
  	}

  	else {
 		echo "Connection Succesful";
 	}
*/


 	//connecting the mysql server
    $DSN ="mysql:host=localhost;dbname=eduport";
    $usernamedb="root";
    $passworddb="";
    $dbh=new PDO ($DSN,$usernamedb,$passworddb);

   /* if (!$db)
        {
        $e ='Could not connect: '. mysql_error();

        }

    else
        {
        $e = "connected successfully";
        }
*/


//         $db = new mysqli("localhost", "root", "", "eduport");

// /* check connection */
// if (mysqli_connect_errno()) {
//     printf("Connect failed: %s\n", mysqli_connect_error());
//     exit();
// }

 ?>



