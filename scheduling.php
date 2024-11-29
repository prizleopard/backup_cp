<?php

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_form.php"); // Redirect to login page if not logged in
    exit();
}
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Scheduling</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            background-color: hsl(191, 17%, 20%);
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="datetime-local"],
        button {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }

        button {
            background-color: #007BFF;
            color: #ffffff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .edit-button {
            background-color: #FFD700;
            color: #333;
        }

        .edit-button:hover {
            background-color: #FFC107;
        }

        .delete-button {
            background-color: #FF4136;
            color: #ffffff;
        }

        .delete-button:hover {
            background-color: #C0392B;
        }

        .home-button {
            background-color: #008080;
            color: #f0f4f8;
            padding: 8px 12px;
            border-radius: 5px;
            text-align: center;
            display: block;
            width: 150px;
            transition: background-color 0.3s ease;
            margin: 20px auto;
        }

        .home-button a {
            display: block;
            color: #f0f4f8;
            text-decoration: none;
            font-size: 18px;
            text-align: center;
            width: 100%;
        }

        .home-button:hover {
            background-color: #005f5f;
        }

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
            background-color: #007BFF;
            color: white;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            color: white;
            background-color: #28a745;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .alert.error {
            background-color: #dc3545;
        }



        @media (max-width: 600px) {
            body {
                padding: 10px;
            }

            .container {
                padding: 10px;
            }

            input[type="text"],
            input[type="datetime-local"],
            button {
                width: calc(100% - 18px);
                padding: 8px;
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
    </style>
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
        <h1>Manage Sports Schedules</h1>
        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'Error') !== false ? 'error' : '' ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>
        <form action="<?php htmlspecialchars('PHP_SELF') ?>" method="POST">
            <select name="sport" id="">
                <option value="" selected disabled>Choose Sports</option>
                <?php
                 $servername1 = "localhost"; // or your server address
                 $username1 = "root"; // replace with your database username
                 $password1 = ""; // replace with your database password
                 $dbname1 = "venues"; // your database name
                 
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
            <select name="team_a" id="">
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
            <select name="team_b" id="">
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
            
            <select name="venue" id="">
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
                            $asql = "SELECT * FROM venues WHERE id = '$winerid'";
                         $ares = mysqli_query($conn1,$asql);
                         $arow = mysqli_fetch_assoc($ares);
                         echo @$arow['name']."</br>".@$row['score'];

                            ?>
                        </td>
                        <td>
                        <button class="edit-button" onclick="updateresult(<?php echo $row['id']?>)">Update Result</button>
                        <button class="edit-button" onclick="sendsms(<?php echo $row['id']?>)">Send SMS</button>
                            <button class="edit-button" onclick="editSchedule('<?= htmlspecialchars($row['sport']); ?>', '<?= htmlspecialchars($row['round_type']); ?>', '<?= htmlspecialchars($row['team_a']); ?>', '<?= htmlspecialchars($row['team_b']); ?>', '<?= htmlspecialchars($row['match_date']); ?>', '<?= htmlspecialchars($row['venue']); ?>')">Edit</button>
                            <form method="POST" style="display:inline;">
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

        <form method="POST" onsubmit="return confirmDelete();">
            <button class="delete-button" name="delete_all">Delete All Schedules</button>
        </form>



        <div class="home-button">
            <a href="Dashb.php">Go Back to Dashboard</a>
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
</body>
</html>

<?php $conn->close(); ?>
