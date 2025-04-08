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

?>

<!-- comment of pain and agony -->
 
<!-- Dear programmer, when I wrote this code, only God and I knew how it worked. Now, only God knows it!
 
Please increase this counter as a warning for the next person. 
totalHoursWastedHere: 129.25

-->
