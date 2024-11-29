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
    <title>Organizer Page</title>
    <link rel="stylesheet" href="dashbstyle.css"> 
</head>
<style>
#sidebar {
    padding: 20px; /* Add inner spacing within the sidebar */}

#sidebar .brand {
    display: flex;
    align-items: center;
    gap: 10px; /* Space between the icon and text */
    margin-bottom: 20px; /* Space below the brand section */
    font-size: 1.2em; /* Slightly larger text for emphasis */
}

#sidebar .brand i {
    font-size: 1.5em; /* Increase icon size */
}


/* General container styles */
.organizer-container,
.monitor-container {
    width: 85%; /* Reduced width for better centering */
    max-width: 1200px;
    margin: 20px auto; /* Added vertical margin for better spacing */
    padding: 25px; /* Increased padding for breathing space */
    background-color: #f8fafc;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 20px;
}


/* Ensure equal size for all sections */
.organizer-container h2,
.monitor-container h2 {
    font-size: 24px;
    color: #3a506b; /* Primary blue */
    margin-bottom: 20px;
}

.organizer-container table,
.monitor-container table {
    width: 100%;
    overflow: auto;
    font-size: 16px;
}

table th, table td {
    padding: 10px;
    border: 1px solid #e0e7e9;
    text-align: left;
}

/* Action buttons */
.btn-action {
    background-color: #FFD700; 
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
    margin: 5px; /* Space between the buttons */
    text-align: center;
    display: inline-block;
}

.btn-action:hover {
    background-color: #dbbf25;
}

/* Distinct style for delete button */
.btn-action.delete {
    background-color: #e74c3c; /* Red color for delete */
}

.btn-action.delete:hover {
    background-color: #c0392b; /* Darker red for hover effect */
}

/* Add New Organizer and Filter buttons */
.btn-add-organizer,
.filter-button {
    background-color: #3a506b; /* Primary blue */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    font-size: 14px;
    text-align: center;
    transition: background-color 0.3s;
}

.btn-add-organizer:hover,
.filter-button:hover {
    background-color: #2c3e50; /* Darker blue for hover effect */
}

/* Responsive styles */
@media screen and (max-width: 768px) {
    .organizer-container, .monitor-container {
        padding: 15px;
        width: 95%; /* Slightly increase the container width on smaller screens */
    }

    table th, table td {
        font-size: 14px;
    }

    .btn-add-organizer, .filter-button,
    .btn-action {
        font-size: 12px;
        padding: 8px 15px;
    }
}

@media screen and (max-width: 480px) {
    .organizer-container, .monitor-container {
        padding: 10px;
        width: 100%; /* Use the full width of the screen */
    }

    table th, table td {
        font-size: 12px;
    }

    .btn-add-organizer, .filter-button,
    .btn-action {
        font-size: 10px;
        padding: 5px 10px;
    }
}


    /* Action buttons */
    .btn-action {
        background-color: #FFD700; 
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
        margin: 5px; /* Space between the buttons */
        text-align: center;
        display: inline-block;
    }

    .btn-action:hover {
        background-color: #dbbf25;
    }

    /* Distinct style for delete button */
    .btn-action.delete {
        background-color: #e74c3c; /* Red color for delete */
    }

    .btn-action.delete:hover {
        background-color: #c0392b; /* Darker red for hover effect */
    }

    /* Add New Organizer and Filter buttons */
    .btn-add-organizer,
    .filter-button {
        background-color: #3a506b; /* Primary blue */
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        font-size: 14px;
        text-align: center;
        transition: background-color 0.3s;
    }

    .btn-add-organizer:hover,
    .filter-button:hover {
        background-color: #2c3e50; /* Darker blue for hover effect */
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .organizer-container, .monitor-container {
            padding: 15px;
        }

        table th, table td {
            font-size: 14px;
        }

        .btn-add-organizer, .filter-button,
        .btn-action {
            font-size: 12px;
            padding: 8px 15px;
        }
    }

    @media screen and (max-width: 480px) {
        .organizer-container, .monitor-container {
            padding: 10px;
        }

        table th, table td {
            font-size: 12px;
        }

        .btn-add-organizer, .filter-button,
        .btn-action {
            font-size: 10px;
            padding: 5px 10px;
        }
    }

    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 20px;
        background-color: #f0f4f8; /* Light background */
    }

    nav .profile {
        margin-left: auto; /* Push the logo/image to the right */
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    th{
        background-color: #3a506b;
        color: white;
    }
    .container {
        width: 90%; /* Make the container take up 90% of the viewport width */
    max-width: 1200px; /* Set a max width for large screens */
    margin: 0 auto; /* Center the container */
    padding: 20px;
    background-color: #f8fafc; /* Light background */
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    gap: 20px;
    overflow: auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        .color-button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .color-button:hover {
            background-color: #45a049; /* Darker green */
        }
        .color-button:active {
            background-color: #3e8e41; /* Even darker green */
        }/* Add print styles to match container sizes */
@media print {
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 100%;
        max-width: 1200px; /* Match the max-width of the main content container */
        margin: 0 auto;
        padding: 20px;
        background-color: #f8fafc; /* Keep background */
        border-radius: 8px;
        box-shadow: none;
    }

    .monitor-container,
    .organizer-container {
        width: 100%;
        max-width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse; /* Ensures table spacing is consistent */
    }

    table th, table td {
        padding: 10px;
        border: 1px solid #ccc; /* Make table borders visible */
        text-align: left;
    }

    .btn-action, .filter-button, .color-button {
        display: none; /* Hide buttons for printing */
    }
}


.color-button {
    margin-top: 20px; /* Adjust the margin as needed */
    font-size: 16px;
    padding: 10px 20px;
}

/* Optional: Adjust the button's position if you need to change it to the bottom */
main .color-button {
    margin-top: auto;
    margin-bottom: 20px; /* Moves the button to the bottom */
}

</style>



<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="odashboard.php" class="brand">
        <i class='bx bx-group'></i>
            <span class="text">Organizer Page</span>
        </a>
        <ul class="side-menu top">
            
            <li class="active"><a href="odashbaord.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="ogamesched.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="organizers.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="ovenues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
        </ul>

        <ul class="side-menu">
    <li>
        <a href="#" class="logout" onclick="return confirmLogout();">
            <i class='bx bxs-log-out-circle'></i>
            <span class="text">Logout</span>
        </a>
    </li>
</ul>

<script>
    function confirmLogout() {
        var result = confirm("Are you sure you want to log out?");
        if (result) {
            window.location.href = "ologin_form.php"; // Redirect to login form if confirmed
        }
        return false; // Prevent default action if canceled
    }
</script>
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
            </div><br>
            <button class="color-button" onclick="printSelectedContainers()">Print Selected Containers</button>
 
 <div id="container1" class="container">
     <label>
     <input type="checkbox" class="print-checkbox" data-target="container1">
     Select Container 1
 </label>
            <ul class="box-info">
                <div class="monitor-container">
                    <h2>Recently Posted Game Schedules</h2>
                    <!-- Filter Options for Today, Yesterday, and Month Picker -->
                    <div class="schedule-filters">
                        <form method="GET" action="">
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
                             $servername1 = "localhost"; // or your server address
                            $username1 = "root"; // replace with your database username
                            $password1 = ""; // replace with your database password
                            $dbname1 = "venues"; // your database name
                            
                            // Create connection
                            $conn1 = new mysqli($servername1, $username1, $password1, $dbname1);
                            // Execute the query
                            $monitor_result = $conn->query($filter_sql);
                            while ($monitor_row = $monitor_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($monitor_row['sport']); ?></td>
                                    <td><?= htmlspecialchars($monitor_row['round_type']); ?></td>
                                    
                                    <td><?php $teama= $monitor_row['team_a'];
                                    $asql = "SELECT * FROM venues WHERE id = '$teama'";
                                    $ares = mysqli_query($conn1,$asql);
                                    $arow = mysqli_fetch_assoc($ares);
                                    echo $arow['name'];
                                    ?></td>
                                     <td><?php
                                        $teama= $monitor_row['team_b'];
                                        $asql = "SELECT * FROM venues WHERE id = '$teama'";
                                        $ares = mysqli_query($conn1,$asql);
                                        $arow = mysqli_fetch_assoc($ares);
                                        echo $arow['name'];
                                        
                                        ?></td>
                                    
                                    <td><?= htmlspecialchars($monitor_row['match_date']); ?></td>
                                    <td><?php
                                    $teama= $monitor_row['venue'];
                                    $asql = "SELECT * FROM venues WHERE id = '$teama'";
                                    $ares = mysqli_query($conn1,$asql);
                                    $arow = mysqli_fetch_assoc($ares);
                                    echo $arow['name'];
                                    
                                    ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </ul>
        </div>
        <br>

 <div id="container2" class="container">
     <label>
     <input type="checkbox" class="print-checkbox" data-target="container1">
     Select Container 2
 </label>
            <div class="organizer-container">
                <h2>Organizer List</h2>
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
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

            
        <script>
                function printSelectedContainers() {
                    var checkboxes = document.querySelectorAll('.print-checkbox');
                    var printContents = '';

                    checkboxes.forEach(function(checkbox) {
                        if (checkbox.checked) {
                            var targetId = checkbox.getAttribute('data-target');
                            var container = document.getElementById(targetId);
                            printContents += container.outerHTML + '<br><br>';
                        }
                    });

                    if (printContents === '') {
                        alert("Please select at least one container to print.");
                        return;
                    }

                    var printWindow = window.open('', '', 'width=800,height=600');
                    printWindow.document.write('<html><head><title>Print</title></head><body>');
                    printWindow.document.write(printContents);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                }

                // Helper function to fetch venue name by ID
                function getVenueName(venueId) {
                    <?php
                        // Add JavaScript to PHP function or AJAX here if needed for dynamic data fetching.
                    ?>
                    return "Venue Name"; // Placeholder, replace with actual venue fetching logic.
                }
            </script>

        </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>