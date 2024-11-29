<?php

@include 'config.php';

session_start();

if (!isset($_SESSION['organizer_name'])) {
    header('location:login_form.php'); // Redirect to the organizer login form
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Organizer Page</title>
   <style>
      /* Body Styling */
      body {
         font-family: Arial, sans-serif;
         background: linear-gradient(135deg, #f3e5f5, #e1bee7);
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         height: 100vh;
      }

      /* Container Styling */
      .container {
         background: #ffffff;
         border-radius: 15px;
         padding: 30px;
         width: 90%;
         max-width: 500px;
         text-align: center;
         box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      }

      .container h1 {
         font-size: 2em;
         margin-bottom: 10px;
         color: #8e44ad;
      }

      .container h1 span, .container h3 span {
         color: #9b59b6;
      }

      .container h3 {
         font-size: 1.5em;
         margin-bottom: 15px;
         color: #a569bd;
      }

      .container p {
         font-size: 1em;
         color: #333;
         margin-bottom: 20px;
      }

      /* Button Styling */
      .btn {
         display: inline-block;
         background-color: #9b59b6;
         color: white;
         padding: 10px 20px;
         text-decoration: none;
         border-radius: 5px;
         margin: 5px;
         font-size: 0.9em;
         transition: background-color 0.3s ease;
      }

      .btn:hover {
         background-color: #7d3c98;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
         .container {
            padding: 20px;
         }

         h1 {
            font-size: 1.8em;
         }

         h3 {
            font-size: 1.4em;
         }

         .btn {
            padding: 8px 16px;
         }
      }

      @media (max-width: 480px) {
         .container {
            width: 95%;
            padding: 15px;
         }

         h1 {
            font-size: 1.6em;
         }

         h3 {
            font-size: 1.2em;
         }

         .btn {
            width: 100%;
            padding: 10px 0;
         }
      }
   </style>
</head>
<body>
   <div class="container">
      <h1>Welcome, Organizer <span><?php echo htmlspecialchars($_SESSION['organizer_name']); ?></span></h1>
      <p>This is your organizer dashboard.</p>
      <p>Press the button to manage your events:</p>
      <a href="odashboard.php" class="btn">Dashboard</a>
      <a href="logout.php" class="btn">Logout</a>
   </div>
</body>
</html>
