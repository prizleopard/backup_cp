<?php
include 'db.php'; // Include the database connection

// Get the organizer ID from the URL
$id = $_GET['id'];

// Delete organizer from the database
$sql = "DELETE FROM organizers WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header('Location: index.php'); // Redirect back to the admin page after deletion
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
