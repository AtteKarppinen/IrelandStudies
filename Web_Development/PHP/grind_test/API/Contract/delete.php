<?php

/*
    Contract deletion. Require token.

    API call is made using DELETE to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");

    // Include database and object files
    include_once "../Config/database.php";
    include_once "../Objects/contract.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize tutor object
    $contract = new contract($db);

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));

    // Check that data is not missing any info
    // TODO expect token as well
    if (!empty($data->contractnumber)) {

        // Set values in contract.php
        $contract->contract_num = $data->contractnumber;
        echo $contract->contract_num;
        // Delete
        // Successful deletion returns true
        if ($contract->delete()) {

            // HTTP status code - 200 OK
            http_response_code(200);

            echo json_encode(array("Success" => "Contract Deleted"));
        }
        // Delete failed
        else {

            // HTTP status code - 500 Internal Server Error
            http_response_code(500);

            echo json_encode(array("Message" => "Delete Failed"));
        }
    }
    // No ID provided
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>