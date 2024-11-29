<?php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "list"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert team into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $school_name = $_POST['school_name'];
    $team_name = $_POST['team_name'];

    $sql = "INSERT INTO teams (school_name, team_name) VALUES ('$school_name', '$team_name')";

    if ($conn->query($sql) === TRUE) {
        echo "New team added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Team</title>
</head>
<body>
    <h1>Add New Team</h1>
    <form method="post" action="">
        <label for="school_name">School Name:</label>
        <input type="text" name="school_name" required><br><br>
        
        <label for="team_name">Team Name:</label>
        <input type="text" name="team_name" required><br><br>
        
        <button type="submit">Add Team</button>
    </form>
</body>
</html>
