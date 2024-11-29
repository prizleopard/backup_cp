<?php
include 'config.php'; // Include database connection

session_start(); // Start the session for storing user data

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate email and password inputs
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    $errors = [];

    // Check if the fields are empty
    if (empty($email) || empty($password)) {
        $errors[] = 'Email and password are required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format!';
    }

    // If no errors, proceed with checking the credentials
    if (empty($errors)) {
        // Prepare the SQL statement to prevent SQL injection
        $query = "SELECT * FROM user_form WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email); // Bind the email parameter
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt); // Get the result from the query

        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password using password_verify()
            if (password_verify($password, $row['password'])) {
                // If the user is an admin, redirect to the admin page
                if ($row['user_type'] == 'admin') {
                    $_SESSION['admin_name'] = $row['name'];
                    header('Location: admin_page.php');
                    exit();
                } elseif ($row['user_type'] == 'user') {
                    // If the user is a regular user, redirect to the user page
                    $_SESSION['user_name'] = $row['name'];
                    header('Location: user_page.php');
                    exit();
                }
            } else {
                // If the password is incorrect
                $errors[] = 'Incorrect email or password!';
            }
        } else {
            // If no account is found with this email
            $errors[] = 'No account found with this email!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e3f2fd;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .form-container img {
            width: 100px; /* Adjust size of the logo */
            margin-bottom: 20px;
        }
        .form-container h3 {
            margin-bottom: 20px;
            color: #1565c0;
        }
        .form-container input, .form-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #cfd8dc;
            border-radius: 4px;
        }
        .form-container input.form-btn {
            background-color: #1565c0;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container input.form-btn:hover {
            background-color: #0d47a1;
        }
        .form-container p {
            margin-top: 15px;
            color: #546e7a;
        }
        .form-container p a {
            color: #1565c0;
            text-decoration: none;
        }
        .form-container p a:hover {
            text-decoration: underline;
        }
        .error-msg {
            color: #d32f2f;
            font-size: 0.9em;
            margin-top: -5px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <!-- Logo Image -->
        <img src="sanluis.png" alt="Logo"> <!-- Updated with the correct logo filename -->
        <form action="" method="post">
            <h3>Login Now</h3>
            <?php
            // Display any errors that occur during login
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<span class="error-msg">' . htmlspecialchars($error) . '</span>';
                }
            }
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <input type="submit" name="submit" value="Login Now" class="form-btn">
            <p>Don't have an account? <a href="register_form.php">Register now</a></p>
        </form>
    </div>
</body>
</html>
