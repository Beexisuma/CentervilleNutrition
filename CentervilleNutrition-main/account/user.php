<?php

include('../header/header.php');
if (isset($_SESSION['firstName'])) {
    $lastName = $_SESSION['lastName'];
?>

<div class="main-content account-content">
    <div class="account-container">
        <h1><?= $_SESSION['firstName'] ?></h1>

        <div class="receipt-box">
        <h3>Transaction History</h3>

            <div class="receipt-list">
                <?php
                $email = $_SESSION['email'];
                $receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date FROM receipts WHERE email='$email' ORDER BY Date Desc");
                $num_rows = mysqli_num_rows($receiptQuery);

                if ($num_rows > 0) {
                    while ($row = $receiptQuery->fetch_assoc()) {
                ?>
                        
                        <div class="transaction">
                            <h4><?= htmlspecialchars($row['Date']) ?></h4>
                            <h5>$<?= htmlspecialchars($row['Cost']) ?></h5>
                            <form method="POST" class="view-receipt">
                                <input type="hidden" name="receiptDate" value="<?= htmlspecialchars($row['Date']) ?>">
                                <input type="submit" name="view" value="View Receipt">
                            </form>
                        </div>

                <?php
                    }
                } else {
                    echo "<div class='empty-receipt'>
                            <h2>You have no purchases on this account</h2>
                            <a href='menu.php'>Get Started</a>
                          </div>";
                }

                if (isset($_POST['view']) && isset($_POST['receiptDate'])) {
                    $_SESSION['receiptDate'] = $_POST['receiptDate'];
                    header('Location: receiptDisplay.php');
                    exit();
                }
                ?>
            </div>
        </div>

        <form class="account-btns" method="POST">
            <button class="btn-account" type="button" onclick="togglePop()">Edit Info</button>
            <input class="btn-account sign-out" type="submit" value="Sign Out" name="logout"/>
        </form>

<!-- edit user popup -->
<div class="POP popup popUp-container">
						
						<form class="sign-form edit-form" method="POST" style="">
						<button class="out" onclick="togglePop()">✕</button>
						
						<section id="regPage1">
							<h1>Edit Account</h1>
							
							<p>Email</p>
							<input class="reg-text reg-text2" placeholder="<?= $email ?>" type="text" name="email" required disabled style="width: 100%"/>
							
							<p>First Name</p>
							<input class="reg-text reg-text2" type="text" name="firstName" value='<?= $firstName ?>' required/>
						
							<p>Last Name</p>
							<input class="reg-text reg-text2" type="text" name="lastName" value='<?= $lastName ?>' required/>

								<input name="nameChange" class="reg-submit change-btn" type="submit" value="Confirm"/>
								<button class="reg-next" onclick="nextPage()" type="button">Change Password</button>
							</section>

						<section id="regPage2" class="POP">
							<h1>Change Password</h1>
							<span class="regPass">
								<section>
									<h3 class="regPass-title">Password Requirements</h3>
								
									<ul>
										<li class="reg-error" id="req0">Passwords must match</li>
										<li class="reg-error" id="req1">At least 8 characters</li>
										<li class="reg-error" id="req2">At least 1 uppercase letter</li>
										<li class="reg-error" id="req3">At least 1 lowercase letter</li>
										<li class="reg-error" id="req4">At least 1 number</li>
										<li class="reg-error" id="req5">At least 1 special character</li>
									</ul>
								</section>
						
								<section>
									<p>Password</p>
									<input class="reg-text reg-text2" type="password" name="password" id="password1" onkeyup="checkPassword()"/>	
								
									<p>Confirm Password</p>
									<input class="reg-text reg-text2" type="password" name="password2" id="password2" onkeyup="checkPassword()"/>
								</section>
							</span>
							<input name="passChange" id="accountSubmit" class="reg-submit change-btn" type="submit" value="Change Password" disabled/>
							<button class="reg-next" onclick="nextPage()" type="button" style="margin-bottom: 24px">Edit Info</button>
							
							</section>
						
						
					</form>
					</div>





    </div>
</div>
</body>

<script>
			function togglePop() {
				document.querySelector(".popup").classList.toggle("POP");
				//console.log("toggled Popup");
			}
			
			function nextPage() {
				document.getElementById("regPage1").classList.toggle("POP");
				document.getElementById("regPage2").classList.toggle("POP");
			}



			//Password requirements for account creation
			let passwordStrong = false; 




			function checkPassword() {
			//passwords
			let submit = document.getElementById("accountSubmit");
			
			var password1 = document.getElementById("password1").value.trim();
			var password2 = document.getElementById("password2").value.trim();
			
			
			console.log(password1 + ", " + password2)
			//req0
			var match = password1 === password2 && password1 != ""
			
			//req1
            var length = password1.length >= 8;

            //req2
            var upper = /[A-Z]/.test(password1);

            //req3
            var lower = /[a-z]/.test(password1);

            //req4
            var number = /\d/.test(password1);

            //req5
            var special = /[!@#$%^&*(),.?:{}|<>]/.test(password1.trim());

			//Check reqs
			let reqs = [match, length, upper, lower, number, special]
			
			for (let i = 0; i <= 5; i++) {
				if (!reqs[i]) {
					document.getElementById("req" + i).classList.add("reg-error");
				} else {
					document.getElementById("req" + i).classList.remove("reg-error");
				}
			}

            //Final check
            passwordGood = match && length && upper && lower && number && special;
			console.log("Match:" + match);
			console.log("Upper:" + upper);
			console.log("Lower:" + lower);
			console.log("Number:" + number);
			console.log("Special:" + special);
			console.log("Final:" + passwordGood);
			console.log("\nSTOP\n")

            if(passwordGood) {
				submit.disabled = false;
			} else {
				submit.disabled = true;
			}
            
        }
	</script>


</html>




<?php 



    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../homepage/index.php");
        exit();
    }
} else {
    header("Location: login.php");
    $_SESSION['mustLogin'] = "<div class='error'>You must log in to access the user page.</div>";
    exit;
}

$currentUserEmail = $_SESSION['email'];
$user_query = mysqli_query($con, "SELECT FirstName, LastName, Email, Pass, IsAdmin FROM user WHERE Email = '$currentUserEmail'");
$user = mysqli_fetch_assoc($user_query);

if (!$user) {
    echo "<p>User not found.</p>";
    exit;
}

if (isset($_SESSION["updateYes"])) {
    echo("<script>alert('Your details were updated successfully.')</script>");
    unset($_SESSION["updateYes"]);
}

if (isset($_SESSION['bad'])) {
    echo("<script>alert('There was an error updating your details.')</script>");
    unset($_SESSION['bad']);
}

if (isset($_POST['nameChange'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    

    $firstName = mysqli_real_escape_string($con, $firstName);
    $lastName = mysqli_real_escape_string($con, $lastName);
    $email = mysqli_real_escape_string($con, $email);





    $sql = "UPDATE user SET FirstName='$firstName', LastName='$lastName' WHERE Email='$currentUserEmail'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["updateYes"] = "<div class='success'>Your details were updated successfully.</div>";
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating user: " . mysqli_error($con) . "</div>";
    }
    $_SESSION['firstName'] = $firstName;
    $_SESSION['lastName'] = $lastName;

    header("location: user.php");
    exit;
}

if(isset($_POST['passChange'])) {
$password = $_POST['password'];
 $password2 = $_POST['password2'];

    if (empty($password)) {
        $password = $user['Pass'];
    } else {
        if ($password == $password2) {
            $password = md5($password);
        } else {
            exit;
        }
    }
    
    $sql = "UPDATE user SET pass='$password' WHERE Email='$currentUserEmail'";

    if (mysqli_query($con, $sql)) {
        $_SESSION["updateYes"] = 1;
    } else {
        $_SESSION['bad'] = 1;
    }


    header("location: user.php");
    exit;

}
