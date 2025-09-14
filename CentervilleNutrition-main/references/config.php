<?php
    
    // Start session and output buffering
    ob_start(); 
    session_start();

    // Set timezone
    $timezone = date_default_timezone_set("America/New_York");

    // Include database functions for later use
    include("Database.php");

    // If connection error, give exit message
    if (mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
        exit(); 
    }


    
    // if last activity was more than 30 minutes ago, end session
    if (isset($_SESSION['active']) && (time() - $_SESSION['active'] > 1800)) {
        session_unset();     // unset session
        session_destroy();   // destroy session 
    }
    
    $_SESSION['active'] = time(); // update as long as user is active

    ini_set('display_errors', 0);  
    

?>

