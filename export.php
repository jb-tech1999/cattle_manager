<?php
  session_start();  
  //linux side
  include_once "config.php";
  //create query
  $own = $_SESSION['id'];
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=data.csv');
  $output = fopen('php://output', 'w');

  fputcsv($output, array('Number', 'Mom Number', 'Dad', 'Gender', 'Owner', 'Date of Birth'));
  $query = "SELECT * FROM animals WHERE eienaarID = '$own' ORDER BY maID";

  $result = mysqli_query($con, $query);

  while ($row = mysqli_fetch_assoc($result)){
    fputcsv($output, $row);
  }
  fclose($output);
 

?>