<?php
include('references/header.php');

if (isset($_SESSION['firstName'])) {
    echo "<h1 class='welcome'>Welcome, " . $_SESSION['firstName'] . "!</h1>";
    echo "<form method='POST' class='user-form'><a href='receipt.php'>Purchase History</a>
        <input type='submit' name='logout' value='Logout'><button type='submit' name='edit' value='edit'>Edit</button></form>";

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: login.php");
    $_SESSION['mustLogin'] = "<div class='error'>You must log in to access the user page.</div>";
    exit;
}

$currentUserEmail = $_SESSION['email'];
$user_query = mysqli_query($con, "SELECT FirstName, LastName, Email, Pass, IsAdmin FROM user WHERE Email = '$currentUserEmail'");
$user = mysqli_fetch_assoc($user_query);

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}

if (isset($_SESSION["updateYes"])) {
    echo $_SESSION["updateYes"];
    unset($_SESSION["updateYes"]);
}

if (isset($_SESSION['bad'])) {
    echo $_SESSION['bad'];
    unset($_SESSION['bad']);
}

if (isset($_POST['submitChange'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($password)) {
        $password = $user['Pass'];
    } else {
        if ($password == $password2) {
            $password = md5($password);
        } else {
            exit;
        }
    }

    $firstName = mysqli_real_escape_string($con, $firstName);
    $lastName = mysqli_real_escape_string($con, $lastName);
    $email = mysqli_real_escape_string($con, $email);

    $sql = "UPDATE user SET FirstName='$firstName', LastName='$lastName', Pass='$password' WHERE Email='$currentUserEmail'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["updateYes"] = "<div class='success'>Your details were updated successfully.</div>";
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating user: " . mysqli_error($con) . "</div>";
    }
    $_SESSION['firstName'] = $firstName;
    $_SESSION['email'] = $email;
    header("location: user.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
</head>
<body>

<?php
if (isset($_POST['edit'])) {
    echo "<h2>Edit Your Account</h2>";
    echo "<form method='POST'>
            <p>First Name:</p>
            <input type='text' name='firstName' value='" . htmlspecialchars($user['FirstName']) . "' required>
            <p>Last Name:</p>
            <input type='text' name='lastName' value='" . htmlspecialchars($user['LastName']) . "' required>
            <p>Email:</p>
            <input type='text' name='email' value='" . htmlspecialchars($user['Email']) . "' required readonly>
            <p>Password:</p>
            <input type='password' name='password' placeholder='Leave empty to keep current password'>
            <input type='password' name='password2' placeholder='Confirm Password'>
            <input type='submit' name='submitChange' value='Submit Changes'>
          </form>";
}
?>
<a href='game.html'>Game</a>
</body>
</html>
