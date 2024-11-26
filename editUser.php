<?php 
include('references/header.php');

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
$user_query = $con->query("SELECT Email, FirstName, LastName, CartID, IsAdmin FROM user");
if ($user_query->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Cart ID</th>
            <th>Admin?</th>
            <th>Edit</th>
        </tr>";

    while ($row = $user_query->fetch_assoc()) {
        $admin = $row["IsAdmin"] == 1 ? "Yes" : "No";
        echo "<tr>
            <td>" . htmlspecialchars($row["FirstName"]) . "</td>
            <td>" . htmlspecialchars($row["LastName"]) . "</td>
            <td>" . htmlspecialchars($row["Email"]) . "</td>
            <td>" . htmlspecialchars($row["CartID"]) . "</td>
            <td>" . htmlspecialchars($admin) . "</td>
            <td>
                <form method='POST'>
                    <input type='hidden' name='editUserId' value='" . htmlspecialchars($row["Email"]) . "'>
                    <input type='submit' name='edit' value='Edit User'>
                    <input type='submit' name='delete' value='Delete User'>
                </form>
            </td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users available.</p>";
}

if (isset($_POST['delete'])) {
    $editUserId = $con->real_escape_string($_POST['editUserId']);

    // Prevent deleting the logged-in admin
    if ($editUserId == $_SESSION['email']) {
        $_SESSION['bad'] = "<div class='error'>You cannot delete the currently logged-in user.</div>";
        header("location: editUser.php");
        exit;
    }

    // Fetch CartID of the user to delete
    $user_result = $con->query("SELECT CartID FROM user WHERE Email = '$editUserId'");
    if ($user_result && $user_result->num_rows > 0) {
        $user_data = $user_result->fetch_assoc();
        $cartID = $user_data['CartID'];

        // Delete related data from other tables
        if (!empty($cartID)) {
            $con->query("DELETE FROM punchcard WHERE CartID = '$cartID'");
            $con->query("DELETE FROM cart WHERE CartID = '$cartID'");
        }

        // Delete the user
        $con->query("DELETE FROM user WHERE Email = '$editUserId'");

        // Provide feedback
        if ($con->affected_rows > 0) {
            $_SESSION['deleteYes'] = "<div class='success'>User Deleted Successfully.</div>";
        } else {
            $_SESSION['bad'] = "<div class='error'>Failed to delete user. Please try again.</div>";
        }
    } else {
        $_SESSION['bad'] = "<div class='error'>User not found or already deleted.</div>";
    }

    header("location: editUser.php");
    exit;
}


// Handle edit request
if (isset($_POST['edit'])) {
    $editUserId = $con->real_escape_string($_POST['editUserId']);
    $user_query = $con->query("SELECT * FROM user WHERE Email = '$editUserId'");
    $row = $user_query->fetch_assoc();

    if ($row) {
        $adminChecked = $row["IsAdmin"] == 1 ? 'checked' : '';
        echo "
        <form method='POST'>
            <p>First Name:</p><input type='text' name='firstName' value='" . htmlspecialchars($row["FirstName"]) . "' required>
            <p>Last Name:</p><input type='text' name='lastName' value='" . htmlspecialchars($row["LastName"]) . "' required>
            <p>Email:</p><input type='text' name='email' value='" . htmlspecialchars($row["Email"]) . "' required>
            <p>Password:</p><input type='password' name='password' placeholder='Leave empty to keep current password'>
            <p>Admin?:</p><input type='checkbox' name='admin' value='1' $adminChecked>
            <input type='hidden' name='originalEmail' value='" . htmlspecialchars($row["Email"]) . "'>
            <input type='hidden' name='originalPass' value='" . htmlspecialchars($row["Pass"]) . "'>
            <input type='submit' name='submitChange' value='Submit Changes'>
        </form>";
    } else {
        echo "<p>User not found.</p>";
    }
}

// Handle submit changes
if (isset($_POST['submitChange'])) {
    $firstName = $con->real_escape_string($_POST['firstName']);
    $lastName = $con->real_escape_string($_POST['lastName']);
    $email = $con->real_escape_string($_POST['email']);
    $password = $_POST['password'] ? md5($con->real_escape_string($_POST['password'])) : $_POST['originalPass'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;
    $originalEmail = $con->real_escape_string($_POST['originalEmail']);

    $sql = "UPDATE user SET FirstName='$firstName', LastName='$lastName', Pass='$password', IsAdmin='$isAdmin' WHERE Email='$originalEmail'";
    if ($con->query($sql)) {
        $_SESSION["updateYes"] = "<div class='success'>User details updated successfully.</div>";
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating user: " . $con->error . "</div>";
    }
    header("location: editUser.php");
    exit;
}

// Display add user form
if (isset($_POST['addDisplay'])) {
    echo "
    <form method='POST'>
        <p>First Name:</p><input type='text' name='firstName' required>
        <p>Last Name:</p><input type='text' name='lastName' required>
        <p>Email:</p><input type='email' name='email' required>
        <p>Password:</p><input type='password' name='password' required>
        <p>Confirm Password:</p><input type='password' name='password2' required>
        <p>Admin?</p><input type='checkbox' name='admin' value='1'>
        <input type='submit' name='submitAdd' value='Add User'>
    </form>";
}

// Handle add user request
if (isset($_POST['submitAdd'])) {
    $firstName = $con->real_escape_string($_POST['firstName']);
    $lastName = $con->real_escape_string($_POST['lastName']);
    $email = $con->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;

    if ($password != $password2) {
        $_SESSION['bad'] = "<div class='error'>Passwords do not match.</div>";
    } else {
        $email_check = $con->query("SELECT email FROM user WHERE email='$email'");
        if ($email_check->num_rows > 0) {
            $_SESSION['bad'] = "<div class='error'>Email already in use.</div>";
        } else {
            $password = md5($password);
            $sql = "INSERT INTO user (FirstName, LastName, Email, Pass, IsAdmin) VALUES ('$firstName', '$lastName', '$email', '$password', '$isAdmin')";
            if ($con->query($sql)) {
                $_SESSION['updateYes'] = "<div class='success'>User Added Successfully.</div>";
                header("Location: editUser.php");
                exit;
            } else {
                $_SESSION['bad'] = "<div class='error'>Error adding user: " . $con->error . "</div>";
            }
        }
    }
}
?>

<br>
<form style='display: flex; justify-content: center;' method='POST'>
    <input type='submit' name='addDisplay' value='Add User'>
</form>

</body>
</html>
