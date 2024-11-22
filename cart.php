<?php
include 'references/header.php';

if (isset($_SESSION['firstName'])) {

    // Check if there are items in the cart
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
        $total = 0;

        // Handle item deletion
        if (isset($_POST['deleteButton'])) {

            
            // delete from cart table rather than array
            $itemIDToRemove = $_POST['itemID'];

            // Remove the item from the cart
            if (($key = array_search($itemIDToRemove, $_SESSION['itemArray'])) !== false) {
                unset($_SESSION['itemArray'][$key]);
                $_SESSION['itemArray'] = array_values($_SESSION['itemArray']);  // delete this code but not cart count
                $_SESSION['cartCount'] = $_SESSION['cartCount'] - 1;
                if ($_SESSION['cartCount'] <= 0) {

                    // leave this here
                    $_SESSION['buySomething'] = "<div class='error'>There are no items in the cart.</div>";
                }
            }
            header("Location: cart.php");
            exit();
        }

        // Display cart items and calculate the total
        foreach ($_SESSION['itemArray'] as $itemID) {

            // select from cart table with updated code

            $sql = "SELECT ItemID, Price, Name, Description FROM menu WHERE ItemID='$itemID'";
            $cartQuery = mysqli_query($con, $sql);
            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    echo "<div style='margin: 20px;'>";
                    echo "<h2>" . htmlspecialchars($row['Name']) . "</h2>";
                    echo "<p><strong>Price:</strong> $" . number_format($row['Price'], 2) . "</p>";
                    echo "<p><strong>Description:</strong> " . htmlspecialchars($row['Description']) . "</p>";
                    echo "<form method='POST'>";
                    echo "<input type='submit' name='deleteButton' value='Delete' />";
                    echo "<input type='hidden' name='itemID' value='" . $row['ItemID'] . "' />";
                    echo "</form>";
                    echo "</div>";
                    $total += $row['Price'];
                }
            }
        }

        // Apply punch card discount if applicable
        $_SESSION['subtract'] = 0;
        if($_SESSION['unredeemed'] > 0) {
            echo "<form method='POST' id='punchForm'>";
            echo "Would you like to redeem a punch card for a free drink?" . "<br>";
            echo "<input type='checkbox' name='punchCheck' id='punchCheck' /> Yes, redeem a punch card for a free drink";
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
