<?php
// Start the session
session_start();

// Destroy the session to log out
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Redirect to the home page after logging out
header("Location: index.php");
exit(); // Stop further script execution
?>

