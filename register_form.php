<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $user_type = $_POST['user_type'];

    // Validate inputs
    $errors = [];
    if (empty($name) || empty($email) || empty($password)) {
        $errors[] = 'Name, email, and password are required!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format!';
    }

    if (empty($errors)) {
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Check if the email already exists in the database
        $select_query = "SELECT * FROM user_form WHERE email = ?";
        $stmt = mysqli_prepare($conn, $select_query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $errors[] = 'Email already exists!';
        } else {
            // Insert new user into the database, including the name field
            $insert_query = "INSERT INTO user_form (name, email, password, user_type) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $hashed_password, $user_type);
            mysqli_stmt_execute($stmt);
            header('Location: login_form.php'); // Redirect to login page after successful registration
            exit();
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
    <title>Register Form</title>
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
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .form-container img {
            width: 120px; /* Adjust size of the logo */
            margin-bottom: 20px;
        }

        .form-container h3 {
            margin-bottom: 20px;
            color: #1565c0;
            font-size: 24px;
        }

        .form-container input,
        .form-container select {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #cfd8dc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-container input.form-btn {
            background-color: #1565c0;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            padding: 12px;
        }

        .form-container input.form-btn:hover {
            background-color: #0d47a1;
        }

        .form-container p {
            margin-top: 15px;
            color: #546e7a;
            font-size: 14px;
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
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
        <img src="sanluis.png" alt="Logo"> <!-- Updated with the correct logo filename -->

            <h3>Register Now</h3>
            <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<div class="error-msg">' . htmlspecialchars($error) . '</div>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Enter your name">
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Enter your password">
            <select name="user_type">
                <option value="" disabled selected>Choose User Type</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <input type="submit" value="Register Now" class="form-btn">
            <p>Already have an account? <a href="login_form.php">Login now</a></p>
        </form>
    </div>
</body>
</html>
