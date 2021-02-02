<?php
    //Adding database credentials
    //Fill in your own credentials
   // $link = mysqli_connect('host', 'user', 'password' , 'database');
    $mysqli = new mysqli('localhost', 'root', '' , 'cattle_manager');
    $con = mysql_connect('localhost', 'root', '' , 'cattle_manager');
  

    //check connection
    if ($mysqli === false){
        die("Error: Could not connect. " . mysqli_connect_error());
    }

?>