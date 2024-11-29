<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Coordinators Page</title>
    <link rel="stylesheet" href="dashbstyle.css">
    <style>
    .form-container, .bracket-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #f0f4f8;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        margin-right: 1000px; 
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

    /* Bracket container styling */
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
                <span class="text">Coordinators Page</span>
            </a>
            <ul class="side-menu top">
            <li><a href="cbracketing.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li class="active"><a href="coordinators.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="cgamesched.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="cnewsfeed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="corganizers.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="cresults.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
            <li><a href="cgallery.php"><i class='bx bxs-building-house'></i><span class="text">Schools</span></a></li>
            <li><a href="cvenues.php"><i class='bx bxs-map-pin'></i><span class="text">Venues</span></a></li>
        </ul>
    
            <ul class="side-menu">
                <li><a href="login_form.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
            </ul>
        </section>
        <!-- SIDEBAR -->
    
        <!-- CONTENT -->
        <section id="content">
            <!-- NAVBAR -->
            <nav>
                <i class='bx bx-menu' id="menu-icon"></i>
                <div>
    
                </div>
                <a href="#" class="profile">
            <img src="sanluis.jpg" alt="Profile Image">
            </a>
            </nav>
            <!-- NAVBAR -->
    
            <!-- MAIN CONTENT -->
            <main style="overflow: hidden;">

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
                                        
                                    </div>
                                    <div>
                                        <form method="POST" action="" onsubmit="return confirmDelete();"><a class="view-button" href="venues.php?venue=' . urlencode($row["venue"]) . '">View Venue</a>
                                            <input type="hidden" name="match_id" value="' . htmlspecialchars($row["id"]) . '">

                                        </form>
                                    </div>
                                </div>';
                        }
                    } else {
                        echo "<p>No matches available.</p>";
                    }

                    $conn->close();
                    ?>



            </main>
            <!-- MAIN CONTENT -->
        </section>
        <!-- CONTENT -->
    
        <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this match?");
        }
        </script>
        <script src="script.js"></script> <!-- Link your JavaScript file -->
    </body>
    </html>