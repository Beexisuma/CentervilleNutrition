<?php include('references/header.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Users</title>
</head>
<body>

<?php
if (!isset($_SESSION['firstName']) || $_SESSION['admin'] != 1) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
    exit;
}

if (isset($_SESSION["updateYes"])) { echo $_SESSION["updateYes"]; unset($_SESSION["updateYes"]); }
if (isset($_SESSION['bad'])) { echo $_SESSION['bad']; unset($_SESSION['bad']); }
if (isset($_SESSION['deleteYes'])) { echo $_SESSION['deleteYes']; unset($_SESSION['deleteYes']); }

$user_query = mysqli_query($con, "SELECT Email, FirstName, LastName, CartID, IsAdmin FROM user");
$num_rows = mysqli_num_rows($user_query);

if ($num_rows > 0) {
    echo "<table border='1'><tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Cart ID</th><th>Admin?</th><th>Edit</th></tr>";
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
    $editUserId = $_POST['editUserId'];
    if ($editUserId == $_SESSION['email']) {
        $_SESSION['bad'] = "<div class='error'>You cannot edit the currently logged in user.</div>";
        header("location: editUser.php");
        exit;
    } else {
        mysqli_query($con, "DELETE FROM user WHERE Email = '$editUserId'");
        $_SESSION['deleteYes'] = "<div class='success'>User Deleted Successfully.</div>";
        header("location: editUser.php");
        exit;
    }
}

if (isset($_POST['edit'])) {
    $editUserId = $_POST['editUserId'];
    $user_query = mysqli_query($con, "SELECT * FROM user WHERE Email = '$editUserId'");
    $row = $user_query->fetch_assoc();

    if ($row) {
        $adminChecked = $row["IsAdmin"] == 1 ? 'checked' : '';
        echo "
        <form method='POST'>
            <p>First Name:</p><input type='text' name='firstName' value='" . htmlspecialchars($row["FirstName"]) . "'>
            <p>Last Name:</p><input type='text' name='lastName' value='" . htmlspecialchars($row["LastName"]) . "'>
            <p>Email:</p><input type='text' name='email' value='" . htmlspecialchars($row["Email"]) . "'>
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

if (isset($_POST['submitChange'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'] ? md5($_POST['password']) : $_POST['originalPass'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;
    $originalEmail = $_POST['originalEmail'];

    $sql = "UPDATE user SET FirstName='$firstName', LastName='$lastName', Pass='$password', IsAdmin='$isAdmin' WHERE Email='$originalEmail'";
    if (mysqli_query($con, $sql)) {
        $_SESSION["updateYes"] = "<div class='success'>User details updated successfully.</div>";
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating user: " . mysqli_error($con) . "</div>";
    }
    header("location: editUser.php");
    exit;
}

if (isset($_POST['addDisplay'])) {
    echo "
    <form method='POST'>
        <p>First Name:</p><input type='text' name='firstName' required>
        <p>Last Name:</p><input type='text' name='lastName' required>
        <p>Email:</p><input type='text' name='email' required>
        <p>Password:</p><input type='password' name='password' required>
        <p>Confirm Password:</p><input type='password' name='password2' required>
        <p>Admin?</p><input type='number' name='admin' value=''>
        <input type='submit' name='submitAdd'>
    </form>";
}

if (isset($_POST['submitAdd'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $isAdmin = $_POST['admin'];

    if ($password != $password2) {
        $_SESSION['bad'] = "<div class='error'>Passwords do not match.</div>";
    } else {
        $email_check = mysqli_query($con, "SELECT email FROM user WHERE email='$email'");
        if (mysqli_num_rows($email_check) > 0) {
            $_SESSION['bad'] = "<div class='error'>Email already in use.</div>";
        } else {
            $password = md5($password);
            $sql = "INSERT INTO user (FirstName, LastName, Email, Pass, IsAdmin) VALUES ('$firstName', '$lastName', '$email', '$password', '$isAdmin')";
            if (mysqli_query($con, $sql)) {
                $_SESSION['updateYes'] = "<div class='success'>User Added Successfully.</div>";
                header("Location: editUser.php");
                exit;
            } else {
                $_SESSION['bad'] = "<div class='error'>Error adding user: " . mysqli_error($con) . "</div>";
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
