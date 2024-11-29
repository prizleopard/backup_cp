<?php
// Database connection
$servername = "localhost"; // Change if needed
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "result"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert game result
$success_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sport = $_POST['sport'];
    $game_date = $_POST['game_date'];
    $team_a = $_POST['team_a'];
    $team_b = $_POST['team_b'];
    $score_a = $_POST['score_a'];
    $score_b = $_POST['score_b'];
    $status = $_POST['status'];

    $sql = "INSERT INTO sports_results (sport, game_date, team_a, team_b, score_a, score_b, status)
            VALUES ('$sport', '$game_date', '$team_a', '$team_b', $score_a, $score_b, '$status')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "New game result recorded successfully!";
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #007BFF, #00A859);
            overflow: hidden;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Increased width */
            width: 90%;
            height: 80%;
            overflow-y: auto;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        h2 {
            color: #007BFF; /* University of Batangas Blue */
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF; /* University of Batangas Blue */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }

        .alert {
            background-color: #28a745; /* Green for success */
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #28a745; /* Green for sports results */
            color: white;
        }

        td {
            width: 14%; /* Set width for all columns evenly */
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd; /* Light gray on hover */
        }

        .go-back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF; /* University of Batangas Blue */
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-weight: bold;
            margin-top: 20px; /* Add some space above the button */
            transition: background-color 0.3s ease;
        }

        .go-back-button:hover {
            background-color: #0056b3; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h2>Enter Sports Results</h2>
        
        <?php if ($success_message): ?>
            <div class="alert"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <form action="insert_result.php" method="POST">
            <label for="sport">Select Sport:</label>
            <select name="sport" required>
                <option value="arnis">Arnis</option>
                <option value="badminton">Badminton</option>
                <option value="baseball">Baseball</option>
                <option value="basketball">Basketball</option>
                <option value="billards">Billards</option>
                <option value="boxing">Boxing</option>
                <option value="chess">Chess</option>
                <option value="football">Football</option>
                <option value="futsal">Futsal</option>
                <option value="gymnastics">Gymnastics</option>
                <option value="sepak takraw">Sepak Takraw</option>
                <option value="softball">Softball</option>
                <option value="swimming">Swimming</option>
                <option value="table tennis">Table Tennis</option>
                <option value="taekwondo">Taekwondo</option>
                <option value="tennis">Tennis</option>
                <option value="volleyball">Volleyball</option>
                <option value="wrestling">Wrestling</option>
                <option value="wushu">Wushu</option>
            </select><br>

            <label for="game_date">Game Date:</label>
            <input type="date" name="game_date" required><br>

            <label for="team_a">Team A:</label>
            <input type="text" name="team_a" required><br>

            <label for="team_b">Team B:</label>
            <input type="text" name="team_b" required><br>

            <label for="score_a">Score A:</label>
            <input type="number" name="score_a" required><br>

            <label for="score_b">Score B:</label>
            <input type="number" name="score_b" required><br>

            <label for="status">Status:</label>
            <select name="status">
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select><br>

            <input type="submit" value="Submit Results">
        </form>

        <?php
        // Fetch sports results
        $sql = "SELECT * FROM sports_results";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Sports Results</h2>";
            echo "<table><tr><th>Date</th><th>Sport</th><th>Team A</th><th>Team B</th><th>Score A</th><th>Score B</th><th>Status</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['game_date']}</td>
                        <td>{$row['sport']}</td>
                        <td>{$row['team_a']}</td>
                        <td>{$row['team_b']}</td>
                        <td>{$row['score_a']}</td>
                        <td>{$row['score_b']}</td>
                        <td>{$row['status']}</td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No results found.</p>";
        }

        $conn->close();
        ?>
        
        <a href="Dashb.php" class="go-back-button">Go Back</a>
    </div>
</body>
</html>
