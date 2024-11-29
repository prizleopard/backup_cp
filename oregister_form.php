<?php
// Database connection directly in this file
$servername = "localhost";
$username = "root";  // Change as needed
$password = "";      // Change as needed
$dbname = "user_db"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error array
$error = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $user_type = $_POST['user_type'];

    // Check if passwords match
    if ($password !== $cpassword) {
        $error[] = "Passwords do not match!";
    } else {
        // Hash the password before storing
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO user_form (username, email, password, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $passwordHash, $user_type);

        // Execute the statement and check if insertion was successful
        if ($stmt->execute()) {
            echo "Registration successful!";
        } else {
            $error[] = "Error: " . $stmt->error;
        }

        $stmt->close();  // Close the statement
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <form action="oregister_form.php" method="post">
        <h3>Register Now</h3>

        <?php
        // Display any errors or success messages
        if (!empty($error)) {
            foreach ($error as $err) {
                echo '<span class="error-msg">' . htmlspecialchars($err) . '</span>';
            }
        }
        ?>

        <input type="text" name="username" required placeholder="Enter your username">
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="password" name="cpassword" required placeholder="Confirm your password">

        <label for="user_type">User Type:</label>
        <select name="user_type" required>
            <option value="user">Coordinator</option>
            <option value="admin">Admin</option>
            <option value="organizer">Organizer</option>
        </select>

        <input type="submit" name="submit" value="Register Now" class="form-btn">
        <p>Already have an account? <a href="ologin_form.php">Login now</a></p>
    </form>
</div>
</body>
</html>
