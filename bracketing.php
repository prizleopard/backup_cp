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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Dashb_styles.css">
    <title>Sports Bracketing System</title>
    <style>
        /* General styles */
        body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
    overflow-y: hidden; /* Prevent full body scrolling, only scroll #content */
}

#content {
    padding: 20px;
    max-width: none;
    margin: auto;
    position: absolute; /* Use relative for correct alignment */
    width: calc(100% - 280px);
    left: 280px;
    transition: .3s ease;
    overflow-y: auto; /* Allow scrolling within the content */
    height: 100vh; /* Use viewport height to allow scrollable area */
}
        #content {
            position: auto;
            width: calc(100% - 280px);
            left: 280px;
            transition: .3s ease;
        }
        .form-container, .bracket-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position:relative
        }
        .form-container h2, .bracket-container h2 {
            font-size: 24px;
            color: #007bff;
            margin-bottom: 20px;
        }
        
        /* Form styling */
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-container input, .form-container select, .form-container button {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }
        .form-container input, .form-container select {
            border: 1px solid #ccc;
        }
        .form-container button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }

        /* Bracket container styling */
        .match {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .match div {
            flex: 1;
            margin-right: 10px;
            text-align: center;
        }
        
        /* Buttons */
        .view-button, .delete-button {
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .view-button {
            background-color: #28a745;
        }
        .view-button:hover {
            background-color: #218838;
        }
        .delete-button {
            background-color: #dc3545;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="Dashb.php" class="brand">
            <i class="bx bxs-face-mask"></i>
            <span class="text">Admin Page</span>
        </a>
        <ul class="side-menu top">
            <?php 
                $sidebarItems = [
                    ["link" => "Dashb.php", "icon" => "bxs-dashboard", "text" => "Dashboard"],
                    ["link" => "trylastna.php", "icon" => "bxs-folder-open", "text" => "Organizers"],
                    ["link" => "insert_result.php", "icon" => "bxs-doughnut-chart", "text" => "Results"],
                    ["link" => "schools.php", "icon" => "bxs-school", "text" => "Schools"],
                    ["link" => "trylang.php", "icon" => "bxs-time", "text" => "Game Schedules"],
                    ["link" => "trylangdin.php", "icon" => "bx-abacus", "text" => "Bracketing", "active" => true],
                    ["link" => "venues.php", "icon" => "bxs-map", "text" => "Venues"],
                    ["link" => "Dashb_news_feed.php", "icon" => "bx-spreadsheet", "text" => "News Feed"],
                    ["link" => "trymessage.php", "icon" => "bxs-message-dots", "text" => "Message"],
                ];

                usort($sidebarItems, fn($a, $b) => strcmp($a['text'], $b['text']));

                foreach ($sidebarItems as $item) {
                    echo '<li' . (isset($item['active']) ? ' class="active"' : '') . '>
                            <a href="' . $item['link'] . '">
                                <i class="bx ' . $item['icon'] . '"></i>
                                <span class="text">' . $item['text'] . '</span>
                            </a>
                          </li>';
                }
            ?>
        </ul>
    </section>

    <div id="content">
        <!-- Form Container -->
        <div class="form-container">
            <h2>Create a Game Bracket</h2>
            <form method="POST" action="">
                <label for="sport">Type of Sport:</label>
                <select id="sport" name="sport" required>
                    <option value="">Select a Sport</option>
                    <option value="Basketball">Basketball</option>
                    <option value="Volleyball">Volleyball</option>
                    <option value="Soccer">Soccer</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Tennis">Tennis</option>
                    <option value="Baseball">Baseball</option>
                    <option value="Softball">Softball</option>
                    <option value="Boxing">Boxing</option>
                    <option value="Wrestling">Wrestling</option>
                    <option value="Swimming">Swimming</option>
                    <option value="Track and Field">Track and Field</option>
                </select>

                <label for="team1">Team 1:</label>
                <input type="text" id="team1" name="team1" required>
                
                <label for="team2">Team 2:</label>
                <input type="text" id="team2" name="team2" required>

                <label for="date">Match Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="venue">Venue:</label>
                <input type="text" id="venue" name="venue" required>

                <button type="submit" name="submit">Add Match</button>
            </form>
        </div>

        <!-- Bracket Container -->
        <div class="bracket-container">
            <h2>Game Bracket</h2>
            <?php
            // Database connection
            $conn = new mysqli("localhost", "root", "", "list");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_POST['delete'])) {
                $match_id = $conn->real_escape_string($_POST['match_id']);
                $sql = "DELETE FROM tbl_matches WHERE id = $match_id";
                if ($conn->query($sql) === TRUE) {
                    echo "<p>Match deleted successfully</p>";
                } else {
                    echo "Error deleting record: " . $conn->error;
                }
            }

            $sql = "SELECT * FROM tbl_matches";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="match">
                            <div>' . htmlspecialchars($row["sport"]) . ': ' . htmlspecialchars($row["team1"]) . ' vs ' . htmlspecialchars($row["team2"]) . ' on ' . htmlspecialchars($row["match_date"]) . '</div>
                            <div>
                                <a class="view-button" href="venues.php?venue=' . urlencode($row["venue"]) . '">View Venue</a>
                            </div>
                            <div>
                                <form method="POST" action="" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="match_id" value="' . htmlspecialchars($row["id"]) . '">
                                    <button type="submit" name="delete" class="delete-button">Delete</button>
                                </form>
                            </div>
                          </div>';
                }
            } else {
                echo "<p>No matches available.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>

<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this match?");
}
</script>

<script src="js/sidebar.js"></script>
</body>
</html>
