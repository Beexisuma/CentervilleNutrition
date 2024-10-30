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
    <input type="text" name="firstName" placeholder="">
    <p>Last Name:</p>
    <input type="text" name="lastName" placeholder="">
    <p>Email</p>
  <input type="text" name="email" placeholder="">
  <p>Password:</p>
  <input type="password" name ="password" placeholder="">
    <p>Confirm Password</p>
    <input type="password" name ="password2" placeholder="">
    <p>Submit</p>
    <input type="submit" name="submit">
</form>
</body>
</html>

<?php 

if(isset($_POST['submit'])) {
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password2'];



$email_check = mysqli_query($con, "SELECT email FROM user WHERE email='$email'");
  
$num_rows  = mysqli_num_rows($email_check);

    if ($num_rows > 0)
    {
      $_SESSION['userTaken'] = "<div class='error'> Email already in use, please log in.  </div>"; 
    }
    
  
  else {
    $sql = "INSERT INTO user SET firstName='$firstName', lastName='$lastName', email='$email', pass='$password'";
    $res = mysqli_query($con, $sql);
  
    if($res==TRUE)
    {
      $_SESSION['add'] = "<div class='success'>User Added Successfully</div>";
      header("Location: login.php");
    }
    }
}
?>
