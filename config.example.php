<?php
/**
 * Database Configuration Example
 * 
 * Copy this file to config.php and update the values below
 * with your actual database credentials.
 * 
 * @author Cattle Manager Team
 * @version 1.0.0
 */

// Database Configuration
// Update these credentials for your environment
$db_host = 'localhost';          // Your database server hostname
$db_username = 'your_db_user';   // Your database username
$db_password = 'your_password';  // Your database password
$db_name = 'cattle_manager';     // Your database name

// Create MySQLi connection object (OOP style)
$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Create MySQLi connection (procedural style) - maintained for compatibility
$con = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection and handle errors
if ($mysqli === false) {
    die("ERROR: Could not connect to database. " . mysqli_connect_error());
}

// Set charset to UTF-8 for proper character handling
$mysqli->set_charset("utf8");

?>