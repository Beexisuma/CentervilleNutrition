<?php
include 'references/header.php';
$isOpen = $_SESSION['isOpen'];


// check if user is logged in
if (isset($_SESSION['firstName'])) {

    // check cart for items
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
        $total = 0;

if (isset($_SESSION['cartChecked']) && $_SESSION['cartChecked'] == 'yes') {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                var checkbox = document.getElementById('punchCheck');
                checkbox.checked = true; 
                document.getElementById('punchForm').submit();

            });
          </script>";
          unset($_SESSION['cartChecked']);
          $total = $total - 10.99;
}

        // if delete button is pressed, delete the itemID
        

        // temp array to store item groups
        $groupedItems = [];

        // for each item in the array, add its itemID as the first value
        
        foreach ($_SESSION['itemArray'] as $itemID) {
            $baseItemID = $itemID[0]; // 
            $customizations = array_slice($itemID, 1); // add customizations for the rest of the values

            // Create a unique key for this item based on its ID and customizations
            $key = $baseItemID . implode("-", $customizations);

            // If the item with this key already exists, increment its count
            if (isset($groupedItems[$key])) {
                $groupedItems[$key]['quantity']++;
            } else {
                // Otherwise, add it to the array with quantity 1
                $groupedItems[$key] = [
                    'array' => $itemID,
                    'itemID' => $baseItemID,
                    'customizations' => $customizations,
                    'quantity' => 1
                ];
            }
        }

        if (isset($_POST['deleteButton'])) {
            $itemAsString = $_POST["cartItemID"];
            $itemAsArray = $dataClass->cartToArray($itemAsString)[0];
            $count = 0;
            
            $cart = $_SESSION['itemArray'];

            foreach($_SESSION['itemArray'] as $cartItem)
            {
                if($cartItem == $itemAsArray)
                {
                    unset($cart[$count]);
                }
                $count++;
            }

            $_SESSION['itemArray'] = $cart; // recreate the array with new values

            // update the database with new array
            $dataClass->updateData('cart', 'ItemList = "' . $dataClass->cartToString($_SESSION['itemArray']) . '"', 'CartID', $dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);
            header("Location: cart.php");  // reload page
            
            exit(); 
        }

        // Display grouped items and calculate the total
        $cartIndex = 0;
        echo "<div class='main-content cart-content'>
                <h1 class='cart-title'>My Items</h1>
                <div class='cart-list'>";

        $_SESSION['highestDrink'] = 0;
        


        foreach ($groupedItems as $key => $item) {
            $oneItem = 0;
            $baseItemID = $item['itemID'];
            $customizations = $item['customizations'];
            $quantity = $item['quantity'];
            $itemTotal = 0; // Initialize the total for the item

            // Query to get item details from the menu based on the ItemID
            $sql = "SELECT ItemID, Price, Name, Description, ImagePath, type FROM menu WHERE ItemID='$baseItemID'";
            $cartQuery = mysqli_query($con, $sql);

            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    // Display item details
                    if($row['ImagePath'] == 'none')
                    {
                        if($row['type'] == 'Shake')
                        {
                            $src = "./menuImages/Shake.png";
                        }
                        else
                        {
                            $src = "./menuImages/Tea.png";
                        }
                    }
                    else
                    {
                        $src = $row['ImagePath'];
                    }
                    echo "<div class='cart-item'>
                            <span>
                                <img src='" . $src . "' class='cart-img' />
                                <div class='cart-item-text'>
                                    <h1 class='cart-item-title'>" . htmlspecialchars($row['Name']) . " <strong class='cart-item-quantity'>x" . $quantity . "</strong></h1>";
                                    if ($row['type'] == 'Tea') {
                                        $type2 = "Tea Bomb";
                                    } else {
                                        $type2 = "Protein Shake";
                                    }
                                    echo "<h2 class='cart-item-type " . htmlspecialchars($row['type']) . "-text'>" . $type2 . "</h2>
                                    <p class='cart-item-custom'>";

                    // loop through customizations
                    $customizationCount = count($customizations); // count customizations
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
                        $oneItem += $customization['Price'];

                        $currentCustomizationIndex++;
                    }
                    
                    echo "</p>";
                    
                    // Add the price of the current item (base item price)
                    $itemTotal += $row['Price'] * $quantity;  // Multiply by quantity
                    $oneItem += $row['Price'];

                    // Display the delete button
                    echo "</div>
                            </span>
                            <section>
                                <form method='POST'>
                                <input type='submit' class='delete-cart' name='deleteButton' value='✕' />
                                <input type='hidden' name='cartItemID' value='" . $dataClass->cartToString(array($item['array'])) . "' />
                                </form>
                                <p class='cart-item-price'>$" . number_format($itemTotal, 2) . "</p>
                            </section>
                          </div>";
                    
                    // Add the price of the current item to the total
                    $total += $itemTotal;

                    if($oneItem > $_SESSION['highestDrink'])
                    {
                        $_SESSION['highestDrink'] = $oneItem;
                    }

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
                $total -= $_SESSION['highestDrink'];  // subtract free drink
                $total = round($total, 2);  // round total to 2 places
                $_SESSION['subtract'] = 1;  // flag for payment page
            } else {
                // remove discount and flag if unchecked
                if ($_SESSION['subtract'] == 1) {
                    $total += $_SESSION['highestDrink'];  
                    $total = round($total, 2); 
                    $_SESSION['subtract'] = 0;  
                }
            }
        }

        // session variable for total
        $_SESSION['total'] = $total;
        echo "<h3>Total: $" . number_format($total, 2) . "</h3>";
        if($isOpen)
        {
            echo ("<a class='cart-checkout' href='payment.php'>Checkout</a>");
        }
        else
        {
            echo("<p>Sorry, checkout is disabled after store hours</p>");
            echo ("<a class='cart-no-more'>Checkout</a>");
        }
        
        
        echo "</div></div>";
    } else {
   
        if (!isset($_SESSION['buySomething'])) {
            $_SESSION['buySomething'] = "<div class='error'>There are no items in the cart.</div>";
        }
        echo $_SESSION['buySomething'];
        unset($_SESSION['buySomething']); 
    }
} else {
    // home page redirect if user is not logged in
    header("location: index.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}
?>

<script>
    // when checked or unchecked, submit the form to update page
        document.getElementById('punchCheck').addEventListener('change', function() {
        document.getElementById('punchForm').submit();
    });
</script>




