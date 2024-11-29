<?php
// Include database connection
include 'connection.php';

// Process Add Student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Insert new student into the database
    $sql = "INSERT INTO students (name, email, phone, address) VALUES ('$name', '$email', '$phone', '$address')";
    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Process Delete Student
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM students WHERE id=$id");
    echo "Student deleted successfully!";
}

// Fetch all students
$result = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
</head>
<body>

<h2>Add New Student</h2>
<form action="index.php" method="POST">
    <input type="text" name="name" placeholder="Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="address" placeholder="Address">
    <button type="submit" name="add_student">Add Student</button>
</form>

<h2>Student List</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['address']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
            <a href="students.php?delete=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
