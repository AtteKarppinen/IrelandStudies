<?php
//Responsible for 3 variable search on our API from the front-page
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
$tutors = new Tutor($db);

// Get data sent from front-end
// php://input includes body data sent using POST
// file_get_contents reads parameter into one string
// json_decode converts json string to php variable
$data = json_decode(file_get_contents("php://input"));

//Retrieve the data from front-end 
//Checks if the front-end actually had input
//tutorFee is variable used for front-end
if ((!empty($data->tutorLocation) && !empty($data->subjectLevel) && !empty($data->subjectName))) {
    
    //Sets values from front-end
    $tutors->t_location    = $data->tutorLocation;
    $tutors->subject_name  = $data->subjectName;
    $tutors->subject_level = $data->subjectLevel;
    
    //Query tutor with fee
    //Call the method from the other file
    //The other file returns Tutors and we set it here
    $foundTutors = $tutors->fetchTutorThree();
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
            //Fetches 2 tables from the subject table ike name and level for user to see
            $tutorItem = array(
                "Tutor Number" => $t_num,
                "First Name" => $t_fname,
                "Last Name" => $t_lname,
                "Birthday" => $t_bdate,
                "Sex" => $t_sex,
                "Email" => $t_email,
                "Address" => $t_address,
                "Location" => $t_location,
                "Fee" => $t_fee,
                "Subject Name" => $subject_name,
                "Subject Level" => $subject_level
                // Location is in unrecognised format, breaking this call
                // "Location" => $Location
                //I added subject name and level from the subject table to the array
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