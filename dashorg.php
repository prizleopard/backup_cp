<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "organizers";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle add, edit, and delete requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add organizer
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $sql = "INSERT INTO organizers (fname, lname, email, contact, role, password) VALUES ('$fname', '$lname', '$email', '$contact', '$role', '$password')";
        $conn->query($sql);
    } elseif (isset($_POST['edit'])) {
        // Edit organizer
        $id = $_POST['id'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $role = $_POST['role'];
        // Only update password if it is provided
        $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        $sql = "UPDATE organizers SET fname='$fname', lname='$lname', email='$email', contact='$contact', role='$role' " . ($password ? ", password='$password'" : "") . " WHERE id=$id";
        $conn->query($sql);
    } elseif (isset($_POST['delete'])) {
        // Delete organizer
        $id = $_POST['id'];
        $sql = "DELETE FROM organizers WHERE id=$id";
        $conn->query($sql);
    }
}

// Fetch all organizers
$sql = "SELECT id, fname, lname, email, contact, role FROM organizers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizers List</title>
   </head>
   <style>
        body {
            font-family: Arial, sans-serif;
            background-color: hsl(191, 17%, 20%);
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #007BFF; /* University of Batangas Blue */
            text-align: center;
            margin-bottom: 20px;
        }

        .container {
            max-width: 600px; /* Set a max width for the container */
            margin: auto;
            background-color: hsl(191, 17%, 15%);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table-container {
            overflow-y: auto;
            max-height: 300px; /* Adjust this height as needed */
            width: 100%;
            border-radius: 10px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: hsl(191, 17%, 25%);
            color: #fff;
        }

        table, th, td {
            border: 1px solid #444;
        }

        th {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }

        td {
            padding: 8px;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: hsl(191, 17%, 30%);
        }

        tr:hover {
            background-color: hsl(191, 17%, 35%);
            cursor: pointer;
        }

        .form-container {
            margin-top: 20px;
            display: flex; /* Use flexbox */
            flex-direction: column; /* Arrange items in a column */
            align-items: center; /* Center items horizontally */
            
        }

        .form-container input {
            width: auto; /* Set to a percentage for responsiveness */
            padding: 10px;
            margin: 5px 0; /* Adjust margin */
            border: none;
            border-radius: 5px;
        }

        .form-container button {
            width: auto; /* Set to a percentage for responsiveness */
            padding: 10px 15px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            
        }

        .form-container button:hover {
            background-color: #0056b3;
            
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-container input {
                width: 100%; /* Full width on smaller screens */
                margin: 5px 0; /* Adjust margin for small screens */
            }

            .form-container button {
                width: 100%; /* Full width on smaller screens */
            }

            .table-container {
                max-height: 200px; /* Reduce height for smaller screens */
            }

            table, th, td {
                font-size: 14px; /* Smaller font size for small screens */
            }

            h2 {
                font-size: 24px; /* Smaller heading for small screens */
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px; /* Even smaller heading for very small screens */
            }

            th, td {
                font-size: 12px; /* Smaller font size for very small screens */
            }
        }
        .button-container {
        display: flex;
        justify-content: center; /* Center the button */
        width: 100%;
        margin-top: 10px; /* Add some space above the button */
        }

        .form-container button {
        width: auto; /* Set width to auto to avoid stretching */
        }

        .button-container {
    display: flex;
    justify-content: space-between; /* Distribute buttons across the container */
    width: 100%;
    margin-top: 10px; /* Add some space above the buttons */
}

.button-container button {
    width: auto; /* Allow buttons to have automatic width */
    padding: 10px 15px; /* Add padding for better appearance */
}

.left-button {
    background-color: #007BFF; /* Blue color for Add button */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.left-button:hover {
    background-color: #0056b3; /* Darker blue on hover */
}

.right-button {
    background-color: #f44336; /* Red color for Go Back button */
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.right-button:hover {
    background-color: #c62828; /* Darker red on hover */
}

    </style>
<body>

<div class="container">
    <h2>Organizers</h2>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['fname']} {$row['lname']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['contact']}</td>
                                <td>{$row['role']}</td>
                                <td>
                                    <form method='post' style='display:inline-block;'>
                                        <input type='hidden' name='id' value='{$row['id']}'>
                                        <input type='text' name='fname' placeholder='First Name' value='{$row['fname']}' required>
                                        <input type='text' name='lname' placeholder='Last Name' value='{$row['lname']}' required>
                                        <input type='email' name='email' placeholder='Email' value='{$row['email']}' required>
                                        <input type='text' name='contact' placeholder='Contact' value='{$row['contact']}' required>
                                        <input type='text' name='role' placeholder='Role' value='{$row['role']}' required>
                                        <input type='password' name='password' placeholder='New Password (optional)'>
                                        <button type='submit' name='edit'>Edit</button>
                                        <button type='submit' name='delete'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No organizers found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="form-container">
    <h2>Add Organizer</h2>
    <form method="post">
        <input type="text" name="fname" placeholder="First Name" required>
        <input type="text" name="lname" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="contact" placeholder="Contact" required>
        <input type="text" name="role" placeholder="Role" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <div class="button-container">
            <button type="submit" name="add" class="left-button">Add</button>
            <button type="button" class="right-button" onclick="window.location.href='Dashb.php'">Go Back</button>
        </div>
    </form>
</div>

</div>
</div>

<?php
$conn->close();
?>

</body>
</html>
