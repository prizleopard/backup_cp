<?php
// Include database connection
include 'schedconn.php';

// Message variable to hold feedback
$message = "";

// Insert new sport logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_sport'])) {
    $sport_name = $conn->real_escape_string($_POST['sport_name']);

    // Check if sport already exists
    $check_query = "SELECT * FROM sportlist WHERE SPORTSNAME = '$sport_name'";
    $check_result = $conn->query($check_query);
    if ($check_result->num_rows > 0) {
        $message = "Sport already exists!";
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO sportlist (SPORTSNAME) VALUES (?)");
        $stmt->bind_param("s", $sport_name);

        if ($stmt->execute()) {
            $message = "New sport added successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <title>Add Sport</title>
    <link rel="stylesheet" href="dashbstyle.css">
</head>
<style>
/* Add your custom styles here */
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
}

.container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

input[type="text"], button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1em;
}

button {
    background-color: #3a506b;
    color: #ffffff;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.alert {
    padding: 10px;
    margin-bottom: 20px;
    color: white;
    background-color: #28a745;
    border-radius: 4px;
}

.alert.error {
    background-color: #dc3545;
}
</style>
<body>

    <div class="container">
        <h1>Add New Sport</h1>

        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'Error') !== false ? 'error' : '' ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="text" name="sport_name" placeholder="Enter sport name" required>
            <button type="submit" name="add_sport">Add Sport</button>
        </form>
    </div>

</body>
</html>
