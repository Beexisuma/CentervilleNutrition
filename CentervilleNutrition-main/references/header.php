<?php include('config.php');
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centerville Nutrition</title>
	<link rel="stylesheet" href="styles/styles.css">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Playball&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
	<nav class="home-nav">
		<a href="index.php" class="logo">
			<h1>Centerville Nutrition</h1>
			<span>
			<div class="logoUnder1"></div>
			<div class="logoUnder2"></div>
			</span>
		</a>
		
		<div class="main-nav">			
			<?php
			if (isset($_SESSION['admin'])) {
				
			 if($_SESSION['admin'] == 1) {
			echo ("<a href='editMenu.php'>Admin</a>");
			} 
			}
			?>
			<a href="menu.php">Menu</a>
			
            <?php 
            if (!isset($_SESSION['firstName'])) {
                echo "<a href='login.php'>Sign In</a>";


            } else {
				echo "<a href='rewards.php'>Rewards</a>";
                echo "<a href='user.php'>" . ($_SESSION['firstName']) . "</a>";
				$firstName = $_SESSION['firstName'];
          
				if($dataClass->searchData("cart", "CartID" ,$dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"] != "")
				{
				$cartCount = count($dataClass->cartToArray(($dataClass->searchData("cart", "CartID" ,$dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"])));
				}else
				{
					$cartCount = 0;
					$_SESSION['itemArray'] = array();
				}
				if(isset($cartCount)) 
				{
					$cartDisplay = $cartCount; 
				} 
				else 
				{
					$cartDisplay = "0";
				}

				echo '<a href="cart.php" id="cartNum">' . $cartDisplay. '</a><svg id="cart" class="icon-bag" version="1.1" viewBox="0.0 0.0 149.35958005249344 115.65879265091864" fill="none" stroke="none" stroke-linecap="square" stroke-miterlimit="10" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><clipPath id="p.0"><path d="m0 0l149.35957 0l0 115.65879l-149.35957 0l0 -115.65879z" clip-rule="nonzero"/></clipPath><g clip-path="url(#p.0)"><path fill="#000000" fill-opacity="0.0" d="m0 0l149.35957 0l0 115.65879l-149.35957 0z" fill-rule="evenodd"/><path fill="#fff9fb" d="m34.52231 46.143044l0 0c0 -25.409575 17.867249 -46.04065 39.97361 -46.156994c22.106361 -0.1163453 40.13723 20.3258 40.33967 45.73431l-12.22892 0.12872314l0 0c-0.13323212 -18.679798 -12.671074 -33.71457 -28.047867 -33.63364c-15.376793 0.08092785 -27.80693 15.247105 -27.80693 33.9276z" fill-rule="evenodd"/><path fill="#fff9fb" d="m2.0341208 43.640434l0 0c0 -7.3754005 5.978943 -13.354345 13.354343 -13.354345l118.58265 0c3.5417938 0 6.9385223 1.406971 9.442947 3.911398c2.504425 2.504425 3.9113922 5.9011536 3.9113922 9.442947l0 58.67714c0 7.3753967 -5.978943 13.35434 -13.35434 13.35434l-118.58265 0c-7.3754005 0 -13.354343 -5.978943 -13.354343 -13.35434z" fill-rule="evenodd"/></g></svg></a>';
			}
			?>
			<!-- <a href="cart.php" id='cartNum'></a><svg id='cart' class="icon-bag" version="1.1" viewBox="0.0 0.0 149.35958005249344 115.65879265091864" fill="none" stroke="none" stroke-linecap="square" stroke-miterlimit="10" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg"><clipPath id="p.0"><path d="m0 0l149.35957 0l0 115.65879l-149.35957 0l0 -115.65879z" clip-rule="nonzero"/></clipPath><g clip-path="url(#p.0)"><path fill="#000000" fill-opacity="0.0" d="m0 0l149.35957 0l0 115.65879l-149.35957 0z" fill-rule="evenodd"/><path fill="#fff9fb" d="m34.52231 46.143044l0 0c0 -25.409575 17.867249 -46.04065 39.97361 -46.156994c22.106361 -0.1163453 40.13723 20.3258 40.33967 45.73431l-12.22892 0.12872314l0 0c-0.13323212 -18.679798 -12.671074 -33.71457 -28.047867 -33.63364c-15.376793 0.08092785 -27.80693 15.247105 -27.80693 33.9276z" fill-rule="evenodd"/><path fill="#fff9fb" d="m2.0341208 43.640434l0 0c0 -7.3754005 5.978943 -13.354345 13.354343 -13.354345l118.58265 0c3.5417938 0 6.9385223 1.406971 9.442947 3.911398c2.504425 2.504425 3.9113922 5.9011536 3.9113922 9.442947l0 58.67714c0 7.3753967 -5.978943 13.35434 -13.35434 13.35434l-118.58265 0c-7.3754005 0 -13.354343 -5.978943 -13.354343 -13.35434z" fill-rule="evenodd"/></g></svg></a>
		</div> -->
	</nav>
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
		
			cart.addEventListener('click', function() {window.location.href = "cart.php";});
		</script>





