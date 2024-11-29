<?php
// Database connection to 'list' database
$conn = new mysqli("localhost", "root", "", "list");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = ""; // Initialize the success message variable

// Handle adding new sport
if (isset($_POST['add_sport'])) {
    $new_sport = $conn->real_escape_string($_POST['new_sport']);
    
    // Check if the sport already exists in the database
    $check_query = "SELECT * FROM tbl_sports WHERE sport_name = '$new_sport'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        echo "<p style='color: red;'>Sport already exists in the database!</p>";
    } else {
        // Insert the new sport into the database
        $insert_query = "INSERT INTO tbl_sports (sport_name) VALUES ('$new_sport')";
        
        if ($conn->query($insert_query) === TRUE) {
            $successMessage = "New sport added successfully!"; // Set success message
        } else {
            echo "<p style='color: red;'>Error adding sport: " . $conn->error . "</p>";
        }
    }
}

// Fetch sports from the database to populate the dropdown
$sports_query = "SELECT sport_name FROM tbl_sports";
$sports_result = $conn->query($sports_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Page</title>
    <link rel="stylesheet" href="dashbstyle.css">
    <style>
    .form-container, .bracket-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #f0f4f8;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .form-container h2, .bracket-container h2 {
        font-size: 24px;
        color: #3a506b;
        margin-bottom: 20px;
    }

    .form-container input, .form-container select, .form-container button {
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
    }

    .form-container input, .form-container select {
        border: 1px solid #b2b9b6;
        background-color: #e0e7e9;
    }

    .form-container button {
        background-color: #3a506b;
        color: #ffffff;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .form-container button:hover {
        background-color: #2c3e50;
    }

    .match {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        margin-bottom: 10px;
        border: 1px solid #b2b9b6;
        border-radius: 4px;
        background-color: #f8fafc;
    }

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
        background-color: #56cfe1;
    }

    .view-button:hover {
        background-color: #2a9d8f;
    }

    .delete-button {
        background-color: #e76f51;
    }

    .delete-button:hover {
        background-color: #d85d3b;
    }
    nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #f0f4f8;
}

nav .profile {
    margin-left: auto;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}
.success-message {
    background-color: #d4edda; /* Light green background */
    color: #155724; /* Dark green text */
    padding: 15px;
    margin: 20px 0;
    border: 1px solid #c3e6cb; /* Light green border */
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    text-align: center;
}

</style>
</head>

<body>
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
            <li class="active"><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="tryresult.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
            <li><a href="school_gallery.php"><i class='bx bxs-building-house'></i><span class="text">Schools</span></a></li>
            <li><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Venues</span></a></li>
        </ul>
        <ul class="side-menu">
            <li><a href="login_form.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
            <div></div>
            <a href="#" class="profile">
                <img src="sanluis.jpg" alt="Profile Image">
            </a>
        </nav>

        <main>
        <div id="container">
<!-- Display success message after adding sport -->
<?php if ($successMessage): ?>
    <p class="success-message" id="success-alert"><?php echo $successMessage; ?></p>
<?php endif; ?>

<script>
    // Check if the success message exists
    window.onload = function() {
        var successMessage = document.getElementById('success-alert');
        
        // If the success message exists, set a timeout to hide it after 3 seconds
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none'; // Hide the success message
            }, 3000); // 3000 milliseconds = 3 seconds
        }
    };
</script>


                <div class="container">
                    <div class="form-container">
                        <h2>Add New Sport</h2>
                        <form method="POST" action="">
                            <label for="new_sport">Sport Name:</label>
                            <input type="text" id="new_sport" name="new_sport" required>
                            <button type="submit" name="add_sport">Add Sport</button>
                        </form>
                    </div>

                    <div class="form-container">
                        <h2>Create a Game Bracket</h2>
                        <form method="POST" action="">
                            <label for="sport">Type of Sport:</label>
                            <select id="sport" name="sport" required>
                                <option value="">Select a Sport</option>
                                <?php
                                if ($sports_result->num_rows > 0) {
                                    while ($row = $sports_result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['sport_name']) . "'>" . htmlspecialchars($row['sport_name']) . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No sports available</option>";
                                }
                                ?>
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
                    </div>
                    <div class="bracket-container">
                        <h2>Game Bracket</h2>
                        <?php
                        // Select matches
                        $sql = "SELECT * FROM tbl_matches";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="match">
                                        <div>' . htmlspecialchars($row["sport"]) . ': ' . htmlspecialchars($row["team1"]) . ' vs ' . htmlspecialchars($row["team2"]) . ' on ' . htmlspecialchars($row["match_date"]) . '</div>
                                        <div>
                                            <a class="view-button" href="venues.php?venue=' . urlencode($row["venue"]) . '">View</a>
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
                        ?>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this match?");
        }
    </script>
        <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>

<?php
$conn->close();
?>
