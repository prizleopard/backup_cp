<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['user_name'])){
   header('location:login_form.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Page</title>

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
        .container {
            width: 100%;
            max-width: 600px;
            padding: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .content h3 {
            color: #1565c0;
            margin-bottom: 10px;
        }
        .content h1 {
            color: #0d47a1;
            margin-bottom: 20px;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 1.2em;
            color: #546e7a;
        }
        .btn {
            display: inline-block;
            padding: 12px 25px;
            margin: 10px 5px;
            background-color: #1565c0;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0d47a1;
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
   
<div class="container">

   <div class="content">
      <h1>Welcome <span><?php echo $_SESSION['user_name']; ?></span></h1>
      <p>This is the user page.</p>
      <a href="coordinators.php" class="btn">Go to Dashboard</a> <!-- New Button for Dashboard -->

   </div>

</div>

</body>
</html>
