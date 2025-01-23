<?php include("references/header.php") ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <p>First Name:</p>
        <input type="text" name="firstName" placeholder="" required>
        <p>Last Name:</p>
        <input type="text" name="lastName" placeholder="" required>
        <p>Email:</p>
        <input type="text" name="email" placeholder="" required>
        <p>Password:</p>
        <input type="password" name="password" placeholder="" required>
        <p>Confirm Password:</p>
        <input type="password" name="password2" placeholder="" required>
        <input type="submit" name="submit">
    </form>
</body>
</html>

<?php 

if(isset($_POST['submit'])) {
    // Capture the form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $password2 = md5($_POST['password2']);

    // Check if the email already exists
    $email_check = mysqli_query($con, "SELECT email FROM user WHERE email='$email'");
    $num_rows = mysqli_num_rows($email_check);

    if ($num_rows > 0) {
        $_SESSION['regError'] = "<div class='error'>Email already in use, please log in.</div>";
        echo $_SESSION['regError'];
        unset($_SESSION['regError']);
    } 
    // Check if the passwords match
    else if ($password != $password2) {
        $_SESSION['passMatch'] = "<div class='error'>Passwords do not match, please try again.</div>";
        echo $_SESSION['passMatch'];
        unset($_SESSION['passMatch']);
    }
    else {
        // Insert the user into the database
        $sql = "INSERT INTO user (firstName, lastName, email, pass) VALUES ('$firstName', '$lastName', '$email', '$password')";
        $res = mysqli_query($con, $sql);

        if ($res) {
            // Get the CartID (the last inserted user ID)
            $cartID = mysqli_insert_id($con);
            
            // Insert the CartID into the punchcard table
            $punchcard_sql = "INSERT INTO punchcard (CartID) VALUES ('$cartID')";
            $punchcard_res = mysqli_query($con, $punchcard_sql);
            
            $cartid_sql = "INSERT INTO cart (cartID) VALUES ('$cartID')";
            mysqli_query($con, $cartid_sql);
            
            // Check if the punchcard insertion was successful
            if ($punchcard_res) {
                $_SESSION['regSuccess'] = "<div class='success'>User Added Successfully, and CartID assigned to punchcard!</div>";
                header("Location: login.php");
            } else {
                // Handle error if the punchcard insertion fails
                $_SESSION['regError'] = "<div class='error'>Error inserting CartID into punchcard table.</div>";
                echo $_SESSION['regError'];
                unset($_SESSION['regError']);
            }
        } else {
            // Handle error if user insertion fails
            $_SESSION['regError'] = "<div class='error'>Error adding user to the database.</div>";
            echo $_SESSION['regError'];
            unset($_SESSION['regError']);
        }
    }
}
?>
