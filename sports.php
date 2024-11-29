<?php
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

// Handle form submission for updating the winner
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['match_id'])) {
    $match_id = $_POST['match_id'];
    $winner = $_POST['winner'];

    // Update the winner in the database
    $update_sql = "UPDATE tbl_sports SET winner='$winner' WHERE id='$match_id'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<div class='alert success'>Winner updated successfully!</div>";
    } else {
        echo "<div class='alert error'>Error updating winner: " . $conn->error . "</div>";
    }
}

// Handle form submission for adding a new sport bracket
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_sport'])) {
    $sport_name = $_POST['sport_name'];
    $round = $_POST['round'];
    $team1 = $_POST['team1'];
    $team2 = $_POST['team2'];

    // Insert new sport bracket into the database
    $insert_sql = "INSERT INTO tbl_sports (sport_name, round, team1, team2) VALUES ('$sport_name', '$round', '$team1', '$team2')";
    if ($conn->query($insert_sql) === TRUE) {
        echo "<div class='alert success'>New sport bracket added successfully!</div>";
    } else {
        echo "<div class='alert error'>Error adding sport bracket: " . $conn->error . "</div>";
    }
}

// Handle form submission for deleting a sport bracket
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Delete the sport bracket from the database
    $delete_sql = "DELETE FROM tbl_sports WHERE id='$delete_id'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<div class='alert success'>Sport bracket deleted successfully!</div>";
    } else {
        echo "<div class='alert error'>Error deleting sport bracket: " . $conn->error . "</div>";
    }
}

// Fetch sports data and arrange them alphabetically
$sql = "SELECT * FROM tbl_sports ORDER BY sport_name ASC"; // Ordered by sport_name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Bracketing System</title>
    <style>
        body {
            background: linear-gradient(to right, #1a1a2e, #16213e);
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            height: calc(100vh - 40px);
            overflow-y: auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .sport-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .sport-card h2 {
            margin-bottom: 10px;
            font-size: 1.5em;
        }

        .sport-card p {
            margin: 5px 0;
        }

        .sport-card form input[type="text"] {
            width: 80%;
            padding: 5px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: none;
        }

        .sport-card form input[type="submit"], .sport-card form input[type="button"] {
            padding: 7px 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .sport-card form input[type="button"] {
            background: #dc3545; /* Red for delete button */
        }

        .add-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .add-container button {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-container button:hover {
            background: #0056b3;
        }

        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            animation: fadeIn 0.5s ease-in-out;
        }

        .success {
            background: rgba(76, 175, 80, 0.7);
        }

        .error {
            background: rgba(244, 67, 54, 0.7);
        }

        .go-back-button {
            display: block;
            margin: 30px auto;
            padding: 10px 20px;
            background: #FF5733;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }

        .go-back-button:hover {
            background: #e04e2d;
        }

        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 60%;
            border-radius: 5px;
            border: none;
            margin-right: 10px;
        }

        .search-container input[type="button"] {
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <script>
        function searchSports() {
            var input = document.getElementById("searchInput").value.toLowerCase();
            var sportCards = document.getElementsByClassName("sport-card");

            for (var i = 0; i < sportCards.length; i++) {
                var sportName = sportCards[i].getElementsByTagName("h2")[0].innerText.toLowerCase();
                if (sportName.includes(input)) {
                    sportCards[i].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    sportCards[i].style.border = "2px solid yellow";  // Highlight the selected sport
                    break;
                }
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Sports Bracketing System</h1>

        <!-- Search Bar -->
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search for a sport...">
            <input type="button" value="Search" onclick="searchSports()">
        </div>

        <!-- Add Sport Bracket Button -->
        <div class="add-container">
            <button onclick="document.getElementById('addSportForm').style.display='block'">Add Sport Bracket</button>
        </div>

        <!-- Add Sport Bracket Form -->
        <div class="add-sport-form" id="addSportForm" style="display: none; text-align: center;">
            <form method="POST" action="">
                <input type="text" name="sport_name" placeholder="Sport Name" required>
                
                <!-- Round Dropdown Menu -->
                <select name="round" required>
                    <option value="1">Round 1</option>
                    <option value="2">Round 2</option>
                    <option value="3">Round 3</option>
                    <option value="4">Round 4</option> <!-- Added Round 4 -->
                </select>
                
                <input type="text" name="team1" placeholder="Team 1" required>
                <input type="text" name="team2" placeholder="Team 2" required>
                <input type="submit" name="add_sport" value="Add Sport Bracket">
            </form>
        </div>

        <!-- Display Sports -->
        <div class="grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while($match = $result->fetch_assoc()): ?>
                    <div class="sport-card">
                        <h2><?php echo htmlspecialchars($match['sport_name']); ?></h2>
                        <p>Round: <?php echo htmlspecialchars($match['round']); ?></p>
                        <p><?php echo htmlspecialchars($match['team1']); ?> vs <?php echo htmlspecialchars($match['team2']); ?></p>
                        
                        <form method="POST" action="">
                            <input type="text" name="winner" placeholder="Enter Winner" required>
                            <input type="hidden" name="match_id" value="<?php echo htmlspecialchars($match['id']); ?>">
                            <input type="submit" value="Update Winner">
                        </form>

                        <!-- Delete Button -->
                        <form method="POST" action="">
                            <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($match['id']); ?>">
                            <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this sport bracket?');">
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No sports available. Please add some.</p>
            <?php endif; ?>
        </div>

        <!-- Go Back Button -->
        <a class="go-back-button" href="Dashb.php">Go Back</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
