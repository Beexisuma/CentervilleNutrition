<?php
include('references/header.php');

// Check if the session for itemArray is set
if (!isset($_SESSION['itemArray'])) {
    $_SESSION['itemArray'] = array();
}

// Display success message if any
if (isset($_SESSION['success_message'])) {
    echo "<div class='success'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']); 
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

// Handle Add to Cart
if (isset($_POST['addCart'])) {
    $item_id = $_POST['item_id'];
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
    $row = $item_query->fetch_assoc();
    
    // Store the ItemID in a session variable for customization page
    $_SESSION['customize_item_id'] = $item_id;
    
    // Redirect to the customization page
    header('Location: customize.php');
    exit(); 
}
?>

</body>
</html>
