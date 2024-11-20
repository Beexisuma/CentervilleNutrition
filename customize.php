<?php
include('references/header.php');

// Check if the session variable for customization is set
if (isset($_SESSION['customize_item_id'])) {
    $item_id = $_SESSION['customize_item_id'];

    // Query to get the selected menu item details
    $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price FROM menu WHERE ItemID = '$item_id'");
    $item = $item_query->fetch_assoc();

    if ($item) {
        echo "<h1>Customize " . htmlspecialchars($item['Name']) . "</h1>";
        echo "<p>" . htmlspecialchars($item['Description']) . "</p>";
        echo "<p>Base Price: $" . number_format($item['Price'], 2) . "</p>";

        // Query to get all customization options for this menu item
        $customization_query = mysqli_query($con, "SELECT CustomizationID, Name, Description, Price, InStock FROM customization");
        $num_rows = mysqli_num_rows($customization_query);

        if ($num_rows > 0) {
            echo "<h2>Customization Options</h2>";
            echo "<table border='1'>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>In Stock</th>
                <th>Add to Item</th>
            </tr>";
            
            while ($row = $customization_query->fetch_assoc()) {
                // Check if the customization is in stock
                if ($row["InStock"] == 1) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["Name"]) . "</td>
                        <td>" . htmlspecialchars($row["Description"]) . "</td>
                        <td>$" . number_format($row["Price"], 2) . "</td>
                        <td>" . ($row["InStock"] ? 'Yes' : 'No') . "</td>
                        <td><form style='display: flex; justify-content: center;' method='POST'>
                        <input type='hidden' name='customization_id' value='" . htmlspecialchars($row["CustomizationID"]) . "'>
                        <input type='submit' name='addCart' value='Add to Cart'>
                        </form>
                        </td>
                    </tr>";
                } 
            }
            echo "</table>";
        } else {
            echo "<p>No customization options available for this item.</p>";
        }

        // Add the item to the cart form
        echo "<form method='POST' action='customize.php'>
                <input type='submit' name='addToCart' value='Add Customized Item to Cart'>
              </form>";
    } else {
        echo "<p>Item not found.</p>";
    }
} else {
    echo "<p>No item selected for customization.</p>";
}

// Handle Add to Cart after customization
if (isset($_POST['addToCart'])) {
    $item_id = $_SESSION['customize_item_id'];
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
    $row = $item_query->fetch_assoc();

    // Add the item to the cart
    $_SESSION['cartCount'] = isset($_SESSION['cartCount']) ? $_SESSION['cartCount'] + 1 : 1;
    $_SESSION['success_message'] = $row['Name'] . " added to cart.";

    // Add the item to session array for cart
    array_push($_SESSION['itemArray'], $item_id);
    
    // Clear customization session (optional, as item is now added to the cart)
    unset($_SESSION['customize_item_id']);
    
    // Redirect back to menu or cart page
    header('Location: menu.php');
    exit();
}
?>

</body>
</html>
