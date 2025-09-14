<?php 
include("../header/header.php"); 

if (isset($_SESSION['firstName'])) {
    // Initialize user data
    $email = $_SESSION['email'];
    $cartID_query = mysqli_query($con, "SELECT CartID FROM user WHERE email='$email'");

    // Get CartID
    if ($cartID_query && mysqli_num_rows($cartID_query) > 0) {
        $cartID = mysqli_fetch_row($cartID_query)[0];

        // Get current punches and unredeemed cards
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
    
    // Display the user's punch card information
    $firstName = $_SESSION['firstName'];

    // Display the user's punch count
    echo "<div class='main-content rewards-content'>";
    echo "<div class='rewards-container'>";
    echo "<h1>Hi <span>" . htmlspecialchars($firstName) . "!</span></h1>";

    if ($currentPunch == 1) {
        echo "<h4>You have <span>" . $currentPunch . "</span> punch on your Centerville Nutrition punch card!</h4>";
    } elseif ($currentPunch < 9) {
        echo "<h4>You have <span>" . $currentPunch . "</span> punches on your Centerville Nutrition punch card!</h4>";
    }

   

    // Display the punch card image
    $imagePath = "../images/punchCards/punch" . $currentPunch . ".png";
    if (file_exists($imagePath)) {
        echo "<section><img src='$imagePath' width='600px' alt='Picture of a punch card with current number of punches.' /></section>";
    } else {
        echo "<section>Picture of a punch card with current number of punches.</section>";
    }

    // Display how many more punches are needed
    if ($currentPunch < 9 && $currentPunch != 8) {
        echo "<h4><span>" . (9 - $currentPunch) . "</span> more punches and your next drink is <span>Free!</span></h4>";
    } elseif ($currentPunch == 8) {
        echo "<h4><span>" . (9 - $currentPunch) . "</span> more punch and your next drink is <span>Free!</span></h4>";
    }

    // If the user has 9 punches, show they have earned a free drink
    if ($currentPunch == 9) {
        echo "<h4>You have completed 9 punches, and get a free drink!</h4>";
    }

    if ($unredeemed > 1) {
        echo "<h4 style='margin-top: 64px'>";
        echo "<h4>You have <span>" . $unredeemed . "</span> free drinks available</h4>";
        echo "</h4>";
    } elseif ($unredeemed > 0) {
        echo "<h4 style='margin-top: 64px'>";
        echo "<h4>You have <span>" . $unredeemed . "</span> free drink available</h4>";
        echo "</h4>";}
        if($unredeemed != 0)
        {
            echo "<form method='POST'>";
            echo "<input style='none;' type='submit' name='takeMe' value='Redeem Now!'>";
            echo "</form>";  
        }
        echo "<p><span>*Earn a punch</span> for every item you purchase on your account.</p>";


    echo "</div>";
    echo "</div>";


} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}

// if cart is empty, take to menu
if(count($_SESSION['itemArray']) == 0) {
if(isset($_POST['takeMe'])) {
    header('location: ../menu/menuDisplay.php');
    $_SESSION['cartChecked'] = 'yes';
}
}

// otherwise, take to cart and auto-check redeem free drink
else {
    if(isset($_POST['takeMe'])) {
        header('location: ../menu/cart.php');
        $_SESSION['cartChecked'] = 'yes';
    }  
}

?>
