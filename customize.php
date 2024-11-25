<?php
include('references/header.php');

// Check if the session variable for customization is set
if (isset($_SESSION['customize_item_id'])) {
    $item_id = $_SESSION['customize_item_id'];

    // Query to get the selected menu item details
    $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price FROM menu WHERE ItemID = '$item_id[0]'");
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
<<<<<<< WorkingCustomization

                <th>Add to Item</th>
=======
                <th>In Stock</th>
                <th>Customization</th>
>>>>>>> main
            </tr>";

            while ($row = $customization_query->fetch_assoc()) {
                // Check if the customization is in stock
                if ($row["InStock"] == 1) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row["Name"]) . "</td>
                        <td>" . htmlspecialchars($row["Description"]) . "</td>
                        <td>$" . number_format($row["Price"], 2) . "</td>

                        <td><form style='display: flex; justify-content: center;' method='POST'>
                        <input type='hidden' name='customization_id' value='" . htmlspecialchars($row["CustomizationID"]) . "'>
                        <input type='submit' name='addCart' value='Add to Item'>
                        </form>
                        </td>
                    </tr>";
                } 
            }
            echo "</table>";
        } else {
            echo "<p>No customization options available for this item.</p>";
        }

        // Add the item to the cart form with quantity option
        echo "<form method='POST' action='customize.php'>
                <label for='quantity'>Quantity:</label>
                <input type='number' name='quantity' value='1' min='1' style='width: 60px; margin-right: 10px;'>
                <input type='submit' name='addToCart' value='Add to Cart'>
              </form>";
    } else {
        echo "<p>Item not found.</p>";
    }
} else {
    echo "<p>No item selected for customization.</p>";
}


if (isset($_POST['addCart']))
{
    $notSelectedCustomization = true;
    for($index=1; $index < count($_SESSION['customize_item_id']); $index++)
    {

        if($_POST['customization_id'] == $_SESSION['customize_item_id'][$index])
        {
            $notSelectedCustomization = false;
        }
    }
    
    if($notSelectedCustomization)
    {
        array_push($_SESSION['customize_item_id'], $_POST['customization_id']);
    }
}

// Handle Add to Cart after customization
if (isset($_POST['addToCart'])) {
    $item_id = $_SESSION['customize_item_id'];
<<<<<<< WorkingCustomization
    
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id[0]'");
    $row = $item_query->fetch_assoc();

    // Add the item to the cart
    $_SESSION['success_message'] = $row['Name'] . " added to cart.";


    // Add the item to session array for cart
    array_push($_SESSION['itemArray'], $item_id);
    print_r($item_id);
=======
    $quantity = $_POST['quantity']; // Get the quantity from the form

    // Query to get the item name
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
    $row = $item_query->fetch_assoc();

    // Add the item with the specified quantity to the cart
    $_SESSION['cartCount'] = isset($_SESSION['cartCount']) ? $_SESSION['cartCount'] + $quantity : $quantity;
    $_SESSION['success_message'] = $row['Name'] . " added to cart.";

    // Add the item to session array for cart, multiple items based on quantity
    for ($i = 0; $i < $quantity; $i++) {
        array_push($_SESSION['itemArray'], $item_id);
    }
>>>>>>> main

    // Clear customization session (optional, as item is now added to the cart)
    unset($_SESSION['customize_item_id']);
    unset($_SESSION['customization_array']);
    //#3,2,#4,#5,1,3,#1,#1,2, 'cart','ItemList = "#1,"','CartID',3
    $dataClass->updateData('cart','ItemList = "' . $dataClass->cartToString($_SESSION['itemArray']). '"','CartID',$dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);

    // Redirect back to menu or cart page
    header('Location: menuDisplay.php');
    exit();
}
?>

</body>
</html>
