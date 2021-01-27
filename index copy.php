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
               <form action="insert.php" method="post" >
                    <p>
                        <input type="date" name="date" placeholder="date">
                    </p>
                    <p>
                        <input type="text"  name="Speedometer" placeholder="Speedometer">
                    </p>
                    <p>
                        <input type="text"  name="Distance" placeholder="Distance">
                    </p>
                    <p>
                        <input type="text"  name="liters" placeholder="Litres Purchased">
                    </p>
                    <p>
                        <input type="text"  name="Garage" placeholder="Garage">
                    </p>
                    <p>
                        <input type="text"  name="Total_Cost" placeholder="Total Cost">
                    </p>
                    <p>
                        <input type="submit" name="submit" placeholder="Save" class="full">
                    </p>
               </form> 
            </div>
            <div class="logs">
               <?php
                        
                        $link = mysqli_connect('localhost', 'root', '' , 'petrol_log');
                        $total_distance = 0;
                        $total_litres = 0;
                        //sql to show data
                        $sql = 'SELECT * FROM logs ORDER BY date DESC';
                        if($result = mysqli_query($link, $sql)){
                            if(mysqli_num_rows($result) > 0){
                                echo '<table>';
                                echo '<tr>';
                                echo "<th>Average Distance</th>";
                                echo "<th>Average Litres per KM</th>";
                                echo '</tr>';

                                while($row = mysqli_fetch_array($result)){
                                   $total_distance = $total_distance + $row['distance'];
                                   $total_litres = $total_litres + $row['l_p_km'];
                                }
                                echo '<tr>';
                                    echo '<td>' . round($total_distance / mysqli_num_rows($result), 2) . '</td>';
                                    echo '<td>' . round($total_litres / mysqli_num_rows($result), 2) . '</td>';
                                echo '</tr>';
                                echo '</table>';
                                //free result
                                mysqli_free_result($result);
                            }else{
                                echo 'No records were found';
                            }
                        }else{
                            echo "ERROR was not able to execute $sql." . mysqli_error($link);
                        }

                        //Print host info
                    // echo 'Connected ' . mysqli_get_host_info($link);

                        mysqli_close($link);

                ?>
               <form action="export.php" method="post" class='export'>
                        <p> 
                            <input type="submit" value="Export CSV" name="export">
                        </p>
                </form>
               </div>
        </div>

    </div>
</body>
</html>