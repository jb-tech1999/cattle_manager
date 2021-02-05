<?php
    session_start();



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cattle Manager</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <div class="container">
    <div class="header">
        <h1 class="brand animate__animated animate__heartBeat">Cattle Manager</h1>
        
    </div>
        <div class="wrapper" >
            <div class="insert animate__animated animate__bounceInLeft" >
               <form action="test.php" method="post" >
                    <p><h3 class="brand animate__animated animate__heartBeat"><?php echo 'Welcome, ' . $_SESSION['name'];?></h3></p>
                    <p>
                        <input type="text" name="Number" placeholder="Animal Number">
                        <?php echo $number_err; ?>     
                    </p>
                    <p><textarea name="info"  cols="40" rows="5" class="full"></textarea> </p>

                    <p>
                        <input type="submit" name="submit" value="Save" class="full">
                    </p>
                    <p>
                        <input type="submit" name="export" class="full" value="Export">
                    </p>
                    
                   
               </form> 
               
            </div>
            
        </div>
        
    </div>
    <a href="logout.php">Logout</a>
</body>
</html>