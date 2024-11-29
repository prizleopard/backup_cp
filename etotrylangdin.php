<?php
$servername = "localhost"; // Update if necessary
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "news_feed"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    
    // Handle file upload
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $media = basename($_FILES['media']['name']);
        $upload_dir = "C:\\mine\\htdocs\\system\\uploads\\"; // Your upload directory
        $target_file = $upload_dir . $media;

        // Check file type and size (optional validation)
        $allowed_types = array('jpg', 'png', 'gif', 'jpeg');
        $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if (in_array($file_extension, $allowed_types)) {
            move_uploaded_file($_FILES['media']['tmp_name'], $target_file);

            // Insert post data into the database
            $sql = "INSERT INTO news_feed (title, content, media) VALUES ('$title', '$content', '$media')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New record created successfully');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "<script>alert('Invalid file type. Only JPG, PNG, GIF are allowed.');</script>";
        }
    }
}

// Fetch news posts
$sql = "SELECT * FROM news_feed ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Admin Page</title>
    <link rel="stylesheet" href="Dashb_styles.css"> 
</head>
<style>
.container {
    max-width: 800px;
    margin: 30px auto;
    padding: 20px;
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
}

h1, h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #007bff; /* Primary color for headers */
}

.post-form {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}

.post-form input[type="text"],
.post-form textarea,
.post-form input[type="file"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    transition: border-color 0.3s ease;
}

.post-form input[type="text"]:focus,
.post-form textarea:focus {
    border-color: #007bff; /* Highlight border on focus */
}

.post-form button {
    background-color: #007bff;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.post-form button:hover {
    background-color: #0056b3;
    transform: translateY(-2px); /* Slightly lift the button on hover */
}

.posts {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
}

.post {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    transition: transform 0.3s, box-shadow 0.3s;
}

.post:hover {
    transform: translateY(-2px); /* Lift the post on hover */
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
}

.media {
    max-width: 100%;
    border-radius: 5px;
    margin: 10px 0;
    height: auto;
}

.post-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.btn {
    background-color: #28a745;
    color: white;
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s, transform 0.2s;
}

.btn.edit {
    background-color: #007bff;
}

.btn.delete {
    background-color: #dc3545;
}

.btn:hover {
    opacity: 0.9;
    transform: translateY(-2px); /* Slightly lift buttons on hover */
}

.cancel {
    background-color: #6c757d;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    text-decoration: none;
    cursor: pointer;
}

.cancel:hover {
    background-color: #5a6268;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.back-button-container {
    display: flex;
    justify-content: center; /* Center horizontally */
    margin-bottom: 20px; /* Space below the button */
}

.btn-back {
    padding: 10px 20px;
    background-color: #007BFF; /* Button background color */
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    text-align: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-back:hover {
    background-color: #0056b3; /* Darker color on hover */
}

.btn-back:active {
    background-color: #003f7f; /* Even darker color on click */
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
            <li><a href="bracketing.php"><i class='bx bx-abacus'></i><span class="text">Bracketing</span></a></li>
            <li class="active"><a href="Dashb.php"><i class='bx bxs-dashboard'></i><span class="text">Dashboard</span></a></li>
            <li><a href="scheduling.php"><i class='bx bxs-time'></i><span class="text">Game Schedules</span></a></li>
            <li><a href="template.php"><i class='bx bxs-message-dots'></i><span class="text">Message</span></a></li>
            <li><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="dashorg.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
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
        <!-- NAVBAR -->
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

        <!-- MAIN CONTENT -->
        <main>
        <div class="container">
        <h1>News Feed</h1>

        <!-- Back button to Dashb.php -->
        <div class="back-button-container">
            <button onclick="window.location.href='Dashb.php'" class="btn-back">Back to Dashboard</button>
        </div>

        <form method="POST" enctype="multipart/form-data" class="post-form">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="content" placeholder="Content" required></textarea>
            <input type="file" name="media" required>
            <button type="submit">Post</button>
        </form>

        <h2>Recent Posts</h2>
        <div class="posts">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['content']); ?></p>
                    <?php if (!empty($row['media'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['media']); ?>" alt="Media" class="media">
                    <?php endif; ?>
                    <div class="post-actions">
                        <a href="Dashb_nf_download.php?file=<?php echo urlencode($row['media']); ?>" class="btn download">Download</a>
                        <a href="Dashb_nf_edit.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                        <a href="Dashb_nf_delete.php?id=<?php echo $row['id']; ?>" class="btn delete">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <?php $conn->close(); ?>
    </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->

    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>