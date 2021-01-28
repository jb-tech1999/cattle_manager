<?php
    
    //date, speedometer, distance, litres_purchased, l_p_km, ppl, garage, total_cost
    if (isset($_POST['export'])){
      echo '<script type="text/javascript">';
      echo ' alert("File ready for export")';
      echo '</script>';
        $link = mysqli_connect('localhost', 'root', '' , 'cattle_manager');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen('php://output', 'w');

        fputcsv($output, array('Animal ID', 'Mother', 'Father', 'Owner', 'Date of Birth'));
        $query = 'SELECT * FROM animals GROUP BY maID';
        $result = mysqli_query($link, $query);

        while ( $row = mysqli_fetch_assoc($result)){
          fputcsv($output, $row);  
        }
        fclose($output);

    }



?>