<?php

/*
This script is resbonsible for fetching tutors from database
based on the fee given.

API call now is made using GET to this script.
*/

// Required headers
// First line allows API calls from any address
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// Include database and object files
include_once "../Config/database.php";
include_once "../Objects/tutor.php";

// Instantiate database
$database = new Database();
$db       = $database->getConnection();

// Initialize tutor object
$tutor = new Tutor($db);

// Get data sent from front-end
// php://input includes body data sent using POST
// file_get_contents reads parameter into one string
// json_decode converts json string to php variable
$data = json_decode(file_get_contents("php://input"));

//Retrieve the data from front-end 
//Checks if the front-end actually had input
//tutorFee is variable used for front-end
if (!empty($data->tutorFee)) {
    
    //Set values in tutor.php
    //Sets value from front-end
    //Set t_fee as this value
    $tutor->t_fee = $data->tutorFee;
    
    //Query tutor with fee
    //Call the method from the other file
    $foundTutors = $tutor->fetchTutorFee();
    $num         = $foundTutors->rowCount();
    
    //Check if any tutors found
    if ($num > 0) {
        
        $tutorsArray["Tutors"] = array();
        
        // Retrieve our table contents
        while ($row = $foundTutors->fetch(PDO::FETCH_ASSOC)) {
            
            // This will make $row["Fname"] to
            // Just $Fname only
            extract($row);
            
            // "Description for data" => Tutor property (fields from db)
            $tutorItem = array(
                "Tutor Number" => $t_num,
                "First Name" => $t_fname,
                "Last Name" => $t_lname,
                "Birthday" => $t_bdate,
                "Sex" => $t_sex,
                "Email" => $t_email,
                "Address" => $t_address,
                "Location"=> $t_location,
                "Fee" => $t_fee,
                "Subject Number" => $t_subject_num
                // Location is in unrecognised format, breaking this call
                // "Location" => $Location
            );
            array_push($tutorsArray["Tutors"], $tutorItem);
        } //End while    
        
        //Set response code 200 okay
        http_response_code(200);
        
        //Sow students in json format
        echo json_encode($tutorsArray);
        
    } else {
        
        // Set response code - 404 Not Found
        http_response_code(404);
        
        // Tell the user no students found
        echo json_encode(array(
            "Message" => "No tutor found."
        ));
    }
} else {
    
    // HTTP status code - 400 Bad Request
    http_response_code(400);
    
    echo json_encode(array(
        "Message" => "Bad Request. Incomplete Data"
    ));
}

?>
