<?php
    session_start(); // Start the session

    // Destroy all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the index page
    header("Location: index.php");
    exit();
?>