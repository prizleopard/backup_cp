<?php

// Include database connection
include 'schedconn.php';

// Message variable to hold feedback
$message = "";

// Insert schedule logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_schedule'])) {
    $sport = $conn->real_escape_string($_POST['sport']);
    $round_type = $conn->real_escape_string($_POST['round_type']);
    $team_a = $conn->real_escape_string($_POST['team_a']);
    $team_b = $conn->real_escape_string($_POST['team_b']);
    $match_date = $conn->real_escape_string($_POST['match_date']);
    $venue = $conn->real_escape_string($_POST['venue']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO schedules (sport, round_type, team_a, team_b, match_date, venue) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $sport, $round_type, $team_a, $team_b, $match_date, $venue);

    if ($stmt->execute()) {
        $message = "New schedule created successfully.";

        
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Edit schedule logic
if (isset($_POST['edit_schedule'])) {
    $sport = $conn->real_escape_string($_POST['sport']);
    $round_type = $conn->real_escape_string($_POST['round_type']);
    $team_a = $conn->real_escape_string($_POST['team_a']);
    $team_b = $conn->real_escape_string($_POST['team_b']);
    $match_date = $conn->real_escape_string($_POST['match_date']);
    $venue = $conn->real_escape_string($_POST['venue']);

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE schedules SET round_type=?, match_date=?, venue=? WHERE sport=? AND team_a=? AND team_b=?");
    $stmt->bind_param("sssss", $round_type, $match_date, $venue, $sport, $team_a, $team_b);

    if ($stmt->execute()) {
        $message = "Schedule updated successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Delete schedule logic
if (isset($_POST['delete_schedule'])) {
    $sport = $conn->real_escape_string($_POST['sport']);
    $team_a = $conn->real_escape_string($_POST['team_a']);
    $team_b = $conn->real_escape_string($_POST['team_b']);

    $stmt = $conn->prepare("DELETE FROM schedules WHERE sport=? AND team_a=? AND team_b=?");
    $stmt->bind_param("sss", $sport, $team_a, $team_b);

    if ($stmt->execute()) {
        $message = "Schedule deleted successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Delete all schedules logic
if (isset($_POST['delete_all'])) {
    $stmt = $conn->prepare("DELETE FROM schedules");

    if ($stmt->execute()) {
        $message = "All schedules deleted successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Search functionality
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = $conn->real_escape_string($_POST['search_query']);
}

$sql = "SELECT * FROM schedules WHERE sport LIKE '%$search_query%' OR team_a LIKE '%$search_query%' OR team_b LIKE '%$search_query%'";
$result = $conn->query($sql);


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
/* General body and container styles */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
    line-height: 1.6;
}
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
.container {
    max-width: 1000px;
    margin: 20px auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
}

/* Form inputs and buttons */
input[type="text"],
input[type="datetime-local"],
select,
button {
    /* width: calc(100% - 22px); */
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

button {
    background-color: #3a506b;
    color: #ffffff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

/* Alert messages */
.alert {
    padding: 10px;
    margin-bottom: 20px;
    color: white;
    background-color: #28a745;
    border-radius: 4px;
}

.alert.error {
    background-color: #dc3545;
}

/* Table styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #3a506b;
    color: white;
}

/* Button variants */
.edit-button {
    background-color: #FFD700;
    color: #333;
}

.edit-button:hover {
    background-color: #FFC107;
}

.update-button {
    background-color: #2196f3;
    color: #fff;
    border-radius: 5px;
    padding: 8px;
}

.update-button:hover {
    background-color: #1769aa;
}

.send-button {
    background-color: #4caf50;
    color: #fff;
    padding: 8px;
    border-radius: 5px;
}

.send-button:hover {
    background-color: #2e7d32;
}

.delete-button {
    background-color: #FF4136;
    color: white;
    padding: 8px;
}

.delete-button:hover {
    background-color: #C0392B;
}


/* Responsive adjustments */
@media (max-width: 600px) {
    .container {
        padding: 15px;
        margin: 10px;
    }

    h1, h2 {
        font-size: 1.5em;
    }

    table {
        font-size: 0.9em;
    }

    th, td {
        padding: 6px;
    }


}

/* Navbar styling */
nav {
    color: white;
    padding: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

nav input[type="search"] {
    width: 200px;
    padding: 8px;
    border: none;
    border-radius: 4px;
}

nav .profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

nav .search-btn {
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    margin-left: 8px;
}


/* Miscellaneous styles */
td:last-child {
    text-align: center;
    padding: 10px;
}

td:last-child button,
td:last-child a,
td:last-child form {
    display: inline-block;
    margin: 2px;
}
.button-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.button-group form, .button-group .home-button {
    margin: 0;
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
@media print {
    /* Remove unnecessary elements */
    #sidebar, nav, .alert, .button-group, .profile { 
        display: none; 
    }
    
    /* Adjust table appearance */
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }
    
    /* Optionally adjust font size or other elements for printing */
    body {
        font-size: 12px;
    }
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
            
            <li><a href="odashboard.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li class="active"><a href="ogamesched.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
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
        <!-- Sidebar Content -->
    </section>

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

        <!-- MAIN CONTENT -->
        <main>
        <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete all schedules?");
        }

        function editSchedule(sport, roundType, teamA, teamB, matchDate, venue) {
            document.querySelector('input[name="sport"]').value = sport;
            document.querySelector('input[name="round_type"]').value = roundType;
            document.querySelector('input[name="team_a"]').value = teamA;
            document.querySelector('input[name="team_b"]').value = teamB;
            document.querySelector('input[name="match_date"]').value = matchDate;
            document.querySelector('input[name="venue"]').value = venue;
        }
    </script>
</head>
<body>
<button onclick="printPage()" class="send-button">Print Schedules</button>
<script>
    function printPage() {
        var printContents = document.querySelector('.container').innerHTML; // Grab the content of the table
        var originalContents = document.body.innerHTML; // Store the original content of the page

        document.body.innerHTML = printContents; // Replace the body content with the table content
        window.print(); // Trigger the print dialog

        // Restore the original content after printing
        document.body.innerHTML = originalContents;
    }
</script>

    <div class="container">
        <h1>Game Schedules</h1>
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'Error') !== false ? 'error' : '' ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php htmlspecialchars('PHP_SELF') ?>" method="POST">
    <?php
     $servername1 = "localhost"; // or your server address
     $username1 = "root"; // replace with your database username
     $password1 = ""; // replace with your database password
     $dbname1 = "sdms"; // your database name
     
     // Create connection
     $conn1 = new mysqli($servername1, $username1, $password1, $dbname1);
     $sqlll = "SELECT * FROM sportlist";
    $results = mysqli_query($conn1,$sqlll);
    foreach($results as $row){
    }
    ?>
</select>

           


        <table>
            <thead>
                <tr>
                    <th>Sport</th>
                    <th>Round Type</th>
                    <th>Team A</th>
                    <th>Team B</th>
                    <th>Match Date</th>
                    <th>Venue</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['sport']); ?></td>
                        <td><?= htmlspecialchars($row['round_type']); ?></td>
                        <td><?php $teama= $row['team_a'];
                        $asql = "SELECT * FROM venues WHERE id = '$teama'";
                        $ares = mysqli_query($conn1,$asql);
                        $arow = mysqli_fetch_assoc($ares);
                        echo $arow['name'];
                        
                        
                        
                        
                        ?></td>
                        <td><?php
                        $teama= $row['team_b'];
                        $asql = "SELECT * FROM venues WHERE id = '$teama'";
                        $ares = mysqli_query($conn1,$asql);
                        $arow = mysqli_fetch_assoc($ares);
                        echo $arow['name'];
                        
                        ?></td>
                        <td><?= htmlspecialchars($row['match_date']); ?></td>
                        <td><?php
                         $teama= $row['venue'];
                         $asql = "SELECT * FROM venues WHERE id = '$teama'";
                         $ares = mysqli_query($conn1,$asql);
                         $arow = mysqli_fetch_assoc($ares);
                         echo $arow['name'];
                        
                        ?></td>
                        <td>
                            <?php
                            $winerid =  $row['winner'];
                            
                         echo @$arow['name']."</br>".@$row['score'];

                            ?>
                        </td>

                    </tr>
                <?php endwhile; ?>
            </tbody>
                </table>
</div>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    function sendsms(id) {
    // Show loader
    Swal.fire({
        title: 'Sending...',
        text: 'Please wait while we send the SMS.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Make the AJAX call
    $.ajax({
        url: 'sendsms.php',
        type: 'POST',
        data: { id: id },
        success: function(response) {
            // Parse the JSON response
            
            
        
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'The SMS was sent successfully.',
                    confirmButtonText: 'OK'
                });
            
        },
        error: function(xhr, status, error) {
            // Close the loader and show error message if AJAX request fails
            Swal.fire({
                icon: 'error',
                title: 'Failed!',
                text: 'There was an error sending the SMS.',
                confirmButtonText: 'Try Again'
            });
        }
    });
}

</script>
            </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>