<?php include('references/header.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>

<?php

if (!isset($_SESSION['itemArray'])) {
    $_SESSION['itemArray'] = array();
}

$menu_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, InStock FROM menu");
$num_rows = mysqli_num_rows($menu_query);

if ($num_rows > 0) {
    echo "<table border='1'>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Add To Cart</th>
    </tr>";
    
    while ($row = $menu_query->fetch_assoc()) {
        if ($row["InStock"] == 1) {
            echo "<tr>
                <td>" . htmlspecialchars($row["Name"]) . "</td>
                <td>" . htmlspecialchars($row["Description"]) . "</td>
                <td>" . htmlspecialchars($row["Price"]) . "</td>
                <td>
                <form style='display: flex; justify-content: center;' method='POST'>
                    <input type='hidden' name='item_id' value='" . htmlspecialchars($row["ItemID"]) . "'>
                    <input type='submit' name='addCart' value='Add to Cart'>
                </form>
                </td>
              </tr>";
        } 
    }
    echo "</table>";
} else {
    echo "<p>No items available.</p>";
} 

if (isset($_POST['addCart'])) {
    $item_id = $_POST['item_id'];
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
    $row = $item_query->fetch_assoc();

    $_SESSION['cartCount'] = isset($_SESSION['cartCount']) ? $_SESSION['cartCount'] + 1 : 1;

    $_SESSION['success_message'] = $row['Name'] . " added to cart.";

    array_push($_SESSION['itemArray'], $item_id);
    
    header('location: menu.php');
    exit(); 
}

// Display success message if any
if (isset($_SESSION['success_message'])) {
    echo "<div class='success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']); 
}


?>

</body>
</html>
