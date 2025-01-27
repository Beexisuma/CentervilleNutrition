<?php include('references/header.php');

$email = $_SESSION['email'];
$date = $_SESSION['receiptDate'];
$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date FROM receipts WHERE email='$email' AND Date='$date'");
$num_rows = mysqli_num_rows($receiptQuery);

// Display the receipt if available
if ($num_rows > 0) {
    $row = $receiptQuery->fetch_assoc();
    $cartArray = $dataClass->cartToArray($row["PurchasedCart"]);
    
    // Start outputting the receipt HTML
    echo "<div style='font-family: Arial, sans-serif; width: 300px; border: 1px solid #ddd; padding: 10px; margin: auto;'>
            <h2 style='text-align: center;'>Receipt</h2>
            <hr>
            <p><strong>Date:</strong> " . htmlspecialchars($row['Date']) . "</p>
            <p><strong>Email:</strong> " . htmlspecialchars($row['Email']) . "</p>
            <hr>
            <p><strong>Purchased Items:</strong></p>
            <ul style='list-style-type: none; padding-left: 0;'>";

    // Loop through each purchased item and display it
    foreach ($cartArray as $item) {
        $price = 0;

        if (count($item) > 1) {
            for ($i = 1; $i < count($item); $i++) {
                $customization = $dataClass->searchData('customization', 'CustomizationID', $item[$i])['Price'];
                $price += $customization;
            }
        }

        $drink = $dataClass->searchData('menu', 'ItemID', $item[0])['Name'];
        $price += $dataClass->searchData('menu', 'ItemID', $item[0])['Price'];


        echo "<li><strong>" . htmlspecialchars($drink) . "</strong> -$" . $price;

        // If there are customizations, display them as plain text
        if (count($item) > 1) {
            echo "<br><ul style='list-style-type: none; padding-left: 0;'>";
            for ($i = 1; $i < count($item); $i++) {
                $customization = $dataClass->searchData('customization', 'CustomizationID', $item[$i])['Name'];
                echo " [". htmlspecialchars($customization) . "] ";
            }
            echo "</ul>";
        }

        echo "</li>";
    }

    $total = htmlspecialchars($row['Cost']); 
    $subtotal = $total / 1.07;
    $tax = round($subtotal * 0.07, 2);
    
    

    // Output total cost
    echo "</ul>
          <hr>
          <p><strong>Tax:</strong> $" . $tax . "</p>;
          <p><strong>Total Cost:</strong> $" . htmlspecialchars($row["Cost"]) . "</p>
          <hr>
          <p style='text-align: center;'>Thank you for your purchase!</p>
        </div>";

    echo("<a href='receipt.php'>Back</a>");
} else {
    echo "<p>No receipts available.</p>";
}
?>
