<?php
/**
 * CSV Data Export Functionality
 * 
 * This file exports all cattle records for the logged-in user to a CSV file.
 * The CSV includes: Animal Number, Mother ID, Father ID, Gender, Owner ID, Date of Birth
 * 
 * @author Cattle Manager Team
 * @version 1.0.0
 */

// Start session to access user information
session_start();

// Include database configuration
include_once "config.php";

// Security check: Ensure user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: index.php");
    exit;
}

// Get current user's ID for data filtering
$current_owner_id = $_SESSION['id'];

// Set HTTP headers for CSV file download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=cattle_data_' . date('Y-m-d') . '.csv');

// Open output stream for writing CSV data
$output = fopen('php://output', 'w');

// Write CSV column headers
fputcsv($output, array('Number', 'Mom Number', 'Dad', 'Gender', 'Owner', 'Date of Birth'));

// Prepare SQL query to fetch user's animals (ordered by mother ID for consistency)
$query = "SELECT * FROM animals WHERE eienaarID = ? ORDER BY maID";

// Use prepared statement for security
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param('i', $current_owner_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Output each record as CSV row
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
    
    $stmt->close();
} else {
    // Handle query preparation error
    die("Error preparing export query: " . $mysqli->error);
}

// Close output stream
fclose($output);

// Close database connection
$mysqli->close();
?>