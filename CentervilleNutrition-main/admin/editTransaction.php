<?php include('../header/header2.php');

// Check if the user is logged in (session exists) and if the user is an admin
if (!isset($_SESSION['firstName'])) {
    // If the user is not logged in, redirect to the home page and show an error
    header('location: ../homepage/index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
} else if ($_SESSION['admin'] != 1) {
    // If the user is not an admin, redirect to the home page and show an error
    header('location: ../homepage/index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
}

?>

<div class="main-content admin-content">
<div id="adminNav" class="admin-left mobile-nav" style="padding: 24px 10px">
<button class="out nav-out" onclick="addNav()">✕</button>
<section style="margin-top: auto">
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

						<a class="admin-switch hours-switch" href='editHours.php'>
				<svg xmlns="http://www.w3.org/2000/svg" style="margin-top: 0px" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#fff9fb" d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>


							<h1>Hours</h1>
						</a>
					</section>
</div>
<div class='admin-interface'>

	<h1>Transactions</h1>
	<!--Search Bar-->
    <form class="search" method="POST">
    <!-- Submit Button with SVG Icon inside -->
    <button type="submit" name="search-submit" class="search-btn">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
                d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"
            />
        </svg>
    </button>

    <!-- Search Input -->
    <input type="search" name="search" placeholder="Search Users" />
    </form>
<?php
if (!isset($_SESSION['firstName'])) {
    header('location: ../homepage/index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must log in to access this page.</h3>";
} else if ($_SESSION['admin'] != 1) {
    header('location: ../homepage/index.php');
    $_SESSION['mustLogin'] = "<h3 class='error'>You must be an admin to access this page.</h3>"; 
}

if(isset($_POST['search-submit'])) {
	$search_query = mysqli_real_escape_string($con, $_POST['search']);
    if($_POST['search'] != "") {
    echo("<h3 style='color: #7ad1a5;'>Showing Results for: " . $_POST['search'] . "</h3>");
    echo("<form method='POST' style='margin-bottom: 10px;'><input class='charlieDidThis' type='submit' name='reload' value='Clear Search Results'></form>");
    }

	if(isset($_POST['reload'])) {
        header('location: editTransaction.php');
    }

	$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date, ReceiptID FROM receipts WHERE Email LIKE '%$search_query%' ORDER BY ReceiptID desc");
	$num_rows = mysqli_num_rows($receiptQuery);
}

else {
$receiptQuery = mysqli_query($con, "SELECT Email, PurchasedCart, Cost, Date, ReceiptID FROM receipts ORDER BY ReceiptID desc");
$num_rows = mysqli_num_rows($receiptQuery);
}
if ($num_rows > 0) {
    echo "<table border='1' class='table'>
    <tr>
        <th>Date</th>
        <th>Email</th>
		<th>Total</th>
		<th>View</th>
    </tr>";
    
    while ($row = $receiptQuery->fetch_assoc()) {
     
        echo "<tr>
            <td>" . htmlspecialchars($row['Date']) . "</td>
            <td>" . htmlspecialchars($row["Email"]) . "</td>
            <td>$" . htmlspecialchars($row['Cost']) . "</td>
			<td>
                <form method='POST' class='list-actions'>
                    <input type='hidden' name='receiptID' value='" . htmlspecialchars($row['ReceiptID']) . "'>
                    <input type='submit' name='view' value='View Receipt'></input>
                </form>
            </td>
          </tr>";
    }
    echo "</table>";

	if(isset($_POST['view'])) {
		$_SESSION['receiptID'] = $_POST['receiptID'];
		header('location: viewReceipt.php');
	}
} else {
    echo "<p>No receipts available.</p>";
}
?>

<div class="admin-relative">
                    <button class="admin-add" onclick="addNav()">
						<img src="../images/menu.png" />
                    </button>
                </div>
</div>
    <div class="admin-right"></div>		
</div>
<script>
	//Toggle admin navigation for mobile view
	function addNav() {
		document.getElementById("adminNav").classList.toggle("mobile-nav");
		//console.log("Nav toggled");
	}
</script>

</body>
</html>