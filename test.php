<?php
    session_start();
   // echo $_SESSION['id'];
    //add config file
    include_once 'config.php';

    //define Variables and initialize with empty values
    $number = $mnumber = $dnumber = $dob = '';
    $number_err = '';

    if ($_POST['submit']){
        //validate Animal number
        if (empty(trim($_POST['Number']))){
            $number_err = "Please enter a number";
        }else{
            //Prepare statement 
            $sql = "SELECT id FROM animals WHERE id = ?";

            if ($stmt = $mysqli->prepare($sql)){
                $stmt->bind_param('s', $param_number); 
                //set parameter
                $param_number = trim($_POST['Number']);

                //attempt to execute
                if ($stmt->execute()){
                    $stmt->store_result();
                    if ($stmt->num_rows == 1){
                        $number_err = "This number already exists";
                    }else{

                        $number = trim($_POST['Number']);
                        $mnumber = trim($_POST['momID']);
                        $dnumber = trim($_POST['dadID']);
                        $gender = trim($_POST['gender']);
                        $dob = $_POST['dob'];
                        
                    }
                }else{
                    echo "Oops! Somthing went wrong!";
                }
            }
            //close statement
            $stmt->close();
        }
        if (empty($number_err)){
            //prepare sql statement
            $sql = " INSERT INTO animals(id, maID, paID, gender, eienaarID, dob) VALUES(?,?,?,?,?,?)";

            if ($stmt = $mysqli->prepare($sql)){

                //Bind variables
                $stmt->bind_param('ssssis', $param_number, $param_ma, $param_pa, $param_gender, $param_own, $param_dob);

                //set parameters
                $param_number = $number;
                $param_ma = $mnumber;
                $param_pa = $dnumber;
                $param_gender = $gender;
                $param_own = $_SESSION['id'];
                $param_dob = $dob;


                //attempt to execute
                if ($stmt->execute()){
                    echo '<script type="text/javascript">';
                    echo ' alert("Animal has been added")';
                    echo '</script>';
                }else{
                    echo $mysqli_error();
                    echo '<script type="text/javascript">';
                    echo ' alert("Animal could not be added")';
                    echo '</script>';
                }
                //close staement
                $stmt->close();

            }

        }
        $mysqli->close();

    }
    if ($_POST['export']){
        header("location: export.php");

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
                    <p>
                        <input type="text"  name="momID" placeholder="Mother">
                    </p>
                    <p>
                        <input type="text"  name="dadID" placeholder="Father">
                    </p>
                    <p>
                        <select name="gender" id="gender" >
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>   
                        </select>
                    </p>
                    <p>
                        <input type="date"  name="dob" placeholder="Date of Birth">
                    </p>
                    <p>
                        <input type="submit" name="submit" value="Add Animal" class="full">
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