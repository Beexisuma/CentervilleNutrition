<?php include("references/header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rewards</title>
</head>
<body>
    
</body>
</html>

<?php


if(isset($_SESSION['username'])) {

    echo("Yippee");
}

else {
header("Location: login.php");
$_SESSION['mustLogin'] = "<h3 style='color: red; display: flex; justify-content: center; margin-top: 20px;'>You must log in to access the rewards page.</h3>";
}

