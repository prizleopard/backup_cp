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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Page</title>
    <link rel="stylesheet" href="dashbstyle.css"> 
</head>
<style>


        .container {
            margin-top: 20px;
        padding: 20px;
        background-color: #f0f4f8;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        margin-right: 1000px; 
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
            background-color: #3a506b; /* Green for sports results */
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
        nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #f0f4f8; /* Adjust based on your design */
}

nav .profile {
    margin-left: auto; /* Push the logo/image to the right */
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}
    </style>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="Dashb.php" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Admin Page</span>
        </a>
        <ul class="side-menu top">
            <li><a href="trylangdin.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li><a href="Dashb.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="trylang.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="trymessage.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li class="active"><a href="tryresult.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
            <li><a href="school_gallery.php"><i class='bx bxs-building-house'></i><span class="text">Schools</span></a></li>
            <li><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Venues</span></a></li>
        </ul>

        <ul class="side-menu">
            <li><a href="login_form.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>
    <!-- SIDEBAR -->
   <!-- CONTENT -->
   <section id="content">
    <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
    <div>

    </div>
    <a href="#" class="profile">
            <img src="sanluis.jpg" alt="Profile Image">
            </a>
        </nav>
        <!-- NAVBAR -->


        <main>
            <div id="container">
            <div class="container">
                <h2>Enter Sports Results</h2>
                
                <?php if ($success_message): ?>
                    <div class="alert"><?php echo $success_message; ?></div>
                <?php endif; ?>
                
                <form action="tryresult.php" method="POST">
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
            </div>
            </main>
        <!-- MAIN CONTENT -->

    </section>                 
    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>