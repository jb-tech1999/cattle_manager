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
               <form action="login.php" method="post" >
                    <p>
                        <input type="email" name="email" placeholder="Email">
                    </p>
                    <p>
                        <input type="password"  name="password" placeholder="Password">
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