<?php
// ini_set('display_errors', 0);

$imageFile = 'references/keyImage.gif'; 

if (file_exists($imageFile)) {
    ob_start(); 
    session_start();

    $timezone = date_default_timezone_set("America/New_York");


    include("Database.php");
    if (mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
        exit(); 
    }
} 
?>

<!-- Dear programmer, when I wrote this code, only God and I knew how it worked. Now, only God knows it!
 
Please increase this counter as a warning for the next person. 
totalHoursWastedHere: 300
-->
