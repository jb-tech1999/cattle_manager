<?php
    
    //date, speedometer, distance, litres_purchased, l_p_km, ppl, garage, total_cost
    if (isset($_POST['export'])){

        $link = mysqli_connect('localhost', 'root', '' , 'petrol_log');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, array('ID' , 'Date', ' Speedometer', 'Distance', 'Litres purchased', 'litres per km', 'Price per Litre', 'Garage', 'Total cost'));
        $query = 'SELECT * FROM logs ORDER BY date DESC';
        $result = mysqli_query($link, $query);

        while ( $row = mysqli_fetch_assoc($result)){
          fputcsv($output, $row);  
        }
        fclose($output);

    }



?>