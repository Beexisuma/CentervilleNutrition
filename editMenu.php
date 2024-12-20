<?php include('references/header.php'); 

// Ensure the user is logged in and has admin privileges
if (!isset($_SESSION['firstName'])) {
    // Redirect to login page if the user is not logged in
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
    exit;
} else if ($_SESSION['admin'] != 1) {
    // Redirect if the user is not an admin
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
    exit;
}

// Display success or error messages if set in the session
if (isset($_SESSION["updateYes"])) {
    echo $_SESSION["updateYes"];
    unset($_SESSION["updateYes"]);
}

if (isset($_SESSION['bad'])) {
    echo $_SESSION['bad'];
    unset($_SESSION['bad']);
}

if (isset($_SESSION['deleteYes'])) {
    echo $_SESSION['deleteYes'];
    unset($_SESSION['deleteYes']);
}

// Fetch all menu items from the database
$menu_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, Type, InStock FROM menu");
$num_rows = mysqli_num_rows($menu_query);

// Display the menu items in a table if available
if ($num_rows > 0) {
    echo "<table border='1'>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Type</th>
        <th>Stocked?</th>
        <th>Manage</th>
    </tr>";
    
    // Loop through each menu item and display it in a table row
    while ($row = $menu_query->fetch_assoc()) {
        // Check the in-stock status (1 = Yes, 0 = No)
        $inStockStatus = $row["InStock"] == 1 ? "Yes" : "No";
        echo "<tr>
            <td>" . htmlspecialchars($row["Name"]) . "</td>
            <td>" . htmlspecialchars($row["Description"]) . "</td>
            <td>" . htmlspecialchars($row["Price"]) . "</td>
            <td>" . htmlspecialchars($row["Type"]) . "</td>
            <td>" . $inStockStatus . "</td>
            <td>
            <form style='display: flex; justify-content: center;' method='POST'>
                <input type='hidden' name='itemID' value='" . htmlspecialchars($row["ItemID"]) . "'>
                <input type='submit' name='editItem' value='Edit'>
                <input style='margin-left: 5px;' type='submit' name='deleteItem' value='Delete'>
            </form>
            </td>
          </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No items available.</p>";
}

// Handle the deletion of a menu item
if (isset($_POST['deleteItem'])) {
    $itemID = $_POST['itemID'];
    // Delete the item from the database
    mysqli_query($con, "DELETE FROM menu WHERE ItemID='$itemID'");
    $_SESSION['deleteYes'] = "<div class='success'>Item deleted successfully.</div>";
    header("location: editMenu.php");
    exit;
}

// Handle the editing of a menu item
if (isset($_POST['editItem'])) {
    $itemID = $_POST['itemID'];
    // Fetch the item details for editing
    $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, Type FROM menu WHERE ItemID = '$itemID'");
    $row = $item_query->fetch_assoc();

    if ($row) {
        // Populate form fields with the current item data
        $originalName = $row["Name"];
        $originalDescription = $row["Description"];
        $originalPrice = $row["Price"];
        $originalInStock = $row["InStock"];
        $originalType = $row["Type"];

        // Display the edit form with the current values
        echo('<form method="POST">
        <p>Item Name:</p>
        <input type="text" name="name" value="' . htmlspecialchars($originalName) . '" required>
        <p>Description:</p>
        <input type="text" name="description" value="' . htmlspecialchars($originalDescription) . '" required>
        <p>Price:</p>
        <input type="number" name="price" value="' . htmlspecialchars($originalPrice) . '" step="0.01" required>
        <p>Type:</p>
        <input type="text" name="type" value="' . htmlspecialchars($originalType) . '" required>
        <p>In Stock:</p>
        <select name="inStock" required>
            <option value="1" ' . ($originalInStock == 1 ? "selected" : "") . '>Yes</option>
            <option value="0" ' . ($originalInStock == 0 ? "selected" : "") . '>No</option>
        </select>
        <input type="hidden" name="itemID" value="' . htmlspecialchars($itemID) . '">
        <input type="submit" name="submitEdit" value="Submit Changes">
    </form>');
    } else {
        echo "<p>Menu item not found.</p>";
    }
}

// Handle the submission of the edited item
if (isset($_POST['submitEdit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $itemID = $_POST['itemID'];
    $inStock = $_POST['inStock'];
    $type = $_POST['type'];

    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($con, $name);
    $description = mysqli_real_escape_string($con, $description);
    $price = (float) mysqli_real_escape_string($con, $price);
    $type = mysqli_real_escape_string($con, $type);

    // Update the item details in the database
    $sql = "UPDATE menu SET Name='$name', Description='$description', Price='$price', InStock='$inStock', Type='$type' WHERE ItemID='$itemID'";

    // Check if the update was successful
    if (mysqli_query($con, $sql)) {
        $_SESSION["updateYes"] = "<div class='success'>Menu item updated successfully.</div>";
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating menu item: " . mysqli_error($con) . "</div>";
    }

    // Redirect back to the menu edit page
    header("location: editMenu.php");
    exit;
}

// Handle the addition of a new menu item
if (isset($_POST['addMenuItem'])) {
    echo "
    <form method='POST'>
        <p>Item Name:</p>
        <input type='text' name='name' required>
        <p>Description:</p>
        <input type='text' name='description' required>
        <p>Price:</p>
        <input type='number' name='price' step='0.01' required>
        <p>Type:</p>
        <input type='text' name='type' required>
        <p>In Stock:</p>
        <select name='inStock' required>
            <option value='1'>Yes</option>
            <option value='0'>No</option>
        </select>
        <input type='submit' name='submitAddMenuItem' value='Add Item'>
    </form>";
}

// Handle the submission of a new menu item
if (isset($_POST['submitAddMenuItem'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $inStock = $_POST['inStock'];

    // Escape user inputs to prevent SQL injection
    $name = mysqli_real_escape_string($con, $name);
    $description = mysqli_real_escape_string($con, $description);
    $price = (float) mysqli_real_escape_string($con, $price);
    $type = mysqli_real_escape_string($con, $type);

    // Insert the new menu item into the database
    $sql = "INSERT INTO menu (Name, Description, Price, InStock, Type) VALUES ('$name', '$description', '$price', '$inStock', '$type')";

    // Check if the insertion was successful
    if (mysqli_query($con, $sql)) {
        $_SESSION['updateYes'] = "<div class='success'>Menu item added successfully.</div>";
        header("Location: editMenu.php");
        exit;
    } else {
        $_SESSION['bad'] = "<div class='error'>Error adding menu item: " . mysqli_error($con) . "</div>";
    }
}
?>

<!-- Button to add a new menu item -->
<br>
<form style='display: flex; justify-content: center;' method='POST'>
    <input type='submit' name='addMenuItem' value='Add New Menu Item'>
</form>

</body>
</html>
