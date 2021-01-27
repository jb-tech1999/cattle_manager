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
        <h1 class="brand animate__animated animate__heartBeat"><?php session_start(); echo 'Welcome, ' . $_SESSION['name'];?></h1>
        <div class="wrapper" >
            <div class="insert animate__animated animate__bounceInLeft" >
               <form action="insert.php" method="post" >
                    <p>
                        <input type="text" name="Number" placeholder="Animal Number">
                    </p>
                    <p>
                        <input type="text"  name="momID" placeholder="Animal Mother Number">
                    </p>
                    <p>
                        <input type="text"  name="dadID" placeholder="Animal Father Number">
                    </p>
                    <p>
                        <input type="date"  name="dob" placeholder="Date of Birth">
                    </p>
                    <p>
                        <input type="submit" name="submit" placeholder="Save" class="full">
                    </p>
               </form> 
               
            </div>
            
        </div>
        
    </div>
    <a href="logout.php">Logout</a>
</body>
</html>