<?php
// dbconnection.php

// Database connection details
$servername = "localhost"; // Usually 'localhost'
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "game_sched"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
