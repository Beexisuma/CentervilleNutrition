<?php 
include('../references/config.php');
include('../references/date.php');
include('../references/icons.php');




// Check if user is logged in
if(!isset($_SESSION['firstName'])) {
	header("location: ../account/login.php");
	$_SESSION['error'] = "<div class='error'>You must be logged in to acccess this page.</div>";

}

// Check if logged in user is an admin
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
	header("location: ../account/login.php");
	$_SESSION['error'] = "<div class='error'>You must be an admin to acccess this page.</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Centerville Nutrition</title>
		<!-- <link rel="stylesheet" href="styles/styles.css"> -->

		<link rel="stylesheet" href="../styles/account.css">
		<link rel="stylesheet" href="../styles/admin.css">
		<link rel="stylesheet" href="../styles/cart.css">
		<link rel="stylesheet" href="../styles/checkout.css">
		<link rel="stylesheet" href="../styles/general.css">
		<link rel="stylesheet" href="../styles/home.css">
		<link rel="stylesheet" href="../styles/items.css">
		<link rel="stylesheet" href="../styles/mMenu.css">
		<link rel="stylesheet" href="../styles/products.css">
		<link rel="stylesheet" href="../styles/register.css">
		<link rel="stylesheet" href="../styles/rewards.css">

		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link rel="icon" href="../images/Both.png" type="image/icon type">
		<link
			href="https://fonts.googleapis.com/css2?family=IM+Fell+DW+Pica:ital@0;1&family=Playball&display=swap"
			rel="stylesheet"
		/>

		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Playball&display=swap"
			rel="stylesheet"
		/>
	</head>
	<body>
		
		<div class="container">
			
			<nav class="home-nav admin-top">
				<a class="logo admin-logo" href="../homepage/index.php">
					<h1>Centerville Nutrition</h1>
					<span>
						<div class="logoUnder1"></div>
						<div class="logoUnder2"></div>
					</span>
				</a>

				<div class="main-nav admin-nav">
                <div class="main-nav">			
			<?php
			if (isset($_SESSION['admin'])) {
				// If user is an admin, display admin button on page
				if($_SESSION['admin'] == 1) {
					echo ("<a href='editMenu.php'>Admin</a>");
				} 
			}
			?>
			
			<a href="../menu/menu.php">Menu</a>
			<a href="../account/rewards.php">Rewards</a>

            <?php 
			// Check if the user is logged in and display their name if so
            if (!isset($_SESSION['firstName'])) {
                echo "<a href='../account/login.php'>Sign In</a>";
            } 
			else {
                echo "<a href='../account/user.php'>" . ($_SESSION['firstName']) . "</a>";
				$firstName = $_SESSION['firstName'];
          
				// Update the cart from the database by using the user's firstname as the key
				if($dataClass->searchData("cart", "CartID" ,$dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"] != "")
				{
				$cartCount = count($dataClass->cartToArray(($dataClass->searchData("cart", "CartID" ,$dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"])));
				}else
				{
					$cartCount = 0;
					$_SESSION['itemArray'] = array();
				}
				
				// If the user has items in their cart, display the number of items above the cart icon
				if(isset($cartCount)) 
				{
					$cartDisplay = $cartCount; 
				} 
				else 
				{
					$cartDisplay = "0";
				}

				echo '<a href="../menu/cart.php" id="cartNum">' . $cartDisplay. '</a>' . $cartIcon2 . '</a>';
				
			}
			?>
		</div>
			</nav>
		</head>

		<script>
			let cart = document.getElementById('cart');
			
			
			
			function cartNumber() {
				
				let cNum = document.getElementById('cartNum');
				let cartBox = cart.getBoundingClientRect();
				
				cNum.style.left = cartBox.left + 'px';
				cNum.style.top = cartBox.top + 'px';
				cNum.style.width = cartBox.width + 'px';
				cNum.style.height = cartBox.height + 4 + 'px';
			}
			
			window.addEventListener('resize', cartNumber);
			window.addEventListener('load', cartNumber);
		
			cart.addEventListener('click', function() {window.location.href = "../menu/cart.php";});
		</script>

