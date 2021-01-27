<?php
$link = mysqli_connect('localhost', 'root', '' , 'petrol_log');
//check connection
if ($link === false){
    die('ERROR: Could not connect. ' .mysqli_error);
}


if ($_POST['date'] == ''){
}else{
    //sql to insert new data
    $sql = 'INSERT INTO logs (date, speedometer, distance, litres_purchased, l_p_km, ppl, garage, total_cost) VALUES(?,?,?,?,?,?,?,?)';

    if ($stmt = mysqli_prepare($link, $sql)){
        //binds variables to prepared statement
        mysqli_stmt_bind_param($stmt, 'siddddsd', $date, $speedometer, $distance, $litres_purchased, $l_p_km, $ppl, $garage, $cost);

        //getting values from website with get
        $date = $_POST["date"];
        $speedometer = $_POST['Speedometer'];
        $distance = $_POST["Distance"];
        $litres_purchased = $_POST["liters"];
        $l_p_km = $distance / $litres_purchased;
        $garage = $_POST["Garage"];
        $cost = $_POST["Total_Cost"];
        $ppl = $cost / $litres_purchased;
        mysqli_stmt_execute($stmt);
        $_POST["date"] = '';

    }else{
        echo "ERROR: was not able to insert records: $sql. " . mysqli_error($link);
    }
    //Close statement
    mysqli_stmt_close($stmt);
}
mysqli_close($link);
header('Location: index.php');




?>