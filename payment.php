<?php 
include('references/header.php');

if (isset($_SESSION['firstName'])) {
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
        $subtotal = 0;
        $itemCount = 0;
        $totalItems = count($_SESSION['itemArray']);

        foreach ($_SESSION['itemArray'] as $itemID) {
            $sql = "SELECT ItemID, Price, Name, Description FROM menu WHERE ItemID='$itemID[0]'";
            $cartQuery = mysqli_query($con, $sql);
 
            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    $itemPrice = $row['Price'];

                    // Check if the item is the first one and we are redeeming
                    if (isset($_SESSION['subtract']) && $_SESSION['subtract'] == 1 && $itemCount == 0) {
                        $itemPrice = 0; // This item is free due to the redemption
                    }

                    for($custom = 1; $custom < count($itemID); $custom++)
                    {
                        $itemPrice += $dataClass->searchData("customization", "CustomizationID", $itemID[$custom])['Price'];
                    }

                    echo "<div style='margin: 20px;'>";
                    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
                    echo "<p><strong>Price:</strong> $" . number_format($itemPrice, 2) . "</p>";
                    echo "</div>";
                    
                    $subtotal += $itemPrice;

                    $itemCount++;
                }
            }
        }

        if (isset($subtotal)) {
            $tax = $subtotal * 0.07;
            $tax = round($tax, 2);
            $total = $subtotal + $tax;
            $total = round($total, 2);

            echo "<div style='position: absolute; margin-top: 200px; margin-left: 800px;'>";
            echo "Subtotal: $" . number_format($subtotal, 2) . "<br>";
            echo "Tax: $" . number_format($tax, 2) . "<br>";
            echo "Total: $" . number_format($total, 2) . "<br>";
            echo "</div>";
        }
    } else {
        $_SESSION['buySomething'] = "<div class='error'>There are no items in the cart.</div>";
        header('location: cart.php');
        exit();
    }
} else {
    header("location: index.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
    exit();
}

?>

<button style="width: 100px; display: flex; justify-content: center;">
    <a href="cart.php">Back</a>
</button>

<form method="POST">
    <input type="submit" name="pay" value="Pay">
</form>

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
                header("location: index.php");
                exit();
            }
        }
    }
}
?>

</body>
</html>
