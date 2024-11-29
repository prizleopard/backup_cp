<?php
$servername = "localhost"; // Change this if necessary
$username = "root"; // Change this if necessary
$password = ""; // Change this if necessary
$dbname = "news_feed"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM news_feed WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href='Dashb_news_feed.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    die("Invalid request.");
}

$conn->close();
?>
