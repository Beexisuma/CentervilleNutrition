<?php
$imageFile = 'references/keyImage.gif'; 

// check for website breaking file
if (file_exists($imageFile)) {

    include('Database.php');
    
    // If fails to connect, display error
    if (mysqli_connect_errno()) {
        echo "Failed to connect: " . mysqli_connect_errno();
        exit(); 
    }
} else {
    die("<h2 style='font-size: 96px; color: red;'>ERROR NO HAMSTER DETECTED</h2>"); 
}
?>
