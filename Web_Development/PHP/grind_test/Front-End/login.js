$(function() {
	var modal = document.getElementById("id04");

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}

	var modal = document.getElementById("id05");

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
    }
    

	// TUTOR
	$("#tutorLog").submit(function(button) {
		button.preventDefault();
		
		const email = $("#tutorEmail").val();
		const pword = $("#tutorPassword").val(); 
		
		const obj = { 
			email: email, 
			password: pword 
		};
		const data = JSON.stringify(obj); 
		
		$.ajax({
			url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Tutor/login.php",
			type: "POST",
			data: data
		})
		.done(function(result) {
			console.log(result);
			if(result.Success){
				window.location = "index.php";
			}
		})
		.fail(function(error) {	
			console.log(error.responseJSON, error.status);
			if(error.responseJSON.Message === "Wrong Email Or Password") {
				alert("Invalid Email Or Password");
			}
		});
	});

    //Tutor resetPassword
    $("#tutorReset").submit(function(button){
		button.preventDefault();
		
		const email   	= $("#tutorResetEmail").val();
		const birthday 	= $("#tutorResetBirthday").val();
		
		const tutorResetData = {
			birthday: 	birthday,
			email: 		email 
		}; 
			
		const data = JSON.stringify(tutorResetData);	
		
		var settings = {
		url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Tutor/resetPassword.php",
		method: "PUT",
		data: data
		};

		$.ajax(settings)
		.done(function (response) {
			console.log(response.Success);

			if (response.Success) {
                window.location = "login.php";
                alert("The password is changed to 'FindGrindTutor'"); 
			}
		})
		.fail(function(error) {
            console.log(error.responseJSON, error.status);
            alert("Invalid Email Or BirthDate");
		});
    });
    

	// STUDENT
	$("#studentLog").submit(function(button) {
		button.preventDefault();
		
		const email = $("#studentEmail").val();
		const psw = $("#studentPassword").val(); 
		
		const obj = { 
			email: email, 
			password: psw 
		};
		const data = JSON.stringify(obj);
		
		$.ajax({
			url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Student/login.php",
			type: "POST",
			data: data
		})
		.done(function(result) {
			console.log(result);
			if(result.Success){
				window.location = "index.php";
			}
		})
		.fail(function(error) {	
			console.log(error.responseJSON, error.status);
			if(error.responseJSON.Message === "Wrong Email Or Password") {
				alert("Invalid Email Or Password");
			}
		});
    });
    
    //Student resetPassword
    $("#studentReset").submit(function(button){
		button.preventDefault();
		
		const email   	= $("#studentResetEmail").val();
		const birthday 	= $("#studentResetBirthday").val();
		
		const tutorResetData = {
			birthday: 	birthday,
			email: 		email 
		}; 
			
		const data = JSON.stringify(tutorResetData);	
		
		var settings = {
		url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Student/resetPassword.php",
		method: "PUT",
		data: data
		};

		$.ajax(settings)
		.done(function (response) {
			console.log(response.Success);

			if (response.Success) {
                window.location = "login.php";
                alert("The password is changed to 'FindGrindTutor'");
			}
		})
		.fail(function(error) {
            console.log(error, error.status);
            alert("Invalid Email Or BirthDate");
		});
    });

});