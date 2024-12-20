<?php 
include('references/header.php');

if (isset($_SESSION['firstName'])) {
    ?>
     <div class="main-content checkout-content">
         <div class="checkout-left">
             <div class="checkout-list">
                 <?php
                 if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
                     $subtotal = 0;
                     $itemCount = 0;
                     $totalItems = count($_SESSION['itemArray']);
                     $groupedItems = [];

                     // Group items by base item ID and customizations
                     foreach ($_SESSION['itemArray'] as $itemID) {
                         $baseItemID = $itemID[0];
                         $customizations = array_slice($itemID, 1); // Customizations are the rest of the item array

                         // Serialize customizations to group identical items
                         $customizationKey = serialize($customizations);

                         // If the item already exists in the grouped array, increment its count
                         if (isset($groupedItems[$baseItemID][$customizationKey])) {
                             $groupedItems[$baseItemID][$customizationKey]['count']++;
                         } else {
                             // If it's a new item, initialize it
                             $groupedItems[$baseItemID][$customizationKey] = [
                                 'count' => 1,
                                 'customizations' => $customizations
                             ];
                         }
                     }

                     // Display grouped items
                     foreach ($groupedItems as $baseItemID => $customizationGroups) {
                         foreach ($customizationGroups as $customizationKey => $group) {
                             // Get item details from the database
                             $sql = "SELECT ItemID, Price, Name, Description FROM menu WHERE ItemID='$baseItemID'";
                             $cartQuery = mysqli_query($con, $sql);

                             if ($cartQuery) {
                                 while ($row = mysqli_fetch_assoc($cartQuery)) {
                                     $itemPrice = $row['Price'];
                                     $itemName = htmlspecialchars($row['Name']);

                                     // Create a label for the customized item
                                     $customizedLabel = $customizedLabel = trim(!empty($group['customizations']) ? '(Customized)' : '');
                                     // Update the subtotal
                                     $subtotal += $itemPrice * $group['count'];

                                     // Add customizations' prices to the item price
                                     if (!empty($group['customizations'])) {
                                         foreach ($group['customizations'] as $customizationID) {
                                             $customizationData = $dataClass->searchData("customization", "CustomizationID", $customizationID);
                                             $subtotal += $customizationData['Price'] * $group['count']; // Add the customization price to the total item price
                                             $itemPrice += $customizationData['Price']; // Add the customization price to the total item price
                                         }
                                     }
                                 }
                                  // Display the base item with customizations and quantity
                                  echo "<div class='checkout-item'>";
                                  echo "<p>" . $itemName . " " . $customizedLabel . " x" . $group['count'] . "</p>";
                                  echo "<p> $" . number_format($itemPrice * $group['count'], 2) . "</p>";
                                  echo "</div>";
                             }
                         }
                     }

                     // Display the free drink (if applicable)
                     if (isset($_SESSION['subtract']) && $_SESSION['subtract'] == 1) {
                         $_SESSION['cartChecked'] = 'yes';
                         echo "<div class='checkout-item'>";
                         echo "<p>Free Drink</p>";
                         echo "<p>-$10.99</p>";
                         echo "</div>";
                         $subtotal -= 10.99;
                     }

                     // Calculate tax and total
                     if (isset($subtotal)) {
                         $tax = $subtotal * 0.07;
                         $tax = round($tax, 2);
                         $total = $subtotal + $tax;
                         $total = round($total, 2);
                        echo "</div>";
                         echo "<div class='total-bottom'>";
                         echo "<div class='total-math'><p>Subtotal:</p><p>$" . number_format($subtotal, 2) . "</p></div>";
                         echo "<div class='total-math'><p>Tax:</p><p>$" . number_format($tax, 2) . "</p></div>";
                        // close checkout list
                         echo "</div>";
                     }
                 } else {
                     $_SESSION['buySomething'] = "<div class='error'>There are no items in the cart.</div>";
                     header('location: cart.php');
                     exit();
                 }
                 ?>
             
             <div class="total-top">
                 <h2 class="total-text">Total:</h2>
                 <h1 class="total-price">$<?php 
                 
                 echo number_format($total, 2);
                 ?></h1>
             </div>
            </div>
<?php
    if (isset($_POST['pay'])) {
        $email = $_SESSION['email'];

        $cartID_query = mysqli_query($con, "SELECT CartID FROM user WHERE email='$email'");
        if ($cartID_query && mysqli_num_rows($cartID_query) > 0) {
            $cartID = mysqli_fetch_row($cartID_query)[0];

            $currentPunch_query = mysqli_query($con, "SELECT CurrentPunches FROM punchcard WHERE CartID='$cartID'");
            if ($currentPunch_query && mysqli_num_rows($currentPunch_query) > 0) {
                $currentPunch = mysqli_fetch_row($currentPunch_query)[0];

                $unredeemed_query = mysqli_query($con, "SELECT UnrewardedCards FROM punchcard WHERE CartID='$cartID'");
                if ($unredeemed_query && mysqli_num_rows($unredeemed_query) > 0) {
                    $unredeemed = mysqli_fetch_row($unredeemed_query)[0]; 
                }

                $newPunch = $currentPunch; // Initialize punches with current punches count
                $itemsProcessed = 0;

                // Loop through the items in the cart
                foreach ($_SESSION['itemArray'] as $itemID) {
                    $sql = "SELECT ItemID, Price FROM menu WHERE ItemID='$itemID[0]'";
                    $cartQuery = mysqli_query($con, $sql);

                    if ($cartQuery) {
                        while ($row = mysqli_fetch_assoc($cartQuery)) {
                            // If we're redeeming for the first item, skip the punch for that item
                            if (isset($_SESSION['subtract']) && $_SESSION['subtract'] == 1 && $itemsProcessed == 0) {
                                 // Skip adding a punch for this redeemed item
                                $itemsProcessed++;
                                continue;
                            }

                            // For all other items, add a punch
                            $newPunch++;
                            $itemsProcessed++;
                        }
                    }
                    $dataClass->updateData('cart','ItemList = ""','CartID',$dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);
                }

                // Calculate unredeemed punch cards
                if ($newPunch >= 10) {
                    $unredeemed += floor($newPunch / 10);
                    $newPunch = $newPunch % 10;
                }

                $update_query = "UPDATE punchcard SET UnrewardedCards='$unredeemed' WHERE CartID='$cartID'";
                $update_res = mysqli_query($con, $update_query);

                $update_query = "UPDATE punchcard SET CurrentPunches='$newPunch' WHERE CartID='$cartID'";
                $update_res = mysqli_query($con, $update_query);

                $_SESSION['unredeemed'] = $unredeemed;

                if ($update_res) {
                    if ($_SESSION['subtract'] == 1) {
                        $unredeemed = $unredeemed - 1;
                        $update_query = "UPDATE punchcard SET UnrewardedCards='$unredeemed' WHERE CartID='$cartID'";
                        $update_res = mysqli_query($con, $update_query);
                    }

                    $_SESSION['paymentSuccess'] = "<div class='success'>Payment successful! Your punches have been updated.</div>";
                    
                    unset($_SESSION['itemArray']); 
                    $_SESSION['cartCount'] = 0;
                    unset($_SESSION['cartChecked']);
                    header("location: index.php");
                    exit();
                }
            }
        }
    }
} else {
    header("location: index.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
    exit();
}
?>
                    <form class="payment-form">
					<h1>Payment</h1>
					<div class="other-payment">
						<div class="other-btn"><img src="references/paypal.png"></div>
						<div class="other-btn"><img src="references/applepay.png"></div>
						<div class="other-btn"><img src="references/venmo.png"></div>
					</div>
					<section class="pay-inputs">
						<p>Card Number:</p><input type="text" name="cardNum" maxlength="19" oninput="formatCreditCard(event)"  placeholder="1111-2222-3333-4444">
						<p>Expiration Date:</p>
					<span>
					<select>  
						<option>January</option>
						<option>February</option>
						<option>March</option>
						<option>April</option>
						<option>April</option>
						<option>May</option>
						<option>June</option>
						<option>July</option>
						<option>August</option>
						<option>September</option>
						<option>October</option>
						<option>November</option>
						<option>December</option>
					</select> 
                        <?php 
                        $year = date("Y"); 
                        $max = $year + 100;

                        echo "<select>";
                        for($i = $year; $i <= $max; $i++) {
                        echo "<option>" . $i . "</option>";
                        }
                        echo "</select>";
                        ?>
					</span>
						<p>CVV:</p><input maxlength="4" type="text" oninput="formatCVV(event)" name="cardNum" placeholder="123">
						<p>Name on Card:</p><input type="text" name="cardNum" placeholder="John Doe">
						<p>Zip Code:</p><input type="text" name="cardNum" placeholder="10001">
					</section>
					<input type="submit" class="submit-pay" value="Submit"/>
				</form>
            </div>
        </div>

    </body>
	
	<script>
        function formatCreditCard(event) {
            //Get the input
            const input = event.target;

            //Remove non-numeric characters
            let value = input.value.replace(/\D/g, '');

            //Add spaces
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');

            input.value = value;
        }

        function formatCVV(event) {
            //Get the input
            const input = event.target;

            //Remove non-numeric characters
            let value = input.value.replace(/\D/g, '');

            //Add spaces
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');

            input.value = value;
        }

    </script>

</html>

