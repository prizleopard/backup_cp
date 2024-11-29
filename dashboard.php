<?php
// Start a session or any necessary PHP configurations
session_start();
include 'db.php'; // Include the database connection

// Fetch organizers data from the database
$query = "SELECT * FROM organizers";
$result = $conn->query($query);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Coordinator Page</title>
    <link rel="stylesheet" href="dashbstyle.css"> 
</head>
<style>
    <style>
    /* Container for the table */
    .table-container {
        background-color: #fff; /* White background for contrast */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 1000px;
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        overflow-x: auto;
    }

    /* Table Styling */
    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #2e3b56; /* Darker blue for the table */
        color: #fff;
    }

    table, th, td {
        border: 1px solid #4b5a6d;
    }

    th {
        background-color: #1e3a8a;
        color: white;
        padding: 12px;
        text-align: left;
        font-weight: bold;
    }

    td {
        padding: 10px;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #3a4b6f; /* Slightly lighter for alternate rows */
    }

    tr:hover {
        background-color: #4b5a6d;
        cursor: pointer;
    }

    /* Buttons inside the table */
    .action-button {
        display: inline-block;
        padding: 8px 16px;
        margin: 2px;
        border-radius: 5px;
        font-size: 14px;
        color: white;
        cursor: pointer;
        text-align: center;
    }

    .edit-button {
        background-color: #218838;
    }

    .edit-button:hover {
        background-color: #28a745;
    }

    .delete-button {
        background-color: #f44336;
    }

    .delete-button:hover {
        background-color: #c62828;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        table, th, td {
            font-size: 14px;
        }

        .table-container {
            max-width: 100%;
        }

        h2 {
            font-size: 24px;
        }
    }

    @media (max-width: 480px) {
        h2 {
            font-size: 20px;
        }

        th, td {
            font-size: 12px;
        }

        .action-button {
            padding: 6px 12px;
            font-size: 12px;
        }
    }

    /* Create Organizer Button */
    .add-organizer-btn {
        display: inline-block;
        padding: 5px 15px;
        background-color: #28a745; /* Green background */
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 20px;
    }

    .add-organizer-btn:hover {
        background-color: #218838; /* Darker green on hover */
        transform: scale(1.05); /* Slightly enlarges button on hover */
    }

    .add-organizer-btn:active {
        background-color: #1e7e34; /* Even darker green when clicked */
        transform: scale(1); /* Normal size when button is pressed */
    }

    .add-organizer-btn:focus {
        outline: none; /* Removes the outline when focused */
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.6); /* Green outline when focused */
    }

    /* Spacing between sections */
    .form-container {
        margin-top: 40px; /* Adds space between the table and the form */
    }

    h2:hover {
    color: #28a745; /* Changes text color to green when hovered */
    cursor: pointer; /* Changes cursor to pointer to indicate interactivity */
    
}

</style>
</style>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="Dashb.php" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Coordinator Page</span>
        </a>
        <ul class="side-menu top">
            <li><a href="trylangdin.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li class="active"><a href="Dashb.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="trylang.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="trymessage.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="tryresult.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
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
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
    <div>

    </div>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile"><img src="sanluis.jpg" alt="Profile Image"></a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN CONTENT -->
        <main>
        <h2>Organizer List</h2>
                <a href="dashorg.php" class="btn-add-organizer">Add New Organizer</a> <!-- Link to the add organizer page -->
                <table>
                    <thead>
                        <tr>

                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <th>Role</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>

                                <td><?= htmlspecialchars($row['fname']) ?></td>
                                <td><?= htmlspecialchars($row['lname']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['contact']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                                <td>
                            
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <ul class="box-info">
                <div class="monitor-container">
                    <h2>Recently Posted Game Schedules</h2>
                    <!-- Filter Options for Today, Yesterday, and Month Picker -->
                    <div class="schedule-filters">
                        <form method="GET" action="">
                            <button type="submit" name="filter" value="today" class="filter-button">Today</button>
                            <button type="submit" name="filter" value="yesterday" class="filter-button">Yesterday</button>
                            <input type="month" name="month" class="month-picker" />
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
                            // Include database connection
                            include 'schedconn.php';

                            // Set the timezone based on the user's region (Example: Asia/Manila)
                            date_default_timezone_set('Asia/Manila');

                            // Default SQL: Fetch the most recent schedules
                            $filter_sql = "SELECT sport, round_type, team_a, team_b, match_date, venue FROM schedules WHERE 1";

                            // Check which filter is applied
                            if (isset($_GET['filter'])) {
                                $filter = $_GET['filter'];
                                if ($filter == 'today') {
                                    // Filter for today's schedules
                                    $filter_sql .= " AND DATE(match_date) = CURDATE()";
                                } elseif ($filter == 'yesterday') {
                                    // Filter for yesterday's schedules
                                    $filter_sql .= " AND DATE(match_date) = CURDATE() - INTERVAL 1 DAY";
                                }
                            }

                            // Check if a specific month was selected using the month picker
                            if (isset($_GET['month']) && !empty($_GET['month'])) {
                                $selected_month = $_GET['month']; // Format: YYYY-MM
                                // Extract year and month from the selected month
                                $year = date('Y', strtotime($selected_month));
                                $month = date('m', strtotime($selected_month));
                                // Filter for the selected month and year
                                $filter_sql .= " AND YEAR(match_date) = '$year' AND MONTH(match_date) = '$month'";
                            }

                            // Order by match date descending and limit to 5 results
                            $filter_sql .= " ORDER BY match_date DESC LIMIT 5";

                            // Execute the query
                            $monitor_result = $conn->query($filter_sql);
                            while ($monitor_row = $monitor_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($monitor_row['sport']); ?></td>
                                    <td><?= htmlspecialchars($monitor_row['round_type']); ?></td>
                                    <td><?= htmlspecialchars($monitor_row['team_a']); ?></td>
                                    <td><?= htmlspecialchars($monitor_row['team_b']); ?></td>
                                    <td><?= htmlspecialchars($monitor_row['match_date']); ?></td>
                                    <td><?= htmlspecialchars($monitor_row['venue']); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </ul>
       

        </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>