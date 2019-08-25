<?php
	session_start();
?>

<!DOCTYPE html>
<html>

	<head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<title>Find a Grind</title>
		<link rel="stylesheet" type="text/css" href="design.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="register.js"></script>
		<script type="text/javascript" src="login.js"></script>
        <script type="text/javascript" src="search.js"></script>
        
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<div id="navbar">
			<img src="Images/logo.png" id="logo">
			<div id="navbar-right">
				<a href="index.php"><i class="fa fa-fw fa-home"></i>Home</a>
				<a href="about.php"><i class='fa fa-fw fa-question'></i>About Us</a>
				<?php
				if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
					echo "<a href='logout.php'><i class='fa fa-fw fa-sign-out'></i>Logout</a>";
					echo "<a href='myaccount.php'><i class='fa fa-fw fa-user'></i>My Account</a>";
				}
				else {
					echo "<a href='login.php'><i class='fa fa-fw fa-user'></i>Login</a>";
					echo "<a href='register.php'><i class='fa fa-fw fa-pencil'></i>Register</a>";
				}
				?>
			</div>
		</div>
		<br><br><br>
		
	</head>	
	
