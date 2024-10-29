<?php 
include("references/styleHeader.php");

if (isset($_POST['login'])) {
	
    $username = $_POST['username'];
    $password = $_POST['password'];
  
    $check_database_query = mysqli_query($con, "SELECT * FROM user WHERE username='$username' AND pass='$password'");
  
    $check_login_query = mysqli_num_rows($check_database_query);
    if ($check_login_query == 1) {
        header("Location: index.php");
        $_SESSION['username'] = $username;
  }
  else {
"<h3 style='color: red; display: flex; justify-content: center; margin-top: 20px;'>Failed to login.</h3>";
  }
  }
  
if(isset($_SESSION['mustLogin'])) {
  echo($_SESSION['mustLogin']);
  unset($_SESSION['mustLogin']);
}

  ?> 
  <div class="main-content">
    <div class="login-main">
  <form class="form" method="POST">
    <p>Username:</p>
    <input type="text" name="username" placeholder="">
    <p>Password:</p>
    <input type="password" name ="password" placeholder="">
    <br>
    <br>
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
</div>
</a>
</div>
</body>
</hmtl>