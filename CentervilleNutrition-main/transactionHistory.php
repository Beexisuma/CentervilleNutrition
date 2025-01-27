<?php include('references/header.php');

// Check if the user is logged in (session exists) and if the user is an admin
if (!isset($_SESSION['firstName'])) {
    // If the user is not logged in, redirect to the home page and show an error
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
} else if ($_SESSION['admin'] != 1) {
    // If the user is not an admin, redirect to the home page and show an error
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
}



$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date FROM receipts");
$num_rows = mysqli_num_rows($receiptQuery);

// Display the menu items in a table if available
if ($num_rows > 0) {
    echo "<table border='1'>
    <tr>
        <th>Date</th>
        <th>Email</th>
        <th>Purchased Items</th>
        <th>Cost</th>
    </tr>";
    
    // Loop through each menu item and display it in a table row
    while ($row = $receiptQuery->fetch_assoc()) {
        // Check the in-stock status (1 = Yes, 0 = No)
        $cartArray = $dataClass->cartToArray($row["PurchasedCart"]);
        $cartDisplay = "";
        foreach($cartArray as $item)
        {
            $drink = $dataClass->searchData('menu','ItemID',$item[0])['Name'];
            if(count($item) > 1)
            {
                $drink = $drink . "<select>";
                $drink = $drink . "<option style='display: none;'>Customizations</option>";
                for($i=1; $i < count($item); $i++ )
                {
                    $drink = $drink . "<option disabled='true'>" . $dataClass->searchData('customization','CustomizationID',$item[$i])['Name'] . "</option>";
                }
                

                $drink = $drink . "</select>";
            }
            
           
            

            $cartDisplay = $cartDisplay . $drink . "<br>";
        }

        echo "<tr>
            <td>" . htmlspecialchars($row['Date']) . "</td>
            <td>" . htmlspecialchars($row["Email"]) . "</td>
            <td>" . $cartDisplay . "</td>
            <td>$" . htmlspecialchars($row["Cost"]) . "</td>
          </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No receipts available.</p>";
}


?>