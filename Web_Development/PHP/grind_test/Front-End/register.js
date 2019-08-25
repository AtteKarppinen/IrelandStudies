$(function() {
	var modal = document.getElementById("id01");

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	var modal = document.getElementById("id02");

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	// Prevent negative numbers in fee input box
	var number = $("#tutorFee");

	// Listen for input event on numInput.
	// Numbers are numbers (buttons) from keyboard
	number.keydown(function(key) {
		if (!((key.keyCode > 95 && key.keyCode < 106)
		|| (key.keyCode > 47 && key.keyCode < 58) 
		|| key.keyCode == 8)) {
			return false;
		}
	});
	// Prevent numbers over 999 (largest fee allowed in db)
	number.keyup( function() {
		if (number.val() > 999) {
			number.val(999);
		}
	});

	$("#studentSubmit").submit(function (button) {
		button.preventDefault();
		
		const firstName	= $("#firstName").val();
		const lastName 	= $("#lastName").val();
		const birthday 	= $("#birthday").val();
		const sex 		= $("#gender").val();
		const email 	= $("#email").val();
		const password 	= $("#password").val();
		
		const studentData = {
			firstName:	firstName, 
			lastName: 	lastName, 
			birthday: 	birthday,
			sex: 		sex,
			email: 		email, 
			password: 	password
		}; 
			
		const data = JSON.stringify(studentData);	
		
		var settings = {
		url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Student/register.php",
		method: "POST",
		data: data
		};

		$.ajax(settings)
		.done(function (response) {
			console.log(response.Success);

			if (response.Success) {
				window.location = "login.php";
			}
		})
		.fail(function(error) {
			console.log(error, error.status);
		});
	});

	$("#tutorSubmit").submit(function(button){
		button.preventDefault();
		
		const firstName	= $("#tutorFName").val();
		const lastName 	= $("#tutorLName").val();
		const birthday 	= $("#tutorBirthday").val();
		const sex 		= $("#tutorGender").val();
		const email 	= $("#tutorEmail").val();
		const password 	= $("#tutorPassword").val();
		const address 	= $("#tutorAddress").val();
		const location 	= $("#tutorLocation").val();
		const fee 		= parseInt($("#tutorFee").val());
		// For now, select only the first selection for taught subjects
		const subjects 	= parseInt($("#tutorSubject").val());
		// Enable if there is time to implement this
		// const vettingDocument = $("#vettingDocument").val();
		
		const tutorData = {
			firstName:	firstName,
			lastName: 	lastName,
			birthday: 	birthday,
			sex: 		sex,
			email: 		email,
			password: 	password,
			address: 	address,
			location: 	location,
			fee: 		fee,
			subNumber: 	subjects
			// vettingDocument: vettingDocument
		};

		const data = JSON.stringify(tutorData);			

		var settings = {
			url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Tutor/register.php",
			method: "POST",
			data: data
		};

		$.ajax(settings)
		.done(function (response) {
			console.log(response.Success);

			if (response.Success) {
			window.location = "login.php";
			}
		})
		.fail(function(error) {
			console.log(error.responseJSON, error.status);
			if (error.responseJSON.Message === "User Already Exists") {
				alert("User with this email exists. Try to log in")
			}
		});
	});
});