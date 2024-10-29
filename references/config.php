<?php
$imageFile = 'references/keyImage.gif'; 

if (file_exists($imageFile)) {
    ob_start(); 
    session_start();

    $timezone = date_default_timezone_set("America/New_York");

    define('LOCALHOST', 'localhost');
    // define('DB_USERNAME', 'root');
    // define('DB_PASSWORD', '');
    
    define('DB_USERNAME', 'root');
    
    define('DB_PASSWORD', '');
    
    
    define('DB_NAME', 'centervillenutrition');
    // Step Three: 
      // Execute Query and Save Data in Database
      $con = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);
      $db_select = mysqli_select_db($con, DB_NAME); // Select Database
    
    if (mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
        exit(); 
    }
} else {
    die("<h2 style='font-size: 96px; color: red;'>ERROR NO HAMSTER DETECTED</h2>"); 
}
?>
