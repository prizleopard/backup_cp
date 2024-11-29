<?php
// Database connection
$servername = "localhost";
$username = "root"; // Change this
$password = ""; // Change this
$dbname = "users"; // Change this

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $email = $conn->real_escape_string($_POST['email']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = $conn->real_escape_string($_POST['role']);
    $profile_pic = '';

    // Check if email already exists
    $checkEmailSql = "SELECT email FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmailSql);
    if ($result->num_rows > 0) {
        echo "Email already exists. Please use a different email.";
    } else {
        // Handle file upload
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
            $target_dir = "uploads/";
            // Ensure uploads directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0755, true);
            }
            $target_file = $target_dir . basename($_FILES["profile_pic"]["name"]);
            if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                $profile_pic = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Insert into database using prepared statement
        $stmt = $conn->prepare("INSERT INTO users (fname, lname, email, contact, password, profile_pic, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $fname, $lname, $email, $contact, $password, $profile_pic, $role);

        if ($stmt->execute()) {
            // Redirect to dashboard after successful profile creation
            header("Location: Dashb.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<style>
body {
    font-family: 'Arial', sans-serif;
    background-color: #001f3f; /* Navy blue background */
    margin: 0;
    padding: 20px;
    display: flex; /* Use Flexbox to center */
    justify-content: center; /* Center horizontally */
    align-items: center; /* Center vertically */
    height: 100vh; /* Full viewport height */
}

.container {
    width: 400px; /* Set a regular width for the container */
    margin: 0 auto; /* Center container */
    background: #ffffff; /* White background for the form */
    padding: 30px; /* Increased padding for a more spacious feel */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* Soft shadow */
    display: flex; /* Use Flexbox to arrange form elements */
    flex-direction: column; /* Arrange elements in a column */
    align-items: center; /* Center items horizontally */
}

h1 {
    color: #001f3f; /* Dark navy for the title */
    text-align: center; /* Center text */
    margin-bottom: 10px; /* Space below the title */
    font-size: 24px; /* Font size for title */
}

h2 {
    color: #001f3f; /* Dark navy for the header */
    margin-bottom: 20px;
    font-size: 20px; /* Font size for subtitle */
    text-align: center; /* Center text */
}

.label {
    display: block;
    margin: 10px 0 5px; /* Reduced margin for labels */
    color: #001f3f; /* Dark navy for labels */
    font-weight: bold; /* Bold labels */
}

input[type="text"],
input[type="email"],
input[type="password"],
select,
input[type="file"] {
    width: 100%; /* Full width for smaller screens */
    padding: 8px; /* Reduced padding for smaller inputs */
    border: 1px solid #001f3f; /* Navy blue border */
    border-radius: 5px;
    margin-bottom: 15px; /* Consistent spacing */
    font-size: 14px; /* Smaller font size */
    transition: border-color 0.3s; /* Smooth transition for focus effect */
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus,
select:focus {
    border-color: #0056b3; /* Change border color on focus */
    outline: none; /* Remove default outline */
}

input[type="submit"] {
    background-color: #0056b3; /* Bright blue button */
    color: white;
    border: none;
    padding: 10px; /* Adjust padding */
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px; /* Smaller font size */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

input[type="submit"]:hover {
    background-color: #004080; /* Darker blue on hover */
}

.form-group {
    margin-bottom: 15px; /* Consistent spacing between groups */
}

/* Responsive design */
@media (max-width: 768px) {
    .container {
        width: 90%; /* Make the container responsive on smaller screens */
        padding: 20px; /* Adjust padding for smaller screens */
    }

    h2 {
        font-size: 18px; /* Smaller header font size */
    }

    input[type="text"],
    input[type="email"],
    input[type="password"],
    select,
    input[type="file"],
    input[type="submit"] {
        font-size: 12px; /* Smaller font size for inputs */
    }
}
</style>
<body>
    <div class="container">
        <h1>Create Your Profile</h1> <!-- Moved title inside the container -->
        <h2>Profile Details</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="label" for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" required>
            </div>
            <div class="form-group">
                <label class="label" for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" required>
            </div>
            <div class="form-group">
                <label class="label" for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label class="label" for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" required>
            </div>
            <div class="form-group">
                <label class="label" for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label class="label" for="role">Role:</label>
                <select id="role" name="role" required>
                    <option value="admin">Admin</option>
                    <option value="organizer">Organizer</option>
                </select>
            </div>
            <div class="form-group">
                <label class="label" for="profile_pic">Profile Picture:</label>
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
            </div>
            <input type="submit" value="Create Profile">
        </form>
    </div>
</body>
</html>
