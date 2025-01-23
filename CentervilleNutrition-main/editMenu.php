<?php include('references/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
</head>
<body>

<?php
if (!isset($_SESSION['firstName'])) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
    exit;
} else if ($_SESSION['admin'] != 1) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
    exit;
}

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

$menu_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, Type, InStock FROM menu");
$num_rows = mysqli_num_rows($menu_query);

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
    
    while ($row = $menu_query->fetch_assoc()) {

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

if (isset($_POST['deleteItem'])) {
    $itemID = $_POST['itemID'];
    $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, Type, ImagePath FROM menu WHERE ItemID = '$itemID'");
    $row = $item_query->fetch_assoc();
    mysqli_query($con, "DELETE FROM menu WHERE ItemID='$itemID'");
    $originalImage = $row["ImagePath"];
    unlink($originalImage);
    $_SESSION['deleteYes'] = "<div class='success'>Item deleted successfully.</div>";
    header("location: editMenu.php");
    exit;
}

if (isset($_POST['editItem'])) {
    $itemID = $_POST['itemID'];
    $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock, ImagePath, Type FROM menu WHERE ItemID = '$itemID'");
    $row = $item_query->fetch_assoc();

    if ($row) {
        $originalName = $row["Name"];
        $originalDescription = $row["Description"];
        $originalPrice = $row["Price"];
        $originalInStock = $row["InStock"];
        $originalType = $row["Type"];
        $originalImage = $row["ImagePath"];

        $inStockOptions = [
            1 => "Yes",
            0 => "No"
        ];

        echo('<form method="POST" enctype="multipart/form-data">
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
        <p>Image:</p>
        <input type="file" name="image" accept="image/png" required> 
        <input type="hidden" name="itemID" value="' . htmlspecialchars($itemID) . '">
        <input type="submit" name="submitEdit" value="Submit Changes">
    </form>');
    } else {
        echo "<p>Menu item not found.</p>";
    }
}

if (isset($_POST['submitEdit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $itemID = $_POST['itemID'];
    $inStock = $_POST['inStock'];
    $image = $_POST['image'];
    $type = $_POST['type'];

    $name = mysqli_real_escape_string($con, $name);
    $description = mysqli_real_escape_string($con, $description);
    $price = (float) mysqli_real_escape_string($con, $price);
    $type = mysqli_real_escape_string($con, $type);

    $imageName = "./menuImages/" . $name . ".png";

    $sql = "UPDATE menu SET Name='$name', Description='$description', Price='$price', InStock='$inStock', Type='$type', ImagePath='$imageName' WHERE ItemID='$itemID'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["updateYes"] = "<div class='success'>Menu item updated successfully.</div>";
        unlink($originalImage);
        file_put_contents($imageName, file_get_contents($_FILES['image']['tmp_name']));
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating menu item: " . mysqli_error($con) . "</div>";
    }

    header("location: editMenu.php");
    exit;
}

if (isset($_POST['addMenuItem'])) {
    echo "
    <form method='POST' enctype='multipart/form-data'>
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
        <p>Image:</p>
        <input type='file' name='image' accept='image/png' required> 
        <input type='submit' name='submitAddMenuItem' value='Add Item'>
    </form>";
}

if (isset($_POST['submitAddMenuItem'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $image = $_POST['image'];
    $inStock = $_POST['inStock'];

    $name = mysqli_real_escape_string($con, $name);
    $description = mysqli_real_escape_string($con, $description);
    $price = (float) mysqli_real_escape_string($con, $price);
    $type = mysqli_real_escape_string($con, $type);

    $imageName = "./menuImages/" . $name . ".png";
    

    $sql = "INSERT INTO menu (Name, Description, Price, InStock, Type, ImagePath) VALUES ('$name', '$description', '$price', '$inStock', '$type','$imageName')";

    if (mysqli_query($con, $sql)) {
        $_SESSION['updateYes'] = "<div class='success'>Menu item added successfully.</div>";
        file_put_contents($imageName, file_get_contents($_FILES['image']['tmp_name']));
        header("Location: editMenu.php");
        
    } else {
        $_SESSION['bad'] = "<div class='error'>Error adding menu item: " . mysqli_error($con) . "</div>";
    }
}

?>

<br>
<form style='display: flex; justify-content: center;' method='POST'>
    <input type='submit' name='addMenuItem' value='Add New Menu Item'>
</form>

</body>
</html>
