<?php
    session_start();

    //include config file
    require_once("config.php");


    $email = $_SESSION['email'];
    $password = $password_check = '';
    $password_err = $password_check_err = '';

    if ($_POST['submit']){
               //validate password
            if (empty(trim($_POST['password']))){
                $password_err = "Please eneter a password";
            }elseif(strlen(trim($_POST['password'])) < 6){
                $password_err = "Password must have atleast 6 characters";
            }else{
                $password = trim($_POST['password']);
                
            } 
            //validate confirm password
             if (empty(trim($_POST['check_password']))){
                $password_check_err = "Please confirm password";
            }else{
                $password_check = trim($_POST['check_password']);
           
                if (empty($password_err) && ($password != $password_check)){
                    $password_check_err = "Passwords did not match";
            }
        }

        if(empty($password_err) && empty($password_check_err)){
            $sql = "UPDATE users SET password = ? where email = '$email'";

            if ($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param('s', $param_password);

                $param_password = password_hash($password, PASSWORD_DEFAULT); //Creates a password hash

                if ($stmt->execute()){
                    $to = $email;
                    $subject = "Password reset";
                    $message = "Your password has been reset";
                    $headers = "From: Jandé <jandre@cattle-manager.co.za>\r\n";
                    $headers .= "Reply-To: jandre@cattle-manager.co.za\r\n";
                    mail($to, $subject, $message, $headers);
                    header('location: index.php');
                }else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            //close statement
            $stmt->close();
        
        }
        $mysqli->close();
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
               <form action="reset_password.php" method="post" >
               <h3 class="brand animate__animated animate__heartBeat">Reset password</h3>
                    <p>
                         <input type="password"  name="password" placeholder="Password">
                        <?php echo $password_err;?> 
                    </p>
                    <p>
                        <input type="password"  name="check_password" placeholder="Confim Password">
                        <?php echo $password_check_err;?>
                    </p>
                    <p>
                        <input type="submit" name="submit"  class="full" value="Reset">
                    </p>

               </form> 
            </div>
        </div>

    </div>
</body>
</html>