<?php
session_start();
include('oconfig.php'); // Include your database connection

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to avoid SQL injection
    $sql = "SELECT * FROM organizers WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters and execute the statement
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        // Verify the password using password_verify() if stored with password_hash()
        if (password_verify($password, $row['password'])) {
            // Successful login, store session variables
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id']; // Store user id in session
            header('Location: odashboard.php'); // Redirect to the dashboard
            exit();
        } else {
            echo "<script>alert('Invalid Username or Password');</script>";
        }
    } else {
        echo "<script>alert('Invalid Username or Password');</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Login</title>
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        /* Login container */
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Form title */
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        /* Label styling */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Input field styles */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Button styles */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Add some margin for alert */
        .alert {
            margin-top: 20px;
            color: red;
        }

        /* Logo styling */
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 100px; /* You can adjust the size of the logo */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="sanluis.png" alt="San Luis Logo" class="logo">
        <h2>Organizer Login</h2>
        <form method="POST" action="ologin_form.php">
            <label for="username">Email:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>