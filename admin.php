<?php include('references/header.php'); 

if (!isset($_SESSION['firstName'])) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
} else if ($_SESSION['admin'] != 1) {
    header('location: index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
}
?>
<div class="main-content main-menu-content">
    <form method="POST" id="menuForm">
        <div class="main-menu-choice">
            <a href="javascript:void(0);" id="menuBtn1" class="main-menu-btn">
                <img style='border-radius: 50%;' src="references/menu.jpg" />
            </a>
            <h1>Menu Edit</h1>
        </div>
    </form>

    <form method="POST" id="userForm">
        <div class="main-menu-choice">
            <a href="javascript:void(0);" id="menuBtn2" class="main-menu-btn">
                <img style='border-radius: 50%;' src="references/user.jpg" />
            </a>
            <h1>User Edit</h1>
        </div>
    </form>

    <span id="menuBlob"></span>
    <span id="userBlob"></span>
</div>

<script>
    let menuHover = document.getElementById("menuBlob");
    let userHover = document.getElementById("userBlob");

    let menuBtn = document.getElementById("menuBtn1");
    let userBtn = document.getElementById("menuBtn2");

    menuBtn.addEventListener('mouseenter', () => {
        menuHover.classList.add('menu-hover');
    });

    menuBtn.addEventListener('mouseleave', () => {
        menuHover.classList.remove('menu-hover');
    });

    userBtn.addEventListener('mouseenter', () => {
        userHover.classList.add('menu-hover');
    });

    userBtn.addEventListener('mouseleave', () => {
        userHover.classList.remove('menu-hover');
    });

    // Submit menu edit form when Menu Edit image is clicked
    menuBtn.addEventListener('click', () => {
        let menuForm = document.getElementById('menuForm');
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'menuEdit';
        hiddenInput.value = 'MenuEdit'; // Set the type as Menu Edit
        menuForm.appendChild(hiddenInput);
        menuForm.submit();
    });

    // Submit user edit form when User Edit image is clicked
    userBtn.addEventListener('click', () => {
        let userForm = document.getElementById('userForm');
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'userEdit';
        hiddenInput.value = 'UserEdit'; // Set the type as User Edit
        userForm.appendChild(hiddenInput);
        userForm.submit();
    });
</script>

</body>
</html>

<?php
if (isset($_POST['menuEdit'])) {
    $_SESSION['action'] = 'MenuEdit';
    header('Location: editMenu.php');  // Redirect to editMenu.php after selecting Menu Edit
    exit();
} elseif (isset($_POST['userEdit'])) {
    $_SESSION['action'] = 'UserEdit';
    header('Location: editUser.php');  // Redirect to editUser.php after selecting User Edit
    exit();
}
?>
