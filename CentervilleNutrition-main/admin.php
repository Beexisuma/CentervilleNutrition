<?php include('references/header.php'); 


if (!isset($_SESSION['firstName'])) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}

 

else if ($_SESSION['admin'] != 1) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <h1 style='display: flex; justify-content: center; font-size: 96px;'>
    <div class='admin-left'>
    <a href='editUser.php'>Edit Users</a>
</div>
</h1>
<h1 style='display: flex; justify-content: center; font-size: 96px;'>
<div class='admin-right'>
    <a href='editMenu.php'>Edit Menu</a>
</div>
</h1>
</body>
</html>


