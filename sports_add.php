<?php
// Include database connection

$servername1 = "localhost"; // or your server address
$username1 = "root"; // replace with your database username
$password1 = ""; // replace with your database password
$dbname1 = "sdms"; // your database name

// Create connection
$conn = new mysqli($servername1, $username1, $password1, $dbname1);    

if (isset($_POST['delete'])) {
    $sport = $conn->real_escape_string($_POST['sport']);
    $sql = "DELETE FROM sportlist WHERE ID='$sport'";
    $res = mysqli_query($conn,$sql);
    ?>
    <script>
        alert("Success")
    </script>
    <?php

}
if(isset($_POST['add_'])){
    $srpot = $conn->real_escape_string($_POST['sport']);
    try {
        $s = "INSERT INTO `sportlist` (`SPORTSNAME`) VALUES('$srpot')";
        $r = mysqli_query($conn,$s);
        ?>
        <script>
            alert("Success");
        </script>
        <?php

    } catch (\Throwable $e) {
        ?>
        <script>
            alert(<?=$e->getMessage()?>)
        </script>
        <?php
    }
}
if (isset($_POST['edit_'])) {
    $sportId = $conn->real_escape_string($_POST['sport_id']);
    $sportName = $conn->real_escape_string($_POST['sport_name']);
    $sql = "UPDATE sportlist SET SPORTSNAME='$sportName' WHERE ID='$sportId'";
    $res = mysqli_query($conn, $sql);
    ?>
    <script>
        alert("Sport updated successfully.");
    </script>
    <?php
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
.edit-button {
    background-color: #FF9800;
    color: white;
    padding: 8px;
    border-radius: 4px;
}

.edit-button:hover {
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
            <li><a href="trylang.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="trymessage.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
            <li class="active"><a href="sports_add.php"><i class='bx bxs-tennis-ball'></i><span class="text">Sports</span></a></li>
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
        <h1>Manage Sports </h1>
        <form action="<?php htmlspecialchars('PHP_SELF') ?>" method="POST">
            <label for="">Sport</label>
            <input type="text" name="sport" required>
            <button type="submit" name="add_">Add Sport</button>
        </form>
          <!-- Edit Sport Form -->
          <?php if (isset($_GET['edit'])): ?>
            <?php
            $sportId = $_GET['edit'];
            $result = mysqli_query($conn, "SELECT * FROM sportlist WHERE ID = '$sportId'");
            $sport = mysqli_fetch_assoc($result);
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="hidden" name="sport_id" value="<?= $sport['ID']; ?>">
                <label for="sport_name">Edit Sport</label>
                <input type="text" name="sport_name" value="<?= $sport['SPORTSNAME']; ?>" required>
                <button type="submit" name="edit_">Update Sport</button>
            </form>
        <?php endif; ?>
        <table>
            <thead>
                <tr>
                    <th>Sports</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $sql = "SELECT * FROM sportlist ORDER BY created_at DESC";
                $result = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?=$row['SPORTSNAME'];?></td>
                        <td>
                            <!-- Edit Button -->
                            <a href="?edit=<?= $row['ID']; ?>" class="edit-button">Edit</a>
                            <!-- Delete Button -->
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="sport" value="<?= htmlspecialchars($row['ID']); ?>">
                                <button class="delete-button" name="delete">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }

                ?>

            </tbody>
        </table>

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