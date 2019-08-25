<?php
	session_start();
	include("navigationbar.php");
?>
<html>
	<body>
		<div class="container">
			<div class="topReg">
				<h3>Register with Find a Grind today!</h3>
				<p>
					Join us now to find a tutor to suit you. Here at Find a Grind our tutors provide a fantastic one on one service so you feel confident going into any exam! 
				</p>
			</div>
		</div>
		
		<div class="container">
			<div class="row">
				<div class="register">
					<h3>Tutor Registration</h3>
					<button onclick="document.getElementById('id01').style.display='block'">Click here to register! </button>
					
					<div id="id01" class="modal">
            
						<form id="tutorSubmit" class="modal-content animate">
							<div class="imgcontainer">
								<span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
							</div>
						
							<div class="regcontainer">
								<h1>Tutor Registration</h1>
								<label for="fname">First Name</label>
								<input type="text" placeholder="Enter your First Name" id="tutorFName" required>
								
								<label for="lname">Last Name</label>
								<input type="text" placeholder="Enter your Last Name" id="tutorLName" required>
								
								<label for="email">Email</label>
								<input type="email" placeholder="Enter your Email" id="tutorEmail" required>

								<label for="password">Password</label>
								<input type="password" placeholder="Create Password" id="tutorPassword" required>
								
								<label for="confirmpassword">Confirm Password</label>
								<input type="password" placeholder="Re-Enter Password" id="tutorConfirmpassword" required>
                                
                                <label for="gender">Select your gender:</label>
                                <input type="radio" name="gender" value="M" id="tutorGender" required>Male
                                <input type="radio" name="gender" value="F" >Female
                                <br><br>
                                
                                <label for="birthday">Date of birth</label>
                                <input type="date" id="tutorBirthday" required>
                                <br><br>
                                
								<label for="address">Address</label>
								<input type="text"  placeholder="Enter Your Address" id="tutorAddress" required>
								
								<label for="location">Location</label>
								<select required id="tutorLocation">
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
								<label for="file">Upload Garda Vetting Document</label><br><br>
								<input type="file" placeholder="Upload your form as a PDF file" id="file">

								<br><br>
								<label for="fee">Your desired hourly rate of pay:</label><br><br>
								<input required type="number" id="tutorFee" min="0" max="999"> 
								
								<br><br>
								<label for="subjects">Select the subject you will teach:</label><br><br>
                                <select required id="tutorSubject">
                                    <option value="default">Enter your subject</option>
                                    <option value="1">Senior Cycle - Accounting </option>
                                    <option value="2">Senior Cycle - Agricultural Economics</option>
                                    <option value="3">Senior Cycle - Agricultural Science  </option>
                                    <option value="4">Senior Cycle - Ancient Greek  </option>
                                    <option value="5">Senior Cycle - Applied Mathematics  </option>
                                    <option value="6">Senior Cycle - Arabic  </option>
                                    <option value="7">Senior Cycle - Art (including crafts)  </option>
                                    <option value="8">Senior Cycle - Biology   </option>
                                    <option value="9">Senior Cycle - Business  </option>
                                    <option value="10">Senior Cycle - Chemistry   </option>
                                    <option value="11">Senior Cycle - Classical Studies  </option>
                                    <option value="12">Senior Cycle - Construction Studies  </option>
                                    <option value="13">Senior Cycle - Design and Communication Graphics  </option>
                                    <option value="14">Senior Cycle - Economics  </option>
                                    <option value="15">Senior Cycle - Engineering  </option>
                                    <option value="16">Senior Cycle - English  </option>
                                    <option value="17">Senior Cycle - French  </option>
                                    <option value="18">Senior Cycle - Geography  </option>
                                    <option value="19">Senior Cycle - German  </option>
                                    <option value="21">Senior Cycle - History  </option>
                                    <option value="22">Senior Cycle - Home Economics  </option>
                                    <option value="23">Senior Cycle - Irish  </option>
                                    <option value="24">Senior Cycle - Italian  </option>
                                    <option value="25">Senior Cycle - Japanese  </option>
                                    <option value="26">Senior Cycle - Latin  </option>
                                    <option value="27">Senior Cycle - Mathematics  </option>
                                    <option value="28">Senior Cycle - Music  </option>
                                    <option value="29">Senior Cycle - Physics  </option>
                                    <option value="30">Senior Cycle - Physics and Chemistry  </option>
                                    <option value="31">Senior Cycle - Russian  </option>
                                    <option value="32">Senior Cycle - Spanish  </option>
                                    <option value="33">Senior Cycle - Technology  </option>
                                    <option value="34">Junior Cycle - Ancient Greek</option>
                                    <option value="35">Junior Cycle - Art, Craft and Design</option>
                                    <option value="36">Junior Cycle - Business Studies</option>
                                    <option value="37">Junior Cycle - Classical Studies</option>
                                    <option value="38">Junior Cycle - English</option>
                                    <option value="39">Junior Cycle - Environmental and Social Studies</option>
                                    <option value="40">Junior Cycle - French</option>
                                    <option value="41">Junior Cycle - Geography</option>
                                    <option value="42">Junior Cycle - German</option>
                                    <option value="43">Junior Cycle - History</option>
                                    <option value="44">Junior Cycle - Home Economics</option>
                                    <option value="45">Junior Cycle - Irish</option>
                                    <option value="46">Junior Cycle - Italian</option>
                                    <option value="47">Junior Cycle - Jewish Studies</option>
                                    <option value="48">Junior Cycle - Latin</option>
                                    <option value="49">Junior Cycle - Materials Technology (Wood)</option>
                                    <option value="50">Junior Cycle - Mathematics</option>
                                    <option value="51">Junior Cycle - Metalwork</option>
                                    <option value="52">Junior Cycle - Music</option>
                                    <option value="53">Junior Cycle - Science</option>
                                    <option value="54">Junior Cycle - Spanish</option>
                                    <option value="55">Junior Cycle - Technical Graphics</option>
                                    <option value="56">Junior Cycle - Technology</option>
                                    </select>
                                
								<button type="submit">Register</button>
							</div>
						</form>
					</div>	
				</div>
				
				<div class="register">
					<h3>Student Registration</h3>
					<button onclick="document.getElementById('id02').style.display='block'">Click here to register! </button>
				
					<div id="id02" class="modal">
						<form id="studentSubmit" class="modal-content animate">
							<div class="imgcontainer">
							<span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
							</div>
						
							<div class="regcontainer">
								<h1>Student Registration</h1>
								<label for="fname">First Name</label>
								<input type="text" placeholder="Enter your First Name" id="firstName" required>
								
								<label for="lname">Last Name</label>
								<input type="text" placeholder="Enter your Last Name" id="lastName" required>
								
								<label for="email">Email</label>
								<input type="email" placeholder="Enter your Email" id="email" required>

								<label for="password">Password</label>
								<input type="password" placeholder="Create Password" id="password" required>
								
								<label for="confirmpassword">Confirm Password</label>
								<input type="password" placeholder="Re-Enter Password" id="confirmpassword" required>
                                
                                <label for="birthday">Date of birth</label>
                                <input type="date" id="birthday" required>
                                <br><br>
                                
                                <label for="gender">Select your gender:</label>
                                <input type="radio" name="gender" value="M" id="gender" required>Male
                                <input type="radio" name="gender" value="F" >Female
                                <br><br>
                                
                
								<button type="submit">Register</button>
							</div>
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>