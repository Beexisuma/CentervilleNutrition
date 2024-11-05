<?php
include 'references/header.php';

if (isset($_SESSION['firstName'])) {
    if (isset($_SESSION['itemArray']) && count($_SESSION['itemArray']) > 0) {
        $total = 0;
        if (isset($_POST['deleteButton'])) {
            $itemIDToRemove = $_POST['itemID'];
            
            if (($key = array_search($itemIDToRemove, $_SESSION['itemArray'])) !== false) {
                unset($_SESSION['itemArray'][$key]);
                $_SESSION['itemArray'] = array_values($_SESSION['itemArray']);
                $_SESSION['cartCount'] = $_SESSION['cartCount'] - 1;

            }

            header("Location: cart.php");
            exit();
        }

        foreach ($_SESSION['itemArray'] as $itemID) {
            $sql = "SELECT ItemID, Price, Name, Description FROM menu WHERE ItemID='$itemID'";
            $cartQuery = mysqli_query($con, $sql);

            if ($cartQuery) {
                while ($row = mysqli_fetch_assoc($cartQuery)) {
                    echo "<div style='margin: 20px;'>";
                    echo "<h2>" . $row['Name'] . "</h2>";
                    echo "<p><strong>Price:</strong> " . $row['Price'] . "</p>";
                    echo "<p><strong>Description:</strong> " . $row['Description'] . "</p>";
                    echo "<form method='POST'>";
                    echo "<input type='submit' name='deleteButton' value='Delete' />";
                    echo "<input type='hidden' name='itemID' value='" . $row['ItemID'] . "' />";
                    echo "</form>";
                    echo "</div>";
                    $total = $total + $row['Price'];
                }
            }
        }


    } else {
        echo "No items found in the cart.";
    }
}

if (isset($total)) {
echo "Total: $" . $total;
}

?>
