<?php
// Include database connection
include 'schedconn.php';

// Message variable to hold feedback
$message = "";

// Add schedule logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_schedule'])) {
    $sport = $conn->real_escape_string($_POST['sport']);
    $round_type = $conn->real_escape_string($_POST['round_type']);
    $team_a = $conn->real_escape_string($_POST['team_a']);
    $team_b = $conn->real_escape_string($_POST['team_b']);
    $match_date = $conn->real_escape_string($_POST['match_date']);
    $venue = $conn->real_escape_string($_POST['venue']);

    $stmt = $conn->prepare("INSERT INTO schedules (sport, round_type, team_a, team_b, match_date, venue) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $sport, $round_type, $team_a, $team_b, $match_date, $venue);

    if ($stmt->execute()) {
        $message = "New schedule created successfully.";
    } else {
        $message = "Error adding schedule: " . $stmt->error;
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

    $stmt = $conn->prepare("UPDATE schedules SET round_type=?, match_date=?, venue=? WHERE sport=? AND team_a=? AND team_b=?");
    $stmt->bind_param("ssssss", $round_type, $match_date, $venue, $sport, $team_a, $team_b);

    if ($stmt->execute()) {
        $message = "Schedule updated successfully.";
    } else {
        $message = "Error updating schedule: " . $stmt->error;
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
        $message = "Error deleting schedule: " . $stmt->error;
    }
    $stmt->close();
}

// Delete all schedules logic
if (isset($_POST['delete_all'])) {
    $stmt = $conn->prepare("DELETE FROM schedules");

    if ($stmt->execute()) {
        $message = "All schedules deleted successfully.";
    } else {
        $message = "Error deleting all schedules: " . $stmt->error;
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
    <title>Admin Page</title>
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

.container {
    max-width: 100%;
    margin: 20px auto;
    background: #ffffff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
    width: 95%;  /* Adjusts container to be flexible on small screens */
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

/* Form inputs and buttons */
input[type="text"],
input[type="datetime-local"],
select,
button {
    width: 100%;  /* Full width on small screens */
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

button {
    padding: 10px 20px; /* Adjusted padding for consistent button size */
    color:#1976D2;
    font-size: 1em;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: auto; /* Ensures buttons don’t stretch or shrink unnaturally */
    display: inline-block;
}

/* Button colors */
.update-button {
    background-color: #4CAF50; /* Green for update */
    color: #fff;
    border-radius: 3px;
}


.send-button {
    background-color: #2196F3; /* Blue for send */
    color: #fff;
}

.delete-button {
    background-color: #F44336; /* Red for delete */
    color: #fff;
}

.edit-button {
    background-color: #FF9800; /* Orange for edit */
    color: #fff;
}

/* Hover effects for each button */
.update-button:hover {
    background-color: #45a049; /* Darker green for hover */
}

.send-button:hover {
    background-color: #1976D2; /* Darker blue for hover */
}

.delete-button:hover {
    background-color: #D32F2F; /* Darker red for hover */
}

.edit-button:hover {
    background-color: #FF5722; /* Darker orange for hover */
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

/* Specific button sizes for consistency */
.update-button,
.send-button,
.delete-button,
.edit-button {
    width: 150px; /* Fixed width to keep buttons uniform */
    padding: 10px;
    text-align: center; /* Center text inside the button */
}

/* Optional: Adjust table buttons */
table td button {
    width: 150px; /* Fixed width to maintain consistent button size in the table */
    padding: 8px;
    margin: 5px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 15px;
        margin: 10px;
        width: 90%; /* Ensures container uses less width on smaller screens */
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

    input[type="text"],
    input[type="datetime-local"],
    select,
    button {
        width: 100%;
        font-size: 0.9em;
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

@media print {
    .update-button,
    .send-button,
    .delete-button,
    .edit-button,
    .home-button,
    form[onsubmit], 
    .button-group {
        display: none !important;
    }
}
@media print {
    th:nth-child(8), /* Hide the "Actions" header (8th column in your table) */
    td:nth-child(8)  /* Hide all "Actions" data cells (8th column) */ {
        display: none;
    }

    /* Optionally, hide other buttons outside the table */
    .update-button, .send-button, .delete-button, .edit-button, form[onsubmit] {
        display: none !important;
    }
}

</style>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="Dashb.php" class="brand">
        <i class='bx bx-group'></i>
            <span class="text">Admin Page</span>
        </a>
        <ul class="side-menu top">
            
            <li><a href="Dashb.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li class="active"><a href="trylang.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="trymessage.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
            <li><a href="sports_add.php"><i class='bx bxs-tennis-ball'></i><span class="text">Sports</span></a></li>
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
            window.location.href = "login_form.php"; // Redirect to login form if confirmed
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
    <div class="container">
        <h1>Manage Game Schedules</h1>
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'Error') !== false ? 'error' : '' ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php htmlspecialchars('PHP_SELF') ?>" method="POST">
            <select name="sport" id="" required >
                <option value="" selected disabled>Choose Sports</option>
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
                    ?>
                    <option value="<?php echo $row['SPORTSNAME']?>"><?php echo $row['SPORTSNAME']?></option>
                    <?php
                }
                
                ?>
            </select>
           
            <input type="text" name="round_type" placeholder="Round Type" required>
            <select name="team_a" id=""required >
                <option value="" selected disabled>Select Team A</option>
                <?php
               
                
                $sqlll = "SELECT * FROM venues";
                $results = mysqli_query($conn1,$sqlll);
                foreach($results as $row){
                    ?>
                    <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                    <?php
                }
                
                ?>
            </select>
            <select name="team_b" id=""required >
            <option value="" selected disabled>Select Team B</option>
            <?php
            $sqlll = "SELECT * FROM venues";
            $results = mysqli_query($conn1,$sqlll);
            foreach($results as $row){
                ?>
                <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                <?php
            }
            ?>
            </select>
            
            <input type="datetime-local" name="match_date" required>
            
            <select name="venue" id=""required >
                <option value=""selected disabled>Select Venue</option>
                <?php
                $sqlll = "SELECT * FROM venues";
                $results = mysqli_query($conn1,$sqlll);
                foreach($results as $row){
                    ?>
                    <option value="<?php echo $row['id']?>"><?php echo $row['name']?></option>
                    <?php
                }
                
                ?>
            </select>
            <button type="submit" name="add_schedule">Add Schedule</button>
        </form>

        <form method="POST">
            <input type="text" name="search_query" placeholder="Search schedules">
            <button type="submit" name="search">Search</button>
        </form>
        <button class="color-button" onclick="printSelectedContainers()">Print Selected Containers</button>
 
 <div id="container1" class="container">
     <label>
     <input type="checkbox" class="print-checkbox" data-target="container1">
     Select Container 1
 </label>
        <table>
            <thead>
                <tr>
                    <th>Sport</th>
                    <th>Round Type</th>
                    <th>Team A</th>
                    <th>Team B</th>
                    <th>Match Date</th>
                    <th>Venue</th>
                    <th>Winner</th>
                    <th>Actions</th>
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
                            
                         echo @$row['winner']."</br>".@$row['score'];

                            ?>
                        </td>
                        <td>
                            
                        <a href="updateresult.php?id=<?php echo $row['id']?>" class="update-button">Update</a>
                        <button class="send-button" onclick="sendsms(<?php echo $row['id']?>)">Send SMS</button>
                            <button class="edit-button" onclick="editSchedule('<?= htmlspecialchars($row['sport']); ?>', '<?= htmlspecialchars($row['round_type']); ?>', '<?= htmlspecialchars($row['team_a']); ?>', '<?= htmlspecialchars($row['team_b']); ?>', '<?= htmlspecialchars($row['match_date']); ?>', '<?= htmlspecialchars($row['venue']); ?>')">Edit</button>
                            <form method="POST" style="display:inline;" onsubmit="return confirmDeleteItem();">
    <input type="hidden" name="sport" value="<?= htmlspecialchars($row['sport']); ?>">
    <input type="hidden" name="team_a" value="<?= htmlspecialchars($row['team_a']); ?>">
    <input type="hidden" name="team_b" value="<?= htmlspecialchars($row['team_b']); ?>">
    <button class="delete-button" name="delete_schedule">Delete</button>
</form>

                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
                </table>
                </div>
                <div class="button-group">
    <div class="home-button">
    <form method="POST" onsubmit="return confirmDelete();">
        <button class="delete-button" name="delete_all">Delete All Schedules</button>
    </form>
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
<script>
    function confirmDeleteItem() {
        return confirm("Are you sure you want to delete this schedule? This action cannot be undone.");
    }
</script>
<script>
function printSelectedContainers() {
    const printCheckboxes = document.querySelectorAll('.print-checkbox:checked');
    const printContents = Array.from(printCheckboxes)
        .map(checkbox => document.getElementById(checkbox.dataset.target).innerHTML)
        .join('');
    
    const originalContents = document.body.innerHTML;

    // Temporarily remove action buttons from content
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = printContents;
    tempDiv.querySelectorAll('.update-button, .send-button, .delete-button, .edit-button').forEach(button => button.remove());

    // Print the modified content
    document.body.innerHTML = tempDiv.innerHTML;
    window.print();
    document.body.innerHTML = originalContents;
}

</script>
            </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>