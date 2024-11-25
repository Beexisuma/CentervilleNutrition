<?php
include('references/header.php');


if (isset($_SESSION['success_message'])) {
    echo "<div class='success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']); 
}

// Set default type to 'Shake' if not already set in the session
if (!isset($_SESSION['type'])) {
    $_SESSION['type'] = 'Shake'; // Default type is 'Shake'
}

if(!isset($_SESSION['itemArray'])) {
    $_SESSION['itemArray'] = array();
}

// Handle link click to toggle between Shake and Tea
if (isset($_POST['toggleType'])) {
    $_SESSION['type'] = ($_SESSION['type'] == 'Shake') ? 'Tea' : 'Shake';
    header("Location: menuDisplay.php"); // Redirect to reload the page with updated session
    exit();
}
?>

<div class="main-content menu-content">
    <h1><?php echo ($_SESSION['type'] == 'Shake') ? 'Protein Shakes' : 'Tea Bombs'; ?></h1>
    
    <form method="POST">
        <input type="submit" name="toggleType" class="go<?php echo $_SESSION['type']; ?>" value="<?php echo ($_SESSION['type'] == 'Shake') ? 'View Tea Bombs' : 'View Protein Shakes'; ?>">
    </form>
    
<span style="width:100vw">
			<!--Waves from https://www.softr.io/tools/svg-wave-generator -->
				<svg class="menu-wave" viewBox="0 0 1440 160" version="1.1" xmlns="http://www.w3.org/2000/svg"><path fill="#dfdede" d="M0,80L48,69.3C96,59,192,37,288,40C384,43,480,69,576,90.7C672,112,768,128,864,120C960,112,1056,80,1152,61.3C1248,43,1344,37,1440,40C1536,43,1632,53,1728,61.3C1824,69,1920,75,2016,85.3C2112,96,2208,112,2304,98.7C2400,85,2496,43,2592,45.3C2688,48,2784,96,2880,112C2976,128,3072,112,3168,90.7C3264,69,3360,43,3456,32C3552,21,3648,27,3744,48C3840,69,3936,107,4032,122.7C4128,139,4224,133,4320,125.3C4416,117,4512,107,4608,93.3C4704,80,4800,64,4896,72C4992,80,5088,112,5184,125.3C5280,139,5376,133,5472,117.3C5568,101,5664,75,5760,74.7C5856,75,5952,101,6048,101.3C6144,101,6240,75,6336,53.3C6432,32,6528,16,6624,8C6720,0,6816,0,6864,0L6912,0L6912,160L6864,160C6816,160,6720,160,6624,160C6528,160,6432,160,6336,160C6240,160,6144,160,6048,160C5952,160,5856,160,5760,160C5664,160,5568,160,5472,160C5376,160,5280,160,5184,160C5088,160,4992,160,4896,160C4800,160,4704,160,4608,160C4512,160,4416,160,4320,160C4224,160,4128,160,4032,160C3936,160,3840,160,3744,160C3648,160,3552,160,3456,160C3360,160,3264,160,3168,160C3072,160,2976,160,2880,160C2784,160,2688,160,2592,160C2496,160,2400,160,2304,160C2208,160,2112,160,2016,160C1920,160,1824,160,1728,160C1632,160,1536,160,1440,160C1344,160,1248,160,1152,160C1056,160,960,160,864,160C768,160,672,160,576,160C480,160,384,160,288,160C192,160,96,160,48,160L0,160Z"></path></svg>	
</span>

<div class='shake-collection'>
<div class="collection-grid">

<?php
$type = $_SESSION['type'];
$menu_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock FROM menu WHERE Type='$type'");
$num_rows = mysqli_num_rows($menu_query);

// Display menu items if available
if ($num_rows > 0) {
    // Loop through each item and display it
    while ($row = $menu_query->fetch_assoc()) {
        if ($row["InStock"] == 1) {
            echo "
                <div class='collection'>
						<a class='collection-img' href='#'></a>
                        <p class='collection-title'>" . htmlspecialchars($row['Name']) . "</p>
                          <form style='display: flex; justify-content: center;' method='POST'>
                        <input type='hidden' name='item_id' value='" . htmlspecialchars($row['ItemID']) . "'>
                        <input type='submit' name='addCart' value='Add to Cart' class='add-to-cart-btn'>
                    </form>
				</div>
            "; 
        }
    }
} else {
    echo "<p>No items available.</p>";
}

// Handle Add to Cart
if (isset($_POST['addCart'])) {
    $item_id = $_POST['item_id'];
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
    $row = $item_query->fetch_assoc();
    
    // Store the ItemID in a session variable for customization page
    $_SESSION['customize_item_id'] = $item_id;
    
    // Redirect to the customization page
    header('Location: customize.php');
    exit(); 
}
?>
</div>
</div>
</div>
</body>
</html>

							
					
					



