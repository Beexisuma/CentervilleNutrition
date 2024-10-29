<?php include('references/header.php');



if(isset($_SESSION['loginSuccess'])) {
    echo $_SESSION['loginSuccess'];
    unset($_SESSION['loginSuccess']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centerville Nutrition</title>
	<link rel="stylesheet" href="styles.css">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playball&display=swap" rel="stylesheet">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
				<h1>It's Our Treat</h1>
			</div>
			<div class="welcome-card welcome-facts2">
				<h4 class="welcome-styled">Knockout</h4>
				<h1>Protein Shakes</h1>
				<h2><span>27g</span> Protein</h2>
				<h2><span>250</span> Calories</h2>
				<h2><span><11g</span> Sugar</h2>
				<p>Loaded with <span>21</span> vitamins and minerals</p>
			</div>
		</div>
		<section class="home-bottom">
				<h1>About Us</h1>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quam velit, vulputate eu pharetra nec, mattis ac neque. Duis vulputate commodo lectus, ac blandit elit tincidunt id. Sed rhoncus, tortor sed eleifend tristique, tortor mauris molestie elit, et lacinia ipsum quam nec dui.</p>
		</section>
	</div>
</div>
</body>
</html>

