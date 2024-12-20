<?php
// Include the header file for common references (e.g., navigation, etc.)
include 'references/header.php';

// Retrieve the user's CartID and convert the cart's item list into an array
$_SESSION['itemArray'] = $dataClass->cartToArray(($dataClass->searchData("cart", "CartID", $dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"]));

// Check if the user is logged in
if (isset($_SESSION['firstName'])) {

    // Check if there are items in the cart
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
        $total = 0;

        // Inside your PHP code, check if the user has previously checked the box
if (isset($_SESSION['cartChecked']) && $_SESSION['cartChecked'] == 'yes') {
    // When the checkbox was previously checked, set it to "checked"
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var checkbox = document.getElementById('punchCheck');
                checkbox.checked = true; // Set checkbox to checked
                document.getElementById('punchForm').submit();

            });
          </script>";
          unset($_SESSION['cartChecked']);
          $total = $total - 10.99;
}

        // Handle item deletion from the cart
        if (isset($_POST['deleteButton'])) {
            $itemIDToRemove = $_POST['cartItemID'];

            // Remove the item from the session's itemArray
            unset($_SESSION['itemArray'][$itemIDToRemove]);
            $_SESSION['itemArray'] = array_values($_SESSION['itemArray']); // Re-index the array

            // Update the cart in the database with the new item list
            $dataClass->updateData('cart', 'ItemList = "' . $dataClass->cartToString($_SESSION['itemArray']) . '"', 'CartID', $dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);
            header("Location: cart.php");  // Redirect back to the cart page
            exit();  // Stop further execution
        }

        // Create a temporary array to store item counts (including customizations)
        $groupedItems = [];

        // Group items by their ID and customizations
        foreach ($_SESSION['itemArray'] as $itemID) {
            $baseItemID = $itemID[0]; // The main item ID
            $customizations = array_slice($itemID, 1); // The customizations (rest of the array)

            // Create a unique key for this item based on its ID and customizations
            $key = $baseItemID . implode("-", $customizations);

            // If the item with this key already exists, increment its count
            if (isset($groupedItems[$key])) {
                $groupedItems[$key]['quantity']++;
            } else {
                // Otherwise, add it to the array with quantity 1
                $groupedItems[$key] = [
                    'itemID' => $baseItemID,
                    'customizations' => $customizations,
                    'quantity' => 1
                ];
            }
        }

        // Display grouped items and calculate the total
        $cartIndex = 0;
        echo "<div class='main-content cart-content'>
                <h1 class='cart-title'>My Items</h1>
                <div class='cart-list'>";

        foreach ($groupedItems as $key => $item) {
            $baseItemID = $item['itemID'];
            $customizations = $item['customizations'];
            $quantity = $item['quantity'];
            $itemTotal = 0; // Initialize the total for the item

            // Query to get item details from the menu based on the ItemID
            $sql = "SELECT ItemID, Price, Name, Description, Type FROM menu WHERE ItemID='$baseItemID'";
            $cartQuery = mysqli_query($con, $sql);

            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    // Display item details
                    echo "<div class='cart-item'>
                            <span>
                                <img src='references/" . htmlspecialchars($row['Type']) . ".png' class='cart-img' />
                                <div class='cart-item-text'>
                                    <h1 class='cart-item-title'>" . htmlspecialchars($row['Name']) . " <strong class='cart-item-quantity'>x" . $quantity . "</strong></h1>";
                                    if ($row['Type'] == 'Tea') {
                                        $type2 = "Tea Bomb";
                                    } else {
                                        $type2 = "Protein Shake";
                                    }
                                    echo "<h2 class='cart-item-type " . htmlspecialchars($row['Type']) . "-text'>" . $type2 . "</h2>
                                    <p class='cart-item-custom'>";

                    // Loop through customizations
                    $customizationCount = count($customizations); // Get the total number of customizations
                    $currentCustomizationIndex = 0; // Track the index of the current customization

                    foreach ($customizations as $customizationID) {
                        $customization = $dataClass->searchData("customization", "CustomizationID", $customizationID);
                        
                        // Display customization name and price, but avoid adding a comma after the last one
                        echo htmlspecialchars($customization['Name']);
                        if ($currentCustomizationIndex < $customizationCount - 1) {
                            echo ", "; // Add a comma only if it's not the last customization
                        }

                        // Add the price of each customization to the item total
                        $itemTotal += $customization['Price'] * $quantity;

                        $currentCustomizationIndex++;
                    }
                    
                    echo "</p>";
                    
                    // Add the price of the current item (base item price)
                    $itemTotal += $row['Price'] * $quantity;  // Multiply by quantity
                    
                    // Display the delete button
                    echo "</div>
                            </span>
                            <section>
                                <form method='POST'>
                                <input type='submit' class='delete-cart' name='deleteButton' value='✕' />
                                <input type='hidden' name='cartItemID' value='" . $cartIndex . "' />
                                </form>
                                <p class='cart-item-price'>$" . number_format($itemTotal, 2) . "</p>
                            </section>
                          </div>";
                    
                    // Add the price of the current item to the total
                    $total += $itemTotal;

                    $cartIndex++;
                }
            }
        }

        // Check if the user has unredeemed punches on their punchcard
        $_SESSION['subtract'] = 0;
        if ($_SESSION['unredeemed'] > 0) {
            // Display a form for redeeming a free drink with punch card points
            echo "<form method='POST' id='punchForm'>
                    Would you like to redeem 10 punches for a free drink?<br>
                    <input type='checkbox' name='punchCheck' id='punchCheck' " . (isset($_POST['punchCheck']) && $_POST['punchCheck'] == 'on' ? 'checked' : '') . " /> Yes, redeem 10 punches for a free drink
                  </form>";

            // If the user checks the box, apply the discount
            if (isset($_POST['punchCheck']) && $_POST['punchCheck'] == 'on') {
                $total -= 10.99;  // Subtract the price of a free drink (10.99)
                $total = round($total, 2);  // Round the total to two decimal places
                $_SESSION['subtract'] = 1;  // Indicate that the discount has been applied
            } else {
                // If the checkbox is unchecked, remove the discount (if previously applied)
                if ($_SESSION['subtract'] == 1) {
                    $total += 10.99;  // Add the free drink price back
                    $total = round($total, 2);  // Round the total to two decimal places
                    $_SESSION['subtract'] = 0;  // Reset the discount flag
                }
            }
        }

        // Store the total in the session and display it
        $_SESSION['total'] = $total;
        echo "<h3>Total: $" . number_format($total, 2) . "</h3>";

        // Display a checkout button
        echo ("<a class='cart-checkout' href='payment.php'>Checkout</a>");
        echo "</div></div>";
    } else {
        // If the cart is empty, display a message
        if (!isset($_SESSION['buySomething'])) {
            $_SESSION['buySomething'] = "<div class='error'>There are no items in the cart.</div>";
        }
        echo $_SESSION['buySomething'];
        unset($_SESSION['buySomething']); // Clear the message after it's displayed
    }
} else {
    // Redirect to the home page if the user is not logged in
    header("location: index.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}
?>

<script>
    // Automatically submit the form when the checkbox is checked or unchecked
    document.getElementById('punchCheck').addEventListener('change', function() {
        document.getElementById('punchForm').submit();
    });
</script>
