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


if(isset($_SESSION['firstName'])) {


        $email = $_SESSION['email'];
        $cartID_query = mysqli_query($con, "SELECT CartID FROM user WHERE email='$email'");

        // select CartID for the logged in user, used as primary key between tables

        // if user has a CartID, select it 
        if ($cartID_query && mysqli_num_rows($cartID_query) > 0) {
        $cartID = mysqli_fetch_row($cartID_query)[0];

        // select current punches from punchcard table, based on cartID
        $currentPunch_query = mysqli_query($con, "SELECT CurrentPunches FROM punchcard WHERE CartID='$cartID'");
        if ($currentPunch_query && mysqli_num_rows($currentPunch_query) > 0) {
            $currentPunch = mysqli_fetch_row($currentPunch_query)[0]; 
            $_SESSION['punchCount'] = $currentPunch;}
}

// display current punch count
if ($currentPunch == 1) {
    echo "You have: " . $currentPunch . " punch." . "<br>";
}

elseif ($currentPunch < 10) {
    echo "You have: " . $currentPunch . " punches." . "<br>";
}

elseif ($currentPunch = 10) {
    echo "You have: " . $currentPunch . " punches." . "<br>" . "You get a free drink!" . "<br>";
}

// punchcard code, use card1, card2, card3 up to card 10
$imagePath = "references/punchcard" . $currentPunch . ".png"; 
        
        if (file_exists($imagePath)) {
            echo "<img src='$imagePath' alt='punch count with current number of punches'>";
        } else {
            echo "Image not found.";
        }
}

else {
header("Location: login.php");
$_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}

?> 
</body>
</html>