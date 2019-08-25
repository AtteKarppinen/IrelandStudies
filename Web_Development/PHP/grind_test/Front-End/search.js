$(function() {
	var modal = document.getElementById("id03");

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
    }
    
	// TUTOR
	$("#PaymentSubmit").submit(function(button) {
        button.preventDefault();
        
        const tutornumber = $("#TutorNumber").val();
		const studentnumber = $("#StudentNumber").val();
		const subjectnumber = $("#SubjectNumber").val();
		var d = new Date();
		const date = d.getFullYear() + "-" + (d.getMonth()+1) +"-"+d.getDate();
        const price = $("#Price").val();
        const cardnumber = $("#PayCardNumber").val();
		
		const obj = { 
			studentnumber: studentnumber, 
			tutornumber: tutornumber,
			subjectnumber: subjectnumber
		};
		const data = JSON.stringify(obj); 
		
		$.ajax({
			url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Contract/make.php",
			type: "POST",
			data: data
		})
		.done(function(result) {
			console.log(result);
			if(result.Success){
				$.ajax({
					url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Contract/fetchAll.php",
					type: "GET",
				})
				.done(function(result) {
					console.log(result);
					if(result){

						result = JSON.parse(JSON.stringify(result));
						console.log(result['Contracts']);
						
						const obj2 = {
							contractNumber: result['Contracts'][result['Contracts'].length-1].Contract_number,
							date: date,
							price: price,
							cardNumber: cardnumber
						}
						console.log(obj2);
						const data2 = JSON.stringify(obj2);
						$.ajax({
							url: "http://134.209.83.193/GrindTutorServices/Back-End/API/Payment/writePayLog.php",
							type: "POST",
							data: data2
						})
						.done(function(result) {
							console.log(result);
							if(result.Success){
								alert("Payment Success");
								window.location = "index.php";
							}
						})
						.fail(function(error) {	
							console.log(error.responseJSON, error.status);
							if(error.responseJSON.Message === "Wrong Email Or Password") {
								alert("Invalid Email Or Password");
							}
						});
					}
				})
				.fail(function(error) {	
					console.log(error.responseJSON, error.status);
					if(error.responseJSON.Message === "Wrong Email Or Password") {
						alert("Invalid Email Or Password");
					}
				});
				
			}
		})
		.fail(function(error) {	
			console.log(error.responseJSON, error.status);
			if(error.responseJSON.Message === "Wrong Email Or Password") {
				alert("Invalid Email Or Password");
			}
		});
	});

    

});
function wrongaccount(){
    alert("You logged in with a tutor account");
    window.location = 'index.php';

}
function validate(evt) {
	var theEvent = evt || window.event;
  
	// Handle paste
	if (theEvent.type === 'paste') {
		key = event.clipboardData.getData('text/plain');
	} else {
	// Handle key press
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode(key);
	}
	var regex = /[0-9]/g;
	if( !regex.test(key) ) {
	  theEvent.returnValue = false;
	  if(theEvent.preventDefault) theEvent.preventDefault();
	}
  }