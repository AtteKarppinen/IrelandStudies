<?php
	include("navigationbar.php");
?>
<html>
    <script>
        
        $(document).ready(function() {
            $("#level").change(function() {
                var val = $(this).val();
                if (val == "Senior Cycle") {
                    $("#choose").html("<option value='default'>Choose a Senior Cycle option</option>"+
                                    "<option value='Accounting'>Senior Cycle - Accounting </option>"+
                                    "<option value='Agricultural Economics'>Senior Cycle - Agricultural Economics</option>"+
                                    "<option value='Agricultural Science'>Senior Cycle - Agricultural Science  </option>"+
                                    "<option value='Ancient Greek'>Senior Cycle - Ancient Greek  </option>"+
                                    "<option value='Applied Mathematics'>Senior Cycle - Applied Mathematics  </option>"+
                                    "<option value='Arabic'>Senior Cycle - Arabic  </option>"+
                                    "<option value='Art (including crafts)'>Senior Cycle - Art (including crafts)  </option>"+
                                    "<option value='Biology'>Senior Cycle - Biology   </option>"+
                                    "<option value='Business'>Senior Cycle - Business  </option>"+
                                    "<option value='Chemistry'>Senior Cycle - Chemistry   </option>"+
                                    "<option value='Classical Studies'>Senior Cycle - Classical Studies  </option>"+
                                    "<option value='Construction Studies'>Senior Cycle - Construction Studies  </option>"+
                                    "<option value='Design and Communication Graphics'>Senior Cycle - Design and Communication Graphics  </option>"+
                                    "<option value='Economics'>Senior Cycle - Economics  </option>"+
                                    "<option value='Engineering'>Senior Cycle - Engineering  </option>"+
                                    "<option value='English'>Senior Cycle - English  </option>"+
                                    "<option value='French'>Senior Cycle - French  </option>"+
                                    "<option value='Geography'>Senior Cycle - Geography  </option>"+
                                    "<option value='German'>Senior Cycle - German  </option>"+
                                    "<option value='History'>Senior Cycle - History  </option>"+
                                    "<option value='Home Economics'>Senior Cycle - Home Economics  </option>"+
                                    "<option value='Irish'>Senior Cycle - Irish  </option>"+
                                    "<option value='Italian'>Senior Cycle - Italian  </option>"+
                                    "<option value='Japanese'>Senior Cycle - Japanese  </option>"+
                                    "<option value='Latin'>Senior Cycle - Latin  </option>"+
                                    "<option value='Mathematics'>Senior Cycle - Mathematics  </option>"+
                                    "<option value='Music'>Senior Cycle - Music  </option>"+
                                    "<option value='Physics'>Senior Cycle - Physics  </option>"+
                                    "<option value='Physics and Chemistry'>Senior Cycle - Physics and Chemistry  </option>");
                } else if (val == "Junior Cycle") {
                    $("#choose").html("<option value='default'>Choose a Junior Cycle option</option>"+
                                    "<option value='Ancient Greek'>Junior Cycle - Ancient Greek</option>"+
                                    "<option value='Art, Craft and Design'>Junior Cycle - Art, Craft and Design</option>"+
                                    "<option value='Business Studies'>Junior Cycle - Business Studies</option>"+
                                    "<option value='Classical Studies'>Junior Cycle - Classical Studies</option>"+
                                    "<option value='English'>Junior Cycle - English</option>"+
                                    "<option value='Environmental and Social Studies'>Junior Cycle - Environmental and Social Studies</option>"+
                                    "<option value='French'>Junior Cycle - French</option>"+
                                    "<option value='Geography'>Junior Cycle - Geography</option>"+
                                    "<option value='German'>Junior Cycle - German</option>"+
                                    "<option value='History'>Junior Cycle - History</option>"+
                                    "<option value='Home Economics'>Junior Cycle - Home Economics</option>"+
                                    "<option value='Irish'>Junior Cycle - Irish</option>"+
                                    "<option value='Italian'>Junior Cycle - Italian</option>"+
                                    "<option value='Jewish Studies'>Junior Cycle - Jewish Studies</option>"+
                                    "<option value='Latin'>Junior Cycle - Latin</option>"+
                                    "<option value='Materials Technology (Wood)'>Junior Cycle - Materials Technology (Wood)</option>"+
                                    "<option value='Mathematics'>Junior Cycle - Mathematics</option>"+
                                    "<option value='Metalwork'>Junior Cycle - Metalwork</option>"+
                                    "<option value='Music'>Junior Cycle - Music</option>"+
                                    "<option value='Science'>Junior Cycle - Science</option>"+
                                    "<option value='Spanish'>Junior Cycle - Spanish</option>"+
                                    "<option value='Technical Graphics'>Junior Cycle - Technical Graphics</option>"+
                                    "<option value='Technology'>Junior Cycle - Technology</option>");
                }
    });
});   
    </script>
	<body>
		<div class="container">
			<div class="row">
				<div class="leftSideTop">
					<p>
						<br><br><br>Here at Find a Grind we help you find a tutor best suited to you that will provide one on one help to get the results you deserve
					</p>
				</div>
				
				<div class="rightSideTop">
					<div class="slideshowContainer">						
						<div class="mySlides fade">
							<img id="students" src="Images/students.jpg" alt="Students">
						</div>
						
						<div class="mySlides fade">
							<img id="students" src="Images/tutor.jpg" alt="Tutors">
						</div>
						
						<div class="mySlides fade">
							<img id="students" src="Images/computer.png" alt="Computers">
						</div>
					</div>
					<br>
					<div style="text-align:center">
						<span class="dot"></span> 
						<span class="dot"></span> 
						<span class="dot"></span> 
					</div>
				</div>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="leftSideMiddle">
					<h2>Find A Tutor Near You</h2>
				</div>
				
				<div class="rightSideMiddle">
					<form action="search.php" method ="get">
						<select name="cycle" id="level">
							<option value="default">Choose a Cycle</option>
							<option value="Junior Cycle">Junior Cycle</option>
							<option value="Senior Cycle">Senior Cycle</option>
						</select>
						<br>
						<select name="subject" id="choose">
							<option value="default">Choose a Cycle first</option>
						</select>
						<br>
						<select name="location">
							<option value="default">Choose your Location</option>
							<option value="Dublin 1">Dublin 1</option>
							<option value="Dublin 2">Dublin 2</option>
							<option value="Dublin 3">Dublin 3</option>
							<option value="Dublin 4">Dublin 4</option>
							<option value="Dublin 5">Dublin 5</option>
							<option value="Dublin 6">Dublin 6</option>
							<option value="Dublin 6W">Dublin 6W</option>
							<option value="Dublin 7">Dublin 7</option>
							<option value="Dublin 8">Dublin 8</option>
							<option value="Dublin 9">Dublin 9</option>
							<option value="Dublin 10">Dublin 10</option>
							<option value="Dublin 11">Dublin 11</option>
							<option value="Dublin 12">Dublin 12</option>
							<option value="Dublin 13">Dublin 13</option>
							<option value="Dublin 14">Dublin 14</option>
							<option value="Dublin 15">Dublin 15</option>
							<option value="Dublin 16">Dublin 16</option>
							<option value="Dublin 17">Dublin 17</option>
							<option value="Dublin 18">Dublin 18</option>
							<option value="Dublin 20">Dublin 20</option>
							<option value="Dublin 22">Dublin 22</option>
							<option value="Dublin 24">Dublin 24</option>
						</select>
						<br><br>
						<input type="submit" value="Submit">
					</form>
				</div>
			</div>
		</div>
		
		<div class="tutors">
			<h1>Popular Tutors</h1>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="bottom">
					<h2>John, 25</h2>
					<br>
					<img id="roundedImage"src="Images/john.jpg" alt="Male Tutor">
					<br>
					<p>
						Leaving Cert Biology <br>Dublin 2
					</p>
				</div>
				
				<div class="bottom">
					<h2>Julie, 27</h2>
					<br>
					<img id="roundedImage"src="Images/julie.jpg" alt="Female Tutor">
					<br>
					<p>
						Junior Cert Geography <br>Dublin 5
					</p>
				</div>
			</div>
		</div>
		
		<script type="text/javascript" src="slideshow.js"></script>
		
	</body>

</html>