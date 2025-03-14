<?php include ('references/header.php'); 
$isOpen = $_SESSION['isOpen'];
?>

<div class="main-content main-menu-content">
    <form method="POST" id="teaForm">
        <div class="main-menu-choice">
            <a href="javascript:void(0);" id="menuBtn1" class="main-menu-btn">
                <img src="references/tea.png" />
            </a>
            <h1>Tea Bombs</h1>
        </div>
    </form>

    <form method="POST" id="shakeForm">
        <div class="main-menu-choice">
            <a href="javascript:void(0);" id="menuBtn2" class="main-menu-btn">
                <img src="references/shake.png" />
            </a>
            <h1>Protein Shakes</h1>
        </div>
    </form>

    <span id="teaBlob"></span>
    <span id="shakeBlob"></span>
    <?php if($isOpen == false){
        // adam do the date thingy please
            echo ("
            <!--Closed Popup-->
            <div class='popup popUp-container' id='notice'>
                <div class='notice'>
                    <button class='out' onclick='toggle(\"notice\")'>✕</button>
                    <h1>NOTICE</h1>
                    <h2>Centerville Nutrition is currently closed</h2>
                    <p>We will open at <strong>" . $nextOpenHour . " " . $nextOpenDay . "</strong></p>
                </div>
            </div>
        ");

    } ?>

</div>

<script>
    let teaHover = document.getElementById("teaBlob");
    let shakeHover = document.getElementById("shakeBlob");

    let teaBtn = document.getElementById("menuBtn1");
    let shakeBtn = document.getElementById("menuBtn2");

    teaBtn.addEventListener('mouseenter', () => {
        teaHover.classList.add('menu-hover');
    });

    teaBtn.addEventListener('mouseleave', () => {
        teaHover.classList.remove('menu-hover');
    });

    shakeBtn.addEventListener('mouseenter', () => {
        shakeHover.classList.add('menu-hover');
    });

    shakeBtn.addEventListener('mouseleave', () => {
        shakeHover.classList.remove('menu-hover');
    });

    // Submit tea form when Tea Bomb image is clicked
    teaBtn.addEventListener('click', () => {
        let teaForm = document.getElementById('teaForm');
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tea';
        hiddenInput.value = 'Tea'; // Set the type as Tea
        teaForm.appendChild(hiddenInput);
        teaForm.submit();
    });

    // Submit shake form when Protein Shake image is clicked
    shakeBtn.addEventListener('click', () => {
        let shakeForm = document.getElementById('shakeForm');
        let hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'shake';
        hiddenInput.value = 'Shake'; // Set the type as Shake
        shakeForm.appendChild(hiddenInput);
        shakeForm.submit();
    });

    //Close Closed popup
    function toggle(id) {
			document.getElementById(id).classList.toggle('POP')
	}



</script>


</body>
</html>

<?php
if (isset($_POST['tea'])) {
    $_SESSION['type'] = 'Tea';
    header('Location: menuDisplay.php');  // Redirect to menuDisplay.php after selecting Tea
    exit();
} elseif (isset($_POST['shake'])) {
    $_SESSION['type'] = 'Shake';
    header('Location: menuDisplay.php');  // Redirect to menuDisplay.php after selecting Shake
    exit();
}
?>
