<?php



// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "organizers";

$conn = new mysqli($servername, $username, $password, $dbname);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add, edit, and delete requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add organizer
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $sql = "INSERT INTO organizers (fname, lname, email, contact, role, password) VALUES ('$fname', '$lname', '$email', '$contact', '$role', '$password')";
        $conn->query($sql);
    } elseif (isset($_POST['edit'])) {
        // Edit organizer
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $role = $_POST['role'];
        // Only update password if it is provided
        $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        $sql = "UPDATE organizers SET fname='$fname', lname='$lname', email='$email', contact='$contact', role='$role' " . ($password ? ", password='$password'" : "") . " WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        // Delete organizer
        $id = $_POST['id'];
        $sql = "DELETE FROM organizers WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch all organizers
$sql = "SELECT id, fname, lname, email, contact, role FROM organizers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Coordinators Page</title>
    <link rel="stylesheet" href="dashbstyle.css"> 
</head>
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
        <a href="odashboard.php" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Organizers Page</span>
        </a>
        <ul class="side-menu top">
            <li><a href="obracketing.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li><a href="odashboard.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="ogamesched.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li class="active"><a href="oorganizers.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="oresults.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
        </ul>

        <ul class="side-menu">
            
            <li><a href="ologin_form.php" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>
    <!-- SIDEBAR -->

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

        <main>
            <h2>Organizer List</h2>
            <div class="table-container">
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
                        <?php while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </main>
    </section>
    <script src="script.js"></script> <!-- Link your JavaScript file -->
    
<?php $conn->close(); ?>
</body>
</html>

