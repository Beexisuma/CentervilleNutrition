<?php include('../header/header.php');

$email = $_SESSION['email'];
$date = $_SESSION['receiptDate'];
$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date, Free FROM receipts WHERE email='$email' AND Date='$date'");
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

            
    // Loop through each purchased item and display it
    foreach ($cartArray as $item) {
        $existCheck = $dataClass->searchData("menu", "itemID", $item[0]);

        if($existCheck != null){
            $price = 0;

            if (count($item) > 1) {
                for ($i = 1; $i < count($item); $i++) {
                    $customization = $dataClass->searchData('customization', 'CustomizationID', $item[$i])['Price'];
                    $price += $customization;
                }
            }

            $drink = $dataClass->searchData('menu', 'ItemID', $item[0])['Name'];
            $price += $dataClass->searchData('menu', 'ItemID', $item[0])['Price'];


            echo "<li><span><strong>" . htmlspecialchars($drink) . "</strong> $" . number_format($price, 2) . "</span>";

            // If there are customizations, display them as plain text
            if (count($item) > 1) {
                echo "<ul class='official-custom'>";
                for ($i = 1; $i < count($item); $i++) {
                    $customization = $dataClass->searchData('customization', 'CustomizationID', $item[$i])['Name'];
                    echo " [". htmlspecialchars($customization) . "] ";
                }
                
                echo "</ul>";
            }

            echo "</li>";
        }
        else
        {
            echo "<li><span><strong>Removed Drink</strong></span></li>";
        }
    }


    $total = htmlspecialchars($row['Cost']); 
    $subtotal = round($total / 1.07, 2);
    $tax = round($subtotal * 0.07, 2);
     
    if($row['Free'] != 0) {
        echo "<h3>Discounts:</h3><li><span><strong>Free Drink</strong>-$" . number_format($row['Free'],2) . "</span></li>";
    }

    // Output total cost
    echo "</ul>
          <div class='official-line'></div>
          <p><strong>Subtotal</strong>: $" . number_format($subtotal, 2) . "</p>
          <p><strong>Tax:</strong> $" . number_format($tax, 2) . "</p>
          <p><strong>Total Cost:</strong> $" . number_format($total, 2) . "</p>
          <div class='official-line'></div>
          <p class='official-end'>Thank you for your purchase!</p>
        </div>
<a class='official-back' href='user.php'>Return</a>";

    echo("<a href='user.php'>Back</a>");
} else {
    echo "<p>No receipts available.</p>";
}
?>






