<?php
$host = "localhost"; // or your host
$user = "root"; // your MySQL user
$password = ""; // your MySQL password
$dbname = "sdms"; // Replace with your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
