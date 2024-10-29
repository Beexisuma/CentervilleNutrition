<?php include("references/header.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
</head>
<body>
</body>
</html>


<?php 
if(isset($_SESSION['username'])) {
    echo("<h1 style='font-size: 64px; display: flex; justify-content: center; color: pink; '>I love you</h1>");
}

else {
    echo("<h1 style='font-size: 64px; display: flex; justify-content: center; color: red; '>LOG IN BROKE BOY</h1>");
}