<?php
include 'references/header.php';


$_SESSION['itemArray'] = $dataClass->cartToArray(($dataClass->searchData("cart", "CartID" ,$dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"]));




if (isset($_SESSION['firstName'])) {

    // Check if there are items in the cart
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
        $total = 0;
        
        // Handle item deletion
        if (isset($_POST['deleteButton'])) {
            
            $itemIDToRemove = $_POST['cartItemID'];

            unset($_SESSION['itemArray'][$itemIDToRemove]);

            $_SESSION['itemArray'] = array_values($_SESSION['itemArray']);

            echo $itemIDToRemove;

            $dataClass->updateData('cart','ItemList = "' . $dataClass->cartToString($_SESSION['itemArray']). '"','CartID',$dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);
            header("Location: cart.php");
            exit();
        }
        $cartIndex = 0;
        // Display cart items and calculate the total
        foreach ($_SESSION['itemArray'] as $itemID) {

            // select from cart table with updated code
            $sql = "SELECT ItemID, Price, Name, Description FROM menu WHERE ItemID='$itemID[0]'";
            $cartQuery = mysqli_query($con, $sql);
            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    echo "<div style='margin: 20px;'>";
                    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
                    echo "<p><strong>Price:</strong> $" . number_format($row['Price'], 2) . "</p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['Description']) . "</p>";
                    echo "<form method='POST'>";
                    echo "<p><strong>Customizations:</strong></p>";
                    for($index = 1; $index < count($itemID); $index++)
                    { 
                        echo "<p>" . $dataClass->searchData("customization", "CustomizationID", $itemID[$index])['Name'] . "</p>";
                        $total += $dataClass->searchData("customization", "CustomizationID", $itemID[$index])['Price'];
                    }
                    echo "<input type='submit' name='deleteButton' value='Delete' />";
                    echo "<input type='hidden' name='cartItemID' value='" . $cartIndex . "' />";
                    
                    echo "</form>";
                    echo "</div>";
                    $total += $row['Price'];
                    $cartIndex++;
                }
            }
        }

        // Apply punch card discount if applicable
        $_SESSION['subtract'] = 0;
        if ($_SESSION['unredeemed'] > 0) {
            echo "<form method='POST' id='punchForm'>";
            echo "Would you like to redeem 10 punches for a free drink?" . "<br>";
            echo "<input type='checkbox' name='punchCheck' id='punchCheck' /> Yes, redeem 10 punches for a free drink";
            echo "</form>";

            if (isset($_POST['punchCheck']) && $_POST['punchCheck'] == 'on') {
                $total -= 10.99;
                $total = round($total, 2);
                $_SESSION['subtract'] = 1;
            }
        }

        // Display the total and checkout button
        $_SESSION['total'] = $total;
        echo "Total: $" . number_format($total, 2);
        echo ("<button style='width: 100px;'><a href='payment.php'>Checkout</a></button>");
    } else {
        if (!isset($_SESSION['buySomething'])) {
            $_SESSION['buySomething'] = "<div class='error'>There are no items in the cart.</div>";
        }
        echo $_SESSION['buySomething'];
        unset($_SESSION['buySomething']); // Clear the message after it's displayed
    }
} else {
    header("location: index.php");
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
}

?>

<script>
document.getElementById('punchCheck').addEventListener('change', function() {
document.getElementById('punchForm').submit();
});
</script>
</body>
</html>
