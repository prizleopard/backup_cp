<?php
session_start();
session_destroy(); // Destroy all session variables
header('Location: ologin_form.php'); // Redirect to login page
exit();
?>
