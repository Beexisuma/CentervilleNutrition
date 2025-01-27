<?php

include('references/header.php');

$email = $_SESSION['email'];
$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date FROM receipts WHERE email='$email'");
$num_rows = mysqli_num_rows($receiptQuery);

if ($num_rows > 0) {
    while ($row = $receiptQuery->fetch_assoc()) {
        // Display the date of the receipt
        echo "Date: " . htmlspecialchars($row['Date']) . " ";

        // Include a form with a hidden field to identify which receipt the user wants to view
        echo "<form method='POST'>
                <input type='hidden' name='receiptDate' value='" . htmlspecialchars($row['Date']) . "'>
                <input type='submit' name='view' value='View Receipt'>
              </form>";

        // Check if the form is submitted and handle the view action
        if (isset($_POST['view']) && isset($_POST['receiptDate']) && $_POST['receiptDate'] == $row['Date']) {
            $_SESSION['receiptDate'] = $row['Date'];
            header('location: receiptDisplay.php');
            exit();  // Ensure that the script stops executing here after the redirect
        }
    }
} else {
    echo "<p>No receipts available.</p>";
}

?>
