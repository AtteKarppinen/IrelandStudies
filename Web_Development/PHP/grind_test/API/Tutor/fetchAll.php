<?php

/*
    This script is resbonsible for fetching tutors from 
    database and returning them in json-format.

    Now $tutor->read() call returns every tutor, make 
    more functions in objects/tutor.php for different purposes
    like readBySubject().

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
    $db = $database->getConnection();
    
    // Initialize tutor object
    $tutor = new Tutor($db);

    // Query tutors
    $tutors = $tutor->fetchAll();
    $num = $tutors->rowCount();
    
    // Check if more than 0 record found
    if ($num > 0) {
    
        // Tutors array
        $tutorsArray["Tutors"] = array();
    
        // Retrieve our table contents
        while ($row = $tutors->fetch(PDO::FETCH_ASSOC)) {
            
            // This will make $row["Fname"] to
            // Just $Fname only
            extract($row);
    
            // "Description for data" => Tutor property (fields from db)
            $tutorItem=array(
                "Tutor Number" => $t_num,
                "First Name" => $t_fname,
                "Last Name" => $t_lname,
                "Birthday" => $t_bdate,
                "Sex" => $t_sex,
                "Email" => $t_email,
                "Password" => $t_password,  // TODO: Remove, only for developing purposes
                "Address" => $t_address,
                "Fee" => $t_fee,
                "Subject Number" => $t_subject_num
                // Location is in unrecognised format, breaking this call
                // "Location" => $Location
            );
            array_push($tutorsArray["Tutors"], $tutorItem);
        }
    
        // Set response code - 200 OK
        http_response_code(200);
    
        // Show tutors data in json format
        echo json_encode($tutorsArray);
    }
    else {
    
        // Set response code - 404 Not Found
        http_response_code(404);
    
        // Tell the user no tutors found
        echo json_encode(
            array("Message" => "No tutors found.")
        );
    }
?>