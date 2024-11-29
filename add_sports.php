<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sports</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"] {
            padding: 0.8rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 0.8rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }

        button.remove-btn {
            background-color: #f44336;
            margin-top: 0.5rem;
        }

        button:hover {
            opacity: 0.9;
        }

        .sport-list {
            margin-top: 1.5rem;
        }

        .sport-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem;
            border-bottom: 1px solid #ddd;
        }

        .back-link {
            margin-top: 1rem;
            text-align: center;
        }

        .back-link a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Sports</h2>
        <?php
// Database connection
$conn = new mysqli("localhost", "root", "", "venues");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = ""; // Initialize success message

// Handle adding a new sport
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_sport'])) {
    $new_sport = $conn->real_escape_string($_POST['new_sport']);
    
    // Check if the sport already exists
    $check_query = "SELECT * FROM tbl_sportlist WHERE sport_name = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $new_sport);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<p style='color: red;'>Sport already exists in the database!</p>";
    } else {
        // Insert the new sport into the tbl_sportlist table
        $insert_query = "INSERT INTO tbl_sportlist (sport_name) VALUES (?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("s", $new_sport);

        if ($stmt->execute()) {
            $successMessage = "New sport added successfully!";
        } else {
            echo "<p style='color: red;'>Error adding sport: " . $conn->error . "</p>";
        }
    }
    $stmt->close();
}
?>


        <form action="" method="POST">
            <input type="text" name="sport_name" placeholder="Enter new sport name" required>
            <button type="submit">Add Sport</button>
        </form>

        <div class="sport-list">
            <h3>Sports List</h3>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="sport-item">
                        <span><?php echo htmlspecialchars($row['SPORTSNAME']); ?></span>
                        <form action="" method="POST" style="margin: 0;">
                            <input type="hidden" name="remove_id" value="<?php echo $row['ID']; ?>">
                            <button type="submit" class="remove-btn">Remove</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No sports found.</p>
            <?php endif; ?>
        </div>

        <div class="back-link">
            <a href="trylang.php">Back to Main Form</a>
        </div>
    </div>
</body>
</html>
