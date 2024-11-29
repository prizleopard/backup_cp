<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'players';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $player_id = $_GET['id'];

    // Delete the player permanently
    $sql = "DELETE FROM players WHERE player_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $player_id);
    $stmt->execute();

    // Redirect to recycle bin
    header("Location: players_recycle_bin.php");
    exit;
}

// Close connection
$stmt->close();
$conn->close();
?>
