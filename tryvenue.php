<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include 'venues_connection.php'; // Include database connection

// Fetch venues data from the database
$query = "SELECT * FROM venues ORDER BY name ASC"; // Fetch all venues and sort by name
$result = $conn->query($query);

// Check for query execution errors
if (!$result) {
    die("Query failed: " . $conn->error);
}

// Handle form submission for adding a new venue
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is for adding a venue
    if (isset($_POST['add_venue'])) {
        // Get the form data and sanitize
        $address = htmlspecialchars($_POST['address']);
        $contact = htmlspecialchars($_POST['contact']);
        $latitude = htmlspecialchars($_POST['latitude']);
        $longitude = htmlspecialchars($_POST['longitude']);
        $name = htmlspecialchars($_POST['name']);

        // Insert the data into the database
        $insert_query = "INSERT INTO venues (name, address, contact, latitude, longitude) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $name, $address, $contact, $latitude, $longitude);

        if ($stmt->execute()) {
            $message = "Venue added successfully!";
            // Refresh the venues list
            $result = $conn->query($query); // Re-fetch the venues
        } else {
            $message = "Error: " . $stmt->error;
        }
    }

    // Check if the form is for removing a venue
    if (isset($_POST['remove_venue'])) {
        $venue_id = intval($_POST['venue_id']); // Get the venue ID from the form

        // Delete the venue from the database
        $delete_query = "DELETE FROM venues WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $venue_id);

        if ($stmt->execute()) {
            $message = "Venue removed successfully!";
            // Refresh the venues list
            $result = $conn->query($query); // Re-fetch the venues
        } else {
            $message = "Error: " . $stmt->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Page</title>
    <link rel="stylesheet" href="Dashb_styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <title>Venues Page</title> 
</head>
<style>
    
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
    .form-container label {
        display: block;
        margin-bottom: 5px;
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
        background-color: #dc3545;
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
        display: flex; /* Use flexbox for layout */
        justify-content: space-between; /* Space between buttons */
        align-items: center; /* Center vertically */
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
        padding: 5px 10px;
        background-color: #28a745; /* Green color */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .view-button:hover {
        background-color: #218838; /* Darker green on hover */
    }
</style>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="Dashb.php" class="brand">
            <i class='bx bxs-face-mask'></i>
            <span class="text">Admin Page</span>
        </a>
        <ul class="side-menu top">
            <li><a href="trylangdin.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li><a href="Dashb.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="trylang.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li class="active"><a href="trymessage.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="insert_result.php"><i class='bx bxs-doughnut-chart'></i><span class="text">Results</span></a></li>
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
    <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
    <div>
        <ul>
        <li><a href="school_gallery.php">Schools </a></li>
        </ul>
    </div>
                <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile"><img src="toge.png" alt="Profile Image"></a>
        </nav>
        <!-- NAVBAR -->


        <main>
            <div id="content">
                <h1>Venues</h1>
                <p><?php if (isset($message)) echo $message; ?></p>
        
                <div class="map-container">
                    <div id="map"></div>
                </div>
        
                <div class="venue-list">
                    <h2>Venue List</h2>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="venue-item">
                            <div>
                                <h3><?php echo $row['name']; ?></h3>
                                <p>Address: <?php echo $row['address']; ?></p>
                                <p>Contact: <?php echo $row['contact']; ?></p>
                            </div>
                            <div>
                                <button class="view-button" onclick="viewVenue('<?php echo addslashes($row['name']); ?>', <?php echo $row['latitude']; ?>, <?php echo $row['longitude']; ?>)">View</button>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="venue_id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="remove_venue" class="remove-button">Remove</button>
                                </form>
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
        
                        <button type="submit" name="add_venue">Add Venue</button>
                    </form>
                </div>
            </div>
        
            <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
            <script>
                // Initialize the map
                var map = L.map('map').setView([14.5995, 120.9842], 13); // Default center (Metro Manila)
        
                // Add a tile layer to the map
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);
        
                // Initialize variable to hold the current marker
                var currentMarker;
        
                // Function to center the map on the selected venue
                function viewVenue(name, lat, lng) {
                    // Center the map on the venue's coordinates
                    map.setView([lat, lng], 15); // Zoom into the venue location
        
                    // Remove the existing marker if there is one
                    if (currentMarker) {
                        map.removeLayer(currentMarker);
                    }
        
                    // Create and add a new marker
                    currentMarker = L.marker([lat, lng]).addTo(map).bindPopup(name).openPopup();
                }
            </script>
                        </main>
        <!-- MAIN CONTENT -->

    </section>                 
    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>
