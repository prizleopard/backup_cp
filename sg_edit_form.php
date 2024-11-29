<?php
// Database connection
$host = 'localhost'; // Database host
$user = 'root';  // MySQL username
$password = '';  // MySQL password
$dbname = 'sanluis_school'; // Database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current school data for editing
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);  // Convert the id to an integer for security

    // Fetch the school record
    $sql = "SELECT * FROM sanluis_school WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "School not found!";
        exit();
    }
} else {
    echo "No school ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit School Information</title>
    <style>
        /* Add some styling for a professional look */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        input[type="file"] {
            margin-bottom: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>Edit School Information</h1>

<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label for="name">School Name:</label>
    <input type="text" name="name" value="<?php echo $row['name']; ?>" required>

    <label for="description">Description:</label>
    <textarea name="description" required><?php echo $row['description']; ?></textarea>

    <label for="location_link">Location Link:</label>
    <input type="text" name="location_link" value="<?php echo $row['location_link']; ?>" required>

    <label for="image">Upload a New Image (if needed):</label>
    <input type="file" name="image" id="image">

    <input type="submit" name="edit_school" value="Update School">
</form>

</body>
</html>

<?php
$conn->close();
?>
