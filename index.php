<?php include('references/header.php'); ?>


<?php 


if(isset($_SESSION['loginSuccess'])) {
    echo $_SESSION['loginSuccess'];
    unset($_SESSION['loginSuccess']);
}

?>