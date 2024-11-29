<?php
// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_form.php"); // Redirect to login page if not logged in
    exit();
}

// Database connection
$host = 'localhost'; // Change this if your database is hosted elsewhere
$user = 'root';  // Your MySQL username
$password = ''; // Your MySQL password
$dbname = 'sanluis_school'; // Your updated database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch school data from the database
$sql = "SELECT name, image, description, location_link FROM sanluis_school";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Gallery</title>
    <style>
        /* Abstract Background Animation */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(45deg, #7fcfff, #007BFF, #ffa07a);
            background-size: 400% 400%;
            animation: backgroundShift 12s ease infinite;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        @keyframes backgroundShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #ffffff;
            font-size: 2.5em;
            letter-spacing: 1px;
            text-shadow: 1px 2px 5px rgba(0, 0, 0, 0.3);
        }

        p {
            color: #eeeeee;
            font-size: 1.2em;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Button Styling */
        .button {
            margin: 20px 0; /* Added margin for spacing */
            padding: 10px 20px;
            background-color: #007BFF; /* Button color */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3; /* Hover color */
        }

        /* Gallery Grid */
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px;
            width: 100%;
        }

        /* School Cards */
        .school-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .school-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .school-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .school-info {
            padding: 20px;
            text-align: center;
        }

        .school-info h2 {
            font-size: 1.5em;
            color: #007BFF;
            margin: 10px 0;
        }

        .school-info p {
            color: #555;
            margin: 10px 0;
        }

        /* Location Button */
        .location-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .location-button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        /* Footer Styling */
        footer {
            text-align: center;
            margin-top: 30px;
            color: #ffffff;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <header>
        <h1>School Gallery</h1>
        <p>Explore our featured schools below:</p>
    </header>

    <div class="gallery">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="school-card">
                    <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" class="school-image">
                    <div class="school-info">
                        <h2><?php echo $row['name']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                        <a href="<?php echo $row['location_link']; ?>" target="_blank" class="location-button">View Location</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No schools found.</p>
        <?php endif; ?>
    </div>

    <!-- Buttons at the Bottom -->
    <button class="button" onclick="goBack()">Go Back</button>
    <button class="button" onclick="window.location.href='school_gallery_upload.php'">Add School</button>

    <footer>
        <p>&copy; 2024 School Gallery. All rights reserved.</p>
    </footer>

    <!-- JavaScript for Back Button -->
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
