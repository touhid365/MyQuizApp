<?php
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: /online_exam/login.php"); // Redirect to login page after logout
exit();
?>
