<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to login page (change to your login/home page if needed)
header("Location: ../index.php");
exit;
?>
