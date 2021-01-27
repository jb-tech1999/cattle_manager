<?php
    //inculde config file
    require_once "config.php";

    //define Variables and initialize with empty values
    $name = $surname = $email = $cell = $password = $check_pass = '';
    $name_err = $surname_err = $email_err = $cell_err = $password_err = $check_pass_err = '';
    
    //Processing form data when for is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        //validate email
        if(empty(trim($_POST["Email"]))){
            $name_err = 'Please enter your Email.';
        }else{
            //Prepare statement
            $sql = 'SELECT id from users WHERE email = ?';

            if ($stmt = $mysqli->prepare($sql)){
                //bind variables to the prepared statement
                $stmt->bind_param('s', $param_email);

                //set parameters
                $param_email = trim($_POST['Email']);
            }
        }
    }
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
        <h1 class="brand animate__animated animate__heartBeat">Cattle Manager</h1>
        <div class="wrapper" >
            <div class="insert animate__animated animate__bounceInLeft" >
               <form action="register.php" method="post" >
                    <p>
                        <input type="text" name="Name" placeholder="Name">
                    </p>
                    <p>
                        <input type="text" name="Surname" placeholder="Surname">
                    </p>
                    <p>
                        <input type="email" name="Email" placeholder="Email">
                    </p>
                    <p>
                        <input type="text" name="Cell" placeholder="Cell Number">
                    </p>
                    <p>
                        <input type="password"  name="password" placeholder="Password">
                    </p>
                    <p>
                        <input type="password" name="check_pass" placeholder="Re-enter Password">
                    </p>
                    <p>
                        <input type="submit" name="submit"  class="full" value="Sign up">
                    </p>
               </form> 
            </div>
        </div>

    </div>
</body>
</html>