<?php
	include("navigationbar.php");

	// If user has not logged in, redirect to login page
	if (!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true)) {
		header("location: login.php");
	}
?>

<body>
	
	
</body>
</html>