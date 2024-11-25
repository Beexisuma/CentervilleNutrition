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
            $_SESSION['punchCount'] = $currentPunch;
        }
        $unredeemed_query = mysqli_query($con, "SELECT UnrewardedCards FROM punchcard WHERE CartID='$cartID'");
        if ($unredeemed_query && mysqli_num_rows($unredeemed_query) > 0) {
            $unredeemed = mysqli_fetch_row($unredeemed_query)[0]; 
            $_SESSION['unredeemed'] = $unredeemed;
}
        }


$firstName = $_SESSION['firstName'];

// display current punch count
if ($currentPunch == 1) {
    echo "Hi " . $_SESSION['firstName'] . ", you have " . $currentPunch . " punch on your Centerville Nutrition punch card!" . "<br>";
}

elseif ($currentPunch < 9) {
    echo "Hi " . $_SESSION['firstName'] . " you have " . $currentPunch . " punches on your Centerville Nutrition punch card!" . "<br>";
}

if($unredeemed > 0) {
    echo "You have " . $unredeemed . " unredeemed punch cards!" . "<br>";
}

// punchcard code, use card1, card2, card3 up to card 9
$imagePath = "references/punch" . $currentPunch . ".png"; 
        
        if (file_exists($imagePath)) {
            echo "<img src='$imagePath' width='600px' alt='Picture of a punch card with current number of punches.'>";
        } else {
            echo "Picture of a punch card with current number of punches." . "<br>";
        }


if ($currentPunch < 9 && $currentPunch != 8) {
    echo(9 - $currentPunch) . " more punches and your next drink is free!" . "<br>";
}
elseif($currentPunch == 8) {
echo(9 - $currentPunch) . " more punch and your next drink is free!" . "<br>";
}

if ($currentPunch == 9) {
    echo "You have completed 9 punches, and get a free drink!" . "<br>";
}

echo "Earn a punch for every item you purchase on your account" . "<br>";
}
else {
header("Location: login.php");
$_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}

?> 
</body>
</html>