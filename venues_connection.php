<?php
$servername = "localhost"; // Adjust based on your server
$username = "root";
$password = "";
$database = "sdms"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
