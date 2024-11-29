<?php
session_start();

// Redirect to dashboard if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: log_in.php");
    exit();
}

// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'user_db');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Sanitize input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        $error[] = "Both email and password are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Invalid email format!";
    } else {
        // Query to find the user
        $select = "SELECT * FROM user_form WHERE email = '$email'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verify password
            if (password_verify($password, $row['password'])) {
                // Check user type and set session
                switch ($row['user_type']) {
                    case 'admin':
                        $_SESSION['admin_name'] = $row['name'];
                        $_SESSION['logged_in'] = true;
                        header('Location: Dashb.php');
                        break;

                    case 'coordinator':
                        $_SESSION['coordinator_name'] = $row['name'];
                        $_SESSION['logged_in'] = true;
                        header('Location: coordinators.php');
                        break;

                    case 'organizer':
                        $_SESSION['organizer_name'] = $row['name'];
                        $_SESSION['logged_in'] = true;
                        header('Location: odashboard.php');
                        break;

                    default:
                        $error[] = "Unauthorized access!";
                        break;
                }
                exit();
            } else {
                $error[] = "Incorrect password!";
            }
        } else {
            $error[] = "No user found with this email!";
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
        }
        .form-container h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #1565c0;
        }
        .form-container input {
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
            text-align: center;
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
    <form action="" method="post">

        <h3>Login Now</h3>
        <?php
        if (isset($error)) {
            foreach ($error as $err) {
                echo '<span class="error-msg">' . htmlspecialchars($err) . '</span>';
            }
        }
        ?>
        <input type="email" name="email" required placeholder="Enter your email">
        <input type="password" name="password" required placeholder="Enter your password">
        <input type="submit" name="submit" value="Login Now" class="form-btn">
    </form>
</div>
</body>
</html>
