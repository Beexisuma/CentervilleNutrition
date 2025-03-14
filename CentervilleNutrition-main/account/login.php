<?php 
// Include header file for common references like navigation, etc.
include("references/header.php"); 

// Check if a user is already logged in (session active), redirect to user page
if (isset($_SESSION['firstName'])) {
    header("location: user.php");
}

if(isset($_SESSION['regSuccess'])) {
    echo($_SESSION['regSuccess']);
    unset($_SESSION['regSuccess']);
}

if(isset($_SESSION['loginSuccess'])) {
    echo($_SESSION['loginSuccess']);
    unset($_SESSION['loginSuccess']);
}

if(isset($_SESSION['error'])){
    echo($_SESSION['error']);
    unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Centerville Nutrition</title>
        <link rel="stylesheet" href="general.css" />
        <link rel="stylesheet" href="register.css" />


        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Playball&display=swap"
            rel="stylesheet"
        />


        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Geologica:wght@100..900&family=Playball&display=swap"
            rel="stylesheet"
        />
    </head>
    <body>
        <div class="container sign-in">
				
				<section id="sign-in" class="">
					<form class="sign-form" method="POST">
						<h1>Sign In</h1>
						<p>Email</p>
						<input class="reg-text" type="text" name="email" required>
						<p>Password</p>
						<input class="reg-text" type="password" name="password" required>
						<input class="reg-submit" name="login" type="submit" value="Sign In"/>
					</form>


						<p class="register-link-text">New to Centerville Nutrition?</p>
						<button class="create-account-link" onclick="register(1)">Create Account</button>
				</section>
				
				
				
				<section id="register" class="POP">
					<form class="sign-form" method="POST">

						<h1>Create Account</h1>
						<section id="regPage1">
							
							
							<p>Email</p>
							<input class="reg-text reg-text2" type="text" name="email" required style="width: 100%"/>
							
							<p>First Name</p>
							<input class="reg-text reg-text2" type="text" name="firstName" required/>
						
							<p>Last Name</p>
							<input class="reg-text reg-text2" type="text" name="lastName" required/>

							<button class="reg-next" onclick="nextPage()" type="button">Next</button>
						</section>
						
						<section id="regPage2" class="POP">

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
									<input class="reg-text reg-text2" type="password" name="password" id="password1" onkeyup="checkPassword()" required/>	
								
									<p>Confirm Password</p>
									<input class="reg-text reg-text2" type="password" name="password2" id="password2" onkeyup="checkPassword()" required/>
								</section>
							</span>
							
							<button class="reg-next" onclick="nextPage()" type="button" style="margin-bottom: 24px">Back</button>
							
							<input name='submit' id="accountSubmit" class="reg-submit" type="submit" value="Create Account" disabled/>
						</section>
						
						
					</form>
						<p class="register-link-text">Already have an account?</p>
						<button class="sign-up-link" onclick="register(2)">Sign In</button>
				</section>
				
				<a class="logo alt-logo" href="index.html">
                    <h1>Centerville Nutrition</h1>
                    <span>
                        <div class="logoUnder1"></div>
                        <div class="logoUnder2"></div>
                    </span>
                </a>
			</div>
		</div>
</body>

<script>


//Page formatting

let sign = document.getElementById('sign-in');
let reg = document.getElementById('register');

function register(val) {
	if (val == 1) {
		sign.classList.add("POP");
		reg.classList.remove("POP");
	} else if (val == 2) {
		reg.classList.add("POP");
		sign.classList.remove("POP");
	}
}

function nextPage() {
	document.getElementById("regPage1").classList.toggle("POP");
	document.getElementById("regPage2").classList.toggle("POP");
}



//Password requirements for account creation

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
			}
            else {
                submit.disabled = true;
            }
        }

</script>

</html>




<?php 
// Check if the form was submitted
if (isset($_POST['submit'])) {

    // Capture form data (firstName, lastName, email, password)
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    // Hash the password using md5
    $password = md5($_POST['password']);
    $password2 = md5($_POST['password2']);

    // Check if the email already exists in the database
    $email_check = mysqli_query($con, "SELECT email FROM user WHERE email='$email'");
    $num_rows = mysqli_num_rows($email_check);

    // If the email already exists, show an error message
    if ($num_rows > 0) {
        $_SESSION['regError'] = "<div class='error'>Email already in use, please log in.</div>";
        echo $_SESSION['regError'];
        unset($_SESSION['regError']);
    } 
    else {
        // Insert new user into the database
        $sql = "INSERT INTO user (firstName, lastName, email, pass) VALUES ('$firstName', '$lastName', '$email', '$password')";
        $res = mysqli_query($con, $sql);

        // If user is inserted successfully, proceed to insert additional records
        if ($res) {
            // Get the CartID (the last inserted user ID)
            $cartID = mysqli_insert_id($con);
            
            // Insert a new record into the punchcard table for the user
            $punchcard_sql = "INSERT INTO punchcard (CartID) VALUES ('$cartID')";
            $punchcard_res = mysqli_query($con, $punchcard_sql);
            
            // Insert a new record into the cart table
            $cartid_sql = "INSERT INTO cart (cartID) VALUES ('$cartID')";
            mysqli_query($con, $cartid_sql);
            
            // Check if the punchcard insertion was successful
            if ($punchcard_res) {
                $_SESSION['regSuccess'] = "<div class='success'>User Added Successfully!</div>";
                
                // If the user is eligible for a free drink, update the punchcard
                if ($_SESSION['freeDrink'] == 'true') {
                    $update_query = "UPDATE punchcard SET UnrewardedCards='1' WHERE CartID='$cartID'";
                    $update_res = mysqli_query($con, $update_query);
                }

                // Redirect to the login page
                header("Location: login.php");

            } else {
                // Handle error if punchcard insertion fails
                $_SESSION['regError'] = "<div class='error'>Error inserting CartID into punchcard table.</div>";
                echo $_SESSION['regError'];
                unset($_SESSION['regError']);
            }
        } else {
            // Handle error if user insertion fails
            $_SESSION['regError'] = "<div class='error'>Error adding user to the database.</div>";
            echo $_SESSION['regError'];
            unset($_SESSION['regError']);
        }
    }
}


if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $check_database_query = mysqli_query($con, "SELECT * FROM user WHERE email='$email' AND pass='$password'");
    $num_rows  = mysqli_num_rows($check_database_query);

    if($num_rows == 0 ) {
        $_SESSION['error'] = "<div class='error'>Failed to login, email or password incorrect.</div>";
        header('location: login.php');
    }

    else {
    $firstName_query = mysqli_query($con, "SELECT firstName FROM user WHERE email='$email' AND pass='$password'");
    $firstName = mysqli_fetch_row($firstName_query)[0]; 

    $lastName_query = mysqli_query($con, "SELECT LastName FROM user WHERE email='$email' AND pass='$password'");
    $_SESSION['lastName'] = mysqli_fetch_row($lastName_query)[0]; 

    $cartID_query = mysqli_query($con, "SELECT CartID FROM user WHERE email='$email'");

    if ($cartID_query && mysqli_num_rows($cartID_query) > 0) {
        $cartID = mysqli_fetch_row($cartID_query)[0];
        $currentPunch_query = mysqli_query($con, "SELECT CurrentPunches FROM punchcard WHERE CartID='$cartID'");
        if ($currentPunch_query && mysqli_num_rows($currentPunch_query) > 0) {
            $currentPunch = mysqli_fetch_row($currentPunch_query)[0]; 
            $_SESSION['punchCount'] = $currentPunch;
}
}
    $admin_query = mysqli_query($con, "SELECT IsAdmin FROM user WHERE email='$email' AND pass='$password'");
    $admin = mysqli_fetch_row($admin_query)[0]; 

    $_SESSION['admin'] = $admin;
    $_SESSION['cartCount'] = 0;
    $_SESSION['email'] = $email;
    $_SESSION['firstName'] = $firstName;
    $_SESSION['loginSuccess'] = "<div class='success'>Login Successful.</div>";
    header('location: index.php');
    // get cart id and make into an array
    if(!isset($_SESSION['itemArray'])) {
     $_SESSION['itemArray'] = $dataClass->cartToArray(($dataClass->searchData("cart", "CartID", $dataClass->searchData("user", "email", $_SESSION['email'])["CartID"])["ItemList"]));
     }
    $unredeemed_query = mysqli_query($con, "SELECT UnrewardedCards FROM punchcard WHERE CartID='$cartID'");
    if ($unredeemed_query && mysqli_num_rows($unredeemed_query) > 0) {
        $_SESSION['unredeemed'] = mysqli_fetch_row($unredeemed_query)[0]; 
}
}
}
?> 
