<?php
    //initialize session
    session_start();

    //check if user is already logged in
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
        header('location: test.php');
        exit;
    }

    //include config file
    require_once "config.php";

    //define variables and initialze empty
    $email = $password = '';
    $email_err = $password_err = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        //check if email is empty
        if (empty(trim($_POST['email']))){
            $email_err = "Please enter your email.";
        }else{
            $email = trim($_POST['email']);
        }

        //check is password is empty
        if (empty(trim($_POST['password']))){
            $password_err = "Please enter your password";
        }else{
            $password = trim($_POST['password']);
        }

        //validate credentials
        if (empty($email_err) && empty($password_err)){
            //prepare statement

            $sql = 'SELECT userID, name, email, password FROM users WHERE email = ?';

            if ($stmt = $mysqli->prepare($sql)){
                //Bind variables to the prepared statement as parameters

                $stmt->bind_param('s', $param_email);

                //set parameters
                $param_email = $email;

                //Attempt to execute prepared statement
                if ($stmt->execute()){
                    //store result
                    $stmt->store_result();
                    //check if email exists, if yes, verify password
                    if ($stmt->num_rows == 1){
                        //bind result variables
                        $stmt->bind_result($userID, $name, $email, $hased_password);
                        if ($stmt->fetch()){
                            if (password_verify($password, $hased_password)){

                                $to = $email;
                                $subject = "Recent log in";
                                $message = "Hi, " . $name . " you've just logged in to your cattle-manager account.";
                                $headers = "From: Jandé <jandre@cattle-manager.co.za>\r\n";
                                $headers .= "Reply-To: jandre@cattle-manager.co.za\r\n";
                                mail($to, $subject, $message, $headers);
                                //password correct, start new session
                                session_start();
                                $_SESSION['loggedin'] = true;
                                $_SESSION['id'] = $userID;
                                $_SESSION['name'] = $name;
                                //redirect to test page
                                header('location: test.php');
                            }else{
                                //password entered is not valid
                                $password_err = 'The password you have entered is not valid';
                            }
                        }
                    }else{
                        $email_err = "No account with this email address could be found.";
                        header('location: register.php');
                    }
                }else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                //close statement
                $stmt->close();
            }
        }
        //close ceonnection
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
               <form action="index.php" method="post" >
                    <p>
                        <input type="email" name="email" placeholder="Email" value="<?php if (empty($_SESSION['email'])){echo "";}else{echo $_SESSION['email'];}?>">
                        <?php echo $email_err;?>
                    </p>
                    <p>
                        <input type="password"  name="password" placeholder="Password">
                        <?php echo $password_err;?>
                    </p>
                    <p>
                        <input type="submit" name="submit"  class="full" value="Login">
                    </p>
                    <p>Don't have an account? <a href="register.php">Click here</a></p>
               </form> 
            </div>
        </div>

    </div>
</body>
</html>