<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include database connection
include 'venues_connection.php'; // Make sure this file contains the connection code to your database

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data and sanitize inputs
    $name = $conn->real_escape_string(trim($_POST['name']));
    $address = $conn->real_escape_string(trim($_POST['address']));
    $contact = $conn->real_escape_string(trim($_POST['contact']));
    $latitude = $conn->real_escape_string(trim($_POST['latitude']));
    $longitude = $conn->real_escape_string(trim($_POST['longitude']));

    // Prepare SQL query to insert venue
    $query = "INSERT INTO venues (name, address, contact, latitude, longitude) VALUES ('$name', '$address', '$contact', '$latitude', '$longitude')";

    // Execute the query and check for errors
    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "New venue added successfully!";
        header("Location: venues.php"); // Redirect back to the venues page
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $query . "<br>" . $conn->error;
        header("Location: venues.php"); // Redirect back to the venues page
        exit();
    }
}

// Close the database connection
$conn->close();
?>
