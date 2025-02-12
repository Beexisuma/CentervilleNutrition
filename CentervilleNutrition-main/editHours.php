<?php 
include('references/header.php');
?>


<?php
// Redirect non-admin users or unauthenticated users
if (!isset($_SESSION['firstName']) || $_SESSION['admin'] != 1) {
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in as an admin to access this page.</h3>";
    header('location: index.php');
    exit;
}

// Display session messages
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

// Display user table
$user_query = $con->query("SELECT Day, Open, Close, isOpen  FROM hours");
if ($user_query->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>Day</th>
            <th>Opening</th>
            <th>Closing</th>
            <th>Opened/Closed</th>
        </tr>";

    while ($row = $user_query->fetch_assoc()) {
        $isOpen = "Closed";
        if($row["isOpen"])
        {
            $isOpen = "Open";
        }
        echo "<tr>
            <td>" . htmlspecialchars($row["Day"]) . "</td>
            <td>" . htmlspecialchars($row["Open"]) . "am</td>
            <td>" . htmlspecialchars($row["Close"]) . "pm</td>
            <td>" . $isOpen . "</td>
            <td>
                <form method='POST'>
                    <input type='hidden' name='dayID' value='" . htmlspecialchars($row["Day"]) . "'>
                    <input type='submit' name='edit' value='Edit'>
                </form>
            </td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users available.</p>";
}




// Handle edit request
if (isset($_POST['edit'])) {
    // $editUserId = $con->real_escape_string($_POST['Day']);
    // $user_query = $con->query("SELECT * FROM user WHERE Email = '$editUserId'");
    // $row = $user_query->fetch_assoc();
    $row = $dataClass->searchData("hours", "Day", $_POST['dayID']);
    if ($row) {
        $isOpen = $row["isOpen"] == 1 ? 'checked' : '';

        echo "
        <form method='POST'>
            <p>" . $row["Day"] . "</p>
            <p>Opening Time (am):</p><input type='number' min='1' max='12' name='openTime' value='" . htmlspecialchars($row["Open"]) . "' required>
            <p>Closing Time (pm):</p><input type='number' min='1' max='12' name='closeTime' value='" . htmlspecialchars($row["Close"]) . "' required>
            <p>Opened:</p><input type='checkbox' name='isOpen' value='". $row["isOpen"] . "' $isOpen>  
            <input type='hidden' name='day' value='" . $_POST['dayID'] . "'>         
            <input type='submit' name='submitChange' value='Submit Changes'>
        </form>";
    } else {
        echo "<p>User not found.</p>";
    }
}

// Handle submit changes
if (isset($_POST['submitChange'])) {
    $day = $_POST["day"];
    $openTime = $_POST['openTime'];
    $closeTime = $_POST['closeTime'];
    $isOpen = isset($_POST['isOpen']) ? 1 : 0;   

    $dataClass->updateData("hours", "Open=" . $openTime, "Day", $day);
    $dataClass->updateData("hours", "Close=" . $closeTime, "Day", $day);
    $dataClass->updateData("hours", "isOpen=" . $isOpen, "Day", $day);

    header("location: editHours.php");
    exit;
}
?>

</body>
</html>
