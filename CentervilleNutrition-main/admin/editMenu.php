<?php include('../header/header2.php');



    if(!isset($_GET['admin-drink'])) {
        $_GET['admin-drink'] = 'Teas';
    }



    $type = $_GET['admin-drink'];
    


?>
			<div class="main-content admin-content">
				<div id="adminNav" class="admin-left mobile-nav">
					
					<!--Admin Drink Nav-->
					<button class="out nav-out" onclick="addNav()">✕</button>
					<form class="admin-menu" method="GET">
						<input


							class="admin-menu-nav <?php if($type=="Teas") {echo 'list-select';}?>"
							type="submit"
							name="admin-drink"
							value="Teas"
							onclick="drinkMenu(1)"
						/>
						<input
							class="admin-menu-nav <?php if($type=="Shakes") {echo 'list-select2';}?>"
							type="submit"
							name="admin-drink"
							value="Shakes"
							onclick="drinkMenu(2)"
						/>
						<input
							class="admin-menu-nav <?php if($type=="Add-Ons") {echo 'list-select3';}?>"
							type="submit"
							name="admin-drink"
							value="Add-Ons"
							onclick="drinkMenu(3)"
						/>
					</form>


					<!--Admin Menu Btns-->
					<section>
						<a class="admin-switch user-switch" href='editUser.php'>
							<svg
								version="1.1"
								viewBox="0.0 0.0 102.17060367454069 140.9291338582677"
								fill="none"
								stroke="none"
								stroke-linecap="square"
								stroke-miterlimit="10"
								xmlns:xlink="http://www.w3.org/1999/xlink"
								xmlns="http://www.w3.org/2000/svg"
							>
								<clipPath id="p.0">
									<path
										d="m0 0l102.1706 0l0 140.92914l-102.1706 0l0 -140.92914z"
										clip-rule="nonzero"
									/>
								</clipPath>
								<g clip-path="url(#p.0)">
									<path
										fill="#000000"
										fill-opacity="0.0"
										d="m0 0l102.1706 0l0 140.92914l-102.1706 0z"
										fill-rule="evenodd"
									/>
									<path
										fill="var(--light1)"
										d="m9.46323 136.74278l0 -34.677162l0 0c0 -19.151672 18.634825 -34.67717 41.622047 -34.67717c22.987225 0 41.622044 15.525497 41.622044 34.67717l0 34.677162z"
										fill-rule="evenodd"
									/>
									<path
										fill="var(--light1)"
										d="m20.880978 34.391075l0 0c0 -16.681608 13.523117 -30.204723 30.204723 -30.204723l0 0c8.010792 0 15.693481 3.1822743 21.357964 8.846759c5.6644897 5.664485 8.846764 13.347175 8.846764 21.357964l0 0c0 16.68161 -13.523117 30.204727 -30.204727 30.204727l0 0c-16.681606 0 -30.204723 -13.523117 -30.204723 -30.204727z"
										fill-rule="evenodd"
									/>
								</g>
							</svg>
							<h1>Users</h1>
						</a>

						<!---->


						<a class="admin-switch history-switch" href='editTransaction.php'>
							<svg
								version="1.1"
								viewBox="0.0 0.0 101.14698162729658 120.31233595800525"
								fill="none"
								stroke="none"
								stroke-linecap="square"
								stroke-miterlimit="10"
								xmlns:xlink="http://www.w3.org/1999/xlink"
								xmlns="http://www.w3.org/2000/svg"
							>
								<clipPath id="p.0">
									<path
										d="m0 0l101.14698 0l0 120.31233l-101.14698 0l0 -120.31233z"
										clip-rule="nonzero"
									/>
								</clipPath>
								<g clip-path="url(#p.0)">
									<path
										fill="#000000"
										fill-opacity="0.0"
										d="m0 0l101.14698 0l0 120.31233l-101.14698 0z"
										fill-rule="evenodd"
									/>
									<path
										fill="#fff9fb"
										d="m47.665913 22.222082l0 28.32226l0 0c-1.232811 -0.43878555 -2.4327202 -0.8747597 -3.5997276 -1.3079224c-3.233799 -1.2066193 -5.846367 -2.7912178 -7.8377037 -4.753792c-1.9913368 -1.9771156 -2.9870071 -4.6156883 -2.9870071 -7.915722c0 -3.0383568 0.8084488 -5.6478558 2.4253464 -7.828495c1.6339188 -2.195179 3.9145966 -3.896078 6.8420334 -5.1026955c1.5576057 -0.6420059 3.2766228 -1.1132183 5.157055 -1.4136333zm8.961021 44.23046c2.1979752 0.8753662 4.206333 1.8602982 6.025074 2.9547882c2.2466354 1.3374634 4.025223 2.943863 5.335762 4.819214c1.3105392 1.875351 1.9658127 4.15049 1.9658127 6.8254013c0 3.4890213 -0.7573929 6.41835 -2.272171 8.787979c-1.5147781 2.3550873 -3.795456 4.1141357 -6.8420334 5.2771454c-1.2671776 0.48645782 -2.6713257 0.8711777 -4.2124443 1.1541519l0 0l0 -29.81868zm-4.8762283 -61.897423c-2.723198 0 -4.084793 0.79956675 -4.084793 2.398703l0 4.962012l-3.8146973E-6 0c-2.8704453 0.28674412 -5.5851326 0.79884243 -8.144062 1.536294c-4.1869125 1.2066212 -7.8206806 2.929327 -10.9012985 5.1681156c-3.080618 2.2242508 -5.463415 4.8555584 -7.1483936 7.8939133c-1.6679592 3.0383568 -2.501936 6.3456593 -2.501936 9.921911c0 4.3758163 0.782917 8.017483 2.3487568 10.925003c1.5658398 2.8929825 3.659298 5.2771454 6.2803745 7.1524963c2.6210785 1.8753471 5.5485153 3.4672165 8.7823105 4.7756004c3.2508163 1.2938423 6.5441856 2.4713898 9.8801 3.5326347c0.4705162 0.15353012 0.9385643 0.30758286 1.4041519 0.46216583l0 0l0 33.552883l0 0c-4.229553 -0.12199402 -8.076073 -0.69525146 -11.539551 -1.71978c-3.9145966 -1.1630096 -7.1569023 -2.3260193 -9.726921 -3.4890213c-2.5529976 -1.1630096 -4.348606 -1.7445145 -5.3868256 -1.7445145c-0.62973785 0 -1.1828861 0.26895142 -1.6594486 0.806839c-0.4595394 0.5378876 -0.8765297 1.2138824 -1.2509689 2.0279922c-0.35741806 0.7995682 -0.64675903 1.5773239 -0.8680191 2.3332825c-0.20423889 0.7559509 -0.30635834 1.3592606 -0.30635834 1.8099365c0 0.6251068 0.3404007 1.2284164 1.0211983 1.8099289c0.6807995 0.5814972 1.4892464 1.1411896 2.4253483 1.6790924c1.6849785 0.9740143 3.9316158 1.9771042 6.739914 3.0092773c2.8253174 1.0321732 6.1442146 1.9044342 9.956692 2.616768c3.320507 0.6176605 6.852154 0.96754456 10.59494 1.0496368l0 0l0 6.3209305c0 1.5991364 1.3615952 2.398697 4.084793 2.398697l0.7914314 0c2.723198 0 4.084793 -0.79956055 4.084797 -2.398697l0 -6.6815643l0 0c2.6132088 -0.28943634 5.064087 -0.74443054 7.3526306 -1.3649979c4.289036 -1.1630096 7.94833 -2.8784409 10.977894 -5.146309c3.0465775 -2.282402 5.352783 -5.0300064 6.9186172 -8.242821c1.5658417 -3.2273407 2.3487625 -6.847206 2.3487625 -10.859581c0 -4.5502625 -0.8680191 -8.366379 -2.6040573 -11.448357c-1.7190247 -3.0819702 -4.0422516 -5.647854 -6.9696884 -7.6976547c-2.9274368 -2.0643425 -6.144211 -3.7870483 -9.65033 -5.1681175c-2.8131905 -1.1081276 -5.6044693 -2.146061 -8.373829 -3.1137924l0 0l0 -31.64705l0 0c2.228489 0.1932354 4.2879066 0.57169914 6.178253 1.1353855c2.876377 0.8431816 5.361294 1.6936302 7.454754 2.5513477c2.09346 0.8431816 3.6082382 1.2647705 4.5443344 1.2647705c0.5276184 0 1.04673 -0.2689438 1.5573273 -0.8068371c0.5276184 -0.5378914 0.97013855 -1.2066231 1.3275604 -2.0061874c0.37443542 -0.8141041 0.6637802 -1.6209412 0.8680191 -2.4205093c0.22126007 -0.7995682 0.3318863 -1.468296 0.3318863 -2.0061893c0 -0.45066452 -0.2638092 -0.9667473 -0.7914276 -1.548254c-0.5105972 -0.5815029 -1.2424545 -1.0903187 -2.1955795 -1.5264473c-1.7700729 -0.98855686 -3.9145966 -1.8390064 -6.433548 -2.5513477c-2.5019379 -0.7123413 -5.1655655 -1.2938442 -7.9908867 -1.7445116c-1.65485 -0.26396275 -3.2717514 -0.4506216 -4.8506927 -0.5599785l0 0l0 -4.8043942c0 -1.5991364 -1.361599 -2.398703 -4.084797 -2.398703z"
										fill-rule="evenodd"
									/>
								</g>
							</svg>
							<h1>History</h1>
						</a>

				<a class="admin-switch hours-switch" href='editHours.php'>
				<svg xmlns="http://www.w3.org/2000/svg" style="margin-top: 0px" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#fff9fb" d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>


							<h1>Hours</h1>
						</a>
					</section>
				</div>


				<div class="admin-interface">

					<?php 
						if(isset($_SESSION['updateYes'])) {
							echo $_SESSION['updateYes'];
							unset($_SESSION['updateYes']);
						}

						if(isset($_SESSION['deleteYes'])) {
							echo($_SESSION['deleteYes']);
							unset($_SESSION['deleteYes']);
						}
					?>
					
					<h1><?=$type?></h1>
					<!--Search Bar-->
					<form class="search" method="POST">
					<!-- Submit Button with SVG Icon inside -->
					<button type="submit" name="search-submit" class="search-btn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
							<path
								d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
							/>
						</svg>
					</button>
    
						<!-- Search Input -->
						<input type="search" name="search" placeholder="Search Items" />
					</form>


<!-- Admin Item List -->
<div class="admin-list drink-list">
    <?php


if (isset($_POST['search-submit'])) {
    // Get the search term from the input
    $search_query = mysqli_real_escape_string($con, $_POST['search']);
    if($_POST['search'] != "") {
    echo("<h3 style='color: #7ad1a5;'>Showing Results for: " . $_POST['search'] . "</h3>");
    echo("<form method='POST'><input class='charlieDidThis' type='submit' name='reload' value='Clear Search Results'></form>");
    }


    if(isset($_POST['reload'])) {
        header('location: editMenu.php');
    }
    
    // Modify the SQL query to search in Name and Description
    $menu_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, Type, InStock FROM menu WHERE Name LIKE '%$search_query%' OR Description LIKE '%$search_query%' OR ItemID LIKE '%$search_query%'");

	$custom_query = mysqli_query($con, "SELECT CustomizationID, Name, Price, Description, InStock FROM customization WHERE Name LIKE '%$search_query%' OR Description LIKE '%$search_query%' OR CustomizationID LIKE '%$search_query%'");

} else {

    // If no search query is submitted, fetch all menu items
	if($type != 'Add-Ons') {
    $menu_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, Type, InStock FROM menu");
	}
	else {
		$custom_query = mysqli_query($con, "SELECT CustomizationID, Name, Price, Description, InStock FROM customization");
	}
}

if($type != 'Add-Ons') {
$num_rows = mysqli_num_rows($menu_query);

if ($num_rows > 0) {
    while ($row = $menu_query->fetch_assoc()) {
        // Check if the $type matches the category of the item
        if (($type == 'Teas' && $row['Type'] == 'Tea') || ($type == 'Shakes' && $row['Type'] == 'Shake')) {
            echo "<div class='admin-item'>";
            echo "<p>" . $row['Name'] . "</p>";


            // Form for the action buttons (edit and delete)
            echo "<form method='POST' class='list-actions'>";
            
            // Edit button with SVG icon
            echo "<button type='submit' name='editItem' value='" . $row['ItemID'] . "'>
               " . $pencilIcon . "
                </button>";


            echo "<button type='submit' name='deleteItem' value='" . $row['ItemID'] . "' onclick='return confirm(\"Are you sure you want to delete this item?\")'>
               
			" . $trashcanIcon . "
                </button>
            </form>";
            echo "</div>";
        }
    }
}
}

else {
	
	$num_rows = mysqli_num_rows($custom_query);

	if ($num_rows > 0) {
		while ($row = $custom_query->fetch_assoc()) {
			// Check if the $type matches the category of the item
				echo "<div class='admin-item'>";
				echo "<p>" . $row['Name'] . "</p>";
				// Form for the action buttons (edit and delete)
				echo "<form method='POST' class='list-actions'>";
				
				// Edit button with SVG icon
				echo "<button type='submit' name='editItem' value='" . $row['CustomizationID'] . "'>
					" . $pencilIcon . "
					</button>";
	
	
				// Delete button with SVG icon
				echo "<button type='submit' name='deleteItem' value='" . $row['CustomizationID'] . "' onclick='return confirm(\"Are you sure you want to delete this item?\")'>
				" . $trashcanIcon . "
					</button>
				</form>";
				echo "</div>";
			}
		}
	}

    // Deleting an item
    if (isset($_POST['deleteItem']) && $type != 'Add-Ons') {
        $itemID = $_POST['deleteItem'];
        $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, Type, ImagePath FROM menu WHERE ItemID = '$itemID'");
        $row = $item_query->fetch_assoc();
        mysqli_query($con, "DELETE FROM menu WHERE ItemID='$itemID'");
        $originalImage = $row["ImagePath"];
        unlink($originalImage);
        $_SESSION['deleteYes'] = "<div class='success'>Item deleted successfully.</div>";

		$type = $_GET['admin-drink'];


		if ($type == 'Shakes') {
			header('Location: editMenu.php?admin-drink=Shakes');
		} else {
			header('Location: editMenu.php');
		}	
        exit;
    }

	// Deleting a customization 
	elseif (isset($_POST['deleteItem'])) {
        $customID = $_POST['deleteItem'];
        $custom_query = mysqli_query($con, "SELECT CustomizationID, Name, Description, Price, InStock FROM customization WHERE CustomizationID = '$customID'");
        $row = $custom_query->fetch_assoc();
        mysqli_query($con, "DELETE FROM customization WHERE CustomizationID='$customID'");
        $_SESSION['deleteYes'] = "<div class='success'>Item deleted successfully.</div>";
        header("location: editMenu.php?admin-drink=Add-Ons");
        exit;
    }


    // Editing an item
    if (isset($_POST['editItem']) && $type != 'Add-Ons') {
        $itemID = $_POST['editItem'];
        $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, ImagePath, Type FROM menu WHERE ItemID = '$itemID'");
        $row = $item_query->fetch_assoc();


        if ($row) {
			$_SESSION['itemID'] = $itemID;
            $originalName = $row["Name"];
            $originalDescription = $row["Description"];
            $originalPrice = $row["Price"];
            $originalInStock = $row["InStock"];
            $originalType = $row["Type"];
            $originalImage = $row["ImagePath"];


			
echo '
<div class="popup edit popUp-container">
<div class="insert-top">
<button id="insBtn1" class="insert-top-select">
							Edit Item
						</button>
</div>
	<div class="insert-box">
		<form method="POST" id="editForm" class="outform">
			<button class="out2" onclick="closePop(event)">✕</button>
			<input type="submit" hidden name="the">
		</form>
		<form class="insert-form" method="POST" enctype="multipart/form-data">
			<p>Name:</p>
			<input class="insert-text" type="text" name="name" id="name" value="' . htmlspecialchars($originalName) . '" required />
			<section id="drinkInputs">
				<p>Short Description:</p>
				<input class="insert-text" type="text" name="description" value="' . htmlspecialchars($originalDescription) . '" />
				<span class="insert-stock">
					<p>In Stock?</p>
					<select name="inStock" required>
						<option value="1" ' . ($originalInStock == 1 ? "selected" : "") . '>Yes</option>
						<option value="0" ' . ($originalInStock == 0 ? "selected" : "") . '>No</option>
					</select>
				</span>
				<span>
					<p>Type:</p>
					<select name="typeChange" required>
						<option value="1" ' . ($originalType == "Tea" ? "selected" : "") . '>Tea</option>
						<option value="0" ' . ($originalType == "Shake" ? "selected" : "") . '>Shake</option>
					</select>        
				</span>
				<span>
					<p>Image:</p>
					<input type="file" name="image" accept="image/png" value="' . htmlspecialchars($originalImage) . '">
				</span>
			</section>
			<input id="insertTea" class="insert-submit" type="submit" name="editSubmit" value="Submit changes" />
		</form>
	</div>
</div>';

		}}

		// editing a customization		

		elseif(isset($_POST['editItem'])) {
			$customizationID = $_POST['editItem'];
        	$custom_edit_query = mysqli_query($con, "SELECT CustomizationID, Name, Description, Price, InStock FROM customization WHERE CustomizationID = '$customizationID'");
        	$row = $custom_edit_query->fetch_assoc();


        if ($row) {
			$_SESSION['customID'] = $customizationID;
            $originalName = $row["Name"];
            $originalDescription = $row["Description"];
            $originalPrice = $row["Price"];
            $originalInStock = $row["InStock"];

			
echo '
<div class="popup edit popUp-container">
<div class="insert-top">
<button id="insBtn1" class="insert-top-select">
							Edit Item
						</button>
</div>
	<div class="insert-box">
	<button class="out2" onclick="closePop2()">✕</button>
<form class="insert-form" method="POST" enctype="multipart/form-data">
    <p>Name:</p>
    <input class="insert-text" type="text" name="name" id="name" value="' . htmlspecialchars($originalName) . '" required />

    <section id="drinkInputs">
        <p>Short Description:</p>
        <input class="insert-text" type="text" name="description" value="' . htmlspecialchars($originalDescription) . '" />

        <span class="insert-stock">
		<p>In Stock?</p>
            <select name="inStock" required>
                <option value="1" ' . ($originalInStock == 1 ? "selected" : "") . '>Yes</option>
                <option value="0" ' . ($originalInStock == 0 ? "selected" : "") . '>No</option>
            </select>
        </span>
		<span>
		<p>Price:</p>
		<input type="text" name="price" value = "' . htmlspecialchars($originalPrice) . '"/>
		</span>
    </section>
    <input id="insertTea" class="insert-submit" type="submit" name="editSubmit" value="Submit changes" />
</form>
</div>
</div>';
		}
	}
	
// editing a drink 
if(isset($_POST['editSubmit']) && $type != 'Add-Ons') {
	$itemID = $_SESSION['itemID'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$inStock = $_POST['inStock'];
	$type = $_POST['typeChange'];

	if($type == 1) {
		$type = 'Tea';
	}
	else {
		$type = "Shake";
	}
	
	$image = $_FILES['image'];
	$repeatedImage = false;
	if($image["size"] == 0)
	{
		$repeatedImage = true;
	}
	else
	{
		$fileName = preg_replace('/\s+/', '_', $name);
		$imageName = "../images/menuImages/" . $fileName . ".png";
	}

	$item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, Type, ImagePath FROM menu WHERE ItemID = '$itemID'");
    $row = $item_query->fetch_assoc();
	$originalImage = $row["ImagePath"];
	if(!$repeatedImage)
	{
		unlink($originalImage);
		file_put_contents($imageName, file_get_contents($image['tmp_name']));
	}
	else
	{
		$imageName = $originalImage;
	}



	$sql = "UPDATE menu SET name='$name', description='$description', inStock='$inStock', type='$type', imagePath='$imageName' WHERE itemID='$itemID'";
	if ($con->query($sql)) {
	$_SESSION["updateYes"] = "<div class='success'>Item details updated successfully.</div>";} 
	if ($type == 'Shake') {
		header_remove();
		header('Location: editMenu.php?admin-drink=Shakes');
	} else {
		header('Location: editMenu.php');
	}	
	exit();

}


// editing a customization
elseif(isset($_POST['editSubmit'])) {
	$customizationID = $_SESSION['customID'];
	$name = $_POST['name'];
	$description = $_POST['description'];
	$inStock = $_POST['inStock'];
	$price = $_POST['price'];
	$custom_query = mysqli_query($con, "SELECT CustomizationID, Name, Description, Price FROM customization WHERE CustomizationID='$customizationID'");
    $row = $custom_query->fetch_assoc();

	$sql = "UPDATE customization SET name='$name', description='$description', price='$price', inStock='$inStock' WHERE CustomizationID='$customizationID'";
	if ($con->query($sql)) {
	$_SESSION["updateYes"] = "<div class='success'>Item details updated successfully.</div>";} 
	header('Location: editMenu.php?admin-drink=Add-Ons');
	exit();


}


    if (isset($_POST['submitAddMenuItemTea'])) {
		$name = mysqli_real_escape_string($con, $_POST['name']);
		$description = mysqli_real_escape_string($con, $_POST['description']);
		$price = 9.50;
		$type = 'Tea';
		$inStock = isset($_POST['inStock']) ? 1 : 0; 
		
		$image = $_FILES['image'];
		if($image["size"] == 0)
		{
			$imageName = "none";
		}
		else
		{
			$fileName = preg_replace('/\s+/', '_', $name);
			$imageName = "../images/menuImages/" . $fileName . ".png";
		}

		$item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, Type, ImagePath FROM menu WHERE ItemID = '$itemID'");
        $row = $item_query->fetch_assoc();
        mysqli_query($con, "DELETE FROM menu WHERE ItemID='$itemID'");
        $originalImage = $row["ImagePath"];
        unlink($originalImage);
		
		$sql = "INSERT INTO menu (Name, Description, Price, InStock, Type, ImagePath) VALUES ('$name', '$description', '$price', '$inStock', '$type', '$imageName')";
	
				if (mysqli_query($con, $sql)) {
					$_SESSION['updateYes'] = "<div class='success'>" . $name . " added successfully.</div>";
					
					if($imageName != "none")
					{
						file_put_contents($imageName, file_get_contents($image['tmp_name']));
					}
					header("Location: editMenu.php");
					echo($name);
					
				} else {
					$_SESSION['bad'] = "<div class='insertError'>Error adding menu item: " . mysqli_error($con) . "</div>";
				}
				exit();

			}


	if (isset($_POST['submitAddMenuItemShake'])) {
		$name = mysqli_real_escape_string($con, $_POST['name']);
		$description = mysqli_real_escape_string($con, $_POST['description']);
		$price = 10.50;
		$type = 'Shake';
		$inStock = isset($_POST['inStock']) ? 1 : 0; 
		$image = $_FILES['image'];
		if($image["size"] == 0)
		{
			$imageName = "none";
		}
		else
		{
			$fileName = preg_replace('/\s+/', '_', $name);			
			$imageName = "../images/menuImages/" . $fileName . ".png";
		}
		
				$sql = "INSERT INTO menu (Name, Description, Price, InStock, Type, ImagePath) 
						VALUES ('$name', '$description', '$price', '$inStock', '$type', '$imageName')";
	
				if (mysqli_query($con, $sql)) {
					$_SESSION['updateYes'] = "<div class='success'>Menu item added successfully.</div>";
					if($imageName != "none")
					{
						file_put_contents($imageName, file_get_contents($image['tmp_name']));
					}
					
					header("Location: editMenu.php");
				} else {
					$_SESSION['bad'] = "<div class='error'>Error adding menu item: " . mysqli_error($con) . "</div>";
				}
				exit();

	}
	
	if(isset($_POST['submitAddMenuItemCustom'])) {
		$name = mysqli_real_escape_string($con, $_POST['name']);
		$price = mysqli_real_escape_string($con, $_POST['price']);
				$sql = "INSERT INTO customization (Name, Price) 
						VALUES ('$name', '$price')";
	
				if (mysqli_query($con, $sql)) {
					$_SESSION['updateYes'] = "<div class='success'>Menu item added successfully.</div>";	
					header("Location: editMenu.php?admin-drink=Add-Ons");
				} else {
					$_SESSION['bad'] = "<div class='error'>Error adding menu item: " . mysqli_error($con) . "</div>";
				}
				exit();

	}
        ?>


	</div>
	<div class="admin-relative">
						<button class="admin-add" onclick="addNav()">
							<img src="../images/menu.png" />
						</button>
						<button class="admin-add" onclick="addPop()">
							<img src="../images/plus.png" />
						</button>
					</div>
	</div>


	<div class="admin-right"></div>		
				<!--
				INSERTION POPUP
				-->
				<div class="POP popup add popUp-container">
					<div class="insert-top">
						<button
							id="insBtn1"
							class="insert-top-select"
							onclick="insertForm(1)"
						>
							Tea
						</button>
						<button id="insBtn2" onclick="insertForm(2)">Shake</button>
						<button id="insBtn3" onclick="insertForm(3)">Add-On</button>
					</div>
					<div class="insert-box">
					<form method="POST" id="editForm" class="outform">
					<button class="out2" onclick="closePop(Event)">✕</button>
					<input type="submit" hidden name="the">
		</form>
						<h1>Insert Item</h1>
						<h2><?php if(isset($_SESSION['insertError'])) {
							echo $_SESSION['insertError'];
							unset($_SESSION['insertError']);
						}
						?>
						</h2>


						<form class="insert-form" method="POST" enctype="multipart/form-data">
    <p>Name:</p>
    <input class="insert-text" type="text" name="name" id="name" placeholder="Enter menu item name" required />


    <!-- Short Description Section -->
    <section id="drinkInputs">
        <p>Short Description:</p>
        <input class="insert-text" type="text" name="description" placeholder="Enter short description" />


        <span class="insert-stock">
            <input type="checkbox" name="inStock" checked />
            <label for="inStock">In Stock</label>
        </span>


        <span>
            <p>Image:</p>
            <input type='file' name='image' accept='image/png'>
        </span>
    </section>


    <!-- Price Section -->
    <section id="customInput">
        <p>Price:</p>
        <input class="insert-text" type="text" name="price" placeholder="0.00" />
    </section>


    <!-- Submit Buttons for different types -->
    <input id="insertTea" class="insert-submit" type="submit" name="submitAddMenuItemTea" value="Submit Tea" />
    <input id="insertShake" class="insert-submit" type="submit" name="submitAddMenuItemShake" value="Submit Shake" />
    <input id="insertCustom" class="insert-submit" type="submit" name="submitAddMenuItemCustom" value="Submit Add-On" />
</form>


					</div>
				</div>
			</div>
		</div>
		</div>
							




					
							</div>
		<script>
			let insTea = document.getElementById("insertTea");
			let insShake = document.getElementById("insertShake");
			let insCustom = document.getElementById("insertCustom");


			let drink = document.getElementById("drinkInputs");
			let custom = document.getElementById("customInput");


			//default
			custom.style.display = "none";
			insShake.style.display = "none";
			insCustom.style.display = "none";


			function insertForm(code) {
				let btn1 = document.getElementById("insBtn1");
				let btn2 = document.getElementById("insBtn2");
				let btn3 = document.getElementById("insBtn3");


				btn1.classList.remove("insert-top-select");
				btn2.classList.remove("insert-top-select");
				btn3.classList.remove("insert-top-select");


				insTea.style.display = "none";
				insShake.style.display = "none";
				insCustom.style.display = "none";


				switch (code) {
					case 1:
						btn1.classList.add("insert-top-select");
						drink.style.display = "flex";
						custom.style.display = "none";
						insTea.style.display = "inline";
						break;
					case 2:
						btn2.classList.add("insert-top-select");
						drink.style.display = "flex";
						custom.style.display = "none";
						insShake.style.display = "inline";
						break;
					case 3:
						btn3.classList.add("insert-top-select");
						drink.style.display = "none";
						custom.style.display = "flex";
						insCustom.style.display = "inline";
						break;


					default:
						break;
				}
			}


			function closePop(event) {
		    event.preventDefault(); // Prevent the default button action
   			document.getElementById('editForm').submit(); // Submit the form when '✕' is clicked


				document.querySelector(".add").classList.add("POP");
				//console.log("Closed Popup");
			}


			function addPop() {
				document.querySelector(".add").classList.remove("POP");
				//console.log("Added Popup");
			}

			function closePop2() {
				document.querySelector(".edit").classList.add("POP");

			}

			function addNav() {
				document.getElementById("adminNav").classList.toggle("mobile-nav");
				//console.log("Nav toggled");
			}
		</script>
	</body>
</html>

