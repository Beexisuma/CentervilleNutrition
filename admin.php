<?php 
// Include header file for common references (e.g., navigation, etc.)
include('references/header.php'); 

// Check if the user is logged in (session exists) and if the user is an admin
if (!isset($_SESSION['firstName'])) {
    // If the user is not logged in, redirect to the home page and show an error
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
} else if ($_SESSION['admin'] != 1) {
    // If the user is not an admin, redirect to the home page and show an error
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
}
?>

<!-- Main Content Section -->
<div class="main-content main-menu-content">
    <!-- Menu Edit Form -->
    <form method="POST" id="menuForm">
        <div class="main-menu-choice">
            <a href="javascript:void(0);" id="menuBtn1" class="main-menu-btn">
                <!-- Menu Edit Button with image -->
                <img style='border-radius: 50%;' src="references/menu.jpg" />
            </a>
            <h1>Menu Edit</h1>
        </div>
    </form>

    <!-- User Edit Form -->
    <form method="POST" id="userForm">
        <div class="main-menu-choice">
            <a href="javascript:void(0);" id="menuBtn2" class="main-menu-btn">
                <!-- User Edit Button with image -->
                <img style='border-radius: 50%;' src="references/user.jpg" />
            </a>
            <h1>User Edit</h1>
        </div>
    </form>

    <!-- Placeholders for hover effects (will be manipulated by JavaScript) -->
    <span id="menuBlob"></span>
    <span id="userBlob"></span>
</div>

<!-- JavaScript for handling hover effects and form submission -->
<script>
    // Get references to the elements for hover effects
    let menuHover = document.getElementById("menuBlob");
    let userHover = document.getElementById("userBlob");

    let menuBtn = document.getElementById("menuBtn1");
    let userBtn = document.getElementById("menuBtn2");

    // Add hover effect for Menu Edit button
    menuBtn.addEventListener('mouseenter', () => {
        menuHover.classList.add('menu-hover');
    });

    menuBtn.addEventListener('mouseleave', () => {
        menuHover.classList.remove('menu-hover');
    });

    // Add hover effect for User Edit button
    userBtn.addEventListener('mouseenter', () => {
        userHover.classList.add('menu-hover');
    });

    userBtn.addEventListener('mouseleave', () => {
        userHover.classList.remove('menu-hover');
    });

    // Submit the Menu Edit form when Menu Edit button is clicked
    menuBtn.addEventListener('click', () => {
        let menuForm = document.getElementById('menuForm');
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'menuEdit';
        hiddenInput.value = 'MenuEdit'; // Set the action as Menu Edit
        menuForm.appendChild(hiddenInput);
        menuForm.submit(); // Submit the form
    });

    // Submit the User Edit form when User Edit button is clicked
    userBtn.addEventListener('click', () => {
        let userForm = document.getElementById('userForm');
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'userEdit';
        hiddenInput.value = 'UserEdit'; // Set the action as User Edit
        userForm.appendChild(hiddenInput);
        userForm.submit(); // Submit the form
    });
</script>

</body>
</html>

<?php
// Check if the Menu Edit action is submitted
if (isset($_POST['menuEdit'])) {
    $_SESSION['action'] = 'MenuEdit';  // Set the action session to Menu Edit
    header('Location: editMenu.php');  // Redirect to editMenu.php page for menu editing
    exit(); // Stop further script execution after redirect
} 
// Check if the User Edit action is submitted
elseif (isset($_POST['userEdit'])) {
    $_SESSION['action'] = 'UserEdit';  // Set the action session to User Edit
    header('Location: editUser.php');  // Redirect to editUser.php page for user editing
    exit(); // Stop further script execution after redirect
}
?>
