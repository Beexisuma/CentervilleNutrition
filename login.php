<?php 
include("references/styleHeader.php");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_database_query = mysqli_query($con, "SELECT * FROM user WHERE email='$email' AND pass='$password'");
  
    $check_login_query = mysqli_num_rows($check_database_query);

    if ($check_login_query == 1) {

        $firstName_query = mysqli_query($con, "SELECT firstName FROM user WHERE email='$email' AND pass='$password'");

        $firstName = mysqli_fetch_row($firstName_query)[0]; 

        $_SESSION['firstName'] = $firstName;
        $_SESSION['loginSuccess'] = "<h3 style='color: green; display: flex; justify-content: center; margin-top: 20px;'>Login Successful.</h3>";
        header("Location: index.php");
    } else {
        echo "<h3 style='color: red; display: flex; justify-content: center; margin-top: 20px;'>Failed to login.</h3>";
    }
}

if (isset($_SESSION['mustLogin'])) {
    echo($_SESSION['mustLogin']);
    unset($_SESSION['mustLogin']);
}
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
                <h1>Centerville Nutrition</h1>
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
