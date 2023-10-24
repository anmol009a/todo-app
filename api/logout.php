<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();
}

// Redirect to the login page or any other page as needed
header("Location: ../login.php");
exit;
?>
