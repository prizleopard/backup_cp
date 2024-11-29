<?php
@include 'config.php';

// Check if the connection is established
if (!isset($conn) || !$conn) {
    die("Database connection failed.");
}

// Fetch event results from the database
$query = "SELECT event_name, participant_name, position, score, event_date FROM event_results ORDER BY event_date DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return results as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
