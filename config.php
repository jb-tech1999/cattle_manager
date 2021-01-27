<?php
    //Adding database credentials

    $link = mysqli_connect('localhost', 'root', '' , 'cattle_manager');

    //check connection
    if ($link === false){
        die("Error: Could not connect. " . mysqli_connect_error());
    }


?>