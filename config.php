<?php
    //Adding database credentials

   // $link = mysqli_connect('localhost', 'root', '' , 'cattle_manager');
    $mysqli = new mysqli('localhost', 'root', '' , 'cattle_manager');

    //check connection
    if ($mysqli === false){
        die("Error: Could not connect. " . mysqli_connect_error());
    }


?>