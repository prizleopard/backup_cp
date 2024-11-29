<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "result";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert game result using prepared statements for security
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sport = $_POST['sport'];
    $game_date = $_POST['game_date'];
    $team_a = $_POST['team_a'];
    $team_b = $_POST['team_b'];
    $score_a = $_POST['score_a'];
    $score_b = $_POST['score_b'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO sports_results (sport, game_date, team_a, team_b, score_a, score_b, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdds", $sport, $game_date, $team_a, $team_b, $score_a, $score_b, $status);

    if ($stmt->execute()) {
        echo "<div class='success'>New game result recorded successfully!</div><br>";
    } else {
        echo "<div class='error'>Error: " . $stmt->error . "</div>";
    }

    $stmt->close();
}

// Fetch sports results
$sql = "SELECT * FROM sports_results";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Results</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        h2 { color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-bottom: 20px; }
        label { display: block; margin: 10px 0 5px; }
        input[type="text"], input[type="number"], input[type="date"], select { width: calc(100% - 20px); padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-bottom: 10px; }
        input[type="submit"] { background-color: #007BFF; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0056b3; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #007BFF; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Sports Results</h2>
        <form action="dashinsert_result.php" method="POST">
            <label for="sport">Select Sport:</label>
            <select name="sport" required>
                <option value="arnis">Arnis</option>
                <!-- (Add other sports as needed) -->
            </select>

            <label for="game_date">Game Date:</label>
            <input type="date" name="game_date" required>

            <label for="team_a">Team A:</label>
            <input type="text" name="team_a" required>

            <label for="team_b">Team B:</label>
            <input type="text" name="team_b" required>

            <label for="score_a">Score A:</label>
            <input type="number" name="score_a" required>

            <label for="score_b">Score B:</label>
            <input type="number" name="score_b" required>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select>

            <input type="submit" value="Submit Results">
        </form>
    </div>

    <div class="container">
<?php
if ($result->num_rows > 0) {
    echo "<h2>Sports Results</h2>";
    echo "<table><tr><th>Date</th><th>Sport</th><th>Team A</th><th>Score A</th><th>Team B</th><th>Score B</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['game_date']}</td>
                <td>{$row['sport']}</td>
                <td>{$row['team_a']}</td>
                <td>{$row['score_a']}</td>
                <td>{$row['team_b']}</td>
                <td>{$row['score_b']}</td>
                <td>{$row['status']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<div>No results found.</div>";
}

$conn->close();
?>
    </div>
</body>
</html>
