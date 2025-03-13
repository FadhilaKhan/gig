<?php
// db_connection.php

$host = 'localhost';  // Database host
$username = 'root';   // Database username
$password = '';       // Database password
$database = 'fixmyspacedb'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
