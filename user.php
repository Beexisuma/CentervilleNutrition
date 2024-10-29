<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
</head>
<body>
<?php

 include('references/header.php'); 
if(isset($_SESSION['firstName'])) {
    echo("Welcome " . $_SESSION['firstName']);
        echo("<form method='POST'>");
        echo("<input type='submit' name='logout' value='Logout'>");
        echo("</form>");
        
        
        
        
         if(isset($_POST['logout'])) {
          session_destroy();
          header("Location: login.php");
        }
}

else {
header("Location: login.php");
$_SESSION['mustLogin'] = "<h3 style='color: red; display: flex; justify-content: center; margin-top: 20px;'>You must log in to access the user page.</h3>";
}













?>
</body>
</html>