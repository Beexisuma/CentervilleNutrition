<?php include("references/header.php"); ?>

<?= "<div class='error'>Press this button to delete all accounts.</div>" ?>

<form method='POST' style='display: flex; justify-content: center;'>
    <input type='submit' name='submit' placeholder='Delete'>
</form>

<?php

$firstName = $_SESSION['firstName'];

if(isset($_POST['submit'])) {
    mysqli_query($con, "DELETE FROM user");
    unset($_SESSION['firstName']);
    header('location: index.php');
}