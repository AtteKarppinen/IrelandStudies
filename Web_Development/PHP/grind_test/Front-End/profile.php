<?php
	include("navigationbar.php");

	// If user has not logged in, redirect to login page
	if (!(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true)) {
		header("location: login.php");
	}
?>

	<body>
		<div class="row">
			<div class="leftcolumn">
				<div class="card">
					<div class="fakeimg">
						Image
					</div>
					<h2>Name</h2>
					<p>Location</p>
					<p>Contact Details</p>
				</div>
			</div>
			
			<div class="rightcolumn">
				<div class="card">
					<h2>ABOUT ME</h2>
					<p>Brief intro about themselves</p>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vel nisi et diam posuere vehicula. Pellentesque ut dictum leo, sed pharetra tellus. Proin viverra ac metus at rutrum. Aliquam eleifend, mi id cursus aliquam, erat leo dapibus turpis, dapibus lacinia enim ligula ut libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed nec cursus lacus. Nunc justo nisi, vestibulum ut tempus non, interdum sodales odio. Donec vestibulum nunc id turpis aliquet auctor. Nullam quis massa non dui tempor fermentum. Quisque sed enim erat. Maecenas at semper nisi.
					</p>
					<p>My experience..</p>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. In vel nisi et diam posuere vehicula. Pellentesque ut dictum leo, sed pharetra tellus. Proin viverra ac metus at rutrum. Aliquam eleifend, mi id cursus aliquam, erat leo dapibus turpis, dapibus lacinia enim ligula ut libero. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed nec cursus lacus. Nunc justo nisi, vestibulum ut tempus non, interdum sodales odio. Donec vestibulum nunc id turpis aliquet auctor. Nullam quis massa non dui tempor fermentum. Quisque sed enim erat. Maecenas at semper nisi.
					</p>
					<p>Subjects taught</p>
					<ul>
						<li>Subject 1</li>
					    <li>Subject 2</li>
					    <li>Subject 3</li>
					</ul>
				</div>
			</div>
		</div>
	</body>

</html>