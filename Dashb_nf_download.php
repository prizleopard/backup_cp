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

// Check if the file parameter is set
if (isset($_GET['file'])) {
    $file = $_GET['file'];
    $filePath = "C:\\mine\\htdocs\\system\\uploads\\" . $file; // Set the full file path

    // Check if the file exists
    if (file_exists($filePath)) {
        // Set headers to download the file
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        flush(); // Flush system output buffer
        readfile($filePath); // Read the file
        exit; // Exit the script
    } else {
        echo "File not found.";
    }
} else {
    echo "No file specified.";
}

$conn->close();
?>
