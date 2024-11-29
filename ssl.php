<?php
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
$sql = "SELECT name, image, description, location_link FROM sanluis_school"; // Corrected table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Gallery</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
        }

        header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 {
            color: #333;
            font-size: 2.5em;
        }

        p {
            color: #555;
            font-size: 1.2em;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            max-width: 1200px; /* Max width for the gallery */
            width: 100%; /* Full width */
        }

        .school-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .school-card:hover {
            transform: scale(1.03);
        }

        .school-image {
            width: 100%;
            height: auto;
            display: block; /* Ensures there's no extra space below images */
        }

        .school-info {
            padding: 15px;
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

        .location-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .location-button:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
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

    <footer>
        <p>&copy; 2024 School Gallery. All rights reserved.</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
