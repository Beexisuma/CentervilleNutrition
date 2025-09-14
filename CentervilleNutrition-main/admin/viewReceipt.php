<?php include('../header/header2.php'); ?>

<div class='container'>
<div class='admin-receipt'>

<?php
$receiptID = $_SESSION['receiptID'];
$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date, Free FROM receipts WHERE receiptID='$receiptID'");
$num_rows = mysqli_num_rows($receiptQuery);



// Display the receipt if available
if ($num_rows > 0) {
    $row = $receiptQuery->fetch_assoc();
    $cartArray = $dataClass->cartToArray($row["PurchasedCart"]);

    // Start outputting the receipt HTML
    echo "<div class='official-box'>
            <h2>Receipt</h2>
            <div class='official-line'></div>
            <p><strong>Date:</strong> " . htmlspecialchars($row['Date']) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($row['Email']) . "</p>
            <div class='official-line'></div>
            <h3>Purchased Items:</h3>
            <ul class='official-list'>";

    $deletedProduct = false;        
    // Loop through each purchased item and display it
    foreach ($cartArray as $item) {
        $existCheckItem = $dataClass->searchData("menu", "itemID", $item[0]);

        if($existCheckItem){
            $price = 0;

            if(count($item) > 1)
            {
                for($i = 1; $i < count($item); $i++)
                {
                    $existCheckCustom = $dataClass->searchData("customization", "CustomizationID", $item[$i]);
                    if($existCheckCustom)
                    {
                        $customizationPrice = $dataClass->searchData('customization', 'CustomizationID', $item[$i])['Price'];
                        $price += $customizationPrice;
                    }
                }
            }

            $drink = $dataClass->searchData('menu', 'ItemID', $item[0])['Name'];
            $price += $dataClass->searchData('menu', 'ItemID', $item[0])['Price'];


            echo "<li><span><strong>" . htmlspecialchars($drink) . "</strong> $" . number_format($price, 2) . "</span>";

            // If there are customizations, display them as plain text
            if (count($item) > 1) {
                echo "<ul class='official-custom'>";
                for ($i = 1; $i < count($item); $i++) {
                    $existCheckCustom = $dataClass->searchData("customization", "CustomizationID", $item[$i]);

                    if($existCheckCustom)
                    {
                        $customization = $dataClass->searchData('customization', 'CustomizationID', $item[$i])['Name'];
                        echo " [". htmlspecialchars($customization) . "] ";
                        
                    }
                    else
                    {
                        echo " [Removed Customization] ";
                        $deletedProduct = true;
                    }
                    
                }
                
                echo "</ul>";
            }

            echo "</li>";
        }
        else
        {
            echo "<li><span><strong>Removed Drink</strong></span></li>";
            $deletedProduct = true;
        }
    }


    $total = htmlspecialchars($row['Cost']); 
    $subtotal = round($total / 1.07, 2);
    $tax = round($subtotal * 0.07, 2);
     
    if($row['Free'] != 0) {
        echo "<h3>Discounts:</h3><li><span><strong>Free Drink</strong>-$" . number_format($row['Free'],2) . "</span></li>";
    }

    $adjustMessage = "";

    if($deletedProduct)
    {
        $adjustMessage = "<p>(Adjusted for removed product)</p>";
    }

    // Output total cost
    echo "</ul>
          <div class='official-line'></div>
          <p><strong>Subtotal</strong>: $" . number_format($subtotal, 2) . "</p>
          <p><strong>Tax:</strong> $" . number_format($tax, 2) . "</p>
          <p><strong>Total Cost:</strong> $" . number_format($total, 2) . "</p>
          " . $adjustMessage . "
          <div class='official-line'></div>
          <p class='official-end'>Thank you for your purchase!</p>
        </div>
<a class='official-back' href='editTransaction.php'>Return</a>";
} else {
    echo "<p>No receipts available.</p>";
}
?>

</div>
</div>

