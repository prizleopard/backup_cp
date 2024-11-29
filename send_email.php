<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'dbconnection.php';
require 'vendor/autoload.php';

// if(isset($_POST['sendemail'])){
    $to = mysqli_real_escape_string($conn, $_POST['to']);
    $subjects = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $mail = new PHPMailer(true);
    try {
        // SMTP settings
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                         // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
        $mail->Username   = 'spmanagement143@gmail.com';              // SMTP username
        $mail->Password   = 'xigvqstiplnxsbiz';                      // SMTP password
        $mail->SMTPSecure = 'tls';                                   // Enable implicit TLS encryption
        $mail->Port       = 587;                                     // Port for sending email

        // Email content
        $mail->setFrom('spmanagement143@gmail.com');
        $mail->addAddress($to);                                      // Recipient email address
        $mail->isHTML(true);
        $mail->Subject = $subjects;
        $mail->Body    = $message;

        // Send email
        if ($mail->send()) {
            // Success - show alert
            echo '<script type="text/javascript">
                    alert("Message sent successfully!");
                    window.location.href = "trymessage.php";  // Redirect after success
                  </script>';
        }
    } catch (Exception $e) {
        // Failure - show error alert
        echo '<script type="text/javascript">
                alert("Message failed to send. Error: ' . $e->getMessage() . '");
                window.location.href = "trymessage.php";  // Redirect after failure
              </script>';
    }
// }
?>
