<?php
    include("navigationbar.php");
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
        header('Location: http://134.209.83.193/GrindTutorServices/Front-End/index.php');
        die();
    }   
?>

	<body>
		<div class="container">
			<div class="row">
				<div class="tutorLogin">
					<div class="topcontainer">
						<h2 id="login">Tutor Log In</h2>
					</div>
					<div class="content">
                        <form id="tutorLog">
                            <label for="email">Email</label>
                            <input type="email" placeholder="Enter your Email" id="tutorEmail" required>

                            <label for="password"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" id="tutorPassword" required>
                            <label id="remember">
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </form>
                        <span class="psw">
                            <a style="cursor:pointer" onclick="document.getElementById('id04').style.display='block'">Forgot password?</a>

                            <div style="display:none" id="id04" class="modal">
                                
                                <div class="imgcontainer">
                                    <span onclick="document.getElementById('id04').style.display='none'" class="close" title="Close Modal">&times;</span>
                                </div>
                            
                                <div class="regcontainer">
                                    <form id="tutorReset" class="modal-content animate">
                                        <h1>Forgot Password?</h1>
                                        <label for="fname">E-mail</label>
                                        <input type="text" placeholder="Enter your Email" id="tutorResetEmail" required>
                                        
                                        <label for="lname">Date of Birth</label>
                                        <br>
                                        <input type="date" placeholder="Enter your Date of Birth" id="tutorResetBirthday" min="1901-01-01" max="2020-12-31" required>
                                        <script>
                                            document.getElementById('tutorResetBirthday').value = new Date().toISOString().substring(0,10);
                                        </script>
                                        <button type="submit">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </span>
						<button type="submit" form="tutorLog">Login</button>
						<div class="bottomcontainer">
							<span class="reg">Don't have account? <a href="register.php">Sign up here</a></span>
						</div>
					</div>
                </div>
                

                <div class="studentLogin">
					<div class="topcontainer">
						<h2 id="login">Student Log In</h2>
					</div>
					<div class="content">
                        <form id="studentLog">
                            <label for="email">Email</label>
                            <input type="email" placeholder="Enter your Email" id="studentEmail" required>

                            <label for="password"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" id="studentPassword" required>
                            <label id="remember">
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </form>
                        <span class="psw">
                            <a style="cursor:pointer" onclick="document.getElementById('id05').style.display='block'">Forgot password?</a>

                            <div style="display:none" id="id05" class="modal">
                                
                                <div class="imgcontainer">
                                    <span onclick="document.getElementById('id05').style.display='none'" class="close" title="Close Modal">&times;</span>
                                </div>
                            
                                <div class="regcontainer">
                                    <form id="studentReset" class="modal-content animate">
                                        <h1>Forgot Password?</h1>
                                        <label for="fname">E-mail</label>
                                        <input type="text" placeholder="Enter your Email" id="studentResetEmail" required>
                                        
                                        <label for="lname">Date of Birth</label>
                                        <br>
                                        <input type="date" placeholder="Enter your Date of Birth" id="studentResetBirthday" min="1901-01-01" max="2020-12-31" required>
                                        <script>
                                            document.getElementById('studentResetBirthday').value = new Date().toISOString().substring(0,10);
                                        </script>
                                        <button type="submit">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </span>
						<button type="submit" form="studentLog">Login</button>
						<div class="bottomcontainer">
							<span class="reg">Don't have account? <a href="register.php">Sign up here</a></span>
						</div>
					</div>
				</div>
            </div>
		</div>
	</body>
	
</html>