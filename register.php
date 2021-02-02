<?php
    session_start();
    //inculde config file
    require_once "config.php";

    //define Variables and initialize with empty values
    $name = $surname = $email = $cell = $password = $check_pass = '';
    $name_err = $surname_err = $email_err = $cell_err = $password_err = $check_pass_err = '';
    
    //Processing form data when for is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        //validate email
        if(empty(trim($_POST["Email"]))){
            $email_err = 'Please enter your Email.';
        }else{
            //Prepare statement
            $sql = 'SELECT userID from users WHERE email = ?';

            if ($stmt = $mysqli->prepare($sql)){
               // echo "50";
                //bind variables to the prepared statement
                $stmt->bind_param('s', $param_email);

                //set parameters
                $param_email = trim($_POST['Email']);

                //attempt to execute statement
                if($stmt->execute()){
                    //store result
                    $stmt->store_result();

                    if ($stmt->num_rows == 1){
                        $email_err = 'Email is already in use.';
                    }else{
                        $email = trim($_POST['Email']);
                        echo $email;
                    }
                }else{
                    echo "Oops! Something went wrong";
                }
                //close statement
                $stmt-> close();
            }
        }
        //validate password
        if (empty(trim($_POST['password']))){
            $password_err = "Please eneter a password";
        }elseif(strlen(trim($_POST['password'])) < 6){
            $password_err = "Password must have atleast 6 characters";
        }else{
            $password = trim($_POST['password']);
            
        }

        //validate confirm password
        if (empty(trim($_POST['check_pass']))){
            $check_pass_err = "Please confirm password";
        }else{
            $check_pass = trim($_POST['check_pass']);
           
            if (empty($password_err) && ($password != $check_pass)){
                $check_pass_err = "Passwords did not match";
            }
        }
        //check input errors before writing to database
        if (empty(trim($_POST['Name']))){
            $name_err = "Please enter your name.";
        }else{
            $name = trim($_POST['Name']);
            
        }

        if (empty(trim($_POST['Surname']))){
            $surname_err = "Please enter your surname.";
        }else{
            $surname = trim($_POST['Surname']);
            
        }

        if (empty(trim($_POST['Cell']))){
            $cell_err = "Please enter your cell number.";
        }else{
            $cell = trim($_POST['Cell']);
            
        }
       
        //if (empty($name_err) && empty($surname_err) && empty($email_err) && empty($cell_err) && empty($password) && empty($check_pass_err)){
            
            //prepare insert statement

            $sql = "INSERT INTO users (name, surname, email, cell, password) VALUES(?, ?, ?, ?, ?)";
           // echo "0";
            if ($stmt = $mysqli->prepare($sql)){
              //  echo "0.3";
                //bind variables to the prepared statement as parameters
                $stmt->bind_param("sssss", $param_name, $param_surname, $param_email, $param_cell, $param_password);
               // echo "1";
                //set parameters
                $param_name = $name;
                $param_surname = $surname;
                $param_email = $email;
                $param_cell = $cell;
                $param_password = password_hash($password, PASSWORD_DEFAULT); //Creates a password hash
                echo $name, $surname;

                //attempt to execute prepared statement
                if ($stmt->execute()){
                    $to = $email;
                    $subject = "Thank you for signing up to cattle-manager.co.za";
                    $message = "Hi, welcome to cattle-manager.co.za";
                    $headers = "From: Jandé <jandre@cattle-manager.co.za>\r\n";
                    $headers .= "Reply-To: jandre@cattle-manager.co.za\r\n";
                    mail($to, $subject, $message, $headers);

                    //redirect to main 
                    session_start();
                    $_SESSION['email'] = $email;
                    header('location: index.php');
                }else{
                    echo 'Something went wrong. Please try again later.';
                }

                //close statement
                $stmt->close();

            }else{
                echo "nope";
            }
       // }
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
               <form action="register.php" method="post" >
                    <p>
                        <input type="text" name="Name" placeholder="Name" value="<?php echo $name; ?>">
                        <?php echo $name_err;?>
                    </p>
                    <p>
                        <input type="text" name="Surname" placeholder="Surname" value="<?php echo $surname; ?>">
                        <?php echo $surname_err;?>
                    </p>
                    <p>
                        <input type="email" name="Email" placeholder="Email" value="<?php echo $email; ?>">
                        <?php echo $email_err;?>
                    </p>
                    <p>
                        <input type="text" name="Cell" placeholder="Cell Number" value="<?php echo $cell; ?>">
                        <?php echo $cell_err;?>
                    </p>
                    <p>
                        <input type="password"  name="password" placeholder="Password">
                        <?php echo $password_err;?>
                    </p>
                    <p>
                        <input type="password" name="check_pass" placeholder="Re-enter Password">
                        <?php echo $check_pass_err;?>
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