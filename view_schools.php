<?php
// sdb.php - Database connection
$servername = "localhost"; // Change if needed
$username = "root"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "schools"; // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
