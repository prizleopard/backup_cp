<?php


$servername = "localhost"; // Update if necessary
$username = "root"; // Update if necessary
$password = ""; // Update if necessary
$dbname = "sdms"; // Database name

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
    <link rel="stylesheet" href="dashbstyle.css"> 
</head>
<style>
/* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
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
/* Post Container Styles */
.post-container {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    margin: 0 auto;
    padding: 20px;
    width: 90%;
    max-width: 1200px;
    background-color: #f4f4f4;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

/* Uniform Heading Styles */
h1, h2 {
    text-align: center;
    color: #333;
    margin: 20px 0;
}

/* Post Form Styles */
.post-form {
    width: 100%;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    box-sizing: border-box;
}

.post-form input,
.post-form textarea {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
    border: 1px solid #ccc;
    font-size: 16px;
}

.post-form button {
    width: 100%;
    padding: 10px;
    background-color: #3a506b;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.post-form button:hover {
    background-color: #728197;
}

/* Posts Layout */
.posts {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Adaptive grid layout */
    gap: 20px;
    width: 100%;
    box-sizing: border-box;
}

/* Individual Post Styles */
.post {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
    position: relative;
    box-sizing: border-box;
}

.post h3 {
    font-size: 20px;
    margin-bottom: 10px;
}

.post p {
    font-size: 16px;
    color: #555;
    margin-bottom: 15px;
}

.post img.media {
    width: 100%;
    height: auto;
    border-radius: 4px;
    margin-bottom: 10px;
    filter: brightness(1.1) contrast(1.2);
    object-fit: cover;
}

/* Post Actions */
.post-actions {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap; /* Allow buttons to wrap on smaller screens */
}

.btn {
    padding: 10px 15px;
    font-size: 14px;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s ease;
    flex: 1;
    max-width: 150px;
}

.btn.download {
    background-color: #28a745;
}

.btn.edit {
    background-color: #FF9800;
}

.btn.delete {
    background-color: #dc3545;
}

.btn:hover {
    opacity: 0.9;
}

/* Navigation Styles */
nav {
    display: flex;
    flex-wrap: wrap; /* Allow wrapping on smaller screens */
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #f0f4f8;
    width: 100%;
    box-sizing: border-box;
}

.brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile img {
    border-radius: 50%;
    width: 40px;
    height: 40px;
    object-fit: cover;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .post-form {
        padding: 15px;
    }

    .post img.media {
        height: auto; /* Ensure images scale properly */
    }

    .btn {
        font-size: 12px;
        padding: 8px 12px;
    }

    .post-actions {
        flex-direction: column; /* Stack buttons vertically on smaller screens */
        gap: 5px;
    }
}

@media (max-width: 480px) {
    h1, h2 {
        font-size: 24px;
    }

    .btn {
        font-size: 12px;
        max-width: 100%;
        flex: none; /* Allow buttons to take full width */
    }
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
            <li class="active"><a href="Dashb_news_feed.php"><i class='bx bx-spreadsheet'></i><span class="text">News Feed</span></a></li>
            <li><a href="trylastna.php"><i class='bx bxs-folder-open'></i><span class="text">Organizers</span></a></li>
            <li><a href="venues.php"><i class='bx bxs-map-pin'></i><span class="text">Schools/Venue</span></a></li>
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
    <!-- SIDEBAR -->
   <!-- CONTENT -->
   <section id="content">
    <nav>
            <i class='bx bx-menu' id="menu-icon"></i>
    <div>
    <a href="#" class="profile">
            <img src="sanluis.jpg" alt="Profile Image">
            </a>
        </nav>
        <!-- NAVBAR -->


        <main>

        <div class="container">
        <h1>News Feed</h1>

        <form method="POST" enctype="multipart/form-data" class="post-form">
            <input type="text" name="title" placeholder="Title" required>
            <textarea name="content" placeholder="Content" required></textarea>
            <input type="file" name="media" required>
            <button type="submit">Post</button>
        </form>

        <h2>Recent Posts</h2>
        <div class="back-button-container">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo htmlspecialchars($row['content']); ?></p>
                    <?php if (!empty($row['media'])): ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['media']); ?>" alt="Media" class="media">
                    <?php endif; ?>
                <br>
                <div class="post-actions">
                    <a href="Dashb_nf_download.php?file=<?php echo urlencode($row['media']); ?>" class="btn download">Download</a>
                    <a href="Dashb_nf_edit.php?id=<?php echo $row['id']; ?>" class="btn edit">Edit</a>
                    <a href="Dashb_nf_delete.php?id=<?php echo $row['id']; ?>" class="btn delete" onclick="return confirmDelete();">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    </main>
        <!-- MAIN CONTENT -->

    </section>
    <!-- CONTENT -->
    <?php $conn->close(); ?>
    <script>
    const menuIcon = document.getElementById('menu-icon');
    const sidebar = document.getElementById('sidebar');

    menuIcon.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    });
    </script>
    <script>
    function confirmDelete() {
        var result = confirm("Are you sure you want to delete this post?");
        if (result) {
            return true;  // Proceed with deletion if confirmed
        } else {
            return false;  // Prevent deletion if canceled
        }
    }
</script>
                
    <script src="script.js"></script> <!-- Link your JavaScript file -->
</body>
</html>