<?php 
// Include header file for common references like navigation, etc.
include("references/header.php"); 

// Check if a user is already logged in (session active), redirect to user page
if (isset($_SESSION['firstName'])) {
    header("location: user.php");
}
?>

<body class='reg'>
    <!-- Registration Form -->
    <form method="POST" style='display: flex; justify-content: center; flex-direction: column;'>
        
        <!-- First Name input -->
        <p>First Name:</p>
        <input type="text" name="firstName" placeholder="John" required>

        <!-- Last Name input -->
        <p>Last Name:</p>
        <input type="text" name="lastName" placeholder="Doe" required>

        <!-- Email input -->
        <p>Email:</p>
        <input type="text" name="email" placeholder="johndoe@email.com" required>

        <!-- Password input -->
        <p>Password:</p>
        <input type="password" id="password" name="password" placeholder="Password" required onkeyup="checkPasswordStrength()">
        
        <!-- Password strength requirements checklist -->
        <ul id="password-requirements" class="requirements">
            <li class="requirement" id="length"><input type="checkbox" disabled> At least 8 characters</li>
            <li class="requirement" id="uppercase"><input type="checkbox" disabled> At least one uppercase letter</li>
            <li class="requirement" id="lowercase"><input type="checkbox" disabled> At least one lowercase letter</li>
            <li class="requirement" id="number"><input type="checkbox" disabled> At least one number</li>
            <li class="requirement" id="special"><input type="checkbox" disabled> At least one special character (e.g., !@#$%)</li>
        </ul>

        <br>

        <!-- Confirm Password input -->
        <p>Confirm Password:</p>
        <input type="password" name="password2" placeholder="Confirm Password" required>

        <!-- Submit Button (Initially disabled until password is strong) -->
        <input type="submit" id="submit-btn" name="submit" disabled>
    </form>

    <!-- JavaScript for password strength checking -->
    <script>
        let passwordStrong = false; // Initially, password strength is weak

        function checkPasswordStrength() {
            // Get the password value
            var password = document.getElementById('password').value;

            // Check if password meets length requirement (at least 8 characters)
            var length = password.length >= 8;
            document.getElementById('length').querySelector('input').checked = length;

            // Check for at least one uppercase letter
            var uppercase = /[A-Z]/.test(password);
            document.getElementById('uppercase').querySelector('input').checked = uppercase;

            // Check for at least one lowercase letter
            var lowercase = /[a-z]/.test(password);
            document.getElementById('lowercase').querySelector('input').checked = lowercase;

            // Check for at least one number
            var number = /\d/.test(password);
            document.getElementById('number').querySelector('input').checked = number;

            // Check for at least one special character
            var special = /[!@#$%^&*(),.?":{}|<>]/.test(password);
            document.getElementById('special').querySelector('input').checked = special;

            // Check if the password meets all the conditions
            passwordStrong = length && uppercase && lowercase && number && special;

            // Enable or disable the submit button based on password strength
            document.getElementById('submit-btn').disabled = !passwordStrong;
            if (passwordStrong) {
                document.getElementById('submit-btn').classList.remove('disabled');
            } else {
                document.getElementById('submit-btn').classList.add('disabled');
            }
        }
    </script>
</body>
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
    // If the passwords don't match, show an error message
    else if ($password != $password2) {
        $_SESSION['passMatch'] = "<div class='error'>Passwords do not match, please try again.</div>";
        echo $_SESSION['passMatch'];
        unset($_SESSION['passMatch']);
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
?>
