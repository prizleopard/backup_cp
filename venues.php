<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include 'venues_connection.php'; // Include database connection

// Initialize variables
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$school_type = isset($_GET['school_type']) ? trim($_GET['school_type']) : '';
$message = ""; // Message for user feedback

// Base query
$query = "SELECT * FROM venues";

// Modify the query based on search filters
if (!empty($search_term) && !empty($school_type)) {
    $query .= " WHERE name LIKE ? AND school_type = ?";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search_term . "%";
    $stmt->bind_param("ss", $search_param, $school_type);
} elseif (!empty($search_term)) {
    $query .= " WHERE name LIKE ?";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search_term . "%";
    $stmt->bind_param("s", $search_param);
} elseif (!empty($school_type)) {
    $query .= " WHERE school_type = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $school_type);
} else {
    $query .= " ORDER BY name ASC";
}

// Execute the query
if (isset($stmt)) {
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query($query);
}

// Handle form submission for adding a new venue
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_venue'])) {
        // Get and sanitize form inputs
        $name = htmlspecialchars($_POST['name']);
        $address = htmlspecialchars($_POST['address']);
        $contact = htmlspecialchars($_POST['contact']);
        $latitude = htmlspecialchars($_POST['latitude']);
        $longitude = htmlspecialchars($_POST['longitude']);
        $school_type = htmlspecialchars($_POST['school_type']);

        // Insert venue into database
        $insert_query = "INSERT INTO venues (name, address, contact, latitude, longitude, school_type) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssssss", $name, $address, $contact, $latitude, $longitude, $school_type);

        if ($stmt->execute()) {
            $message = "Venue added successfully!";
        } else {
            $message = "Error adding venue: " . $stmt->error;
        }
    }

    if (isset($_POST['remove_venue'])) {
        // Remove venue from database
        $venue_id = intval($_POST['venue_id']);
        $delete_query = "DELETE FROM venues WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $venue_id);

        if ($stmt->execute()) {
            $message = "Venue removed successfully!";
        } else {
            $message = "Error removing venue: " . $stmt->error;
        }
    }

    // Refresh results after modification
    $result = $conn->query("SELECT * FROM venues ORDER BY name ASC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="dashbstyle.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Venues Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
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
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container button {
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        .form-container input,
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .map-container {
            position: relative;
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        #map {
            width: 100%;
            height: 100%;
        }
        .remove-button {
            padding: 5px 10px;
            background-color: #FF4136;
            
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-button:hover {
            background-color: #c82333;
        }
        .venue-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .venue-item:last-child {
            border-bottom: none;
        }
        .venue-item h3 {
            margin: 0;
            font-size: 1.2em;
        }
        .venue-item p {
            margin: 5px 0;
            color: #666;
        }
        .venue-list {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .view-button {
        color: white;
        padding: 5px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .view-button {
        background-color: #2e7d32;
    }

    .view-button:hover {
        background-color: #2ea52e;
    }
    /* Add styles for the search button */
    .search-button {
            padding: 10px 15px;
            background-color: #2e7d32;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .search-button:hover {
            background-color: #2ea52e;
        }

        .search-button i {
            margin-right: 5px; /* Adds space between the icon and the text */
        }

        .form-input {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .form-input input {
            width: 80%;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .venue-list {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .form-input select {
    padding: 10px;
    margin-left: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
.alert {
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #2ea52e;
        color: white;
        text-align: center;
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
            <li class="active"><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
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
<section id="content">
<nav>
<i class='bx bx-menu' id="menu-icon"></i>
<a href="#" class="profile">
            <img src="sanluis.jpg" alt="Profile Image">
            </a>
</nav>
</section><br>
    <div id="content">
        <h1>Venues</h1>
        <div class="map-container">
            <div id="map"></div>
        </div>
        <form action="venues.php" method="GET">
    <div class="form-input">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Search venues by name..." />
        <select name="school_type">
            <option value="">All Types</option>
            <option value="Public" <?php echo ($school_type == 'Public') ? 'selected' : ''; ?>>Public</option>
            <option value="Private" <?php echo ($school_type == 'Private') ? 'selected' : ''; ?>>Private</option>
        </select>
        <button type="submit" class="search-button"><i class="bx bx-search"></i> Search</button>
    </div>
</form>


<?php if (!empty($message)): ?>
    <div class="alert" id="message-box"><?php echo htmlspecialchars($message); ?></div>
<?php endif; ?>
<script>
    // Automatically hide the message box after 3 seconds
    setTimeout(() => {
        const messageBox = document.getElementById('message-box');
        if (messageBox) {
            messageBox.style.transition = 'opacity 0.5s';
            messageBox.style.opacity = '0'; // Fade out
            setTimeout(() => messageBox.remove(), 500); // Remove after fade out
        }
    }, 3000); // 3 seconds
</script>

<div class="venue-list">
    <h2>Venue List</h2>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="venue-item">
            <div>
                <h3><?php echo $row['name']; ?></h3>
                <p>Address: <?php echo $row['address']; ?></p>
                <p>Contact: <?php echo $row['contact']; ?></p>
                <p>School Type: <?php echo $row['school_type']; ?></p>
            </div>
            <div>
                <button class="view-button" onclick="viewVenue('<?php echo $row['name']; ?>', <?php echo $row['latitude']; ?>, <?php echo $row['longitude']; ?>); scrollToMap();">View</button>
                <form method="POST" style="display: inline;" onsubmit="return confirmDelete();">
    <input type="hidden" name="venue_id" value="<?php echo $row['id']; ?>">
    <button type="submit" name="remove_venue" class="remove-button">Remove</button>
</form>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this venue? This action cannot be undone.");
    }
</script>
            </div>
        </div>
    <?php endwhile; ?>
</div>


<div class="form-container">
    <h2>Add New Venue</h2>
    <form method="POST">
        <label for="name">Venue Name</label>
        <input type="text" name="name" required>
        <label for="address">Address</label>
        <input type="text" name="address" required>
        <label for="contact">Contact Number</label>
        <input type="text" name="contact" required>
        <label for="latitude">Latitude</label>
        <input type="text" name="latitude" required>
        <label for="longitude">Longitude</label>
        <input type="text" name="longitude" required>
        <label for="school_type">School Type</label>
        <select name="school_type" required>
            <option value="Public">Public</option>
            <option value="Private">Private</option>
        </select>
        <button type="submit" name="add_venue">Add Venue</button>
    </form>
</div>

    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([13.840575202935764, 120.95251907816066], 13); // Default map center

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        function viewVenue(name, lat, lng) {
            map.setView(new L.LatLng(lat, lng), 13);
            L.marker([lat, lng]).addTo(map)
                .bindPopup("<b>" + name + "</b>")
                .openPopup();
        }

        function scrollToMap() {
            document.querySelector('.map-container').scrollIntoView({ behavior: 'smooth' });
        }
    </script>
            <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>


