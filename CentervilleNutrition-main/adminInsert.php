<?php include('references/header.php'); ?>

<div class="main-content">
    <div class="login-main">
        <form style='display: flex; justify-content: center' class="form" method="POST">
            <p>Name:</p>
            <input type="text" name="name" id="name" placeholder="">
            <p>Description:</p>
            <input type="text" name="description" placeholder="">
            <br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="submit" name="viewItems" value="View Items">
        </form>
    </div>
</div>
</body>
</html>

<?php 

if(isset($_POST['submit'])) {
    $price = '10.99';
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $inStock = 1;
    $type = 'Shake';

    $item_check = mysqli_query($con, "SELECT name FROM menu WHERE name='$name'");
    $num_rows  = mysqli_num_rows($item_check);

    if ($name != "") {
        if ($num_rows > 0) {
            $_SESSION['itemError'] = "<div class='error'>Item already exists.</div>";
            echo $_SESSION['itemError'];
            unset($_SESSION['itemError']);
        } else {
            $sql = "INSERT INTO menu SET price='$price', name='$name', description=' ', InStock='$inStock', type='$type'";
            $res = mysqli_query($con, $sql);

            if($res == TRUE) {
                $_SESSION['itemAdd'] = "<div class='success'>Item added successfully.</div>";
                echo $_SESSION['itemAdd'];
                unset($_SESSION['itemAdd']);
            }
        }
    }
}

// Display items when "View Items" button is clicked
$sql = "SELECT Name FROM menu";
$result = $con->query($sql);

if(isset($_POST['viewItems'])) {
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo $row["Name"] . "<br>";
        }
    }
}

// JavaScript to set the focus back to the "name" input field after form submission
if (isset($_POST['submit'])) {
    echo "<script>document.getElementById('name').focus();</script>";
}

?>
