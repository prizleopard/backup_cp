<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "list";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get match ID from the URL
if (isset($_GET['id'])) {
    $matchId = $conn->real_escape_string($_GET['id']);

    // Fetch match details from the database
    $sql = "SELECT * FROM tbl_matches WHERE id = '$matchId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $match = $result->fetch_assoc();
    } else {
        echo "<p>Match not found.</p>";
        exit;
    }
} else {
    echo "<p>Invalid match ID.</p>";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Dashb_styles.css">
    <title>Match Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        #content {
            padding: 20px;
            max-width: 800px;
            margin: auto;
        }
        .details-container {
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .details-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #007BFF;
        }
        .details-container p {
            font-size: 18px;
            margin: 5px 0;
        }
        .back-button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div id="content">
        <div class="details-container">
            <h2>Match Details</h2>
            <p><strong>Sport:</strong> <?php echo htmlspecialchars($match['sport']); ?></p>
            <p><strong>Team 1:</strong> <?php echo htmlspecialchars($match['team1']); ?></p>
            <p><strong>Team 2:</strong> <?php echo htmlspecialchars($match['team2']); ?></p>
            <p><strong>Match Date:</strong> <?php echo htmlspecialchars($match['match_date']); ?></p>
            <p><strong>Venue:</strong> <?php echo htmlspecialchars($match['venue']); ?></p>
            <a href="sports.php"><button class="back-button">Go Back to Bracket</button></a>
        </div>
    </div>
</body>
</html>
