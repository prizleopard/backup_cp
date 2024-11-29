<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "organizers");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reset'])) {
        // Get the new password from the form
        $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
        
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update the password in the database
        $sql = "UPDATE organizers SET password='$hashed_password' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Password updated successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fetch user details to show in the form
    $sql = "SELECT fname, lname FROM organizers WHERE id='$id'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
} else {
    echo "Invalid request.";
}

$conn->close();
?>

<h3>Reset Password for <?php echo $user['fname'] . ' ' . $user['lname']; ?></h3>
<form method="POST">
    <input type="password" name="new_password" placeholder="New Password" required>
    <button type="submit" name="reset">Reset Password</button>
</form>
