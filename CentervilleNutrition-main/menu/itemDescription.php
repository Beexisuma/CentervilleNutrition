<?php
include('../header/header.php');

// Initialize necessary variables
$item = "";
$item_id = "";
$item_name = "";
$item_description = "";
$item_price = "";
$item_image = "";
$type = "";
$type2 = "";

// Handle if an item is selected via GET
if (isset($_GET['item_name'])) {
    $_SESSION['itemName'] = htmlspecialchars($_GET['item_name']);
    $item = $_SESSION['itemName'];

    // Fetch the corresponding item ID from the menu based on the item name
    $item_query = mysqli_query($con, "SELECT ItemID FROM menu WHERE Name = '$item'");
    $row = $item_query->fetch_assoc();

    if ($row) {
        $_SESSION['customize_item_id'] = array($row['ItemID']);
    }
}

// Fetch item details based on session variable
if (isset($_SESSION['customize_item_id'])) {
    $item_id = $_SESSION['customize_item_id'][0];
    $item_query = mysqli_query($con, "SELECT ItemID, Name, Description, Price, ImagePath, InStock, Type FROM menu WHERE ItemID='$item_id'");
    if (mysqli_num_rows($item_query) > 0) {
        $row = mysqli_fetch_assoc($item_query);
        $item_name = htmlspecialchars($row['Name']);
        $item_description = htmlspecialchars($row['Description']);
        $item_price = number_format($row['Price'], 2);
        $item_id = htmlspecialchars($row['ItemID']);

        if($row['ImagePath'] == "none")
        {
            if($_SESSION['type'] == 'Shake')
            {
                $item_image = "<img src='../images/menuImages/Shake.png' class='in-img' alt='picture of a shake'>";
                $type = "Protein Shake";
                $type2 = "shake";
            }
            else
            {
                $item_image = "<img src='../images/menuImages/Tea.png' class='in-img' alt='picture of a tea'>";
                $type = "Tea Bomb";
                $type2 = "tea";
            }
        }
        else
        {
            $src = $row['ImagePath'];
            $item_image = "<img src='$src' class='in-img'>";
            $type = htmlspecialchars($row['Type']);
            if($type == 'Protein Shake') {
                $type2 = 'shake';
            }
            else {
                $type2 = 'tea';
            }
        }
    }
}


// Handle the customizations form submission
// Handle the customizations form submission
if (isset($_POST['addCustomizations'])) {
    if (isset($_POST['customizations'])) {
        foreach ($_POST['customizations'] as $customization_id) {
            if (!in_array($customization_id, $_SESSION['customize_item_id'])) {
                array_push($_SESSION['customize_item_id'], $customization_id);
            }
        }
        $_SESSION['success'] = "yesCustom";
    }
    else {
        $_SESSION['success'] = "yes";
    }

    // Handle quantity
    $quantity = $_POST['quantity'];
    $_SESSION['quantity'] = $quantity;

    // Add item with customizations to the cart
    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
    $row = $item_query->fetch_assoc();

    // Add the item to the cart session array
    for ($i = 0; $i < $quantity; $i++) {
        array_push($_SESSION['itemArray'], $_SESSION['customize_item_id']);
    }

    // Clear the customizations
    unset($_SESSION['customize_item_id']);

    // Update the cart in the database
    $dataClass->updateData('cart', 'ItemList = "' . $dataClass->cartToString($_SESSION['itemArray']) . '"', 'CartID', $dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);

    // Redirect to menu page
    header('Location: menuDisplay.php');
    exit();
}


?>

<div class="main-content item-content">
    <h4 class="item-path"><a href="menuDisplay.php"><?= $type ?>s</a> / <?= $item_name; ?></h4>
    <div class="item-top">
        <?php echo "<div class='item-main-img'>" . $item_image . "</div>"; ?>
        <div class="item-interface">
            <h2 class="item-class-<?= $type2 ?>"><?= $type ?></h2>
            <h1><?= $item_name ?></h1>
            <p><?= $item_description ?></p>
            <span>
                <h4 style="font-weight: 100">$<?= $item_price ?></h4>
                <hr>
                <?php 
                    echo $type2 == "tea" ? "<h4>25 Calories</h4>" : "<h4>27g Protein</h4>";
                ?>
            </span>

            <form class="item-form" method="POST">
                <input type="hidden" name="item_id" value="<?= $item_id ?>">
                <?php 
                
                if(isset($_SESSION['firstName']))
                {
                    echo ('<input type="submit" name="addCart" value="Add to Cart" />');
                    echo ('<button type="button" onclick="addPop()" class="customize-btn">Customize</button></form>');
                }
                
                else {
                    echo ('<input type="submit" disabled name="addCart" value="Add to Cart" />');
                    echo ('<button type="button" onclick="addPop()" disabled class="customize-btn">Customize</button>
                           </form><p class="itemMsg"><a href="../account/login.php">Sign in</a> to add items to your cart</p>'); 
                }

                if(isset($_POST['addCart'])) {


                    unset($_SESSION['quantity']);
                    $item_query = mysqli_query($con, "SELECT Name FROM menu WHERE ItemID = '$item_id'");
                    $row = $item_query->fetch_assoc();
                    $_SESSION['success'] = "yes";
                    
                    array_push($_SESSION['itemArray'], $_SESSION['customize_item_id']);
                    $dataClass->updateData('cart', 'ItemList = "' . $dataClass->cartToString($_SESSION['itemArray']) . '"', 'CartID', $dataClass->searchData("user", "email", $_SESSION['email'])['CartID']);
                    header('Location: menuDisplay.php');
                    exit(); 
                }

                ?>

                
                
            
        </div>
    </div>

    <!-- Popup for customization -->
    <div class="POP popup popUp-container">
        <div class="customize">
            <button class="out" onclick="closePop()">✕</button>
            <h1>Customize Item</h1>
            <form class="custom-form" method="POST">
                <?php
                echo "<span class='custom-quantity'>
                <label for='quantity'>Quantity:</label>
                <input type='number' name='quantity' value='1' min='1' max='99'>
        </span>";
                // Query customizations for the item
                $customization_query = mysqli_query($con, "SELECT CustomizationID, Name, Description, Price, InStock FROM customization");
                while ($row = $customization_query->fetch_assoc()) {
                    if ($row["InStock"] == 1) {
                        echo "<input class='custom-check' type='checkbox' name='customizations[]' value='" . htmlspecialchars($row["CustomizationID"]) . "'>";
                        echo "<label for='custom" . $row["CustomizationID"] . "'>" . htmlspecialchars($row["Name"]) . "</label>";
                        echo "<h2 class='custom-price'>+$" . number_format($row["Price"], 2) . "</h2>";
                    }
                }
                ?>
                <input class="custom-done" type="submit" name="addCustomizations" value="Add to Cart">

            </form>
        </div>
    </div>
</div>

<script>

    //Close customization popup
    function closePop() {
        document.querySelector(".popup").classList.add("POP");
    }

    //Open customization popup
    function addPop() {
        document.querySelector(".popup").classList.remove("POP");
    }
</script>

</body>
</html>



