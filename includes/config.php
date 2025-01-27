<?php
$host = 'localhost';
$dbname = 'php_pratical';
$username = 'root';
$password = '';

// Create a connection using mysqli
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

//echo "database connect";
?>