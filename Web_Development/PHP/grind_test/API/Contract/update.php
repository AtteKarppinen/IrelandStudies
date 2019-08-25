<?php

/*
    Contract update. Require token.

    API call is made using PUT to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");

    // Include database and object files
    include_once "../Config/database.php";
    include_once "../Objects/contract.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize contract object
    $contract = new Contract($db);

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));

    // Check that data is not missing any info
    // TODO expect token as well
    if (!empty($data->contractnumber) &&
        !empty($data->studentnumber) &&
        !empty($data->tutornumber) &&
        !empty($data->subjectnumber)) {

        // Set values in contract.php
        $contract->contract_num             = $data->contractnumber;
        $contract->contract_student_num     = $data->studentnumber;
        $contract->contract_tutor_num       = $data->tutornumber;
        $contract->contract_subject_num     = $data->subjectnumber;
       
        // Update
        // Successful update returns true
        if ($contract->update()) {

            // HTTP status code - 200 OK
            http_response_code(200);

            echo json_encode(array("Success" => "Contract Updated"));
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