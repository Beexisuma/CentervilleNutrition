<?php include('references/header.php');

if (isset($_SESSION['loginSuccess'])) {
    echo "<script>alert('Login Successful!');</script>";
    unset($_SESSION['loginSuccess']);
}

if (isset($_SESSION['mustLogin'])) {
    echo $_SESSION['mustLogin'];
    unset($_SESSION['mustLogin']);
}

if (isset($_SESSION['paymentSuccess'])) {
    echo $_SESSION['paymentSuccess'];
    unset($_SESSION['paymentSuccess']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centerville Nutrition</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Playball&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-content home-content">
        <div class="home-welcome">
            <div class="welcome-card welcome-facts1">
                <h4 class="welcome-styled">Signature</h4>
                <h1>Tea Bombs</h1>
                <h2><span>25</span> Calories</h2>
                <h2><span>0</span> Sugars</h2>
                <p>Boosts metabolism and energy levels</p>
                <p>Packed with <span>C</span>, <span>B6</span>, & <span>B12</span> vitamins</p>
            </div>
            <div class="welcome-title">
                <h3>Schedule A Visit Today</h3>
                <h1>It's <a href="images/elkinoak-main/index.php" style="text-decoration: none; color: #463437;">Our</a> Treat</h1>
            </div>
            <div class="welcome-card welcome-facts2">
                <h4 class="welcome-styled">Knockout</h4>
                <h1>Protein Shakes</h1>
                <h2><span>27g</span> Protein</h2>
                <h2><span>250</span> Calories</h2>
                <h2><span>11g</span> Sugar</h2>
                <p>Loaded with <span>21</span> vitamins and minerals</p>
            </div>
        </div>
        <section class="home-bottom">
    <div class="charlie">
        <div class="text-content">
            <h1>New Items</h1>
            <p>Introducing our New Watermelon Jolly Rancher Tea Bomb!</p>
        </div>
        <div class="image-content">
            <img src="references/Tea.png" alt="Watermelon Jolly Rancher Tea Bomb">
        </div>
    </div>
</section>
        <section class="home-bottom">
            <h1>About Us</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </section>
    </div>
</body>
</html>
