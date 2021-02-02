<?php
    session_start();
    include_once("config.php");
    
    //set error variables
    $email_err = '';


     if ($_POST['submit']){
        if (empty(trim($_POST['email']))){
            $email_err = "Please enter your email.";
        }else{
            $email = trim($_POST['email']);
        }

        if (empty($email_err)){
            $sql = "SELECT email FROM users where email = ?";

            if($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param('s', $param_email);

                $param_email = $email;

                if($stmt->execute()){
                    $stmt->store_result();  

                    if ($stmt->num_rows == 1){
                        $to = $email;
                        $subject = "Password reset";
                        $message = "Hi, please follow the link to reset your password. https://cattle-manager.co.za/reset_password.php";
                        $headers = "From: Jandé <jandre@cattle-manager.co.za>\r\n";
                        $headers .= "Reply-To: jandre@cattle-manager.co.za\r\n";
                        $_SESSION['email'] = $email;
                        mail($to, $subject, $message, $headers); 
                        echo '<script type="text/javascript">';
                        echo ' alert("Email has been sent to your account.")';
                        echo '</script>';  
                    }else{
                        $email_err = "No account with this email could be found.";
                        header('location: register.php');
                    }
                }
            }
            //close statement
            $stmt->close();
        }

        //close connection
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
               <form action="mail.php" method="post" >
                    <p>
                        <input type="email" name="email" placeholder="Email" value="">
                        <?php echo $email_err;?>
                    </p>
                    <p>
                        <input type="submit" name="submit"  class="full" value="Reset password">
                    </p>
               </form> 
            </div>
        </div>

    </div>
</body>
</html>