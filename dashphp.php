<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "news_feed_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['news-title']);
    $content = $conn->real_escape_string($_POST['news-content']);
    
    // Handle media upload
    $media = '';
    if (!empty($_FILES['news-media']['name'][0])) {
        $targetDir = "uploads/";
        $fileNames = [];
        foreach ($_FILES['news-media']['name'] as $key => $name) {
            $tempFilePath = $_FILES['news-media']['tmp_name'][$key];
            $newFilePath = $targetDir . basename($name);
            if (move_uploaded_file($tempFilePath, $newFilePath)) {
                $fileNames[] = $newFilePath;
            }
        }
        $media = implode(',', $fileNames); // Store media paths as comma-separated values
    }

    // Insert the news post into the database
    $sql = "INSERT INTO news_posts (title, content, media) VALUES ('$title', '$content', '$media')";
    if ($conn->query($sql) === TRUE) {
        echo "<p>New record created successfully</p>";
        // Redirect back to the Organizer Page (optional)
        header("Location: Dashb.html"); // Change to your actual page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Show error if it fails
    }
}

$conn->close();
?>
