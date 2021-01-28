<?php
    //Adding database credentials

   // $link = mysqli_connect('localhost', 'root', '' , 'cattle_manager');
    $mysqli = new mysqli('localhost', 'root', '' , 'cattle_manager');
   // $mysqli = new mysqli('iwhost10.axxesslocal.co.za', ' jcjhkynr_jandre', '' , 'jcjhkynr_cattle_manager');

    //check connection
    if ($mysqli === false){
        die("Error: Could not connect. " . mysqli_connect_error());
    }

?>