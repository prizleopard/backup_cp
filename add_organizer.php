<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'dbconnection.php';
require 'vendor/autoload.php';
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

if(isset($_POST['add'])){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];
    $pass = $_POST['password'];
    $school = $_POST['school'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $sql = "INSERT INTO organizers (fname, lname, email, contact, role, password,school_id) VALUES ('$fname', '$lname', '$email', '$contact', '$role', '$password','$school')";
    $conn->query($sql);
    $mail = new PHPMailer(true);
    try{
        //
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'spmanagement143@gmail.com';                     //SMTP username
        $mail->Password   = 'xigvqstiplnxsbiz';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;    
        $subject = 'Account Creation';
        $body = "
        <html>
            <body>
                <p>Good Day $fname,</p>
                <p>We want to inform you that your account has been created. Please use the following credentials to sign in to the system:</p>
                <p>
                    Email: <strong>$email</strong><br>
                    Password: <strong>$pass</strong>
                </p>
                <p>Best Regards,</p>
                <p>Sports MS</p>
            </body>
        </html>
    ";
    
        $mail->setFrom('spmanagement143@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();


        echo 'success';

    }catch(Exception $e){
        echo $e->getMessage();
    }


    header('Location:trylastna.php');

}

?>