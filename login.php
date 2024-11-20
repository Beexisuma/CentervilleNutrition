
<?php 
include("references/styleHeader.php");

if(isset($_SESSION['firstName'])) {
    header("location: index.php");
}

if(isset($_SESSION['mustLogin'])) {
    echo($_SESSION['mustLogin']);
    unset($_SESSION['mustLogin']);
}
if
(isset($_SESSION['regSuccess'])) {
  echo($_SESSION['regSuccess']);
  unset($_SESSION['regSuccess']);
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $check_database_query = mysqli_query($con, "SELECT * FROM user WHERE email='$email' AND pass='$password'");
    $num_rows  = mysqli_num_rows($check_database_query);

    if($num_rows == 0 ) {
        echo("<div class='error'>Failed to login.</div>");
    }

    else {
    $firstName_query = mysqli_query($con, "SELECT firstName FROM user WHERE email='$email' AND pass='$password'");
    $firstName = mysqli_fetch_row($firstName_query)[0]; 
    $cartID_query = mysqli_query($con, "SELECT CartID FROM user WHERE email='$email'");

    if ($cartID_query && mysqli_num_rows($cartID_query) > 0) {
        $cartID = mysqli_fetch_row($cartID_query)[0];
        
        $currentPunch_query = mysqli_query($con, "SELECT CurrentPunches FROM punchcard WHERE CartID='$cartID'");
        if ($currentPunch_query && mysqli_num_rows($currentPunch_query) > 0) {
            $currentPunch = mysqli_fetch_row($currentPunch_query)[0]; 
            $_SESSION['punchCount'] = $currentPunch;
}
}
    $admin_query = mysqli_query($con, "SELECT IsAdmin FROM user WHERE email='$email' AND pass='$password'");
    $admin = mysqli_fetch_row($admin_query)[0]; 

    $_SESSION['admin'] = $admin;
    $_SESSION['cartCount'] = 0;
    $_SESSION['email'] = $email;
    $_SESSION['firstName'] = $firstName;
    $_SESSION['loginSuccess'] = "<div class='success'>Login Successful.</div>";
    header("Location: index.php");
}}

?> 
<div class="main-content">
    <div class="login-main">
        <form class="form" method="POST">
            <p>Email</p>
            <input type="text" name="email" placeholder="">
            <p>Password:</p>
            <input type="password" name="password" placeholder="">
            <br><br>
            <input type="submit" name="login" value="Login">
        </form>
    </div>

    <a href="register.php">Create an Account</a>
    <div class="bottomMargin">
        <a href="index.php" class="logo">
            <div class="logo-footer">
                <h1 class='bottom-logo alt'>Centerville Nutrition</h1>
            </div>
            <span>
                <div class="logoUnder1"></div>
                <div class="logoUnder2"></div>
            </span>
        </a>
    </div>
</div>
</body>
</html>
