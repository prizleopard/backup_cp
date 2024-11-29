<?php
include 'db.php'; // Include the database connection

// Get the organizer ID from the URL
$id = $_GET['id'];

// Fetch existing data for the organizer
$query = "SELECT * FROM organizers WHERE id=$id";
$result = $conn->query($query);
$organizer = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];

    // Update the organizer details in the database
    $sql = "UPDATE organizers SET fname='$fname', lname='$lname', email='$email', contact='$contact', role='$role' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header('Location: dashorg.php'); // Redirect back to the admin page after updating
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Organizer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Organizer</h2>
<form action="edit.php?id=<?= $id ?>" method="post">
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="fname" value="<?= $organizer['fname'] ?>" required>

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lname" value="<?= $organizer['lname'] ?>" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= $organizer['email'] ?>" required>

    <label for="contact">Contact</label>
    <input type="text" id="contact" name="contact" value="<?= $organizer['contact'] ?>" required>

    <label for="role">Role</label>
    <input type="text" id="role" name="role" value="<?= $organizer['role'] ?>" required>

    <input type="submit" value="Update Organizer">
</form>

</body>
</html>
