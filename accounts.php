<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sdms"; // Database for organizers

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM organizers WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }
}

// Fetch all organizers
$sql = "SELECT id, fname, lname, email, contact, role, password, school_id FROM organizers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Accounts Management</title>
    <link rel="stylesheet" href="dashbstyle.css"> <!-- Use your existing styles -->
    <style>
        #sidebar {
            padding: 20px;
        }
        #sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 1.2em;
        }
        #sidebar .brand i {
            font-size: 1.5em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #2e3b56;
            color: #fff;
            margin-bottom: 20px;
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
            background-color: #3a4b6f;
        }
        tr:hover {
            background-color: #4b5a6d;
            cursor: pointer;
        }
        .delete-button {
            background-color: #FF4C4C;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover {
            background-color: #FF0000;
        }
        .add-organizer-btn {
            padding: 5px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }
        .add-organizer-btn:hover {
            background-color: #218838;
        }
        .action-buttons {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .action-button {
            padding: 5px 15px;
            font-size: 14px;
        }
        .action-button.edit-button {
            background-color: #FF9800;
        }
        .modal-content input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }
        .modal-content button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            table, th, td {
                font-size: 14px;
            }
        }
        @media (max-width: 480px) {
            th, td {
                font-size: 12px;
            }
            .action-button {
                padding: 6px 12px;
                font-size: 12px;
            }
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

    <script>
        // Function to toggle password visibility
        function togglePassword(id) {
            var passwordField = document.getElementById('password_' + id);
            var button = document.getElementById('toggleButton_' + id);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                button.innerHTML = 'Hide Password';
            } else {
                passwordField.type = 'password';
                button.innerHTML = 'Show Password';
            }
        }

        // Function to confirm deletion
        function confirmDelete() {
            var result = confirm("Are you sure you want to delete this account?");
            return result; // If 'OK' is clicked, form submission proceeds; if 'Cancel', it stops.
        }
    </script>
</head>
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
        <li class="active"><a href="accounts.php"><i class='bx bx-user'></i><span class="text">Accounts</span></a></li>
        <li><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
        <li><a href="sports_add.php"><i class='bx bxs-tennis-ball'></i><span class="text">Sports</span></a></li>
    </ul>
    <ul class="side-menu">
        <li><a href="#" class="logout" onclick="return confirmLogout();"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
    </ul>
</section>

<!-- CONTENT -->
<section id="content">
    <nav>
        <i class='bx bx-menu' id="menu-icon"></i>
        <div></div>
        <a href="#" class="profile"><img src="sanluis.jpg" alt="Profile Image"></a>
    </nav>
    <main>
        <h2>Manage Accounts</h2><br>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Role</th>
                        <th>Password</th>
                        <th>School ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['fname']; ?></td>
    <td><?php echo $row['lname']; ?></td>
    <td><?php echo $row['email']; ?></td>
    <td><?php echo $row['contact']; ?></td>
    <td><?php echo $row['role']; ?></td>
    <td>
    <input type="password" id="password_<?php echo $row['id']; ?>" value="<?php echo $row['password']; ?>">
    <button type="button" id="toggleButton_<?php echo $row['id']; ?>" onclick="togglePassword(<?php echo $row['id']; ?>)">Show Password</button>
</td>

    <td><?php echo $row['school_id']; ?></td>
    <td>
        <form method="post" style="display:inline;" onsubmit="return confirmDelete();">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="delete" class="action-button delete-button">Delete</button>
        </form>
    </td>
</tr>

                    <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</section>

</body>
</html>

<?php $conn->close(); ?>
