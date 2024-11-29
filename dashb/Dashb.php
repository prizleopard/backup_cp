<?php
session_start();
include 'db.php'; // Include the database connection

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

// Fetch organizers data from the database
$query = "SELECT * FROM organizers";
$result_organizers = $conn->query($query);

// Fetch sports results
$sql = "SELECT * FROM sports_results";
$result_results = $conn->query($sql);

// Debugging
if (!$result_results) {
    echo "Error fetching results: " . $conn->error; // Display error if query fails
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Organizer Page</title>
    <link rel="stylesheet" href="Dashb_styles.css"> 
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Organizer Page</span>
        </a>
        <ul class="side-menu top">
            <li><a href="sports.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li class="active"><a href="#"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="scheduling.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="#"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="dashorg.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="insert_result.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
            <li><a href="school_gallery.php"><i class='bx bxs-building-house'></i><span class="text">Schools</span></a></li>
            <li><a href="students.php"><i class='bx bxs-folder-open'></i><span class="text">Teams</span></a></li>
            <li><a href="#"><i class='bx bxs-map-pin'></i><span class="text">Venues</span></a></li>
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
                <ul>
                    <li><a href="school_gallery.php">Schools</a></li>
                </ul>
            </div>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile"><img src="toge.png" alt="Profile Image"></a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN CONTENT -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Home</a></li>
                    </ul>
                </div>
                <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
            </div>

            <div class="organizer-container">
                <h2>Organizer List</h2>
                <a href="dashorg.php" class="btn-add-organizer">Add New Organizer</a> <!-- Link to add organizer page -->
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result_organizers->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['fname']) ?></td>
                                <td><?= htmlspecialchars($row['lname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                                <td>
                                    <a href="dashorg.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn-action">Edit</a>
                                    <a href="dash.php?id=<?= htmlspecialchars($row['id']) ?>" class="btn-action delete" onclick="return confirm('Are you sure?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="container">
                <h2>Recent Sports Results</h2>
                <?php
                if ($result_results->num_rows > 0) {
                    echo "<table><tr><th>Date</th><th>Sport</th><th>Team A</th><th>Score A</th><th>Team B</th><th>Score B</th><th>Status</th></tr>";
                    while($row = $result_results->fetch_assoc()) {
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
                ?>
            </div>

            <div class="monitor-container">
                <h2>Recently Posted Game Schedules</h2>
                <div class="schedule-filters">
                    <form method="GET" action="">
                        <button type="submit" name="filter" value="today" class="filter-button">Today</button>
                        <button type="submit" name="filter" value="yesterday" class="filter-button">Yesterday</button>
                        <input type="month" name="month" class="month-picker">
                        <button type="submit" value="month" class="filter-button">Filter by Month</button>
                    </form>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Sport</th>
                            <th>Round Type</th>
                            <th>Team A</th>
                            <th>Team B</th>
                            <th>Match Date</th>
                            <th>Venue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'schedconn.php'; // Include database connection for schedules
                        date_default_timezone_set('Asia/Manila'); // Set timezone

                        // Default SQL query for recent schedules
                        $filter_sql = "SELECT sport, round_type, team_a, team_b, match_date, venue FROM schedules WHERE 1";

                        // Apply filters based on user selection
                        if (isset($_GET['filter'])) {
                            $filter = $_GET['filter'];
                            if ($filter == 'today') {
                                $filter_sql .= " AND DATE(match_date) = CURDATE()";
                            } elseif ($filter == 'yesterday') {
                                $filter_sql .= " AND DATE(match_date) = CURDATE() - INTERVAL 1 DAY";
                            }
                        }
                        if (isset($_GET['month'])) {
                            $month = $_GET['month'];
                            $filter_sql .= " AND DATE_FORMAT(match_date, '%Y-%m') = '$month'";
                        }

                        // Execute the query
                        $result_schedule = $conn->query($filter_sql);

                        if ($result_schedule && $result_schedule->num_rows > 0) {
                            while ($row = $result_schedule->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['sport']}</td>
                                        <td>{$row['round_type']}</td>
                                        <td>{$row['team_a']}</td>
                                        <td>{$row['team_b']}</td>
                                        <td>{$row['match_date']}</td>
                                        <td>{$row['venue']}</td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No recent schedules found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
        <!-- MAIN CONTENT -->
    </section>
    <!-- CONTENT -->

    <script src="script.js"></script>
</body>
</html>
