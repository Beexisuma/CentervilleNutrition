<?php 
include('references/header.php');

// Redirect non-admin users or unauthenticated users
if (!isset($_SESSION['firstName']) || $_SESSION['admin'] != 1) {
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in as an admin to access this page.</h3>";
    header('location: index.php');
    exit;
}

// Display session messages if set
if (isset($_SESSION["updateYes"])) {
    echo $_SESSION["updateYes"];
    unset($_SESSION["updateYes"]);
}

if (isset($_SESSION['bad'])) {
    echo $_SESSION['bad'];
    unset($_SESSION['bad']);
}

if (isset($_SESSION['deleteYes'])) {
    echo $_SESSION['deleteYes'];
    unset($_SESSION['deleteYes']);
}
?>

<div class="admin-content">
<div id="adminNav" class="admin-left mobile-nav">
<section>
						<a class="admin-switch user-switch" href='editUser.php'>
							<svg
								version="1.1"
								viewBox="0.0 0.0 102.17060367454069 140.9291338582677"
								fill="none"
								stroke="none"
								stroke-linecap="square"
								stroke-miterlimit="10"
								xmlns:xlink="http://www.w3.org/1999/xlink"
								xmlns="http://www.w3.org/2000/svg"
							>
								<clipPath id="p.0">
									<path
										d="m0 0l102.1706 0l0 140.92914l-102.1706 0l0 -140.92914z"
										clip-rule="nonzero"
									/>
								</clipPath>
								<g clip-path="url(#p.0)">
									<path
										fill="#000000"
										fill-opacity="0.0"
										d="m0 0l102.1706 0l0 140.92914l-102.1706 0z"
										fill-rule="evenodd"
									/>
									<path
										fill="var(--light1)"
										d="m9.46323 136.74278l0 -34.677162l0 0c0 -19.151672 18.634825 -34.67717 41.622047 -34.67717c22.987225 0 41.622044 15.525497 41.622044 34.67717l0 34.677162z"
										fill-rule="evenodd"
									/>
									<path
										fill="var(--light1)"
										d="m20.880978 34.391075l0 0c0 -16.681608 13.523117 -30.204723 30.204723 -30.204723l0 0c8.010792 0 15.693481 3.1822743 21.357964 8.846759c5.6644897 5.664485 8.846764 13.347175 8.846764 21.357964l0 0c0 16.68161 -13.523117 30.204727 -30.204727 30.204727l0 0c-16.681606 0 -30.204723 -13.523117 -30.204723 -30.204727z"
										fill-rule="evenodd"
									/>
								</g>
							</svg>
							<h1>Users</h1>
						</a>

						<a class="admin-switch drink-switch" href='editMenu.php'>
							<svg
								version="1.1"
								viewBox="0.0 0.0 100.0 144.8031496062992"
								fill="none"
								stroke="none"
								stroke-linecap="square"
								stroke-miterlimit="10"
								xmlns:xlink="http://www.w3.org/1999/xlink"
								xmlns="http://www.w3.org/2000/svg"
							>
								<clipPath id="p.0">
									<path
										d="m0 0l100.0 0l0 144.80315l-100.0 0l0 -144.80315z"
										clip-rule="nonzero"
									/>
								</clipPath>
								<g clip-path="url(#p.0)">
									<path
										fill="#000000"
										fill-opacity="0.0"
										d="m0 0l100.0 0l0 144.80315l-100.0 0z"
										fill-rule="evenodd"
									/>
									<path
										fill="#fff9fb"
										d="m79.37639 39.37664l-8.496765 86.67716l-41.74663 0l-8.496763 -86.67716z"
										fill-rule="evenodd"
									/>
									<path
										stroke="#fff9fb"
										stroke-width="8.0"
										stroke-linejoin="round"
										stroke-linecap="butt"
										d="m79.37639 39.37664l-8.496765 86.67716l-41.74663 0l-8.496763 -86.67716z"
										fill-rule="evenodd"
									/>
									<path
										fill="#fff9fb"
										d="m17.259842 40.45558l1.9929924 -3.7165375l61.494328 0l1.9929962 3.7165375z"
										fill-rule="evenodd"
									/>
									<path
										stroke="#fff9fb"
										stroke-width="8.0"
										stroke-linejoin="round"
										stroke-linecap="butt"
										d="m17.259842 40.45558l1.9929924 -3.7165375l61.494328 0l1.9929962 3.7165375z"
										fill-rule="evenodd"
									/>
									<path
										fill="#fff9fb"
										d="m51.297237 4.550686l0 0c0.29961777 -1.3630435 1.645031 -2.214289 3.0050697 -1.9013095l2.6024284 0.59888506l0 0c0.6531105 0.15029788 1.2223167 0.5544617 1.5824013 1.12358c0.36008072 0.569118 0.48154068 1.2565713 0.33765793 1.911128l-10.096096 45.930122c-0.29961395 1.3630447 -1.645031 2.2142906 -3.005066 1.90131l-2.6024284 -0.5988846c-1.3600388 -0.31298065 -2.2196808 -1.6716652 -1.920063 -3.03471z"
										fill-rule="evenodd"
									/>
									<path
										stroke="#fff9fb"
										stroke-width="1.0"
										stroke-linejoin="round"
										stroke-linecap="butt"
										d="m51.297237 4.550686l0 0c0.29961777 -1.3630435 1.645031 -2.214289 3.0050697 -1.9013095l2.6024284 0.59888506l0 0c0.6531105 0.15029788 1.2223167 0.5544617 1.5824013 1.12358c0.36008072 0.569118 0.48154068 1.2565713 0.33765793 1.911128l-10.096096 45.930122c-0.29961395 1.3630447 -1.645031 2.2142906 -3.005066 1.90131l-2.6024284 -0.5988846c-1.3600388 -0.31298065 -2.2196808 -1.6716652 -1.920063 -3.03471z"
										fill-rule="evenodd"
									/>
								</g>
							</svg>
							<h1>Drinks</h1>
						</a>

						<!---->

						<a class="admin-switch history-switch" href='transactionHistory.php'>
							<svg
								version="1.1"
								viewBox="0.0 0.0 101.14698162729658 120.31233595800525"
								fill="none"
								stroke="none"
								stroke-linecap="square"
								stroke-miterlimit="10"
								xmlns:xlink="http://www.w3.org/1999/xlink"
								xmlns="http://www.w3.org/2000/svg"
							>
								<clipPath id="p.0">
									<path
										d="m0 0l101.14698 0l0 120.31233l-101.14698 0l0 -120.31233z"
										clip-rule="nonzero"
									/>
								</clipPath>
								<g clip-path="url(#p.0)">
									<path
										fill="#000000"
										fill-opacity="0.0"
										d="m0 0l101.14698 0l0 120.31233l-101.14698 0z"
										fill-rule="evenodd"
									/>
									<path
										fill="#fff9fb"
										d="m47.665913 22.222082l0 28.32226l0 0c-1.232811 -0.43878555 -2.4327202 -0.8747597 -3.5997276 -1.3079224c-3.233799 -1.2066193 -5.846367 -2.7912178 -7.8377037 -4.753792c-1.9913368 -1.9771156 -2.9870071 -4.6156883 -2.9870071 -7.915722c0 -3.0383568 0.8084488 -5.6478558 2.4253464 -7.828495c1.6339188 -2.195179 3.9145966 -3.896078 6.8420334 -5.1026955c1.5576057 -0.6420059 3.2766228 -1.1132183 5.157055 -1.4136333zm8.961021 44.23046c2.1979752 0.8753662 4.206333 1.8602982 6.025074 2.9547882c2.2466354 1.3374634 4.025223 2.943863 5.335762 4.819214c1.3105392 1.875351 1.9658127 4.15049 1.9658127 6.8254013c0 3.4890213 -0.7573929 6.41835 -2.272171 8.787979c-1.5147781 2.3550873 -3.795456 4.1141357 -6.8420334 5.2771454c-1.2671776 0.48645782 -2.6713257 0.8711777 -4.2124443 1.1541519l0 0l0 -29.81868zm-4.8762283 -61.897423c-2.723198 0 -4.084793 0.79956675 -4.084793 2.398703l0 4.962012l-3.8146973E-6 0c-2.8704453 0.28674412 -5.5851326 0.79884243 -8.144062 1.536294c-4.1869125 1.2066212 -7.8206806 2.929327 -10.9012985 5.1681156c-3.080618 2.2242508 -5.463415 4.8555584 -7.1483936 7.8939133c-1.6679592 3.0383568 -2.501936 6.3456593 -2.501936 9.921911c0 4.3758163 0.782917 8.017483 2.3487568 10.925003c1.5658398 2.8929825 3.659298 5.2771454 6.2803745 7.1524963c2.6210785 1.8753471 5.5485153 3.4672165 8.7823105 4.7756004c3.2508163 1.2938423 6.5441856 2.4713898 9.8801 3.5326347c0.4705162 0.15353012 0.9385643 0.30758286 1.4041519 0.46216583l0 0l0 33.552883l0 0c-4.229553 -0.12199402 -8.076073 -0.69525146 -11.539551 -1.71978c-3.9145966 -1.1630096 -7.1569023 -2.3260193 -9.726921 -3.4890213c-2.5529976 -1.1630096 -4.348606 -1.7445145 -5.3868256 -1.7445145c-0.62973785 0 -1.1828861 0.26895142 -1.6594486 0.806839c-0.4595394 0.5378876 -0.8765297 1.2138824 -1.2509689 2.0279922c-0.35741806 0.7995682 -0.64675903 1.5773239 -0.8680191 2.3332825c-0.20423889 0.7559509 -0.30635834 1.3592606 -0.30635834 1.8099365c0 0.6251068 0.3404007 1.2284164 1.0211983 1.8099289c0.6807995 0.5814972 1.4892464 1.1411896 2.4253483 1.6790924c1.6849785 0.9740143 3.9316158 1.9771042 6.739914 3.0092773c2.8253174 1.0321732 6.1442146 1.9044342 9.956692 2.616768c3.320507 0.6176605 6.852154 0.96754456 10.59494 1.0496368l0 0l0 6.3209305c0 1.5991364 1.3615952 2.398697 4.084793 2.398697l0.7914314 0c2.723198 0 4.084793 -0.79956055 4.084797 -2.398697l0 -6.6815643l0 0c2.6132088 -0.28943634 5.064087 -0.74443054 7.3526306 -1.3649979c4.289036 -1.1630096 7.94833 -2.8784409 10.977894 -5.146309c3.0465775 -2.282402 5.352783 -5.0300064 6.9186172 -8.242821c1.5658417 -3.2273407 2.3487625 -6.847206 2.3487625 -10.859581c0 -4.5502625 -0.8680191 -8.366379 -2.6040573 -11.448357c-1.7190247 -3.0819702 -4.0422516 -5.647854 -6.9696884 -7.6976547c-2.9274368 -2.0643425 -6.144211 -3.7870483 -9.65033 -5.1681175c-2.8131905 -1.1081276 -5.6044693 -2.146061 -8.373829 -3.1137924l0 0l0 -31.64705l0 0c2.228489 0.1932354 4.2879066 0.57169914 6.178253 1.1353855c2.876377 0.8431816 5.361294 1.6936302 7.454754 2.5513477c2.09346 0.8431816 3.6082382 1.2647705 4.5443344 1.2647705c0.5276184 0 1.04673 -0.2689438 1.5573273 -0.8068371c0.5276184 -0.5378914 0.97013855 -1.2066231 1.3275604 -2.0061874c0.37443542 -0.8141041 0.6637802 -1.6209412 0.8680191 -2.4205093c0.22126007 -0.7995682 0.3318863 -1.468296 0.3318863 -2.0061893c0 -0.45066452 -0.2638092 -0.9667473 -0.7914276 -1.548254c-0.5105972 -0.5815029 -1.2424545 -1.0903187 -2.1955795 -1.5264473c-1.7700729 -0.98855686 -3.9145966 -1.8390064 -6.433548 -2.5513477c-2.5019379 -0.7123413 -5.1655655 -1.2938442 -7.9908867 -1.7445116c-1.65485 -0.26396275 -3.2717514 -0.4506216 -4.8506927 -0.5599785l0 0l0 -4.8043942c0 -1.5991364 -1.361599 -2.398703 -4.084797 -2.398703z"
										fill-rule="evenodd"
									/>
								</g>
							</svg>
							<h1>History</h1>
						</a>
					</section>
</div>
<div class='main-content' style='background-color: white;'>
<?php
// Fetch users from the database
$user_query = $con->query("SELECT Email, FirstName, LastName, CartID, IsAdmin FROM user");
$punch_query = $con->query("SELECT CartID, CurrentPunches, UnrewardedCards FROM punchcard");

// Display user table if there are users
if ($user_query->num_rows > 0) {
    echo "<table border='1'>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Admin?</th>
            <th>Edit</th>
        </tr>";

    // Loop through the users and display them in a table
    while ($row = $user_query->fetch_assoc()) {
        $admin = $row["IsAdmin"] == 1 ? "Yes" : "No";
        echo "<tr>
            <td>" . htmlspecialchars($row["FirstName"]) . "</td>
            <td>" . htmlspecialchars($row["LastName"]) . "</td>
            <td>" . htmlspecialchars($row["Email"]) . "</td>
            <td>" . htmlspecialchars($admin) . "</td>
            <td>
                <form method='POST'>
                    <input type='hidden' name='editUserId' value='" . htmlspecialchars($row["Email"]) . "'>
                    <input type='submit' name='edit' value='Edit User'>
                    <input type='submit' name='delete' value='Delete User'>
                </form>
            </td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No users available.</p>";
}

// Handle user deletion
if (isset($_POST['delete'])) {
    $editUserId = $con->real_escape_string($_POST['editUserId']);

    // Prevent deleting the logged-in admin
    if ($editUserId == $_SESSION['email']) {
        $_SESSION['bad'] = "<div class='error'>You cannot delete the currently logged-in user.</div>";
        header("location: editUser.php");
        exit;
    }

    // Fetch the user's CartID to delete related records
    $user_result = $con->query("SELECT CartID FROM user WHERE Email = '$editUserId'");
    if ($user_result && $user_result->num_rows > 0) {
        $user_data = $user_result->fetch_assoc();
        $cartID = $user_data['CartID'];

        // Delete related records from other tables
        if (!empty($cartID)) {
            $con->query("DELETE FROM punchcard WHERE CartID = '$cartID'");
            $con->query("DELETE FROM cart WHERE CartID = '$cartID'");
        }

        // Delete the user
        $con->query("DELETE FROM user WHERE Email = '$editUserId'");

        // Provide feedback
        if ($con->affected_rows > 0) {
            $_SESSION['deleteYes'] = "<div class='success'>User Deleted Successfully.</div>";
        } else {
            $_SESSION['bad'] = "<div class='error'>Failed to delete user. Please try again.</div>";
        }
    } else {
        $_SESSION['bad'] = "<div class='error'>User not found or already deleted.</div>";
    }

    header("location: editUser.php");
    exit;
}

// Handle edit user form
if (isset($_POST['edit'])) {
    $editUserId = $con->real_escape_string($_POST['editUserId']);
    $user_query = $con->query("SELECT * FROM user WHERE Email = '$editUserId'");
    $row = $user_query->fetch_assoc();

    if ($row) {
        $adminChecked = $row["IsAdmin"] == 1 ? 'checked' : '';
        echo "
        <form method='POST'>
            <p>First Name:</p><input type='text' name='firstName' value='" . htmlspecialchars($row["FirstName"]) . "' required>
            <p>Last Name:</p><input type='text' name='lastName' value='" . htmlspecialchars($row["LastName"]) . "' required>
            <p>Email:</p><input type='text' name='email' value='" . htmlspecialchars($row["Email"]) . "' required>
            <p>Password:</p><input type='password' name='password' placeholder='Leave empty to keep current password'>
            <p>Admin?:</p><input type='checkbox' name='admin' value='1' $adminChecked>
            <input type='hidden' name='originalEmail' value='" . htmlspecialchars($row["Email"]) . "'>
            <input type='hidden' name='originalPass' value='" . htmlspecialchars($row["Pass"]) . "'>
            <input type='submit' name='submitChange' value='Submit Changes'>
        </form>";
    } else {
        echo "<p>User not found.</p>";
    }
}

// Handle updating user details
if (isset($_POST['submitChange'])) {
    $firstName = $con->real_escape_string($_POST['firstName']);
    $lastName = $con->real_escape_string($_POST['lastName']);
    $email = $con->real_escape_string($_POST['email']);
    $password = $_POST['password'] ? md5($con->real_escape_string($_POST['password'])) : $_POST['originalPass'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;
    $originalEmail = $con->real_escape_string($_POST['originalEmail']);

    // Update user details in the database
    $sql = "UPDATE user SET FirstName='$firstName', LastName='$lastName', Pass='$password', IsAdmin='$isAdmin' WHERE Email='$originalEmail'";
    if ($con->query($sql)) {
        $_SESSION["updateYes"] = "<div class='success'>User details updated successfully.</div>";
    } else {
        $_SESSION['bad'] = "<div class='error'>Error updating user: " . $con->error . "</div>";
    }
    header("location: editUser.php");
    exit;
}

// Display add user form
if (isset($_POST['addDisplay'])) {
    echo "
    <form method='POST'>
        <p>First Name:</p><input type='text' name='firstName' required>
        <p>Last Name:</p><input type='text' name='lastName' required>
        <p>Email:</p><input type='email' name='email' required>
        <p>Password:</p><input type='password' name='password' required>
        <p>Confirm Password:</p><input type='password' name='password2' required>
        <p>Admin?</p><input type='checkbox' name='admin' value='1'>
        <input type='submit' name='submitAdd' value='Add User'>
    </form>";
}

// Handle adding a new user
if (isset($_POST['submitAdd'])) {
    $firstName = $con->real_escape_string($_POST['firstName']);
    $lastName = $con->real_escape_string($_POST['lastName']);
    $email = $con->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $isAdmin = isset($_POST['admin']) ? 1 : 0;

    // Check if passwords match
    if ($password != $password2) {
        $_SESSION['bad'] = "<div class='error'>Passwords do not match.</div>";
    } else {
        // Check if email already exists
        $email_check = $con->query("SELECT email FROM user WHERE email='$email'");
        if ($email_check->num_rows > 0) {
            $_SESSION['bad'] = "<div class='error'>Email already in use.</div>";
        } else {
            // Insert Cart into the 'cart' table first
            $cartInsert = "INSERT INTO cart () VALUES ()"; // Assuming CartID is auto-incremented
            if ($con->query($cartInsert)) {
                $cartID = $con->insert_id; // Get the newly generated CartID

                // Now insert the user with the CartID
                $password = md5($password); // Hash the password
                $sql = "INSERT INTO user (FirstName, LastName, Email, Pass, IsAdmin, CartID) 
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$isAdmin', '$cartID')";
                
                if ($con->query($sql)) {
                    // Insert into the 'punchcard' table with the CartID
                    $punchcard_sql = "INSERT INTO punchcard (CartID) VALUES ('$cartID')";
                    $punchcard_res = $con->query($punchcard_sql);
                    
                    if ($punchcard_res) {
                        $_SESSION['updateYes'] = "<div class='success'>User Added Successfully.</div>";
                        header("Location: editUser.php");
                        exit;
                    } else {
                        $_SESSION['bad'] = "<div class='error'>Error inserting CartID into punchcard table.</div>";
                    }
                } else {
                    $_SESSION['bad'] = "<div class='error'>Error adding user to the database: " . $con->error . "</div>";
                }
            } else {
                $_SESSION['bad'] = "<div class='error'>Error creating Cart in 'cart' table: " . $con->error . "</div>";
            }
        }
    }
}

?>

<br>
<form style='display: flex; justify-content: center;' method='POST'>
    <input type='submit' name='addDisplay' value='Add User'>
</form>

</body>
</html>
