<?php
$servername = "localhost"; // or your server address
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "sdms"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>