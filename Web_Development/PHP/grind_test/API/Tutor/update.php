<?php

/*
    Tutor update. Require token.

    API call is made using PUT to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");

    // Include database and object files
    include_once "../Config/database.php";
    include_once "../Objects/tutor.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize tutor object
    $tutor = new tutor($db);

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));
    
    // Check that data is not missing any info
    // TODO expect token as well
    if (!empty($data->tutorID) &&
        !empty($data->firstName) &&
        !empty($data->lastName) &&
        !empty($data->birthday) &&
        !empty($data->sex) &&
        !empty($data->email) &&
        !empty($data->password) &&
        !empty($data->address) &&
        !empty($data->fee) &&
        !empty($data->subNumber)) {

        // Set values in tutor.php
        $tutor->t_num         = $data->tutorID;
        $tutor->t_fname       = $data->firstName;
        $tutor->t_lname       = $data->lastName;
        $tutor->t_bdate       = $data->birthday;
        $tutor->t_sex         = $data->sex;
        $tutor->t_email       = $data->email;
        $tutor->t_password    = $data->password;
        $tutor->t_address     = $data->address;
        $tutor->t_fee         = $data->fee;
        $tutor->t_subject_num = $data->subNumber;
       
        // Update
        // Successful update returns true
        if ($tutor->update()) {

            // HTTP status code - 200 OK
            http_response_code(200);

            echo json_encode(array("Success" => "User Updated"));
        }
        // Update failed
        else {

            // HTTP status code - 500 Internal Server Error
            http_response_code(500);

            echo json_encode(array("Message" => "Update Failed"));
        }
    }
    // Missing Data
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>