<?php

/*
    Make (insert) contract. 

    API call is made using POST to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    // Include database and object files
    include_once "../Config/database.php";
    include_once "../Objects/contract.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize contract object
    $contract = new contract($db);

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));

    // Check that data is not missing any info
    if (!empty($data->studentnumber) &&
        !empty($data->tutornumber) &&
        !empty($data->subjectnumber)) {
        
        // Set values in contract.php
        $contract->contract_student_num = $data->studentnumber;
        $contract->contract_tutor_num   = $data->tutornumber;
        $contract->contract_subject_num = $data->subjectnumber;


        // Create contract record
        // Successful creation returns true
        if ($contract->makecontract()) {

            // HTTP status code - 201 Created
            http_response_code(201);

            echo json_encode(array("Success" => "Contract Created"));
        }
        // Request failed
        else {

            // HTTP status code - 400 Bad Request
            http_response_code(400);

            echo json_encode(array("Message" => "Make contract failed"));
        }
    }
    // Data missing
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>