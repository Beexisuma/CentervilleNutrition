<?php 
include('references/header.php');

// Check if the user is logged in and if the cart has items
if (isset($_SESSION['firstName'])) {
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {

        // Initialize subtotal as 0
        $subtotal = 0;
        $itemCount = 0; // Counter for the first item
        $totalItems = count($_SESSION['itemArray']); // Total items in cart

        // Loop through the items in the cart and display them
        foreach ($_SESSION['itemArray'] as $itemID) {
            $sql = "SELECT ItemID, Price, Name, Description FROM menu WHERE ItemID='$itemID'";
            $cartQuery = mysqli_query($con, $sql);

            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    $itemPrice = $row['Price'];

                    // If the punchcard is being redeemed, set the price of the first item to 0
                    if (isset($_SESSION['subtract']) && $_SESSION['subtract'] == 1 && $itemCount == 0) {
                        $itemPrice = 0; // Set the price of the first item to 0 (free drink)
                    }

                    echo "<div style='margin: 20px;'>";
                    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
                    echo "<p><strong>Price:</strong> $" . number_format($itemPrice, 2) . "</p>";
                    echo "</div>";
                    
                    // Update subtotal: if item is not free (itemPrice > 0), we add it
                    $subtotal += $itemPrice;

                    $itemCount++; // Increment item counter for free drink application
                }
            }
        }

        // Display the subtotal, tax, and total
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
        exit(); // Ensure the script stops after redirect
    }
} else {
    header("location: index.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
    exit(); // Ensure the script stops after redirect
}

?>

<!-- Back Button and Payment Form -->
<button style="width: 100px; display: flex; justify-content: center;">
    <a href="cart.php">Back</a>
</button>

<form method="POST">
    <input type="submit" name="pay" value="Pay">
</form>

<?php
// Handle the payment action
if (isset($_POST['pay'])) {
    $email = $_SESSION['email'];

    // Fetch the CartID for the logged-in user
    $cartID_query = mysqli_query($con, "SELECT CartID FROM user WHERE email='$email'");
    if ($cartID_query && mysqli_num_rows($cartID_query) > 0) {
        $cartID = mysqli_fetch_row($cartID_query)[0];

        // Fetch the current number of punches associated with the CartID
        $currentPunch_query = mysqli_query($con, "SELECT CurrentPunches FROM punchcard WHERE CartID='$cartID'");
        if ($currentPunch_query && mysqli_num_rows($currentPunch_query) > 0) {
            $currentPunch = mysqli_fetch_row($currentPunch_query)[0];

            // Calculate the new number of punches
            $newPunch = $currentPunch + $totalItems; // Add punches for all items in the cart

            if ($newPunch > 10) {
                $newPunch = 10; // Cap the number of punches at 10
            }

            // Update the punchcard with the new punch count
            $update_query = "UPDATE punchcard SET CurrentPunches='$newPunch' WHERE CartID='$cartID'";
            $update_res = mysqli_query($con, $update_query);

            if ($update_res) {
                // If the discount was applied, subtract 10 punches (redeeming a free drink)
                if ($_SESSION['subtract'] == 1) {
                    $newPunch -= 10; // Subtract 10 for the free drink (if applicable)
                    if ($newPunch < 0) {
                        $newPunch = 0; // Prevent negative punches
                    }
                    $update_query = "UPDATE punchcard SET CurrentPunches='$newPunch' WHERE CartID='$cartID'";
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
