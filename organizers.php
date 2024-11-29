


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


// Fetch all organizers
$sql = "SELECT id, fname, lname, email, contact, role,school_id FROM organizers"  ;
$result = $conn->query($sql);

// Fetch data for editing if requested
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_sql = "SELECT * FROM organizers WHERE id = $edit_id";
    $edit_result = $conn->query($edit_sql);
    $edit_data = $edit_result->fetch_assoc();
}
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
    /* Basic styles for the table and page layout */
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
        background-color: #3a4b6f; /* Slightly lighter for alternate rows */
    }

    tr:hover {
        background-color: #4b5a6d;
        cursor: pointer;
    }

    .delete-button {
    background-color: var(--red); /* Red color for delete button */
    color: var(--light); /* Light color for text */
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 14px;
    margin-left: 0px;
    transition: background-color 0.3s ease;
}
.edit-button {
    background-color:#FF9800;
    color: var(--light); /* Light color for text */
    border: none;
    border-radius: 4px;
    padding: 5px 10px;
    cursor: pointer;
    font-size: 14px;
    margin-left: 0px;
    transition: background-color 0.3s ease;
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

    /* Modal and form styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        margin: 5% auto;
        width: 90%;
        max-width: 400px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .modal-content h2 {
        margin-bottom: 15px;
        font-size: 1.5rem;
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
        transition: background-color 0.3s;
    }

    .modal-content button:hover {
        background-color: #45a049;
    }

    .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .modal-content {
            width: 80%;
        }

        .modal-content input, .modal-content button {
            font-size: 0.9rem;
            padding: 8px;
        }
    }

    @media (max-width: 480px) {
        .modal-content {
            width: 90%;
        }

        .modal-content input, .modal-content button {
            font-size: 0.8rem;
            padding: 6px;
        }
    }
</style>


<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="coordinators.php" class="brand">
        <i class='bx bx-group'></i>
            <span class="text">Organizer Page</span>
        </a>
        <ul class="side-menu top">
            
            <li><a href="odashboard.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="ogamesched.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li class="active"><a href="organizers.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
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
        <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
            <div></div>
            <a href="#" class="profile">
                <img src="sanluis.jpg" alt="Profile Image">
            </a>
        </nav>
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
                            <th>School</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conns = new mysqli("localhost", "root", "", "venues");
                         while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['fname']; ?></td>
                            <td><?php echo $row['lname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php 
                            $school = $row['school_id']; 
                            $dsql = "SELECT * FROM venues WHERE id = '$school'";
                            $sres = mysqli_query($conns,$dsql);
                            $dtrow = mysqli_fetch_assoc($sres);
                            echo @$dtrow['name'];
                            
                            
                            ?></td>
                        </td>

                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
            </div>

        </main>
    </section>
    <script src="script.js"></script>
</body>
</html>

<?php
$conn->close();
?>
